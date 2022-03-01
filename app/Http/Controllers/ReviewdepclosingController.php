<?php

namespace App\Http\Controllers;

use App\Models\pengajuan;
use App\Models\closing;
use App\Models\isi_closing;
use App\Models\departemen;
use App\Models\jenis_pengajuan;
use App\Models\Isi_pengajuan;
use App\Models\reviewdepclosing;
use App\Models\reviewclosing;
use App\Models\approveclosing;
use App\Models\Boilerplate\User;
use App\Http\Requests\StorepengajuanRequest;
use App\Http\Requests\UpdatepengajuanRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Collection;
use App\Notifications\Boilerplate\ReviewaClosing;
use App\Notifications\Boilerplate\RevieweddepClosing;
use App\Notifications\Boilerplate\RevisiClosing;
use App\Notifications\Boilerplate\TolakClosing;
use Validator;
use Auth;
use DB;

class ReviewdepclosingController extends Controller
{
    public function index()
    {
        return view('boilerplate::closing-pengajuan.reviewdep');
        //
    }
    public function create($id)
    {
        $closing = closing::leftJoin('isi_closings', 'closing_id', 'closings.id')->select('closings.id as ida', 'closings.user_id as suser_id', 'closings.status as sstatus', 'isi_closings.*', 'closings.*', )->where('closings.id', $id)->first();
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen')->where('pengajuans.id', $closing->pengajuan_id)->first();
        if ($closing->send_status==1) {
            if( $closing->reviewdep_status == 0 || $closing->reviewdep_status == 5){
                DB::update('update closings set reviewdep_status = 1 where id = ?', [$id]);
            }
            $reviewdepclosing = reviewdepclosing::leftJoin('users', 'users.id', 'reviewdepclosings.reviewerdep_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('reviewdepclosings.created_at as waktu_komentar', 'reviewdep_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['reviewdepclosings.status', '=', 1]]);
            $reviewclosing = reviewclosing::leftJoin('users', 'users.id', 'reviewclosings.reviewer_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('reviewclosings.created_at as waktu_komentar', 'review_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['reviewclosings.status', '=', 1]]);
            $approveclosing = approveclosing::leftJoin('users', 'users.id', 'approveclosings.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approveclosings.created_at as waktu_komentar',  'approve_status as statuss','komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['approveclosings.status', '=', 1]])->union($reviewdepclosing)->union($reviewclosing)->get();
        
            return view('boilerplate::closing-pengajuan.detail-reviewdep', compact('closing'), [
                'isi_closing' => isi_closing::where([['closing_id', '=', $id], ['status', '=', 1]])->get(),
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $closing->pengajuan_id], ['status', '=', 1]])->get(),
                'jenis_pengajuan' => jenis_pengajuan::where('status', 1)->get(),
                'departemens' => departemen::where('status', 1)->get(),
                'komentar' => $approveclosing,
                'pengajuan' => $pengajuan,
            ]); 
        }
        return redirect()->route('boilerplate.reviewdep-closing-pengajuan')
            ->with('growl', [__('Closing pengajuan tidak ada'), 'danger']);
    }
    public function edit($id)
    {
        return view('boilerplate::closing-pengajuan.edit');
        //
    }
    public function store(Request $request, $id)
    {
        return view('boilerplate::closing-pengajuan.closing');
        //
    }
    public function update(Request $request, $id)
    {
        $closing = closing::where([['id', '=', $id],['status', '=', 1]])->first();
        $closing['reviewerdep_id'] = Auth::user()->id;
        $closing['reviewdep_time'] = Carbon::now()->toDateTimeString();

        $reviewdepclosing['closing_id'] = $id;
        $reviewdepclosing['user_id'] = $closing->user_id;
        $reviewdepclosing['reviewerdep_id'] = Auth::user()->id;
        $reviewdepclosing['komentar'] = $request->komentar;
        $link = route('boilerplate.edit-closing-pengajuan', $id);
        switch ($request->submitbutton) {
        case 'Setujui':
            if($closing->reviewdep_status == 2){
                return redirect()->route('boilerplate.reviewdep-closing-pengajuan')
                                ->with('growl', [__('Closing pengajuan telah disetujui'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // send
            if ($closing->review_status==3 || $closing->approve_status==3) {
                $closing['review_status'] = 5;
                $reviewdepclosing['review_status'] = 5;
            }
            $closing['reviewdep_status'] = 2;
            $reviewdepclosing['reviewdep_status'] = 2;
            $closing = $closing->save();
            $reviewdepclosinga = reviewdepclosing::create($reviewdepclosing);

            // $mailto = closing::leftJoin('users', 'users.id', 'closings.user_id')->where('closings.id', $id)->value('users.email');
            // $details = [
            //     'title' => '',
            //     'body' => 'Closing Pengajuan '.$request->closing,
            //     'body2' => 'Closing Pengajuan sudah direviewdep untuk melihat detail silahkan klik link ini '.$link,
            // ];
            
            // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            // $link2 = route('boilerplate.detail-review-closing-pengajuan', $id);

            // $mailto = DB::select('select email from permission_role left join role_user  on permission_role.role_id=role_user.role_id left join users on role_user.user_id=users.id where permission_id=13');
            //     $details = [
            //         'title' => '',
            //         'body' => 'Closing Pengajuan '.$request->closing,
            //         'body2' => 'Untuk review closing pengajuan silahkan klik link ini '.$link2,
            //     ];
            
            // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
            $user=User::leftJoin('closings', 'users.id', 'closings.user_id')->where('closings.id', $id)->first();
            $user->notify(new RevieweddepClosing($id));

            $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 13)->get();
            foreach ($user as $user) {
                $user->notify(new ReviewaClosing($id));
            }
            

            return redirect()->route('boilerplate.reviewdep-closing-pengajuan')
                            ->with('growl', [__('closing berhasil disetujui'), 'success']);
            }
            break;

        case 'Revisi':
            if($closing->reviewdep_status == 3){
                return redirect()->route('boilerplate.reviewdep-closing-pengajuan')
                                ->with('growl', [__('closing telah diminta revisi'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // revisi
            $closing['reviewdep_status'] = 3;
            $closing['revisi_status'] = 1;
            $reviewdepclosing['reviewdep_status'] = 3;

            $closing = $closing->save();
            $reviewdepclosinga = reviewdepclosing::create($reviewdepclosing);

            // $mailto = closing::leftJoin('users', 'users.id', 'closings.user_id')->where('closings.id', $id)->value('users.email');
            // $details = [
            //     'title' => '',
            //     'body' => 'Closing Pengajuan '.$request->closing,
            //     'body2' => 'closing harus direvisi terlebih dahulu untuk revisi silahkan klik link ini '.$link,
            // ];
            
            // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
            $user=User::leftJoin('closings', 'users.id', 'closings.user_id')->where('closings.id', $id)->first();
            $user->notify(new RevisiClosing($id));

            return redirect()->route('boilerplate.reviewdep-closing-pengajuan')
                            ->with('growl', [__('closing berhasil revisi'), 'success']);
            }
            break;
        
        case 'Tolak':
            if($closing->reviewdep_status == 4){
                return redirect()->route('boilerplate.reviewdep-closing-pengajuan')
                                ->with('growl', [__('closing telah ditolak'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // save to draft
            $closing['reviewdep_status'] = 4;
            $reviewdepclosing['reviewdep_status'] = 4;

            $closing = $closing->save();
            $reviewdepclosinga = reviewdepclosing::create($reviewdepclosing);

            // $mailto = closing::leftJoin('users', 'users.id', 'closings.user_id')->where('closings.id', $id)->value('users.email');
            // $details = [
            //     'title' => '',
            //     'body' => 'Closing Pengajuan '.$request->closing,
            //     'body2' => 'Closing Pengajuan ditolak untuk melihat detail silahkan klik link ini '.$link,
            // ];
            
            // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
            $user=User::leftJoin('closings', 'users.id', 'closings.user_id')->where('closings.id', $id)->first();
            $user->notify(new TolakClosing($id));

            return redirect()->route('boilerplate.reviewdep-closing-pengajuan')
                            ->with('growl', [__('closing berhasil ditolak'), 'success']);
            }
            break;
        }
    }
    public function unduh_lampiran($id)
    {
            $file= Storage::disk('local')->get(closing::where([['id', '=', $id], ['status', '=', 1]])->value('lampiran'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
    }
}
