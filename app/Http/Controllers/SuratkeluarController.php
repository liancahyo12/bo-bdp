<?php

namespace App\Http\Controllers;

use App\Models\Suratkeluar;
use App\Http\Requests\StoreSuratkeluarRequest;
use App\Http\Requests\UpdateSuratkeluarRequest;
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
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Auth;
use DB;

class SuratkeluarController extends Controller
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
        //
        // $suratkeluar = new Suratkeluar();
        return view('boilerplate::surat-keluar.surat-keluar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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

    public function create()
    {
        //
        return view('boilerplate::surat-keluar.buat', [
            'approver' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=3'),
            'reviewer' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=4'),
            'jenis_surat' => jenis_surat::all(),
            'departemens' => departemen::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSuratkeluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $this->validate($request, [
                'jenis_surat' => 'required',
                'departemen'  => 'required',
                'reviewer'  => 'required',
                'approver'  => 'required',
                'tgl_surat'  => 'required',
                'perihal' => 'required',
            ]);

        // get date from request
        $mmyy = substr($request->tgl_surat, 0, 7);
        $mm = substr($request->tgl_surat, 5, 2);
        $yy = substr($request->tgl_surat, 0, 4);

        $last_surat_keluar = DB::table('suratkeluars')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $tgl_surat_t = Carbon::createFromFormat('Y-m-d', $request->tgl_surat)->isoFormat('D MMMM Y');
        

        $input['user_id'] = Auth::user()->id;
        $input['jenis_surat_id'] = $request->jenis_surat;
        $input['departemen_id'] = $request->departemen;
        $input['reviewer_id'] = $request->reviewer;
        $input['approver_id'] = $request->approver;
        $input['tgl_surat'] = $request->tgl_surat;
        $input['perihal'] = $request->perihal;
        // $input['no_urut'] = $nourut;
        // $input['no_surat'] = $nosurat;

        $isisurat['surat_keluar_id'] = $last_surat_keluar+1;
        $isisurat['jenis_surat_id'] = $request->jenis_surat;
        $isisurat['item1'] = $request->item1;
        $isisurat['item2'] = $request->item2;
        $isisurat['item3'] = $request->item3;
        $isisurat['item4'] = $request->item4;
        $isisurat['item5'] = $request->item5;
        $isisurat['item6'] = $request->item6;
        $isisurat['item7'] = $request->item7;
        $isisurat['item8'] = $request->item8;
        $isisurat['item9'] = $request->item9;
        $isisurat['item10'] = $request->item10;
        $isisurat['item11'] = $request->item11;
        $isisurat['item12'] = $request->item12;
        $isisurat['item13'] = $request->item13;
        $isisurat['item14'] = $request->item14;
        $isisurat['item15'] = $request->item15;
        $isisurat['item16'] = $request->item16;
        $isisurat['item17'] = $request->item17;
        $isisurat['item18'] = $request->item18;
        $isisurat['item19'] = $request->item19;
        $isisurat['item20'] = $request->item20;

       

        // fungsi tombol
        switch ($request->submitbutton) {
        case 'Kirim':
            // send
            $input['send_status'] = 1;
            $input['send_time'] = Carbon::now()->toDateTimeString();
            $input['review_status'] = 0;
            $input['approve_status'] = 0;

            $suratkeluar = Suratkeluar::create($input);
            $isisuratkeluar = Isi_surat::create($isisurat);

            return redirect()->route('boilerplate.surat-keluar-saya', $suratkeluar)
                            ->with('growl', [__('Surat berhasil dikirim'), 'success']);

            break;

        case 'Simpan Draft':
            // save to draft
            $input['send_status'] = 0;
            $input['review_status'] = 0;
            $input['approve_status'] = 0;

            $suratkeluar = Suratkeluar::create($input);
            $isisuratkeluar = Isi_surat::create($isisurat);

            return redirect()->route('boilerplate.surat-keluar-saya')
                            ->with('growl', [__('Surat berhasil disimpan'), 'success']);
            break;
        case 'Preview Surat':
            # code...
             //read template surat
            $template = new TemplateProcessor('template/'.$request->jenis_surat.'.docx');

            //set values template surat
            $template->setValues([
                // 'no_surat' => $nosurat,
                'tgl_surat' => $tgl_surat_t,
                'item1' => $request->item1,
                'item2' => $request->item2,
                'item3' => $request->item3,
                'item4' => $request->item4,
                'item5' => $request->item5,
                'item6' => $request->item6,
                'item7' => $request->item7,
                'item8' => $request->item8,
                'item9' => $request->item9,
                'item10' => $request->item10,
                'item11' => $request->item11,
                'item12' => $request->item12,
                'item13' => $request->item13,
                'item14' => $request->item14,
                'item15' => $request->item15,
                'item16' => $request->item16,
                'item17' => $request->item17,
                'item18' => $request->item18,
                'item19' => $request->item19,
                'item20' => $request->item20,
            ]);
            header("Content-Disposition: attachment; filename=suratkuasa.docx");

            $template->saveAs('output/suratkuasa.docx');
            // $template->saveAs('php://output');
            // $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
            // $PDFWriter->save(public_path('new-result.pdf'));
            break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Suratkeluar  $suratkeluar
     * @return \Illuminate\Http\Response
     */
    public function show(Suratkeluar $suratkeluar)
    {
        
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Suratkeluar  $suratkeluar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surat = Suratkeluar::leftJoin('isi_surats', 'surat_keluar_id', 'suratkeluars.id')->leftJoin('jenis_surats', 'jenis_surats.id', 'suratkeluars.jenis_surat_id')->select('isi_surats.*', 'suratkeluars.*', 'jenis_surats.*')->where('suratkeluars.id', $id)->first();
        $approver = DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=3');
        $reviewer = DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=4');
        $jenis_surat = jenis_surat::all();
        $departemens = departemen::all();
        return view('boilerplate::surat-keluar.edit', compact('surat'), 
        // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
        [
            'approver' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=3'),
            'reviewer' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=4'),
            'jenis_surat' => jenis_surat::all(),
            'departemens' => departemen::all(),
        ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSuratkeluarRequest  $request
     * @param  \App\Models\Suratkeluar  $suratkeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate request
        $this->validate($request, [
                'jenis_surat' => 'required',
                'departemen'  => 'required',
                'reviewer'  => 'required',
                'approver'  => 'required',
                'tgl_surat'  => 'required',
                'perihal' => 'required',
            ]);

        // get date from request
        $mmyy = substr($request->tgl_surat, 0, 7);
        $mm = substr($request->tgl_surat, 5, 2);
        $yy = substr($request->tgl_surat, 0, 4);

        $last_surat_keluar = DB::table('suratkeluars')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $tgl_surat_t = Carbon::createFromFormat('Y-m-d',  $request->tgl_surat)->isoFormat('D MMMM Y');
        

        $input['user_id'] = Auth::user()->id;
        $input['jenis_surat_id'] = $request->jenis_surat;
        $input['departemen_id'] = $request->departemen;
        $input['reviewer_id'] = $request->reviewer;
        $input['approver_id'] = $request->approver;
        $input['tgl_surat'] = $request->tgl_surat;
        $input['perihal'] = $request->perihal;
        // $input['no_urut'] = $nourut;
        // $input['no_surat'] = $nosurat;

        $isisurat['surat_keluar_id'] = $last_surat_keluar+1;
        $isisurat['jenis_surat_id'] = $request->jenis_surat;
        $isisurat['item1'] = $request->item1;
        $isisurat['item2'] = $request->item2;
        $isisurat['item3'] = $request->item3;
        $isisurat['item4'] = $request->item4;
        $isisurat['item5'] = $request->item5;
        $isisurat['item6'] = $request->item6;
        $isisurat['item7'] = $request->item7;
        $isisurat['item8'] = $request->item8;
        $isisurat['item9'] = $request->item9;
        $isisurat['item10'] = $request->item10;
        $isisurat['item11'] = $request->item11;
        $isisurat['item12'] = $request->item12;
        $isisurat['item13'] = $request->item13;
        $isisurat['item14'] = $request->item14;
        $isisurat['item15'] = $request->item15;
        $isisurat['item16'] = $request->item16;
        $isisurat['item17'] = $request->item17;
        $isisurat['item18'] = $request->item18;
        $isisurat['item19'] = $request->item19;
        $isisurat['item20'] = $request->item20;

       

        // fungsi tombol
        switch ($request->submitbutton) {
        case 'Kirim':
            // send
            $input['send_status'] = 1;
            $input['send_time'] = Carbon::now()->toDateTimeString();
            $input['review_status'] = 0;
            $input['approve_status'] = 0;

            $suratkeluar = Suratkeluar::create($input);
            $isisuratkeluar = Isi_surat::create($isisurat);

            return redirect()->route('boilerplate.surat-keluar-saya', $suratkeluar)
                            ->with('growl', [__('Surat berhasil dikirim'), 'success']);

            break;

        case 'Simpan Draft':
            // save to draft
            $input['send_status'] = 0;
            $input['review_status'] = 0;
            $input['approve_status'] = 0;

            $suratkeluar = Suratkeluar::create($input);
            $isisuratkeluar = Isi_surat::create($isisurat);

            return redirect()->route('boilerplate.surat-keluar-saya')
                            ->with('growl', [__('Surat berhasil disimpan'), 'success']);
            break;
        case 'Preview Surat':
            # code...
             //read template surat
            $template = new TemplateProcessor('template/'.$request->jenis_surat.'.docx');

            //set values template surat
            $template->setValues([
                // 'no_surat' => $nosurat,
                'tgl_surat' => $tgl_surat_t,
                'item1' => $request->item1,
                'item2' => $request->item2,
                'item3' => $request->item3,
                'item4' => $request->item4,
                'item5' => $request->item5,
                'item6' => $request->item6,
                'item7' => $request->item7,
                'item8' => $request->item8,
                'item9' => $request->item9,
                'item10' => $request->item10,
                'item11' => $request->item11,
                'item12' => $request->item12,
                'item13' => $request->item13,
                'item14' => $request->item14,
                'item15' => $request->item15,
                'item16' => $request->item16,
                'item17' => $request->item17,
                'item18' => $request->item18,
                'item19' => $request->item19,
                'item20' => $request->item20,
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
     * @param  \App\Models\Suratkeluar  $suratkeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suratkeluar $suratkeluar)
    {
        //
    }

    public function detail(Suratkeluar $suratkeluar)
    {
        //
    }

    public function review(Suratkeluar $suratkeluar)
    {
        //
    }

    public function approve(Suratkeluar $suratkeluar)
    {
        //
        // get date from request
        $mmyy = substr($request->tgl_surat, 0, 7);
        $mm = substr($request->tgl_surat, 5, 2);
        $yy = substr($request->tgl_surat, 0, 4);

        // cek no urut perbulan
        $nourut = DB::table('suratkeluars')->select('no_urut')->whereRaw('DATE_FORMAT(tgl_surat,"%Y-%m") = ?' , [$mmyy])->orderBy('no_urut', 'DESC')->limit(1)->value('no_urut');

        //buat no urut baru perbulan
        if ($nourut <= 000) {
            $nourut = 1;
        } else {
            $nourut = $nourut+1;
        }

        // buat romawi bulan
        $romawi = $this->getRomawi($mm);
        $departemen_kode = DB::table('departemens')->select('kode')->where('id', $request->departemen)->value('kode');
        $surat_kode = DB::table('jenis_surats')->select('kode')->where('id', $request->jenis_surat)->value('kode');
//buat no surat
        $nosurat= '';
        if ($request->jenis_surat == '12') {
            $nosurat= sprintf("%03d", $nourut).'/BDP-'.$surat_kode.'/'.$departemen_kode.'/'.$romawi.'/'.$yy;
        }else {
            $nosurat= sprintf("%03d", $nourut).'/BDP-'.$surat_kode.'/'.$romawi.'/'.$yy;
        }
    }

    public function arsip(Suratkeluar $suratkeluar)
    {
        //
    }
}
