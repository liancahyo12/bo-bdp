<?php

namespace App\Http\Controllers;

use App\Models\pengajuan;
use App\Models\departemen;
use App\Models\Boilerplate\User;
use App\Models\jenis_pengajuan;
use App\Models\Isi_pengajuan;
use App\Models\cekdeppengajuan;
use App\Models\cekpengajuan;
use App\Models\approvepengajuan;
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
use Illuminate\Notifications\Notifiable;
use Laratrust;
use App\Notifications\Boilerplate\RdepPengajuan;
use Validator;
use Notification;
use Auth;
use DB;

class PengajuanController extends Controller
{
    use Notifiable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('boilerplate::pengajuan.pengajuan');
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis_pengajuan = [];
        if (Laratrust::isAbleTo('pengajuan_fags')==true) {
            $jenis_pengajuan = jenis_pengajuan::where('status', 1)->get();
        }else {
            $jenis_pengajuan = jenis_pengajuan::whereRaw('id<=3')->get();
        }
        return view('boilerplate::pengajuan.buat', [
            'jenis_pengajuan' => $jenis_pengajuan,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepengajuanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inpengajuan = [];
        $input = [];
        $total = 0;
        $this->validate($request, [
                'jenis_pengajuan' => 'required',
                'tgl_pengajuan'  => 'required',
                'file_lampiran' => 'mimes:pdf|max:20480',
        ]);
        if (Laratrust::isAbleTo('pengajuan_fags')==true) {

        }else {
            if ($request->jenis_pengajuan>3) {
                return redirect()->route('boilerplate.saya-pengajuan')
                    ->with('growl', [__('Jenis pengajuan tidak diijinkan'), 'danger']);
            }
        }
        
        $input['user_id'] = Auth::user()->id;
        $input['jenis_pengajuan_id'] = $request->jenis_pengajuan;
        $input['departemen_id'] = Auth::user()->departemen_id;
        $input['catatan'] = $request->catatan;
        $input['tgl_pengajuan'] = $request->tgl_pengajuan;

        $last_pengajuan = pengajuan::select('id')->orderBy('id', 'DESC')->limit(1)->value('id');
        $idf = $last_pengajuan+1;

        $filename = $idf.Str::random(16).'.pdf';
        $path ='';
        if ($request->file_lampiran!=null) {
            $path = $request->file('file_lampiran')->storeAs('lampiran-pengajuan', $filename);
            $input['lampiran'] = $path;
        }

        if ( $request->jenis_pengajuan <= 3) {
            $this->validate($request, [
                'namarek' => 'required',
                'norek' => 'required',
                'bank' => 'required',
            ]);
            foreach($request->input('transaksi') as $key => $value) {
                $inpengajuan["transaksi.{$key}"] = 'required';
                $inpengajuan["nominal.{$key}"] = 'required';
            }
            $validator = Validator::make($request->all(), $inpengajuan);
            if ($validator->passes()) {
                foreach($request->transaksi as $key => $value) {
                    $inpengajuan['transaksi'] = $value;
                    $inpengajuan['nominal'] = $request->nominal[$key];
                    $inpengajuan['pengajuan_id'] = $idf;
                    $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                    $isipengajuan = Isi_pengajuan::create($inpengajuan);
                    $total += $request->nominal[$key];
                }
                $input['total_nominal'] = $total;
                $input['nama_rek'] = $request->namarek;
                $input['no_rek'] = $request->norek;
                $input['bank'] = $request->bank;
            }

        }elseif ($request->jenis_pengajuan == 4) {
            $this->validate($request, [
                'noinvoice' => 'required',
                'namarek' => 'required',
                'norek' => 'required',
                'bank' => 'required',
            ]);
            foreach($request->input('transaksi') as $key => $value) {
                $inpengajuan["transaksi.{$key}"] = 'required';
                $inpengajuan["nominal.{$key}"] = 'required';
            }
            $validator = Validator::make($request->all(), $inpengajuan);
            if ($validator->passes()) {
                foreach($request->transaksi as $key => $value) {
                    $inpengajuan['transaksi'] = $value;
                    $inpengajuan['nominal'] = $request->nominal[$key];
                    $inpengajuan['pengajuan_id'] = $idf;
                    $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                    $isipengajuan = Isi_pengajuan::create($inpengajuan);
                    $total += $request->nominal[$key];
                }
                $input['total_nominal'] = $total;
                $input['no_invoice'] = $request->noinvoice;
                $input['nama_rek'] = $request->namarek;
                $input['no_rek'] = $request->norek;
                $input['bank'] = $request->bank;
            }
        }
        elseif ($request->jenis_pengajuan == 5) {
            $this->validate($request, [
                'namarek' => 'required',
                'norek' => 'required',
                'bank' => 'required',
            ]);
            foreach($request->input('transaksi') as $key => $value) {
                $inpengajuan["transaksi.{$key}"] = 'required';
                $inpengajuan["nominal.{$key}"] = 'required';
                $inpengajuan["coa.{$key}"] = 'required';
                $inpengajuan["saldo.{$key}"] = 'required';
            }
            $validator = Validator::make($request->all(), $inpengajuan);
            if ($validator->passes()) {
                foreach($request->transaksi as $key => $value) {
                    $inpengajuan['transaksi'] = $value;
                    $inpengajuan['nominal'] = $request->nominal[$key];
                    $inpengajuan['coa'] = $request->coa[$key];
                    $inpengajuan['saldo'] = $request->saldo[$key];
                    $inpengajuan['pengajuan_id'] = $idf;
                    $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                    $isipengajuan = Isi_pengajuan::create($inpengajuan);
                    $total += $request->nominal[$key];
                }
                $input['total_nominal'] = $total;
                $input['nama_rek'] = $request->namarek;
                $input['no_rek'] = $request->norek;
                $input['bank'] = $request->bank;
            }
        }
        elseif ($request->jenis_pengajuan == 6) {
            $this->validate($request, [
                'jumpc' => 'required',
                'namarek' => 'required',
                'norek' => 'required',
                'bank' => 'required',
            ]);
            foreach($request->input('jenistr') as $key => $value) {
                $inpengajuan["jenistr.{$key}"] = 'required';
            }
            $validator = Validator::make($request->all(), $inpengajuan);
            if ($validator->passes()) {
                foreach($request->jenistr as $key => $value) {
                    $inpengajuan['jenis_transaksi'] = $value;
                    $inpengajuan['pengajuan_id'] = $idf;
                    $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                    $isipengajuan = Isi_pengajuan::create($inpengajuan);
                }
                $input['jumlah_pc'] = $request->jumpc;
                $input['nama_rek'] = $request->namarek;
                $input['no_rek'] = $request->norek;
                $input['bank'] = $request->bank;
            }
        }elseif ($request->jenis_pengajuan == 7) {
            $this->validate($request, [
                'perusahaan' => 'required',
                'alamat' => 'required',
                'notelepon' => 'required',
                'kontak' => 'required',
                'email' => 'required',
                'ppn' => 'required',
                'dpp' => 'required',
            ]);
            foreach($request->input('pembelian') as $key => $value) {
                $inpengajuan["pembelian.{$key}"] = 'required';
                $inpengajuan["nominal.{$key}"] = 'required';
            }
            $validator = Validator::make($request->all(), $inpengajuan);
            if ($validator->passes()) {
                foreach($request->pembelian as $key => $value) {
                    $inpengajuan['transaksi'] = $value;
                    $inpengajuan['nominal'] = $request->nominal[$key];
                    $inpengajuan['pengajuan_id'] = $idf;
                    $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                    $isipengajuan = Isi_pengajuan::create($inpengajuan);
                    $total += $request->nominal[$key];
                }
                $input['total_nominal'] = $total;
                $input['perusahaan'] = $request->perusahaan;
                $input['alamat'] = $request->alamat;
                $input['phone'] = $request->notelepon;
                $input['kontak'] = $request->kontak;
                $input['email_po'] = $request->email;
                $input['ppn'] = $request->ppn;
                $input['dpp'] = $request->dpp;
            }
        }

        switch ($request->submitbutton) {
        case 'Kirim':
            // send
            $input['send_status'] = 1;
            $input['send_time'] = Carbon::now()->toDateTimeString();
            $input['reviewdep_status'] = 0;
            $pengajuann = pengajuan::create($input);
            
            $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 12)->get();
            foreach ($user as $user) {
                $user->notify(new RdepPengajuan($idf));
            }

            return redirect()->route('boilerplate.saya-pengajuan')
                            ->with('growl', [__('Pengajuan berhasil dikirim'), 'success']);

            break;

        case 'Simpan Draft':
            // save to draft
            $input['send_status'] = 0;
            $isipengajuan = Isi_pengajuan::create($inpengajuan);
            $pengajuann = pengajuan::create($input);

            return redirect()->route('boilerplate.saya-pengajuan')
                            ->with('growl', [__('Pengajuan berhasil disimpan'), 'success']);
            break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function show(pengajuan $pengajuan)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*', 'departemen')->where('pengajuans.id', $id)->first();
        if ($pengajuan->suser_id != Auth::user()->id || $pengajuan->sstatus==0) {
            return redirect()->route('boilerplate.saya-pengajuan')
                            ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
        }
        $reviewdeppengajuan = cekdeppengajuan::leftJoin('users', 'users.id', 'cekdeppengajuans.reviewerdep_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('cekdeppengajuans.created_at as waktu_komentar', 'reviewdep_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['pengajuan_id', '=', $id], ['cekdeppengajuans.status', '=', 1]]);
        $reviewpengajuan = cekpengajuan::leftJoin('users', 'users.id', 'cekpengajuans.reviewer_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('cekpengajuans.created_at as waktu_komentar', 'review_status as statuss', 'komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['pengajuan_id', '=', $id], ['cekpengajuans.status', '=', 1]]);
        $approvepengajuan = approvepengajuan::leftJoin('users', 'users.id', 'approvepengajuans.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approvepengajuans.created_at as waktu_komentar',  'approve_status as statuss','komentar', 'first_name', 'last_name', 'kode', 'users.id as uid')->where([['pengajuan_id', '=', $id], ['approvepengajuans.status', '=', 1]])->union($reviewdeppengajuan)->union($reviewpengajuan)->get();
        
