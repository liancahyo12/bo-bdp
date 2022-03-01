<?php

namespace App\Http\Controllers;

use App\Models\pengajuan;
use App\Models\Isi_pengajuan;
use App\Models\Boilerplate\User;
use App\Notifications\Boilerplate\BayaredPengajuan;
use App\Http\Requests\StorepengajuanRequest;
use App\Http\Requests\UpdatepengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Validator;
use Auth;
use DB;

class BayarpengajuanController extends Controller
{
    public function index()
    {
        return view('boilerplate::pengajuan.bayar');
    }

    public function create($id)
    {
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->leftJoin('users', 'users.id', 'pengajuans.user_id')->select('first_name', 'last_name', 'pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen')->where([['pengajuans.id', '=', $id], ['pengajuans.status', '=', 1]])->first();
        if ($pengajuan->review_status==2 || $pengajuan->reviewdep_status==2 || $pengajuan->approve_status==2) {
            return view('boilerplate::pengajuan.detail-bayar', compact('pengajuan'), [
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $id], ['status', '=', 1]])->get(),
            ]); 
        }  
        return redirect()->route('boilerplate.bayar-pengajuan')
            ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
    }

    public function update(Request $request, $id)
    {
        $pengajuan = pengajuan::where([['id', '=', $id], ['status', '=', 1]])->first();
        if ($pengajuan->review_status==2 || $pengajuan->reviewdep_status==2 || $pengajuan->approve_status==2 && $pengajuan->bayar_status==1) {
            $this->validate($request, [
                    'bukti_bayar' => 'required|mimes:pdf|max:20480',
            ]);
            $filename = $id.Str::random(16).'.pdf';
            $path ='';
            if ($request->bukti_bayar!=null) {
                $path = $request->file('bukti_bayar')->storeAs('bukti-bayar', $filename);
                $pengajuan['bukti_bayar'] = $path;
            }
            $pengajuan['bayar_status'] = 2;
            $pengajuan['bayar_time'] = Carbon::now()->toDateTimeString();;
            $pengajuan->save();

            $user=User::leftJoin('pengajuans', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->first();
            $user->notify(new BayaredPengajuan($id));

            return redirect()->route('boilerplate.bayar-pengajuan')
                ->with('growl', [__('Pengajuan berhasil dibayar'), 'success']);
        }
        return redirect()->route('boilerplate.bayar-pengajuan')
            ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
    }
    public function unduh_lampiran($id)
    {
        $file= Storage::disk('local')->get(pengajuan::where([['id', '=', $id], ['status', '=', 1]])->value('lampiran'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');
    }
    public function unduh_bukti($id)
    {
        $file= Storage::disk('local')->get(pengajuan::where([['id', '=', $id], ['status', '=', 1]])->value('bukti_bayar'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');
    }
    public function unduh_jadi($id)
    {
        $file= Storage::disk('local')->get(pengajuan::where([['id', '=', $id], ['status', '=', 1]])->value('pengajuan_jadi'));
        return (new Response($file, 200))
            ->header('Content-Type', 'application/pdf');
    }
}
