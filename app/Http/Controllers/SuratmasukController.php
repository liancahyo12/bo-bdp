<?php

namespace App\Http\Controllers;

use App\Models\Suratmasuk;
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
use App\Models\Boilerplate\User;
use Carbon\Carbon;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Boilerplate\Suratmasuka;
use Auth;
use DB;

class SuratmasukController extends Controller
{
    public function index()
    {
        return view('boilerplate::surat-masuk.surat-masuk');
        //
    }
    public function create()
    {
        return view('boilerplate::surat-masuk.buat', [
            'departemens' => departemen::all(),
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
                'departemen'  => 'required',
                'tgl_surat'  => 'required',
                'tgl_diterima'  => 'required',
                'ringkasan' => 'required',
                'no_surat' => 'required',
                'pengirim' => 'required',
                'file_surat' => 'mimes:pdf|max:20480',
            ]);

        $input['user_id'] = Auth::user()->id;
        $last_surat_masuk = DB::table('suratmasuks')->select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $ssr = $last_surat_masuk+1;
        $filenameS = $ssr.Str::random(16);
        $pathS ='';
        if ($request->file_surat!=null) {
            $pathS = $request->file('file_surat')->storeAs('suratmasuk', $filenameS.'.pdf');
            $input['isi_surat'] = 'suratmasuk/'.$filenameS.'.pdf';
        }
        
        $input['departemen_id'] = $request->departemen;
        $input['tgl_diterima'] = $request->tgl_diterima;
        $input['tgl_surat'] = $request->tgl_surat;
        $input['ringkasan'] = $request->ringkasan;
        $input['no_surat'] = $request->no_surat;
        $input['pengirim'] = $request->pengirim;
        $suratmasuk = Suratmasuk::create($input);

        $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where([['permission_id', '=', 20], ['users.departemen_id', '=', $request->departemen]])->get();
        foreach ($user as $user) {
            $user->notify(new Suratmasuka($ssr));
        }

        return redirect()->route('boilerplate.surat-masuk-saya')
                ->with('growl', [__('Surat berhasil dikirim'), 'success']);
    }
    public function edit($id)
    {
        return view('boilerplate::surat-masuk.edit');
        //
    }
    public function update(Request $request, $id)
    {
        return view('boilerplate::surat-masuk.surat-masuk');
        //
    }
    public function arsip()
    {
        return view('boilerplate::surat-masuk.arsip');
        //
    }
    public function saya()
    {
        return view('boilerplate::surat-masuk.saya');
        //
    }
    public function detail($id)
    {
        if(Suratmasuk::where('id', $id)->value('departemen_id') == Auth::user()->departemen_id){
            return view('boilerplate::surat-masuk.detail', [
                'suratmasuk' => Suratmasuk::where([['departemen_id', '=', Auth::user()->departemen_id], ['status', '=', 1], ['id', '=', $id]])->first(),
                'departemens' => departemen::all(),
            ]);
        }else {
            return redirect()->route('boilerplate.surat-masuk')
                            ->with('growl', [__('Anda tidak memiliki akses surat ini'), 'warning']);
        }
    }
    public function detail_arsip($id)
    {
        return view('boilerplate::surat-masuk.detail', [
                'suratmasuk' => Suratmasuk::where([['status', '=', 1], ['id', '=', $id]])->first(),
                'departemens' => departemen::all(),
            ]);
    }
    public function detail_saya($id)
    {
        if(Suratmasuk::where('id', $id)->value('user_id') == Auth::user()->id){
            return view('boilerplate::surat-masuk.detail', [
                'suratmasuk' => Suratmasuk::where([['user_id', '=', Auth::user()->id], ['status', '=', 1], ['id', '=', $id]])->first(),
                'departemens' => departemen::all(),
            ]);
        }else {
            return redirect()->route('boilerplate.surat-masuk-saya')
                            ->with('growl', [__('Anda tidak memiliki akses surat ini'), 'warning']);
        }
    }

    public function file_saya($id)
    {
        if(Suratmasuk::where('id', $id)->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(Suratmasuk::where([['status', '=', 1], ['id', '=', $id]])->value('isi_surat'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.surat-masuk-saya')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
    }
    public function file($id)
    {
        if(Suratmasuk::where('id', $id)->value('departemen_id') == Auth::user()->departemen_id){
            $file= Storage::disk('local')->get(Suratmasuk::where([['status', '=', 1], ['id', '=', $id]])->value('isi_surat'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.surat-masuk')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
    }
    public function file_arsip($id)
    {
        $file= Storage::disk('local')->get(Suratmasuk::where([['status', '=', 1], ['id', '=', $id]])->value('isi_surat'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');
    }
}
