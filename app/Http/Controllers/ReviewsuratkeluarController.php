<?php

namespace App\Http\Controllers;

use App\Models\Reviewsuratkeluar;
use App\Http\Requests\StoreReviewsuratkeluarRequest;
use App\Http\Requests\UpdateReviewsuratkeluarRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\jenis_surat;
use App\Models\Isi_surat;
use Illuminate\Support\Facades\Input;
use App\Models\departemen;
use App\Models\Suratkeluar;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Auth;
use DB;

class ReviewsuratkeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->jenis_surat = new Jenis_surat();
        $this->departemen = new Departemen();
        $suratkeluar = new Suratkeluar();
    }

    public function index()
    {
        return view('boilerplate::surat-keluar.review');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $surat = Suratkeluar::leftJoin('jenis_surats', 'jenis_surat_id', 'jenis_surats.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->leftJoin('isi_surats', 'isi_surats.surat_keluar_id', 'suratkeluars.id')->select('suratkeluars.id as ida', 'suratkeluars.*', 'jenis_surats.*', 'isi_surats.*', 'departemens.*')->where('suratkeluars.id', $id)->first();

        return view('boilerplate::surat-keluar.reviewdetail', compact('surat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReviewsuratkeluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReviewsuratkeluarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reviewsuratkeluar  $reviewsuratkeluar
     * @return \Illuminate\Http\Response
     */
    public function show(Reviewsuratkeluar $reviewsuratkeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reviewsuratkeluar  $reviewsuratkeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(Reviewsuratkeluar $reviewsuratkeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReviewsuratkeluarRequest  $request
     * @param  \App\Models\Reviewsuratkeluar  $reviewsuratkeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate request
        

        // get date from request
        $mmyy = substr($request->tgl_surat, 0, 7);
        $mm = substr($request->tgl_surat, 5, 2);
        $yy = substr($request->tgl_surat, 0, 4);

        $last_surat_keluar = DB::table('suratkeluars')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $tgl_surat_t = '';
        
        // $input = Suratkeluar::where('id', $id)->first();
        // $input->review_time = Carbon::now()->toDateTimeString();
        $reviewsurat['surat_keluar_id'] = $id;
        $reviewsurat['user_id'] = DB::table('suratkeluars')->select('user_id')->where('id', $id)->value('user_id');
        $reviewsurat['reviewer_id'] = Auth::user()->id;
        $reviewsurat['komentar'] = $request->komentar;
        

        // fungsi tombol
        switch ($request->submitbutton) {
        case 'Setujui':
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // send
            
            $reviewsurat['review_status'] = 2;

            $suratkeluar = DB::update('update suratkeluars set review_status = 2, review_time = ? where id = ?', [Carbon::now()->toDateTimeString(), $id]);
            $reviewsurata = Reviewsuratkeluar::create($reviewsurat);

            $mailto = Suratkeluar::leftJoin('users', 'users.id', 'suratkeluars.approver_id')->where('suratkeluars.id', $id)->value('email');
            $details = [
                'title' => '',
                'body' => 'Surat Keluar '.$request->perihal,
                'body2' => 'Untuk approve surat keluar silahkan klik link ini http://localhost:8000/surat-keluar-approve/'.$id,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-review.index')
                            ->with('growl', [__('Surat berhasil dikirim'), 'success']);

            break;

        case 'Revisi':
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // save to draft
            $reviewsurat['review_status'] = 2;

            $suratkeluar = DB::update('update suratkeluars set review_status = 3, review_time = ? where id = ?', [Carbon::now()->toDateTimeString(), $id]);
            $reviewsurata = Reviewsuratkeluar::create($reviewsurat);

            $mailto = Suratkeluar::leftJoin('users', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->value('email');
            $details = [
                'title' => '',
                'body' => 'Surat Keluar '.$request->perihal,
                'body2' => 'Untuk harus diervisi terlebih dahulu untuk revisi silahkan klik link ini http://localhost:8000/surat-keluar-saya/'.$id.'/edit',
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-review.index')
                            ->with('growl', [__('Surat berhasil disimpan'), 'success']);
            break;
        case 'Preview Surat':
            # code...
             //read template surat
            $template = new TemplateProcessor('template/'.DB::table('suratkeluars')->select('jenis_surat_id')->where('id', $id)->value('jenis_surat_id').'.docx');
            $isisurat = Isi_surat::where('surat_keluar_id', $id)->first();
            //set values template surat
            $template->setValues([
                // 'no_surat' => $nosurat,
                'tgl_surat' => $tgl_surat_t,
                'item1' => $isisurat->item1,
                'item2' => $isisurat->item2,
                'item3' => $isisurat->item3,
                'item4' => $isisurat->item4,
                'item5' => $isisurat->item5,
                'item6' => $isisurat->item6,
                'item7' => $isisurat->item7,
                'item8' => $isisurat->item8,
                'item9' => $isisurat->item9,
                'item10' => $isisurat->item10,
                'item11' => $isisurat->item11,
                'item12' => $isisurat->item12,
                'item13' => $isisurat->item13,
                'item14' => $isisurat->item14,
                'item15' => $isisurat->item15,
                'item16' => $isisurat->item16,
                'item17' => $isisurat->item17,
                'item18' => $isisurat->item18,
                'item19' => $isisurat->item19,
                'item20' => $isisurat->item20,
            ]);
            header("Content-Disposition: attachment; filename=suratkuasa.docx");

            // $template->saveAs('output/suratkuasa.docx');
            $template->saveAs('php://output');
            // $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
            // $PDFWriter->save(public_path('new-result.pdf'));
            break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reviewsuratkeluar  $reviewsuratkeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $suratkeluar = DB::update('update suratkeluars set status = 0 where id = ?', [$id]);
    }
}
