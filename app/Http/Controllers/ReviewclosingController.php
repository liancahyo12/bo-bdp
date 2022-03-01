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
use App\Notifications\Boilerplate\ApproveaClosing;
use App\Notifications\Boilerplate\ReviewedClosing;
use App\Notifications\Boilerplate\ReviewedpClosing;
use App\Notifications\Boilerplate\RevisiClosing;
use App\Notifications\Boilerplate\RevisipClosing;
use App\Notifications\Boilerplate\TolakClosing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Collection;
use Validator;
use Auth;
use DB;

class ReviewclosingController extends Controller
{
    public function index()
    {
        return view('boilerplate::closing-pengajuan.review');
        //
    }
    public function create($id)
    {
        $closing = closing::leftJoin('isi_closings', 'closing_id', 'closings.id')->select('closings.id as ida', 'closings.user_id as suser_id', 'closings.status as sstatus', 'isi_closings.*', 'closings.*', )->where('closings.id', $id)->first();
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen')->where('pengajuans.id', $closing->pengajuan_id)->first();
        if ($closing->send_status==1) {
            if( $closing->review_status == 0 || $closing->review_status == 5){
                DB::update('update closings set review_status = 1 where id = ?', [$id]);
            }
            $reviewdepclosing = reviewdepclosing::leftJoin('users', 'users.id', 'reviewdepclosings.reviewerdep_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('reviewdepclosings.created_at as waktu_komentar', 'reviewdep_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['reviewdepclosings.status', '=', 1]]);
            $reviewclosing = reviewclosing::leftJoin('users', 'users.id', 'reviewclosings.reviewer_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('reviewclosings.created_at as waktu_komentar', 'review_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['reviewclosings.status', '=', 1]]);
            $approveclosing = approveclosing::leftJoin('users', 'users.id', 'approveclosings.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approveclosings.created_at as waktu_komentar',  'approve_status as statuss','komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['approveclosings.status', '=', 1]])->union($reviewdepclosing)->union($reviewclosing)->get();
        
            return view('boilerplate::closing-pengajuan.detail-review', compact('closing'), [
                'isi_closing' => isi_closing::where([['closing_id', '=', $id], ['status', '=', 1]])->get(),
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $closing->pengajuan_id], ['status', '=', 1]])->get(),
                'jenis_pengajuan' => jenis_pengajuan::where('status', 1)->get(),
                'departemens' => departemen::where('status', 1)->get(),
                'komentar' => $approveclosing,
                'pengajuan' => $pengajuan,
            ]); 
        }
        return redirect()->route('boilerplate.review-closing-pengajuan')
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
        $this->validate($request, [
                    'komentar' => 'required',
                ]);
        $closing = closing::where([['id', '=', $id],['status', '=', 1]])->first();
        
        if ($closing->pengembalian_status==1 || $closing->pengembalian_status==3) {
            $closing['rev_pengembalian_time'] = Carbon::now()->toDateTimeString();
        }else {
            $closing['reviewer_id'] = Auth::user()->id;
            $closing['review_time'] = Carbon::now()->toDateTimeString();
        }

        $reviewclosing['closing_id'] = $id;
        $reviewclosing['user_id'] = $closing->user_id;
        $reviewclosing['reviewer_id'] = Auth::user()->id;
        $reviewclosing['komentar'] = $request->komentar;
        $link = route('boilerplate.edit-closing-pengajuan', $id);
        switch ($request->submitbutton) {
        case 'Setujui':
            if ($closing->pengembalian_status==4 || $closing->pengembalian_status==5) {
                if($closing->pengembalian_status == 2){
                    return redirect()->route('boilerplate.review-closing-pengajuan')
                        ->with('growl', [__('Pengembalian telah disetujui'), 'danger']);
                }else{
                    $closing['pengembalian_status'] = 2;
                    $reviewclosing['review_status'] = 2;
                    $closing = $closing->save();
                    $reviewclosinga = reviewclosing::create($reviewclosing);
                    $user=User::leftJoin('closings', 'users.id', 'closings.user_id')->where('closings.id', $id)->first();
                    $user->notify(new ReviewedpClosing($id));

                    return redirect()->route('boilerplate.review-closing-pengajuan')
                            ->with('growl', [__('Pengembalian berhasil disetujui'), 'success']);
                }
            }else {
                if($closing->review_status == 2){
                    return redirect()->route('boilerplate.review-closing-pengajuan')
                                    ->with('growl', [__('Closing pengajuan telah disetujui'), 'danger']);
                }else{
                // send
                    if ($closing->approve_status==3) {
                        $closing['approve_status'] = 5;
                        $reviewdepclosing['approve_status'] = 5;
                    }
                    $closing['review_status'] = 2;
                    $reviewclosing['review_status'] = 2;
                    $closing = $closing->save();
                    $reviewclosinga = reviewclosing::create($reviewclosing);

                    $user=User::leftJoin('closings', 'users.id', 'closings.user_id')->where('closings.id', $id)->first();
                    $user->notify(new ReviewedClosing($id));

                    $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 15)->get();
                    foreach ($user as $user) {
                        $user->notify(new ApproveaClosing($id));
                    }

                    return redirect()->route('boilerplate.review-closing-pengajuan')
                                    ->with('growl', [__('closing berhasil disetujui'), 'success']);
                }
            }
            break;

        case 'Revisi':
            if ($closing->pengembalian_status==4 || $closing->pengembalian_status==5) {
                if($closing->pengembalian_status == 5){
                    return redirect()->route('boilerplate.review-closing-pengajuan')
                        ->with('growl', [__('Pengembalian telah diminta revisi'), 'danger']);
                }else{
                    $closing['pengembalian_status'] = 3;
                    $reviewclosing['review_status'] = 3;
                    $closing = $closing->save();
                    $reviewclosinga = reviewclosing::create($reviewclosing);
                    $user=User::leftJoin('closings', 'users.id', 'closings.user_id')->where('closings.id', $id)->first();
                    $user->notify(new RevisipClosing($id));

                    return redirect()->route('boilerplate.review-closing-pengajuan')
                            ->with('growl', [__('Pengembalian berhasil diminta revisi'), 'success']);
                }
            }else {
                if($closing->review_status == 3){
                    return redirect()->route('boilerplate.review-closing-pengajuan')
                                    ->with('growl', [__('closing telah diminta revisi'), 'danger']);
                }else{
                    $this->validate($request, [
                        'komentar' => 'required',
                    ]);
                    // revisi
                    $closing['review_status'] = 3;
                    $closing['revisi_status'] = 1;
                    $reviewclosing['review_status'] = 3;

                    $closing = $closing->save();
                    $reviewclosinga = reviewclosing::create($reviewclosing);

                    $user=User::leftJoin('closings', 'users.id', 'closings.user_id')->where('closings.id', $id)->first();
                    $user->notify(new RevisiClosing($id));

                    return redirect()->route('boilerplate.review-closing-pengajuan')
                                    ->with('growl', [__('closing berhasil diminta revisi'), 'success']);
                }
            }

            break;
        
        case 'Tolak':
            if($closing->review_status == 4){
                return redirect()->route('boilerplate.review-closing-pengajuan')
                                ->with('growl', [__('closing telah ditolak'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // save to draft
            $closing['review_status'] = 4;
            $reviewclosing['review_status'] = 4;

            $closing = $closing->save();
            $reviewclosinga = reviewclosing::create($reviewclosing);

            $user=User::leftJoin('closings', 'users.id', 'closings.user_id')->where('closings.id', $id)->first();
            $user->notify(new TolakClosing($id));

            return redirect()->route('boilerplate.review-closing-pengajuan')
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

    public function unduh_bukti_pengembalian($id)
    {
            $file= Storage::disk('local')->get(closing::where([['id', '=', $id], ['status', '=', 1]])->value('bukti_pengembalian'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
    }
}
