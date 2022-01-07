<?php

namespace App\Http\Controllers;

use App\Models\Approvesuratkeluar;
use App\Http\Requests\StoreApprovesuratkeluarRequest;
use App\Http\Requests\UpdateApprovesuratkeluarRequest;
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

class ApprovesuratkeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::surat-keluar.approve');
    }

    public function getRomawi($bulan){
        switch ($bulan){
            case 1: 
                return "I";
            break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if( Suratkeluar::where('id', $id)->value('approve_status') == 0 || Suratkeluar::where('id', $id)->value('approve_status') == 5){
            $suratkeluar = DB::update('update suratkeluars set approve_status = 1 where id = ?', [$id]);
        }

        $surat = Suratkeluar::leftJoin('jenis_surats', 'jenis_surat_id', 'jenis_surats.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->leftJoin('isi_surats', 'isi_surats.surat_keluar_id', 'suratkeluars.id')->select('suratkeluars.id as ida', 'suratkeluars.*', 'jenis_surats.*', 'isi_surats.*', 'departemens.*')->where('suratkeluars.id', $id)->first();

        return view('boilerplate::surat-keluar.approvedetail', compact('surat'));    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApprovesuratkeluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApprovesuratkeluarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Approvesuratkeluar  $approvesuratkeluar
     * @return \Illuminate\Http\Response
     */
    public function show(Approvesuratkeluar $approvesuratkeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Approvesuratkeluar  $approvesuratkeluar
     * @return \Illuminate\Http\Response
     */
    public function edit(Approvesuratkeluar $approvesuratkeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApprovesuratkeluarRequest  $request
     * @param  \App\Models\Approvesuratkeluar  $approvesuratkeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mmyy = substr($request->tgl_surat, 0, 7);
        $mm = substr($request->tgl_surat, 5, 2);
        $yy = substr($request->tgl_surat, 0, 4);

        $last_surat_keluar = DB::table('suratkeluars')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $tgl_surat_t = '';
        
        $approvestatus = Suratkeluar::where('id', $id)->value('approve_status');
        // $input = Suratkeluar::where('id', $id)->first();
        // $input->review_time = Carbon::now()->toDateTimeString();
        $approvesurat['surat_keluar_id'] = $id;
        $approvesurat['user_id'] = DB::table('suratkeluars')->select('user_id')->where('id', $id)->value('user_id');
        $approvesurat['approver_id'] = Auth::user()->id;
        $approvesurat['komentar'] = $request->komentar;

        // buat romawi bulan
        $romawi = $this->getRomawi($mm);
        $departemen_kode = DB::table('suratkeluars')->leftJoin('departemens', 'departemens.id', 'departemen_id')->select('kode')->where('suratkeluars.id', $id)->value('kode');
        $surat_kode = DB::table('suratkeluars')->leftJoin('jenis_surats', 'jenis_surats.id', 'jenis_surat_id')->select('kode')->where('suratkeluars.id', $id)->value('kode');
        $nourut = DB::table('suratkeluars')->select('no_urut')->where('id', $id)->value('no_urut');

        // cek no urut perbulan
        $nourut = DB::table('suratkeluars')->select('no_urut')->whereRaw('DATE_FORMAT(tgl_surat,"%Y-%m") = ? and jenis_surat_id = ? and departemen_id = ?' , [$mmyy, Suratkeluar::where('id', $id)->value('jenis_surat_id'), Suratkeluar::where('id', $id)->value('departemen_id')])->orderBy('no_urut', 'DESC')->limit(1)->value('no_urut');

        //buat no urut baru perbulan
        if ($nourut <= 000) {
            $nourut = 1;
        } else {
            $nourut = $nourut+1;
        }

        

        //buat no surat
        $nosurat= '';
        if ($request->jenis_surat == '12') {
            $nosurat= sprintf("%03d", $nourut).'/BDP-'.$surat_kode.'/'.$departemen_kode.'/'.$romawi.'/'.$yy;
        }else {
            $nosurat= sprintf("%03d", $nourut).'/BDP-'.$surat_kode.'/'.$romawi.'/'.$yy;
        }
        

        // fungsi tombol
        if($approvestatus == 2 || $approvestatus == 3 || $approvestatus == 4){
            return redirect()->route('boilerplate.surat-keluar-approve.index')
                            ->with('growl', [__('Surat telah disetujui atau revisi atau ditolak'), 'danger']);
        }else{
        switch ($request->submitbutton) {
        case 'Setujui':
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // send
            
            $approvesurat['approve_status'] = 2;

            $suratkeluar = DB::update('update suratkeluars set approve_status = 2, approve_time = ?, no_surat = ?, no_urut = ? where id = ?', [Carbon::now()->toDateTimeString(), $nosurat, $nourut, $id]);
            $approvesurata = Approvesuratkeluar::create($approvesurat);

            $mailto = Suratkeluar::leftJoin('users', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->value('email');
            $details = [
                'title' => '',
                'body' => 'Surat Keluar '.$request->perihal,
                'body2' => 'Untuk sudah diapprove untuk melihat detail silahkan klik link ini http://localhost:8000/surat-keluar-detail/'.$id,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-approve.index')
                            ->with('growl', [__('Surat berhasil disetujui'), 'success']);

            break;

        case 'Revisi':
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // save to draft
            $approvesurat['approve_status'] = 3;

            $suratkeluar = DB::update('update suratkeluars set approve_status = 3, approve_time = ? where id = ?', [Carbon::now()->toDateTimeString(), $id]);
            $approvesurata = Approvesuratkeluar::create($approvesurat);

            $mailto = Suratkeluar::leftJoin('users', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->value('email');
            $details = [
                'title' => '',
                'body' => 'Surat Keluar '.$request->perihal,
                'body2' => 'Untuk harus diervisi terlebih dahulu untuk revisi silahkan klik link ini http://localhost:8000/surat-keluar-saya/'.$id.'/edit',
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-approve.index')
                            ->with('growl', [__('Surat berhasil revisi'), 'success']);
            break;
        
        case 'Tolak':
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // save to draft
            $approvesurat['approve_status'] = 4;

            $suratkeluar = DB::update('update suratkeluars set approve_status = 4, approve_time = ? where id = ?', [Carbon::now()->toDateTimeString(), $id]);
            $approvesurata = Approvesuratkeluar::create($approvesurat);

            $mailto = Suratkeluar::leftJoin('users', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->value('email');
            $details = [
                'title' => '',
                'body' => 'Surat Keluar '.$request->perihal,
                'body2' => 'Untuk ditolak untuk melihat detail silahkan klik link ini http://localhost:8000/surat-keluar-detail/'.$id,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-approve.index')
                            ->with('growl', [__('Surat berhasil revisi'), 'success']);
            break;

        case 'Preview Surat':
            # code...
             //read template surat
            $template = new TemplateProcessor('template/'.DB::table('suratkeluars')->select('jenis_surat_id')->where('id', $id)->value('jenis_surat_id').'.docx');
            $isisurat = Isi_surat::where('surat_keluar_id', $id)->first();
            //set values template surat
            $template->setValues([
                'no_surat' => $nosurat,
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
        }}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Approvesuratkeluar  $approvesuratkeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Approvesuratkeluar $approvesuratkeluar)
    {
        //
    }
}
