<?php

namespace App\Http\Controllers;

use App\Models\Request_surat_keluar;
use App\Http\Requests\StoreRequest_surat_keluarRequest;
use App\Http\Requests\UpdateRequest_surat_keluarRequest;
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
use App\Models\Review_request_surat_keluar;
use App\Models\Boilerplate\User;
use Carbon\Carbon;
use Hash;
use Auth;
use DB;
use Illuminate\Support\Facades\Storage;

class RequestSuratKeluarController extends Controller
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
        $requestsuratkeluar = new Request_surat_keluar();
    }

    public function index()
    {
        return view('boilerplate::surat-keluar.saya-request');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
    {
        return view('boilerplate::surat-keluar.buat-request', [
            'jenis_surat' => jenis_surat::all(),
            'departemens' => departemen::all(),
        ]);
    }

    public function review($id)
    {
        $input = Request_surat_keluar::where('id', $id)->first();
        if( $input->request_status == 0 || $input->request_status == 6){
            $input['request_status'] = 1;
            $reqsuratkeluar = $input->save();
        }    
        $reqsurat = Request_surat_keluar::leftJoin('jenis_surats', 'jenis_surat_id', 'jenis_surats.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('request_surat_keluars.id as ida', 'request_surat_keluars.*', 'jenis_surats.*', 'departemens.*')->where('request_surat_keluars.id', $id)->first();

        return view('boilerplate::surat-keluar.review-request', compact('reqsurat'),[
            'jenis_surat' => jenis_surat::all(),
            'departemens' => departemen::all(),
            'reqreview' => Review_request_surat_keluar::where('request_surat_keluar_id', $id)->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequest_surat_keluarRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $last_surat_keluar = DB::table('request_surat_keluars')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $idf = $last_surat_keluar+1;
        
        $this->validate($request, [
                'jenis_surata' => 'required',
                'departemen'  => 'required',
                'perihal' => 'required',
                'keterangan' => 'required',
                'files' => 'required|mimes:pdf|max:20480',
            ]);

        $filename = $idf.Str::random(16).'.pdf';
        $path = $request->file('files')->storeAs('lampiran', $filename);

        $input['user_id'] = Auth::user()->id;
        $input['jenis_surat_id'] = $request->jenis_surata;
        $input['departemen_id'] = $request->departemen;
        $input['perihal'] = $request->perihal;
        $input['keterangan'] = $request->keterangan;
        $input['lampiran'] = $path;
        $input['send_status'] = 1;
        $input['request_status'] = 0;
        $input['send_time'] = Carbon::now()->toDateTimeString();
        
        // $request->files->storeAs('Lampiran', $filename);

        $reqsuratkeluar = Request_surat_keluar::create($input);
        $mailto = DB::select('select email from role_user left join users on role_user.user_id=users.id where role_id=3 limit 1');
                $details = [
                    'title' => '',
                    'body' => 'Surat Keluar '.$request->perihal,
                    'body2' => 'Untuk mereview surat keluar silahkan klik link ini http://localhost:8000/surat-keluar-review/'.$idf,
                ];
        \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

           return redirect()->route('boilerplate.surat-keluar-request-buat')
                            ->with('growl', [__('Surat berhasil dikirim'), 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request_surat_keluar  $request_surat_keluar
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('boilerplate::surat-keluar.request');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request_surat_keluar  $request_surat_keluar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reqsurat = Request_surat_keluar::leftJoin('jenis_surats', 'jenis_surat_id', 'jenis_surats.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('request_surat_keluars.id as ida', 'request_surat_keluars.*', 'jenis_surats.*', 'departemens.*')->where('request_surat_keluars.id', $id)->first();

        return view('boilerplate::surat-keluar.edit-request', compact('reqsurat'),[
            'jenis_surat' => jenis_surat::all(),
            'departemens' => departemen::all(),
            'reqreview' => Review_request_surat_keluar::where('request_surat_keluar_id', $id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRequest_surat_keluarRequest  $request
     * @param  \App\Models\Request_surat_keluar  $request_surat_keluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
                'jenis_surat' => 'required',
                'departemen'  => 'required',
                'perihal' => 'required',
                'keterangan' => 'required',
                'files' => 'mimes:pdf|max:20480',
            ]);

        $input = Request_surat_keluar::where('id', $id)->first();

        $input->jenis_surat_id = $request->jenis_surat;
        $input->departemen_id = $request->departemen;
        $input->perihal = $request->perihal;
        $input->keterangan = $request->keterangan;
        if ($request->file!=null) {
            $request->file('files')->storeAs($input->lampiran);
        }
        

        if ($input->request_status==4) {
            $input->request_status = 6;
            $reqsuratkeluar = $input->save();
            $mailto = DB::select('select email from role_user left join users on role_user.user_id=users.id where role_id=3 limit 1');
                $details = [
                    'title' => '',
                    'body' => 'Surat Keluar '.$request->perihal,
                    'body2' => 'Untuk mereview permintaan surat keluar silahkan klik link ini http://localhost:8000/surat-keluar-request-review/'.$id,
                ];
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-request-saya.index')
                                ->with('growl', [__('Revisi permintaan berhasil dikirim'), 'success']);
        }else {
            return redirect()->route('boilerplate.surat-keluar-request-saya.index')
                                ->with('growl', [__('Permintaan tidak perlu diedit'), 'warning']);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request_surat_keluar  $request_surat_keluar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request_surat_keluar $request_surat_keluar)
    {
        //
    }
    public function download($id)
    {
        if(Request_surat_keluar::where(['id', $id])->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(Request_surat_keluar::where('id', $id)->value('lampiran'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.surat-keluar-request-buat')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
        
    }
    public function download_review($id)
    {
        $file= Storage::disk('local')->get(Request_surat_keluar::where('id', $id)->value('lampiran'));
        return (new Response($file, 200))
              ->header('Content-Type', 'application/pdf');
    }
    public function update_review(Request $request, $id)
    {
        $this->validate($request, [
                'komentar' => 'required',
            ]);
        
        $input = Request_surat_keluar::where('id', $id)->first();
        $input['reviewer_id'] = Auth::user()->id;
        $input['request_time'] = Carbon::now()->toDateTimeString();
        $komenreq['request_surat_keluar_id'] = $id;
        $komenreq['komentar'] = $request->komentar;
        $komenreq['reviewer_id'] = Auth::user()->id;
        

        switch ($request->submitbutton) {
        case 'Buat Surat':
            // send
            
            $input['request_status'] = 2;
            $komenreq['request_status'] = 2;
            
            $reqsuratkeluar = $input->save();
            $reqreviewsurat = Review_request_surat_keluar::create($komenreq);
            
            $mailto = Request_surat_keluar::leftJoin('users', 'users.id', 'request_surat_keluars.user_id')->where('request_surat_keluars.id', $id)->value('email');
            $details = [
                'title' => '',
                'body' => 'Permintaan Surat Keluar'.$request->perihal,
                'body2' => 'Surat anda sedang diproses untuk melihat detail silahkan klik link ini http://localhost:8000/surat-keluar-request-saya/'.$id.'/edit',
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect('surat-keluar-buat/'.$id)
                            ->with('growl', [__('Review berhasil dikirim'), 'success']);

            break;

        case 'Revisi':
            // revisi
            $input['request_status'] = 4;
            $komenreq['request_status'] = 4;
            
            $reqsuratkeluar = $input->save();
            $reqreviewsurat = Review_request_surat_keluar::create($komenreq);

            $mailto = Request_surat_keluar::leftJoin('users', 'users.id', 'request_surat_keluars.user_id')->where('request_surat_keluars.id', $id)->value('email');
            $details = [
                'title' => '',
                'body' => 'Permintaan Surat Keluar'.$request->perihal,
                'body2' => 'Permintaan harus direvisi terlebih dahulu untuk revisi silahkan klik link ini http://localhost:8000/surat-keluar-request-saya/'.$id.'/edit',
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-request-review')
                            ->with('growl', [__('Review berhasil disimpan'), 'success']);
            break;
        case 'Tolak':
            $input['request_status'] = 5;
            $komenreq['request_status'] = 5;
            
            $reqsuratkeluar = $input->save();
            $reqreviewsurat = Review_request_surat_keluar::create($komenreq);

            $mailto = Request_surat_keluar::leftJoin('users', 'users.id', 'request_surat_keluars.user_id')->where('request_surat_keluars.id', $id)->value('email');
            $details = [
                'title' => '',
                'body' => 'Permintaan Surat Keluar'.$request->perihal,
                'body2' => 'Permintaan anda ditolak untuk melihat detail silahkan klik link ini http://localhost:8000/surat-keluar-request-saya/'.$id.'/edit',
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.surat-keluar-request-review')
                            ->with('growl', [__('Review berhasil disimpan'), 'success']);
            break;
        }
    }
}
