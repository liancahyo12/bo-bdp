<?php

namespace App\Http\Controllers;

use App\Models\Suratkeluar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Input;
use App\Models\jenis_surat;
use App\Models\departemen;
use App\Models\Boilerplate\User;
use NcJoes\OfficeConverter\OfficeConverter;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;

class ArsipSuratKeluarController extends Controller
{
    public function index()
    {
        return view('boilerplate::surat-keluar.arsip');
    }
    public function show($id)
    {
        $arsipa = Suratkeluar::where('id', $id)->first();
        if ($arsipa->approve_status==2) {
            $arsip = Suratkeluar::leftJoin('jenis_surats', 'jenis_surat_id', 'jenis_surats.id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->leftJoin('users', 'user_id', 'users.id')->select('suratkeluars.id as ida', 'suratkeluars.*', 'jenis_surats.*', 'departemens.*', 'users.*')->where('suratkeluars.id', $id)->first();

            return view('boilerplate::surat-keluar.edit-arsip', compact('arsip'),[

            ]);
        }
        return redirect()->route('boilerplate.surat-keluar-arsip')
            ->with('growl', [__('Arsip tidak ada'), 'danger']);
    }
    public function update(Request $request, $id)
    {
        $input = Suratkeluar::where('id', $id)->first();
        if ($input->surat_scan==null) {
            $this->validate($request, [
                'file' => 'required|mimes:pdf|max:20480',
            ]);
            $filename = $id.Str::random(16).'.pdf';
            $path = $request->file('file')->storeAs('suratkeluarscan', $filename);
            $input['surat_scan'] = $path;
            $input['scan_time'] = Carbon::now()->toDateTimeString();
            $suratkeluar = $input->save();
            return redirect()->route('boilerplate.surat-keluar-arsip')
                ->with('growl', [__('Unggah Surat Scan Berhasil'), 'success']);
        }
        return redirect()->route('boilerplate.surat-keluar-arsip')
            ->with('growl', [__('Surat scan sudah diuanggah'), 'danger']);
    }
    public function unduh_lampiran($id)
    {
        $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('lampiran'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');        
    }
    public function unduh_surat($id)
    {
        $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('surat_jadi'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');        
    }
    public function unduh_surat_scan($id)
    {
        $file= Storage::disk('local')->get(Suratkeluar::where('id', $id)->value('surat_scan'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');        
    }
}
