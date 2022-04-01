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
use App\Notifications\Boilerplate\ApprovedSuratkeluar;
use App\Notifications\Boilerplate\RevisiSuratkeluar;
use App\Notifications\Boilerplate\TolakSuratkeluar;
use App\Models\jenis_surat;
use App\Models\Isi_surat;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Models\departemen;
use App\Models\Suratkeluar;
use App\Models\Request_surat_keluar;
use App\Models\Boilerplate\User;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use NcJoes\OfficeConverter\OfficeConverter;
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
        $suratapprove = Suratkeluar::where('id', $id)->first();
        if ($suratapprove->send_status==1) {
            if( $suratapprove->approve_status == 0 || $suratapprove->approve_status == 5){
                $suratkeluar = DB::update('update suratkeluars set approve_status = 1 where id = ?', [$id]);
            }

            $surat = Suratkeluar::leftJoin('jenis_surats', 'jenis_surat_id', 'jenis_surats.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->leftJoin('isi_surats', 'isi_surats.surat_keluar_id', 'suratkeluars.id')->select('suratkeluars.id as ida', 'suratkeluars.*', 'jenis_surats.*', 'isi_surats.*', 'departemens.*')->where('suratkeluars.id', $id)->first();

            return view('boilerplate::surat-keluar.approvedetail', compact('surat'), [
                'approve' => Approvesuratkeluar::leftJoin('users', 'approver_id', 'users.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('kode', 'approve_status as statuss', 'approvesuratkeluars.created_at as waktu_komentar', 'approvesuratkeluars.*', 'last_name', 'first_name', 'users.id as uid')->where('surat_keluar_id', $id)->get(),
            ]); 
        }  
        return redirect()->route('boilerplate.surat-keluar-approve.index')
            ->with('growl', [__('Surat tidak ada'), 'danger']);
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

        $surat = Suratkeluar::where('id', $id)->first();
        $surat['approver_id'] = Auth::user()->id;
        $surat['approve_time'] = Carbon::now()->toDateTimeString();

        $approvesurat['surat_keluar_id'] = $id;
        $approvesurat['user_id'] = DB::table('suratkeluars')->select('user_id')->where('id', $id)->value('user_id');
        $approvesurat['approver_id'] = Auth::user()->id;
        $approvesurat['komentar'] = $request->komentar;

        // buat romawi bulan
        $romawi = $this->getRomawi($mm);
        $departemen_kode = DB::table('suratkeluars')->leftJoin('departemens', 'departemens.id', 'departemen_id')->select('kode')->where('suratkeluars.id', $id)->value('kode');
        $surat_kode = DB::table('suratkeluars')->leftJoin('jenis_surats', 'jenis_surats.id', 'jenis_surat_id')->select('kode')->where('suratkeluars.id', $id)->value('kode');
        // $nourut = DB::table('suratkeluars')->select('no_urut')->where('id', $id)->value('no_urut');

        // cek no urut perbulan
        $nourut = DB::table('suratkeluars')->select('no_urut')->whereRaw('DATE_FORMAT(tgl_surat,"%Y-%m") = ? and jenis_surat_id = ? and departemen_id = ?' , [$mmyy, Suratkeluar::where('id', $id)->value('jenis_surat_id'), Suratkeluar::where('id', $id)->value('departemen_id')])->orderBy('no_urut', 'DESC')->limit(1)->value('no_urut');

        //buat no urut baru perbulan
        if ($nourut <= 000) {
            $nourut = 1;
        } else {
            $nourut = $nourut+1;
        }

        //tgl surat
        $tgl_surat_t = Carbon::createFromFormat('Y-m-d', $surat->tgl_surat)->isoFormat('D MMMM Y');

        //buat no surat
        $nosurat= '';
        if ($request->jenis_surat != '12') {
            $nosurat= sprintf("%03d", $nourut).'/BDP-'.$surat_kode.'/'.$departemen_kode.'/'.$romawi.'/'.$yy;
        }else {
            $nosurat= sprintf("%03d", $nourut).'/BDP-'.$surat_kode.'/'.$romawi.'/'.$yy;
        }
        

        // fungsi tombol
        
        switch ($request->submitbutton) {
        case 'Setujui':
            if($surat->approve_status == 2){
                return redirect()->route('boilerplate.surat-keluar-approve.index')
                                ->with('growl', [__('Surat telah disetujui'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // send
            $filename = $id.Str::random(16);
            $saveDocPath = Storage::path('suratkeluarjadi/'.$filename.'.docx');

            $template = new TemplateProcessor(Storage::path($surat->isi_surat.'.docx'));
            $isisurat = Isi_surat::where('surat_keluar_id', $id)->first();
            //set values template surat
            $template->setValues([
                'no_surat' => $nosurat,
                'tgl_surat' => $tgl_surat_t,
                'perihal' => $surat->perihal,
            ]);
            // $templateProcessor->setImageValue('foto', array('path' => 'dummy_foto.jpg', 'width' => 100, 'height' => 100, 'ratio' => true));
            $template->saveAs($saveDocPath);
            $converter = new OfficeConverter($saveDocPath);
            $converter->convertTo($filename.'.pdf'); 
            Storage::delete('suratkeluarjadi/'.$filename.'.docx');

            $surat['surat_jadi'] = 'suratkeluarjadi/'.$filename.'.pdf';
            $surat['no_urut'] = $nourut;
            $surat['no_surat'] = $nosurat;
            $surat['approve_status'] = 2;
            $approvesurat['approve_status'] = 2;

            if ($surat->request_surat_keluar_id!=null) {
                $reqsurat = Request_surat_keluar::where('id', $surat->request_surat_keluar_id)->first();
                $reqsurat['request_status'] = 3;
                $reqsurat['request_time'] = Carbon::now()->toDateTimeString();
                $reqsuratselesai = $reqsurat->save();
            }
            $suratkeluar = $surat->save();
            $approvesurata = Approvesuratkeluar::create($approvesurat);
            $link = route('boilerplate.surat-keluar-saya.edit', $id);
            $user=User::leftJoin('suratkeluars', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->first();
            $user->notify(new ApprovedSuratkeluar($id));

            return redirect()->route('boilerplate.surat-keluar-approve.index')
                            ->with('growl', [__('Surat berhasil disetujui'), 'success']);
            }
            break;

        case 'Revisi':
            if($surat->approve_status == 3){
                return redirect()->route('boilerplate.surat-keluar-approve.index')
                                ->with('growl', [__('Surat telah diminta revisi'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // revisi
            $surat['approve_status'] = 3;
            $approvesurat['approve_status'] = 3;

            $suratkeluar = $surat->save();
            $approvesurata = Approvesuratkeluar::create($approvesurat);

            // $link = route('boilerplate.surat-keluar-saya.edit', $id);
            // $mailto = Suratkeluar::leftJoin('users', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->value('email');
            // $details = [
            //     'title' => '',
            //     'body' => 'Surat Keluar '.$request->perihal,
            //     'body2' => 'Untuk harus direvisi terlebih dahulu untuk revisi silahkan klik link ini '.$link,
            // ];
            
            // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
            $user=User::leftJoin('suratkeluars', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->first();
            $user->notify(new RevisiSuratkeluar($id));

            return redirect()->route('boilerplate.surat-keluar-approve.index')
                            ->with('growl', [__('Surat berhasil revisi'), 'success']);
            }
            break;
        
        case 'Tolak':
            if($surat->approve_status == 4){
                return redirect()->route('boilerplate.surat-keluar-approve.index')
                                ->with('growl', [__('Surat telah ditolak'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // save to draft
            $surat['approve_status'] = 4;
            $approvesurat['approve_status'] = 4;

            $suratkeluar = $surat->save();
            $approvesurata = Approvesuratkeluar::create($approvesurat);
            // $link = route('boilerplate.surat-keluar-saya.edit', $id);
            // $mailto = Suratkeluar::leftJoin('users', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->value('email');
            // $details = [
            //     'title' => '',
            //     'body' => 'Surat Keluar '.$request->perihal,
            //     'body2' => 'Untuk ditolak untuk melihat detail silahkan klik link ini '.$link,
            // ];
            
            // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
            $user=User::leftJoin('suratkeluars', 'users.id', 'suratkeluars.user_id')->where('suratkeluars.id', $id)->first();
            $user->notify(new TolakSuratkeluar($id));

            return redirect()->route('boilerplate.surat-keluar-approve.index')
                            ->with('growl', [__('Surat berhasil revisi'), 'success']);
            }
            break;

        case 'Preview Surat':
            # code...
            if ($surat->no_surat!=null) {
                $PdfDisk = Storage::disk('local')->get($surat->surat_jadi);
                return (new Response($PdfDisk, 200))
                    ->header('Content-Type', 'application/pdf');
            }else {
                $PdfDisk = Storage::disk('local')->get($surat->isi_surat.'.pdf');
                return (new Response($PdfDisk, 200))
                    ->header('Content-Type', 'application/pdf');
            }
             //read template surat
            
            //generates pdf file in same directory as test-file.docx
            
            // $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
            // $PDFWriter->save(public_path('new-result.pdf'));
            break;
        }
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

    public function unduh_lampiran($id)
    {
        $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('lampiran'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');        
    }
    public function preview_surat($id)
    {
        if (Suratkeluar::where('id', $id)->value('approve_status')==2) {
            $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('surat_jadi'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf'); 
        }else {
            $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('isi_surat').'.pdf');
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf'); 
        }    
    }

    public function unduh_scan($id)
    {
        $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('surat_scan'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');
        
    }
}
