<?php

namespace App\Http\Controllers;

use App\Models\pengajuan;
use App\Models\Isi_pengajuan;
use App\Models\approvepengajuan;
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

class ApprovepengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('boilerplate::pengajuan.approve');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen')->where([['pengajuans.id', '=', $id], ['pengajuans.status', '=', 1]])->first();
        if ($pengajuan->send_status==1) {
            if( $pengajuan->approve_status == 0 || $pengajuan->approve_status == 5){
                DB::update('update pengajuans set approve_status = 1 where id = ?', [$id]);
            }
            return view('boilerplate::pengajuan.detail-approve', compact('pengajuan'), [
                'approvepengajuan' => approvepengajuan::leftJoin('users', 'users.id', 'approvepengajuans.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approvepengajuans.*', 'users.first_name', 'approve_status as statuss', 'approvepengajuans.created_at as waktu_komentar', 'kode')->where([['pengajuan_id', '=', $id], ['approvepengajuans.status', '=', 1]])->get(),
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $id], ['status', '=', 1]])->get(),
            ]); 
        }  
        return redirect()->route('boilerplate.approve-pengajuan')
            ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreapprovepengajuanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreapprovepengajuanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\approvepengajuan  $approvepengajuan
     * @return \Illuminate\Http\Response
     */
    public function show(approvepengajuan $approvepengajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\approvepengajuan  $approvepengajuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateapprovepengajuanRequest  $request
     * @param  \App\Models\approvepengajuan  $approvepengajuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mmyy = substr($request->tgl_pengajuan, 0, 7);
        $mm = substr($request->tgl_pengajuan, 5, 2);
        $yy = substr($request->tgl_pengajuan, 0, 4);

        $pengajuan = pengajuan::leftJoin('departemens', 'departemens.id', 'departemen_id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'jenis_pengajuan_id')->select('pengajuans.*', 'departemens.kode as kode_departemen', 'jenis_pengajuans.kode as kode_pengajuan')->where([['pengajuans.id', '=', $id],['status', '=', 1]])->first();
        $pengajuan['approver_id'] = Auth::user()->id;
        $pengajuan['approve_time'] = Carbon::now()->toDateTimeString();

        $approvepengajuan['pengajuan_id'] = $id;
        $approvepengajuan['user_id'] = DB::table('pengajuans')->select('user_id')->where('id', $id)->value('user_id');
        $approvepengajuan['approver_id'] = Auth::user()->id;
        $approvepengajuan['komentar'] = $request->komentar;
        $link = route('boilerplate.edit-pengajuan', $id);
        // buat romawi bulan
        $romawi = $this->getRomawi($mm);
        // $nourut = DB::table('pengajuans')->select('no_urut')->where('id', $id)->value('no_urut');

        // cek no urut perbulan
        $nourut = DB::table('pengajuans')->select('no_urut')->whereRaw('DATE_FORMAT(tgl_pengajuan,"%Y-%m") = ? and jenis_pengajuan_id = ? and departemen_id = ?' , [$mmyy, pengajuan::where('id', $id)->value('jenis_pengajuan_id'), pengajuan::where('id', $id)->value('departemen_id')])->orderBy('no_urut', 'DESC')->limit(1)->value('no_urut');

        //buat no urut baru perbulan
        if ($nourut <= 000) {
            $nourut = 1;
        } else {
            $nourut = $nourut+1;
        }

        //tgl pengajuan
        $tgl_pengajuan_t = Carbon::createFromFormat('Y-m-d', $pengajuan->tgl_pengajuan)->isoFormat('D MMMM Y');

        //buat no pengajuan
        $nopengajuan= sprintf("%03d", $nourut).'/'.$pengajuan->kode_departemen.'/'.$pengajuan->kode_pengajuan.'/'.$romawi.'/'.$yy;
        

        // fungsi tombol
        
        switch ($request->submitbutton) {
        case 'Setujui':
            if($pengajuan->approve_status == 2){
                return redirect()->route('boilerplate.approve-pengajuan')
                                ->with('growl', [__('pengajuan telah disetujui'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // send
            
            $pengajuan['no_urut'] = $nourut;
            $pengajuan['no_pengajuan'] = $nopengajuan;
            $pengajuan['approve_status'] = 2;
            $approvepengajuan['approve_status'] = 2;
            $pengajuan = $pengajuan->save();
            $approvepengajuana = approvepengajuan::create($approvepengajuan);

            $mailto = pengajuan::leftJoin('users', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->value('users.email');
            $details = [
                'title' => '',
                'body' => 'Pengajuan '.$request->perihal,
                'body2' => 'Pengajuan sudah diapprove untuk melihat detail silahkan klik link ini '.$link,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.approve-pengajuan')
                            ->with('growl', [__('pengajuan berhasil disetujui'), 'success']);
            }
            break;

        case 'Revisi':
            if($pengajuan->approve_status == 3){
                return redirect()->route('boilerplate.approve-pengajuan')
                                ->with('growl', [__('pengajuan telah diminta revisi'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // revisi
            $pengajuan['approve_status'] = 3;
            $approvepengajuan['approve_status'] = 3;

            $pengajuan = $pengajuan->save();
            $approvepengajuana = approvepengajuan::create($approvepengajuan);

            $mailto = pengajuan::leftJoin('users', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->value('users.email');
            $details = [
                'title' => '',
                'body' => 'Pengajuan '.$request->perihal,
                'body2' => 'Pengajuan harus direvisi terlebih dahulu untuk revisi silahkan klik link ini '.$link,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.approve-pengajuan')
                            ->with('growl', [__('pengajuan berhasil revisi'), 'success']);
            }
            break;
        
        case 'Tolak':
            if($pengajuan->approve_status == 4){
                return redirect()->route('boilerplate.approve-pengajuan')
                                ->with('growl', [__('pengajuan telah ditolak'), 'danger']);
            }else{
            $this->validate($request, [
                'komentar' => 'required',
            ]);
            // save to draft
            $pengajuan['approve_status'] = 4;
            $approvepengajuan['approve_status'] = 4;

            $pengajuan = $pengajuan->save();
            $approvepengajuana = approvepengajuan::create($approvepengajuan);

            $mailto = pengajuan::leftJoin('users', 'users.id', 'pengajuans.user_id')->where('pengajuans.id', $id)->value('users.email');
            $details = [
                'title' => '',
                'body' => 'Pengajuan '.$request->perihal,
                'body2' => 'Pengajuan ditolak untuk melihat detail silahkan klik link ini '.$link,
            ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

            return redirect()->route('boilerplate.approve-pengajuan')
                            ->with('growl', [__('pengajuan berhasil ditolak'), 'success']);
            }
            break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\approvepengajuan  $approvepengajuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(approvepengajuan $approvepengajuan)
    {
        //
    }

    public function unduh_lampiran($id)
    {
            $file= Storage::disk('local')->get(pengajuan::where([['id', '=', $id], ['status', '=', 1]])->value('lampiran'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
    }
    public function getRomawi($bulan){
        switch ($bulan){
            case 1: 
                return "I";
            break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
}
