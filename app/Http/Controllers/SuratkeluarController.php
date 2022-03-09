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
use Illuminate\Support\Facades\Input;
use App\Models\jenis_surat;
use App\Models\departemen;
use App\Models\Isi_surat;
use App\Models\Request_surat_keluar;
use App\Models\Approvesuratkeluar;
use App\Models\Boilerplate\User;
use Carbon\Carbon;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use NcJoes\OfficeConverter\OfficeConverter;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Boilerplate\ApproveaSuratkeluar;
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

    public function create()
    {
        //
        return view('boilerplate::surat-keluar.buat', [
            'approver' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=4'),
            'reviewer' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=3'),
            'jenis_surat' => jenis_surat::all(),
            'departemens' => departemen::all(),
        ]);
    }

    public function create_request($id)
    {
        $reqsurat = Request_surat_keluar::leftJoin('jenis_surats', 'jenis_surat_id', 'jenis_surats.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('request_surat_keluars.id as ida', 'request_surat_keluars.*', 'jenis_surats.*', 'departemens.*')->where('request_surat_keluars.id', $id)->first();
        return view('boilerplate::surat-keluar.buat-dari-request', compact('reqsurat'),[
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

    public function store_request(Request $request, $id)
    {
        // validate request
        $this->validate($request, [
                'jenis_surat' => 'required',
                'departemen'  => 'required',
                'tgl_surat'  => 'required',
                'perihal' => 'required',
                'lampiran_radio' => 'required',
                'file_surat' => 'mimes:docx|max:20480',
                'file_lampiran' => 'mimes:pdf|max:20480',
            ]);

        $input['user_id'] = Auth::user()->id;
        $last_surat_keluar = DB::table('suratkeluars')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $ssr = $last_surat_keluar+1;
        $filenameS = $ssr.Str::random(16);
        $pathS ='';
        $pathL ='';
        if ($request->file_surat!=null) {
            $pathS = $request->file('file_surat')->storeAs('suratkeluar', $filenameS.'.docx');
            $converter = new OfficeConverter(Storage::path('suratkeluar/'.$filenameS.'.docx'));
            $converter->convertTo($filenameS.'.pdf'); 
            $input['isi_surat'] = 'suratkeluar/'.$filenameS;
        }

        if ($request->lampiran_radio == 1) {
            $input['lampiran'] = Request_surat_keluar::select('lampiran')->where('id', $id)->value('lampiran');
        }elseif ($request->lampiran_radio == 2){
            $filenameL = $ssr.Str::random(16).'.pdf';
            if ($request->file_lampiran!=null) {
                $pathL = $request->file('file_lampiran')->storeAs('lampiran', $filenameL);
                $input['lampiran'] = $pathL;
            }
        }
        

        $tgl_surat_t = Carbon::createFromFormat('Y-m-d', $request->tgl_surat)->isoFormat('D MMMM Y');
        
        
        $input['jenis_surat_id'] = $request->jenis_surat;
        $input['departemen_id'] = $request->departemen;
        $input['request_surat_keluar_id'] = $id;
        $input['tgl_surat'] = $request->tgl_surat;
        $input['perihal'] = $request->perihal;
        // $input['lampiran'] = Request_surat_keluar::select('lampiran')->where('id', $id)->value('lampiran')
        

        // $isisurat['surat_keluar_id'] = $last_surat_keluar+1;
        // $isisurat['jenis_surat_id'] = $request->jenis_surat;
        // $isisurat['item1'] = $request->item1;
        // $isisurat['item2'] = $request->item2;
        // $isisurat['item3'] = $request->item3;
        // $isisurat['item4'] = $request->item4;
        // $isisurat['item5'] = $request->item5;
        // $isisurat['item6'] = $request->item6;
        // $isisurat['item7'] = $request->item7;
        // $isisurat['item8'] = $request->item8;
        // $isisurat['item9'] = $request->item9;
        // $isisurat['item10'] = $request->item10;
        // $isisurat['item11'] = $request->item11;
        // $isisurat['item12'] = $request->item12;
        // $isisurat['item13'] = $request->item13;
        // $isisurat['item14'] = $request->item14;
        // $isisurat['item15'] = $request->item15;
        // $isisurat['item16'] = $request->item16;
        // $isisurat['item17'] = $request->item17;
        // $isisurat['item18'] = $request->item18;
        // $isisurat['item19'] = $request->item19;
        // $isisurat['item20'] = $request->item20;

       

        // fungsi tombol
        switch ($request->submitbutton) {
        case 'Kirim':
            $this->validate($request, [
                'file_surat' => 'required|mimes:docx|max:20480',
            ]);
            // send
            $input['send_status'] = 1;
            $input['send_time'] = Carbon::now()->toDateTimeString();
            $input['approve_status'] = 0;
            $perihal = $request->perihal;
            $suratkeluar = Suratkeluar::create($input);
            // $isisuratkeluar = Isi_surat::create($isisurat);
            $link = route('boilerplate.surat-keluar-review', $ssr);
            $mailto = DB::select('select email from permission_role left join role_user  on permission_role.role_id=role_user.role_id left join users on role_user.user_id=users.id where permission_id=7');
            $details = [
                'title' => '',
                'body' => 'Surat Keluar '.$request->perihal,
                'body2' => 'Untuk approve surat keluar silahkan klik link ini '.$link,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-saya.index')
                            ->with('growl', [__('Surat berhasil dikirim'), 'success']);

            break;

        case 'Simpan Draft':
            // save to draft
            $input['send_status'] = 0;

            $suratkeluar = Suratkeluar::create($input);
            // $isisuratkeluar = Isi_surat::create($isisurat);

            return redirect()->route('boilerplate.surat-keluar-saya.index')
                            ->with('growl', [__('Surat berhasil disimpan'), 'success']);
            break;
        // case 'Preview Surat':
        //     # code...
        //      //read template surat
        //     $template = new TemplateProcessor('template/'.$request->jenis_surat.'.docx');

        //     //set values template surat
        //     $template->setValues([
        //         // 'no_surat' => $nosurat,
        //         'tgl_surat' => $tgl_surat_t,
        //         'item1' => $request->item1,
        //         'item2' => $request->item2,
        //         'item3' => $request->item3,
        //         'item4' => $request->item4,
        //         'item5' => $request->item5,
        //         'item6' => $request->item6,
        //         'item7' => $request->item7,
        //         'item8' => $request->item8,
        //         'item9' => $request->item9,
        //         'item10' => $request->item10,
        //         'item11' => $request->item11,
        //         'item12' => $request->item12,
        //         'item13' => $request->item13,
        //         'item14' => $request->item14,
        //         'item15' => $request->item15,
        //         'item16' => $request->item16,
        //         'item17' => $request->item17,
        //         'item18' => $request->item18,
        //         'item19' => $request->item19,
        //         'item20' => $request->item20,
        //     ]);
        //     header("Content-Disposition: attachment; filename=suratkuasa.docx");

        //     // $template->saveAs('output/suratkuasa.docx');
        //     $template->saveAs('php://output');
        //     // $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($Content,'PDF');
        //     // $PDFWriter->save(public_path('new-result.pdf'));
        //     break;
        }
    }
    
    public function store(Request $request)
    {
        // validate request
        $this->validate($request, [
                'jenis_surat' => 'required',
                'departemen'  => 'required',
                'tgl_surat'  => 'required',
                'perihal' => 'required',
                'file_surat' => 'mimes:docx|max:20480',
                'file_lampiran' => 'mimes:pdf|max:20480',
            ]);

        $input['user_id'] = Auth::user()->id;
        $last_surat_keluar = DB::table('suratkeluars')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $ssr = $last_surat_keluar+1;
        $filenameS = $ssr.Str::random(16);
        $pathS ='';
        if ($request->file_surat!=null) {
            $pathS = $request->file('file_surat')->storeAs('suratkeluar', $filenameS.'.docx');
            $converter = new OfficeConverter(Storage::path('suratkeluar/'.$filenameS.'.docx'));
            $converter->convertTo($filenameS.'.pdf'); 
            $input['isi_surat'] = 'suratkeluar/'.$filenameS;
        }

        $filenameL = $ssr.Str::random(16).'.pdf';
        $pathL ='';
        if ($request->file_lampiran!=null) {
            $pathL = $request->file('file_lampiran')->storeAs('lampiran', $filenameL);
        }

        $tgl_surat_t = Carbon::createFromFormat('Y-m-d', $request->tgl_surat)->isoFormat('D MMMM Y');
                
        $input['jenis_surat_id'] = $request->jenis_surat;
        $input['departemen_id'] = $request->departemen;
        $input['tgl_surat'] = $request->tgl_surat;
        $input['perihal'] = $request->perihal;
        $input['lampiran'] = $pathL;

        // $isisurat['surat_keluar_id'] = $last_surat_keluar+1;
        // $isisurat['jenis_surat_id'] = $request->jenis_surat;
        // $isisurat['item1'] = $request->item1;
        // $isisurat['item2'] = $request->item2;
        // $isisurat['item3'] = $request->item3;
        // $isisurat['item4'] = $request->item4;
        // $isisurat['item5'] = $request->item5;
        // $isisurat['item6'] = $request->item6;
        // $isisurat['item7'] = $request->item7;
        // $isisurat['item8'] = $request->item8;
        // $isisurat['item9'] = $request->item9;
        // $isisurat['item10'] = $request->item10;
        // $isisurat['item11'] = $request->item11;
        // $isisurat['item12'] = $request->item12;
        // $isisurat['item13'] = $request->item13;
        // $isisurat['item14'] = $request->item14;
        // $isisurat['item15'] = $request->item15;
        // $isisurat['item16'] = $request->item16;
        // $isisurat['item17'] = $request->item17;
        // $isisurat['item18'] = $request->item18;
        // $isisurat['item19'] = $request->item19;
        // $isisurat['item20'] = $request->item20;

       

        // fungsi tombol
        switch ($request->submitbutton) {
        case 'Kirim':
            $this->validate($request, [
                'file_surat' => 'required|mimes:docx|max:20480',
            ]);
            // send
            $input['send_status'] = 1;
            $input['send_time'] = Carbon::now()->toDateTimeString();
            $input['approve_status'] = 0;
            $perihal = $request->perihal;
            $suratkeluar = Suratkeluar::create($input);
            // $isisuratkeluar = Isi_surat::create($isisurat);

            // $link = route('boilerplate.surat-keluar-approve.edit', $ssr);
            // $mailto = DB::select('select email from permission_role left join role_user  on permission_role.role_id=role_user.role_id left join users on role_user.user_id=users.id where permission_id=7');
            //     $details = [
            //         'title' => '',
            //         'body' => 'Surat Keluar '.$request->perihal,
            //         'body2' => 'Untuk approve surat keluar silahkan klik link ini '.$link,
            //     ];
            
            // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
            $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 7)->first();
            $user->notify(new ApproveaSuratkeluar($ssr));

            return redirect()->route('boilerplate.surat-keluar-saya.index')
                            ->with('growl', [__('Surat berhasil dikirim'), 'success']);

            break;

        case 'Simpan Draft':
            // save to draft
            $input['send_status'] = 0;

            $suratkeluar = Suratkeluar::create($input);
            // $isisuratkeluar = Isi_surat::create($isisurat);

            return redirect()->route('boilerplate.surat-keluar-saya.index')
                            ->with('growl', [__('Surat berhasil disimpan'), 'success']);
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
        
        $surat = Suratkeluar::leftJoin('isi_surats', 'surat_keluar_id', 'suratkeluars.id')->leftJoin('jenis_surats', 'jenis_surats.id', 'suratkeluars.jenis_surat_id')->leftJoin('request_surat_keluars', 'request_surat_keluar_id', 'request_surat_keluars.id')->select('suratkeluars.id as ida', 'suratkeluars.user_id as suser_id', 'isi_surats.*', 'suratkeluars.*', 'jenis_surats.*', 'request_surat_keluars.lampiran as lprq')->where('suratkeluars.id', $id)->first();
        if ($surat->suser_id != Auth::user()->id) {
            return redirect()->route('boilerplate.surat-keluar-saya.index')
                            ->with('growl', [__('Surat keluar tidak ada'), 'danger']);
        }
        if ($surat->approve_status == 3 || $surat->send_status == 0) {
            return view('boilerplate::surat-keluar.edit', compact('surat'), 
            // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
            [
                'approver' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=4'),
                'reviewer' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=3'),
                'jenis_surat' => jenis_surat::all(),
                'departemens' => departemen::all(),
                'approve' => Approvesuratkeluar::leftJoin('users', 'approver_id', 'users.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('kode', 'approve_status as statuss', 'approvesuratkeluars.created_at as waktu_komentar', 'approvesuratkeluars.*', 'last_name', 'first_name', 'users.id as uid')->where('surat_keluar_id', $id)->get(),
            ]
            );
        }else {
            return view('boilerplate::surat-keluar.detail', compact('surat'), 
            // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
            [
                'approver' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=4'),
                'reviewer' => DB::select('select users.id, first_name from role_user left join users on role_user.user_id=users.id where role_id=3'),
                'jenis_surat' => jenis_surat::all(),
                'departemens' => departemen::all(),
                'approve' => Approvesuratkeluar::leftJoin('users', 'approver_id', 'users.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('kode', 'approve_status as statuss', 'approvesuratkeluars.created_at as waktu_komentar', 'approvesuratkeluars.*', 'last_name', 'first_name', 'kode', 'users.id as uid')->where('surat_keluar_id', $id)->get(),
            ]
            );
        }
        
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
        $input = Suratkeluar::where('id', $id)->first();
        if ($input->send_status==0 || $input->review_status==3 || $input->approve_status==3) {
            $this->validate($request, [
                'jenis_surat' => 'required',
                'departemen'  => 'required',
                'tgl_surat'  => 'required',
                'perihal' => 'required',
                'file_surat' => 'mimes:docx|max:20480',
                'file_lampiran' => 'mimes:pdf|max:20480',
            ]);
            
            $reqlampiran = Request_surat_keluar::select('lampiran')->where('id', $input->request_surat_keluar_id)->value('lampiran');

            
            if ($request->lampiran_radio == 1) {
                $input['lampiran'] = $reqlampiran;
            }elseif ($request->lampiran_radio == 2){
                $filenameL = $id.Str::random(16).'.pdf';
                $pathL = '';
                if ($request->file_lampiran!=0) {
                    if ($input->lampiran==$reqlampiran || $input->lampiran==null) {
                        $pathL = $request->file('file_lampiran')->storeAs('lampiran', $filenameL);
                    }else{
                        $lpr = Str::substr($input->lampiran, 9);
                        $pathL = $request->file('file_lampiran')->storeAs('lampiran', $lpr);
                    }
                    $input['lampiran'] = $pathL;
                }
            }else {
                $input['lampiran'] = '';
            }

            // get date from request

            $last_surat_keluar = DB::table('suratkeluars')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
            $tgl_surat_t = Carbon::createFromFormat('Y-m-d H:i:s', $request->tgl_surat)->isoFormat('D MMMM Y');
            
            // $isisurat = Isi_surat::where('surat_keluar_id', $id)->first();

            $input->jenis_surat_id = $request->jenis_surat;
            $input->departemen_id = $request->departemen;
            $input->tgl_surat = $request->tgl_surat;
            $input->perihal = $request->perihal;

            // fungsi tombol
            switch ($request->submitbutton) {
            case 'Kirim':

                $input['send_status'] = 1;
                $input['send_time'] = Carbon::now()->toDateTimeString();

                if ($input->isi_surat==null) {
                    $this->validate($request, [
                        'file_surat' => 'required|mimes:docx|max:20480',
                    ]);
                    if ($request->file_surat!=null) {
                        $sr = Str::substr($input->isi_surat, 12);
                        $pathS = $request->file('file_surat')->storeAs('suratkeluar', $sr.'.docx');
                        $converter = new OfficeConverter(Storage::path('suratkeluar/'.$sr.'.docx'));
                        $converter->convertTo($sr.'.pdf'); 
                        $input['isi_surat'] = 'suratkeluar/'.$sr;
                    }
                }
                
                if($input->approve_status == 3){
                    $input['approve_status'] = 5;
                }else{
                    $input['approve_status'] = 0;
                }
                // $link = route('boilerplate.surat-keluar-approve.edit', $id);
                // $mailto = DB::select('select email from permission_role left join role_user  on permission_role.role_id=role_user.role_id left join users on role_user.user_id=users.id where permission_id=7');
                // $details = [
                //     'title' => '',
                //     'body' => 'Surat Keluar '.$request->perihal,
                //     'body2' => 'Untuk approve surat keluar silahkan klik link ini '.$link,
                // ];

                $suratkeluar = $input->save();
                // $isisuratkeluar = $isisurat->save();

                // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
                $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 7)->first();
                $user->notify(new ApproveaSuratkeluar($id));

                return redirect()->route('boilerplate.surat-keluar-saya.index')
                                ->with('growl', [__('Surat berhasil dikirim'), 'success']);

                break;

            case 'Simpan Draft':
                // save to draft
                if ($input->isi_surat==null) {
                    if ($request->file_surat!=null) {
                        $sr = Str::substr($input->isi_surat, 12);
                        $pathS = $request->file('file_surat')->storeAs('suratkeluar', $sr.'.docx');
                        $converter = new OfficeConverter(Storage::path('suratkeluar/'.$sr.'.docx'));
                        $converter->convertTo($sr.'.pdf'); 
                        $input['isi_surat'] = 'suratkeluar/'.$sr;
                    }
                }
                $suratkeluar = $input->save();
                // $isisuratkeluar = $isisurat->save();

                return redirect()->route('boilerplate.surat-keluar-saya.index')
                                ->with('growl', [__('Surat berhasil disimpan'), 'success']);
                break;
            case 'Preview Surat':
                if ($input->isi_surat==null) {
                    return redirect()->route('boilerplate.surat-keluar-saya.index')
                                ->with('growl', [__('Belum ada lampiran'), 'danger']);
                }else {
                    $PdfDisk = Storage::disk('local')->get($input->isi_surat.'.pdf');
                    return (new Response($PdfDisk, 200))
                        ->header('Content-Type', 'application/pdf');
                }
                break;
            }
        }else {
            return redirect()->route('boilerplate.surat-keluar-saya.index')
                                ->with('growl', [__('Tidak dapat diedit'), 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Suratkeluar  $suratkeluar
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        //
        $send = Suratkeluar::where('id', $id)->first();
        if ($send->send_status==0) {
            $send['status'] = 0;
            $dele = $send->save();
        }else {
            return redirect()->route('boilerplate.surat-keluar-saya.index')
                            ->with('growl', [__('Tidak dapat dihapus'), 'danger']);
        }
        
    }

    public function detail($id)
    {
        //
    }

    public function unduh_format($id)
    {
        $file = 'a';
        if (Storage::disk('local')->exists(Jenis_surat::where('id', $id)->value('format'))) {
            $file= Storage::disk('local')->get(Jenis_surat::where('id', $id)->value('format'));
        }else {
            $file= Storage::disk('local')->get('format/surat-keluar.docx');
        }
        return (new Response($file, 200))
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        
    }

    public function unduh_lampiran($id)
    {
        if(Suratkeluar::where('id', $id)->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('lampiran'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.surat-keluar-request-buat')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
        
    }

    public function unduh_surat_lama($id)
    {
        if(Suratkeluar::where('id', $id)->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('isi_surat').'.pdf');
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.surat-keluar-request-buat')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
        
    }
    public function unduh_surat_jadi($id)
    {
        if(Suratkeluar::where('id', $id)->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('surat_jadi'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.surat-keluar-request-buat')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
        
    }

    
}
