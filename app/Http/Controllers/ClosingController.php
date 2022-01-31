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
use App\Notifications\Boilerplate\ReviewdepaClosing;
use Validator;
use Auth;
use DB;

class ClosingController extends Controller
{
    public function index()
    {
        return view('boilerplate::closing-pengajuan.closing');
        //
    }
    public function create($id)
    {

        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->leftJoin('closings', 'closings.pengajuan_id', 'pengajuans.id')->select('pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen', 'closings.pengajuan_id as idp')->where('pengajuans.id', $id)->first();
        if ($pengajuan->suser_id != Auth::user()->id || $pengajuan->sstatus==0) {
            return redirect()->route('boilerplate.saya-pengajuan')
                            ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
        }
        if ($pengajuan->idp!=null) {
            return redirect()->route('boilerplate.saya-closing-pengajuan')
                ->with('growl', [__('Closing telah dibuat'), 'danger']);
        }else if (($pengajuan->jenis_pengajuan_id==3 ||$pengajuan->jenis_pengajuan_id==5 ) &&$pengajuan->reviewdep_status==2 && $pengajuan->review_status==2 &&$pengajuan->approve_status==2) {
            return view('boilerplate::closing-pengajuan.buat', compact('pengajuan'), 
            // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
            [
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $id], ['status', '=', 1]])->get(),
                'jenis_pengajuan' => jenis_pengajuan::all(),
                'departemens' => departemen::all(),
                
            ]
            );
        }else{
            return redirect()->route('boilerplate.saya-pengajuan')
                ->with('growl', [__('Pengajuan belum diapprove atau tidak perlu closing'), 'danger']);
        }
    }
    public function edit($id)
    {
        $closing = closing::leftJoin('isi_closings', 'closing_id', 'closings.id')->select('closings.id as ida', 'closings.user_id as suser_id', 'closings.status as sstatus', 'isi_closings.*', 'closings.*', )->where('closings.id', $id)->first();
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen')->where('pengajuans.id', $closing->pengajuan_id)->first();
        if ($closing->suser_id != Auth::user()->id || $closing->sstatus==0) {
            return redirect()->route('boilerplate.saya-closing-pengajuan')
                            ->with('growl', [__('Closing tidak ada'), 'danger']);
        }
        $reviewdepclosing = reviewdepclosing::leftJoin('users', 'users.id', 'reviewdepclosings.reviewerdep_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('reviewdepclosings.created_at as waktu_komentar', 'reviewdep_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['reviewdepclosings.status', '=', 1]]);
        $reviewclosing = reviewclosing::leftJoin('users', 'users.id', 'reviewclosings.reviewer_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('reviewclosings.created_at as waktu_komentar', 'review_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['reviewclosings.status', '=', 1]]);
        $approveclosing = approveclosing::leftJoin('users', 'users.id', 'approveclosings.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approveclosings.created_at as waktu_komentar',  'approve_status as statuss','komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['closing_id', '=', $id], ['approveclosings.status', '=', 1]])->union($reviewdepclosing)->union($reviewclosing)->get();
        
        if ($closing->revisi_status == 1) {
            return view('boilerplate::closing-pengajuan.edit', compact('closing'), 
            // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
            [
                'isi_closing' => isi_closing::where([['closing_id', '=', $id], ['status', '=', 1]])->get(),
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $closing->pengajuan_id], ['status', '=', 1]])->get(),
                'jenis_pengajuan' => jenis_pengajuan::all(),
                'departemens' => departemen::all(),
                'komentar' => $approveclosing,
                'pengajuan' => $pengajuan,
                
            ]
            );
        }else {
            return view('boilerplate::closing-pengajuan.detail', compact('closing'), 
            // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
            [
                'isi_closing' => Isi_closing::where([['closing_id', '=', $id], ['status', '=', 1]])->get(),
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $closing->pengajuan_id], ['status', '=', 1]])->get(),
                'jenis_pengajuan' => jenis_pengajuan::all(),
                'departemens' => departemen::all(),
                'komentar' => $approveclosing,
                'pengajuan' => $pengajuan,
                
            ]
            );
        }
        //
    }
    public function store(Request $request, $id)
    {
        $inclosing = [];
        $input = [];
        $total = 0;
        $this->validate($request, [
                'tgl_closing'  => 'required',
                'catatana' => 'required',
                'file_lampiran' => 'mimes:pdf|max:20480',
        ]);
        $pengajuan = pengajuan::where('id',$id)->first();
        if (($pengajuan->jenis_pengajuan_id==3 ||$pengajuan->jenis_pengajuan_id==5 ) &&$pengajuan->reviewdep_status==2 && $pengajuan->review_status==2 &&$pengajuan->approve_status==2) {
            $input['user_id'] = Auth::user()->id;
            $input['pengajuan_id'] = $id;
            $input['jenis_pengajuan_id'] = $pengajuan->jenis_pengajuan_id;
            $input['departemen_id'] = Auth::user()->departemen_id;
            $input['closing'] = 'Closing '.$pengajuan->pengajuan;
            $input['no_urut'] = $pengajuan->no_urut;
            $input['no_pengajuan'] = $pengajuan->no_pengajuan;
            $input['catatan'] = $request->catatana;
            $input['tgl_closing'] = $request->tgl_closing;

            $last_closing = closing::select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
            $idf = $last_closing+1;

            $filename = $idf.Str::random(16).'.pdf';
            $path ='';
            if ($request->file_lampiran!=null) {
                $path = $request->file('file_lampiran')->storeAs('lampiran-pengajuan', $filename);
                $input['lampiran'] = $path;
            }
            foreach($request->input('transaksia') as $key => $value) {
                    $inclosing["transaksia.{$key}"] = 'required';
                    $inclosing["nominala.{$key}"] = 'required';
                }
            $validator = Validator::make($request->all(), $inclosing);
            if ($validator->passes()) {
                foreach($request->transaksia as $key => $value) {
                    $inclosing['transaksi'] = $value;
                    $inclosing['nominal'] = $request->nominala[$key];
                    $inclosing['closing_id'] = $idf;
                    $inclosing['pengajuan_id'] = $id;
                    $inclosing['jenis_pengajuan_id'] = $pengajuan->jenis_pengajuan_id;
                    $isipengajuan = Isi_closing::create($inclosing);
                    $total += $request->nominala[$key];
                }
                $input['total_nominal'] = $total;
            }
            $input['send_status'] = 1;
            $input['send_time'] = Carbon::now()->toDateTimeString();
            $input['reviewdep_status'] = 0;
            $pengajuann = closing::create($input);
            // $link = route('boilerplate.detail-reviewdep-closing-pengajuan', $idf);
            // // $isisuratkeluar = Isi_surat::create($isisurat);

            //     $mailto = DB::select('select email from role_user left join users on role_user.user_id=users.id where role_id=5 limit 1');
            //     $details = [
            //         'title' => '',
            //         'body' => 'Pengajuan '.$request->pengajuan,
            //         'body2' => 'Untuk review pengajuan silahkan klik link ini '.$link,
            //     ];
            
            // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
            $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 12)->first();
            $user->notify(new ReviewdepaClosing($idf));

            return redirect()->route('boilerplate.saya-pengajuan')
                            ->with('growl', [__('Pengajuan berhasil dikirim'), 'success']);
        }else {
            return redirect()->route('boilerplate.saya-pengajuan')
                ->with('growl', [__('Pengajuan belum diapprove atau tidak perlu closing'), 'danger']);
        }
    }
    public function update(Request $request, $id)
    {
        $input = closing::where([['id', '=', $id], ['user_id', '=', Auth::user()->id]])->first();
        if ($input->status==1 && ( $input->reviewdep_status==3 || $input->review_status==3 || $input->approve_status==3) ) {
            $total = 0;
            $this->validate($request, [
                    'tgl_closing'  => 'required',
                    'catatana' => 'required',
                    'file_lampiran' => 'required|mimes:pdf|max:20480',
            ]);
            $input['catatan'] = $request->catatana;
            $input['tgl_closing'] = $request->tgl_closing;
            $filename = Str::substr($input->lampiran, 19);
            $path ='';
            if ($request->file_lampiran!=null) {
                $path = $request->file('file_lampiran')->storeAs('lampiran-pengajuan', $filename);
            }

            foreach($request->input('transaksia') as $key => $value) {
                    $inclosing["transaksia.{$key}"] = 'required';
                    $inclosing["nominala.{$key}"] = 'required';
                }
            $validator = Validator::make($request->all(), $inclosing);
            if ($validator->passes()) {
                Isi_closing::where('closing_id', $id)->update(['status' => 0]);
                foreach($request->transaksia as $key => $value) {
                    $inclosing['transaksi'] = $value;
                    $inclosing['nominal'] = $request->nominala[$key];
                    $inclosing['closing_id'] = $id;
                    $inclosing['pengajuan_id'] = $input->pengajuan_id;
                    $inclosing['jenis_pengajuan_id'] = $input->jenis_pengajuan_id;
                    $isipengajuan = Isi_closing::create($inclosing);
                    $total += $request->nominala[$key];
                }
                $input['total_nominal'] = $total;
            }
            if ($input->send_status == 1 && $input->revisi_status==1) {
                    $input['reviewdep_status'] = 5;
                    $input['revisi_status'] = 2;
                }elseif ($input->send_status == 0) {
                    $input['send_status'] = 1;
                }else {
                    return redirect()->route('boilerplate.saya-closing-pengajuan')
                        ->with('growl', [__('Closing pengajuan tidak perlu update'), 'danger']);
                }
                
                $input['send_time'] = Carbon::now()->toDateTimeString();
                $pengajuann = $input->save();
                $link = route('boilerplate.detail-reviewdep-closing-pengajuan', $id);

                // $mailto = DB::select('select email from role_user left join users on role_user.user_id=users.id where role_id=5 limit 1');
                //     $details = [
                //         'title' => '',
                //         'body' => 'Closing Pengajuan '.$input->closing,
                //         'body2' => 'Untuk review closing pengajuan silahkan klik link ini '.$link,
                //     ];
                
                // \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));
                $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 12)->first();
                $user->notify(new ReviewdepaClosing($idf));

                return redirect()->route('boilerplate.saya-closing-pengajuan')
                                ->with('growl', [__('Pengajuan berhasil dikirim'), 'success']);
        }
    }
    public function unduh_lampiran($id)
    {
        if(closing::where('id', $id)->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(closing::where('id', $id)->value('lampiran'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.buat-closing')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
        
    }
}