        if ($pengajuan->revisi_status == 1 || $pengajuan->send_status == 0) {
            return view('boilerplate::pengajuan.edit', compact('pengajuan'), 
            // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
            [
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $id], ['status', '=', 1]])->get(),
                'jenis_pengajuan' => jenis_pengajuan::all(),
                'departemens' => departemen::all(),
                'komentar' => $approvepengajuan,
                
            ]
            );
        }else {
            return view('boilerplate::pengajuan.detail', compact('pengajuan'), 
            // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
            [
                'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $id], ['status', '=', 1]])->get(),
                'jenis_pengajuan' => jenis_pengajuan::where('status', 1)->get(),
                'departemens' => departemen::where('status', 1)->get(),
                'komentar' => $approvepengajuan,
                
            ]
            );
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepengajuanRequest  $request
     * @param  \App\Models\pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = pengajuan::where([['id', '=', $id], ['user_id', '=', Auth::user()->id]])->first();
        if ($input->status==1 && ( $input->reviewdep_status==3 || $input->review_status==3 || $input->approve_status==3  || $input->send_status == 0) ) {
            $inpengajuan = [];
            $total = 0;
            $this->validate($request, [
                    'tgl_pengajuan'  => 'required',
                    'catatan' => 'required',
                    'file_lampiran' => 'mimes:pdf|max:20480',
            ]);
            $input['catatan'] = $request->catatan;
            $input['tgl_pengajuan'] = $request->tgl_pengajuan;

            if ($input->lampiran==null) {
                $filename = $id.Str::random(16).'.pdf';
                $path ='';
                if ($request->file_lampiran!=null) {
                    $path = $request->file('file_lampiran')->storeAs('lampiran-pengajuan', $filename);
                    $input['lampiran'] = $path;
                }
            }else {
                $filename = Str::substr($input->lampiran, 19);
                $path ='';
                if ($request->file_lampiran!=null) {
                    $path = $request->file('file_lampiran')->storeAs('lampiran-pengajuan', $filename);
                }
            }

            
            

            if ( $input->jenis_pengajuan_id <= 3) {
                $this->validate($request, [
                    'namarek' => 'required',
                    'norek' => 'required',
                    'bank' => 'required',
                ]);
                foreach($request->input('transaksi') as $key => $value) {
                    $inpengajuan["transaksi.{$key}"] = 'required';
                    $inpengajuan["nominal.{$key}"] = 'required';
                }
                $validator = Validator::make($request->all(), $inpengajuan);
                if ($validator->passes()) {
                    Isi_pengajuan::where('pengajuan_id', $id)->update(['status' => 0]);
                    foreach($request->transaksi as $key => $value) {
                        $inpengajuan['transaksi'] = $value;
                        $inpengajuan['nominal'] = $request->nominal[$key];
                        $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                        $inpengajuan['pengajuan_id'] = $id;
                        $isipengajuan = Isi_pengajuan::create($inpengajuan);
                        $total += $request->nominal[$key];
                    }
                    $input['total_nominal'] = $total;
                    $input['nama_rek'] = $request->namarek;
                    $input['no_rek'] = $request->norek;
                    $input['bank'] = $request->bank;
                }

            }elseif ($input->jenis_pengajuan_id == 4) {
                $this->validate($request, [
                    'noinvoice' => 'required',
                    'namarek' => 'required',
                    'norek' => 'required',
                    'bank' => 'required',
                ]);
                foreach($request->input('transaksi') as $key => $value) {
                    $inpengajuan["transaksi.{$key}"] = 'required';
                    $inpengajuan["nominal.{$key}"] = 'required';
                }
                $validator = Validator::make($request->all(), $inpengajuan);
                if ($validator->passes()) {
                    Isi_pengajuan::where('pengajuan_id', $id)->update(['status' => 0]);
                    foreach($request->transaksi as $key => $value) {
                        $inpengajuan['transaksi'] = $value;
                        $inpengajuan['nominal'] = $request->nominal[$key];
                        $inpengajuan['pengajuan_id'] = $id;
                        $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                        $isipengajuan = Isi_pengajuan::create($inpengajuan);
                        $total += $request->nominal[$key];
                    }
                    $input['total_nominal'] = $total;
                    $input['no_invoice'] = $request->noinvoice;
                    $input['nama_rek'] = $request->namarek;
                    $input['no_rek'] = $request->norek;
                    $input['bank'] = $request->bank;
                }
            }
            elseif ($input->jenis_pengajuan_id == 5) {
                $this->validate($request, [
                    'namarek' => 'required',
                    'norek' => 'required',
                    'bank' => 'required',
                ]);
                foreach($request->input('transaksi') as $key => $value) {
                    $inpengajuan["transaksi.{$key}"] = 'required';
                    $inpengajuan["nominal.{$key}"] = 'required';
                    $inpengajuan["coa.{$key}"] = 'required';
                    $inpengajuan["saldo.{$key}"] = 'required';
                }
                $validator = Validator::make($request->all(), $inpengajuan);
                if ($validator->passes()) {
                    Isi_pengajuan::where('pengajuan_id', $id)->update(['status' => 0]);
                    foreach($request->transaksi as $key => $value) {
                        $inpengajuan['transaksi'] = $value;
                        $inpengajuan['nominal'] = $request->nominal[$key];
                        $inpengajuan['coa'] = $request->coa[$key];
                        $inpengajuan['saldo'] = $request->saldo[$key];
                        $inpengajuan['pengajuan_id'] = $id;
                        $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                        $isipengajuan = Isi_pengajuan::create($inpengajuan);
                        $total += $request->nominal[$key];
                    }
                    $input['total_nominal'] = $total;
                    $input['nama_rek'] = $request->namarek;
                    $input['no_rek'] = $request->norek;
                    $input['bank'] = $request->bank;
                }
            }
            elseif ($input->jenis_pengajuan_id == 6) {
                $this->validate($request, [
                    'jumpc' => 'required',
                    'namarek' => 'required',
                    'norek' => 'required',
                    'bank' => 'required',
                ]);
                foreach($request->input('jenistr') as $key => $value) {
                    $inpengajuan["jenistr.{$key}"] = 'required';
                }
                $validator = Validator::make($request->all(), $inpengajuan);
                if ($validator->passes()) {
                    Isi_pengajuan::where('pengajuan_id', $id)->update(['status' => 0]);
                    foreach($request->jenistr as $key => $value) {
                        $inpengajuan['jenis_transaksi'] = $value;
                        $inpengajuan['pengajuan_id'] = $id;
                        $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                        $isipengajuan = Isi_pengajuan::create($inpengajuan);
                    }
                    $input['jumlah_pc'] = $request->jumpc;
                    $input['nama_rek'] = $request->namarek;
                    $input['no_rek'] = $request->norek;
                    $input['bank'] = $request->bank;
                }
            }elseif ($input->jenis_pengajuan_id == 7) {
                $this->validate($request, [
                    'perusahaan' => 'required',
                    'alamat' => 'required',
                    'notelepon' => 'required',
                    'kontak' => 'required',
                    'email' => 'required',
                    'ppn' => 'required',
                    'dpp' => 'required',
                ]);
                foreach($request->input('pembelian') as $key => $value) {
                    $inpengajuan["pembelian.{$key}"] = 'required';
                    $inpengajuan["nominal.{$key}"] = 'required';
                }
                $validator = Validator::make($request->all(), $inpengajuan);
                if ($validator->passes()) {
                    Isi_pengajuan::where('pengajuan_id', $id)->update(['status' => 0]);
                    foreach($request->pembelian as $key => $value) {
                        $inpengajuan['transaksi'] = $value;
                        $inpengajuan['nominal'] = $request->nominal[$key];
                        $inpengajuan['pengajuan_id'] = $id;
                        $inpengajuan['jenis_pengajuan_id'] = $request->jenis_pengajuan;
                        $isipengajuan = Isi_pengajuan::create($inpengajuan);
                        $total += $request->nominal[$key];
                    }
                    $input['total_nominal'] = $total+$request->ppn+$request->dpp;
                    $input['perusahaan'] = $request->perusahaan;
                    $input['alamat'] = $request->alamat;
                    $input['phone'] = $request->notelepon;
                    $input['kontak'] = $request->kontak;
                    $input['email_po'] = $request->email;
                    $input['ppn'] = $request->ppn;
                    $input['dpp'] = $request->dpp;
                }
            }

            switch ($request->submitbutton) {
            case 'Kirim':
                // send
                if ($input->send_status == 1 && $input->revisi_status==1) {
                    $input['reviewdep_status'] = 5;
                    $input['revisi_status'] = 2;
                }elseif ($input->send_status == 0) {
                    $input['send_status'] = 1;
                }else {
                    return redirect()->route('boilerplate.saya-pengajuan')
                        ->with('growl', [__('Pengajuan tidak perlu update'), 'danger']);
                }
                
                $input['send_time'] = Carbon::now()->toDateTimeString();
                $pengajuann = $input->save();
                
                $user=User::leftJoin('role_user', 'role_user.user_id', 'users.id')->leftJoin('permission_role', 'permission_role.role_id', 'role_user.role_id')->where('permission_id', 12)->get();
                foreach ($user as $user) {
                    $user->notify(new RdepPengajuan($id));
                }

                return redirect()->route('boilerplate.saya-pengajuan')
                                ->with('growl', [__('Pengajuan berhasil dikirim'), 'success']);

                break;

            case 'Simpan Draft':
                // save to draft
                $isipengajuan = Isi_pengajuan::create($inpengajuan);
                $pengajuann = pengajuan::create($input);

                return redirect()->route('boilerplate.saya-pengajuan')
                                ->with('growl', [__('Pengajuan berhasil disimpan'), 'success']);
                break;
            }
        }else {
            return redirect()->route('boilerplate.saya-pengajuan')
                ->with('growl', [__('Pengajuan tidak perlu diedit'), 'danger']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengajuan  $pengajuan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $send = pengajuan::where('id', $id)->select('send_status')->value('send_status');
        if ($send==0) {
            $suratkeluar = DB::update('update pengajuans set status = 0 where id = ?', [$id]);
        }else {
            return redirect()->route('boilerplate.surat-keluar-saya.index')
                            ->with('growl', [__('Tidak dapat dihapus'), 'danger']);
        }
    }
    public function unduh_lampiran($id)
    {
        if(pengajuan::where('id', $id)->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(pengajuan::where('id', $id)->value('lampiran'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.buat-pengajuan')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
        
    }
    public function unduh_bukti($id)
    {
        if(pengajuan::where('id', $id)->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(pengajuan::where('id', $id)->value('bukti_bayar'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.buat-pengajuan')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
        
    }
    public function unduh_pengajuan($id)
    {
        if(pengajuan::where('id', $id)->value('user_id') == Auth::user()->id){
            $file= Storage::disk('local')->get(pengajuan::where('id', $id)->value('pengajuan_jadi'));
            return (new Response($file, 200))
                ->header('Content-Type', 'application/pdf');
        }else {
            return redirect()->route('boilerplate.buat-pengajuan')
                            ->with('growl', [__('Anda tidak memiliki akses file ini'), 'warning']);
        }
        
    }
}
