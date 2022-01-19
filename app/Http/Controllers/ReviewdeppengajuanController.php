<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengajuan;
use App\Models\Isi_pengajuan;
use App\Models\cekdeppengajuan;
use App\Http\Requests\StorepengajuanRequest;
use App\Http\Requests\UpdatepengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Validator;
use Auth;
use DB;

class ReviewdeppengajuanController extends Controller
{
    public function index()
    {
        return view('boilerplate::pengajuan.reviewdep');
        //
    }
    public function create($id)
    {
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen')->where([['pengajuans.id', '=', $id], ['pengajuans.status', '=', 1]])->first();
        if ($pengajuan->send_status==1) {
            if( $pengajuan->reviewdep_status == 0 || $pengajuan->reviewdep_status == 5){
                DB::update('update pengajuans set reviewdep_status = 1 where id = ?', [$id]);
            }
            return view('boilerplate::pengajuan.detail-reviewdep', compact('pengajuan'), [
                'reviewdeppengajuan' => cekdeppengajuan::leftJoin('users', 'users.id', 'cekdeppengajuans.reviewerdep_id')->select('cekdeppengajuans.*', 'users.first_name')->where([['pengajuan_id', '=', $id], ['cekdeppengajuans.status', '=', 1]])->get(),
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $id], ['status', '=', 1]])->get(),
            ]); 
        }  
        return redirect()->route('boilerplate.reviewdep-pengajuan')
            ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
        //
    }
    public function update(Request $request, $id)
    {
        $pengajuan = pengajuan::where([['id', '=', $id],['status', '=', 1]])->first();
        $pengajuan['reviewerdep_id'] = Auth::user()->id;
        $pengajuan['reviewdep_time'] = Carbon::now()->toDateTimeString();

        $reviewdeppengajuan['pengajuan_id'] = $id;
        $reviewdeppengajuan['user_id'] = DB::table('pengajuans')->select('user_id')->where('id', $id)->value('user_id');
        $reviewdeppengajuan['reviewerdep_id'] = Auth::user()->id;
        $reviewdeppengajuan['komentar'] = $request->komentar;
        $link = route('boilerplate.edit-pengajuan', $id);
        switch ($request->submitbutton) {
        case 'Setujui':
            if($pengajuan->reviewdep_status == 2){
                return redirect()->route('boilerplate.reviewdep-pengajuan')
                                ->with('growl', [__('pengajuan telah disetujui'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // send
            if ($pengajuan->review_status==3 || $pengajuan->approve_status==3) {
                $pengajuan['review_status'] = 5;
                $reviewdeppengajuan['review_status'] = 5;
            }
            $pengajuan['reviewdep_status'] = 2;
            $reviewdeppengajuan['reviewdep_status'] = 2;
            $pengajuan = $pengajuan->save();
            $reviewdeppengajuana = cekdeppengajuan::create($reviewdeppengajuan);

            $mailto = pengajuan::leftJoin('users', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->value('users.email');
            $details = [
                'title' => '',
                'body' => 'Pengajuan '.$request->perihal,
                'body2' => 'Pengajuan sudah direviewdep untuk melihat detail silahkan klik link ini '.$link,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.reviewdep-pengajuan')
                            ->with('growl', [__('pengajuan berhasil disetujui'), 'success']);
            }
            break;

        case 'Revisi':
            if($pengajuan->reviewdep_status == 3){
                return redirect()->route('boilerplate.reviewdep-pengajuan')
                                ->with('growl', [__('pengajuan telah diminta revisi'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // revisi
            $pengajuan['reviewdep_status'] = 3;
            $reviewdeppengajuan['reviewdep_status'] = 3;

            $pengajuan = $pengajuan->save();
            $reviewdeppengajuana = cekdeppengajuan::create($reviewdeppengajuan);

            $mailto = pengajuan::leftJoin('users', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->value('users.email');
            $details = [
                'title' => '',
                'body' => 'Pengajuan '.$request->perihal,
                'body2' => 'Pengajuan harus direvisi terlebih dahulu untuk revisi silahkan klik link ini '.$link,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.reviewdep-pengajuan')
                            ->with('growl', [__('pengajuan berhasil revisi'), 'success']);
            }
            break;
        
        case 'Tolak':
            if($pengajuan->reviewdep_status == 4){
                return redirect()->route('boilerplate.reviewdep-pengajuan')
                                ->with('growl', [__('pengajuan telah ditolak'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // save to draft
            $pengajuan['reviewdep_status'] = 4;
            $reviewdeppengajuan['reviewdep_status'] = 4;

            $pengajuan = $pengajuan->save();
            $reviewdeppengajuana = cekdeppengajuan::create($reviewdeppengajuan);

            $mailto = pengajuan::leftJoin('users', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->value('users.email');
            $details = [
                'title' => '',
                'body' => 'Pengajuan '.$request->perihal,
                'body2' => 'Pengajuan ditolak untuk melihat detail silahkan klik link ini '.$link,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.reviewdep-pengajuan.index')
                            ->with('growl', [__('pengajuan berhasil ditolak'), 'success']);
            }
            break;
        }
    }
    public function unduh_lampiran($id)
    {
            $file= Storage::disk('local')->get(pengajuan::where([['id', '=', $id], ['status', '=', 1]])->value('lampiran'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
    }
}
