<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengajuan;
use App\Models\Isi_pengajuan;
use App\Models\cekdeppengajuan;
use App\Models\cekpengajuan;
use App\Models\approvepengajuan;
use App\Models\departemen;
use App\Models\Boilerplate\User;
use App\Http\Requests\StorepengajuanRequest;
use App\Http\Requests\UpdatepengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Notifications\Boilerplate\ReviewPengajuan;
use App\Notifications\Boilerplate\RevieweddepPengajuan;
use App\Notifications\Boilerplate\RevisiPengajuan;
use App\Notifications\Boilerplate\TolakPengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Collection;
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
        if (departemen::where('id', pengajuan::where('id', $id)->first()->departemen_id)->first()->reviewerdep_id == Auth::user()->id || Auth::user()->departemen_id == pengajuan::where('id', $id)->first()->departemen_id) {
            $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->leftJoin('users', 'users.id', 'pengajuans.user_id')->select('first_name', 'last_name', 'pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen')->where([['pengajuans.id', '=', $id], ['pengajuans.status', '=', 1]])->first();
            if ($pengajuan->send_status==1) {
                if( $pengajuan->reviewdep_status == 0 || $pengajuan->reviewdep_status == 5){
                    DB::update('update pengajuans set reviewdep_status = 1 where id = ?', [$id]);
                }
                $reviewdeppengajuan = cekdeppengajuan::leftJoin('users', 'users.id', 'cekdeppengajuans.reviewerdep_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('cekdeppengajuans.created_at as waktu_komentar', 'reviewdep_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['pengajuan_id', '=', $id], ['cekdeppengajuans.status', '=', 1]]);
                $reviewpengajuan = cekpengajuan::leftJoin('users', 'users.id', 'cekpengajuans.reviewer_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('cekpengajuans.created_at as waktu_komentar', 'review_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['pengajuan_id', '=', $id], ['cekpengajuans.status', '=', 1]]);
                $approvepengajuan = approvepengajuan::leftJoin('users', 'users.id', 'approvepengajuans.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approvepengajuans.created_at as waktu_komentar',  'approve_status as statuss','komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['pengajuan_id', '=', $id], ['approvepengajuans.status', '=', 1]])->union($reviewdeppengajuan)->union($reviewpengajuan)->get();
                return view('boilerplate::pengajuan.detail-reviewdep', compact('pengajuan'), [
                    'komentar' => $approvepengajuan,
                    'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $id], ['status', '=', 1]])->get(),
                ]); 
            }  
            return redirect()->route('boilerplate.reviewdep-pengajuan')
                ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
        }else {
            return redirect()->route('boilerplate.reviewdep-pengajuan')
                ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
        }
        
        //
    }
    public function update(Request $request, $id)
    {
        if (departemen::where('id', pengajuan::where('id', $id)->first()->departemen_id)->first()->reviewerdep_id == Auth::user()->id || Auth::user()->departemen_id == pengajuan::where('id', $id)->first()->departemen_id) {
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

                $user=User::leftJoin('pengajuans', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->first();
                $user->notify(new RevieweddepPengajuan($id));

                $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 13)->first();
                $user->notify(new ReviewPengajuan($id));
                
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
                $pengajuan['revisi_status'] = 1;
                $reviewdeppengajuan['reviewdep_status'] = 3;

                $pengajuan = $pengajuan->save();
                $reviewdeppengajuana = cekdeppengajuan::create($reviewdeppengajuan);

                $user=User::leftJoin('pengajuans', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->first();
                $user->notify(new RevisiPengajuan($id));

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

                $user=User::leftJoin('pengajuans', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->first();
                $user->notify(new TolakPengajuan($id));

                return redirect()->route('boilerplate.reviewdep-pengajuan')
                                ->with('growl', [__('pengajuan berhasil ditolak'), 'success']);
                }
                break;
            }
        }else {
            return redirect()->route('boilerplate.reviewdep-pengajuan')
                ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
        }
    }
    public function unduh_lampiran($id)
    {
        if (departemen::where('id', pengajuan::where('id', $id)->first()->departemen_id)->first()->reviewerdep_id == Auth::user()->id || Auth::user()->departemen_id == pengajuan::where('id', $id)->first()->departemen_id) {
            $file= Storage::disk('local')->get(pengajuan::where([['id', '=', $id], ['status', '=', 1]])->value('lampiran'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.reviewdep-pengajuan')
                ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
        }
    }
}
