<?php

namespace App\Http\Controllers;

use App\Models\pengajuan;
use App\Models\departemen;
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
use Validator;
use Auth;
use DB;

class PengajuanController extends Controller
{
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
        return view('boilerplate::pengajuan.buat', [
            'jenis_pengajuan' => jenis_pengajuan::all(),
            'departemens' => departemen::all(),
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
                'departemen'  => 'required',
                'tgl_pengajuan'  => 'required',
                'pengajuan' => 'required',
                'catatan' => 'required',
                'file_lampiran' => 'mimes:pdf|max:20480',
        ]);
        $input['user_id'] = Auth::user()->id;
        $input['jenis_pengajuan_id'] = $request->jenis_pengajuan;
        $input['departemen_id'] = $request->departemen;
        $input['pengajuan'] = $request->pengajuan;
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
            }
        }elseif ($request->jenis_pengajuan == 7) {
            $this->validate($request, [
                'perusahaan' => 'required',
                'alamat' => 'required',
                'notelepon' => 'required',
                'kontak' => 'required',
                'email' => 'required',
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
                $input['email'] = $request->email;
            }
        }

        switch ($request->submitbutton) {
        case 'Kirim':
            // send
            $input['send_status'] = 1;
            $input['send_time'] = Carbon::now()->toDateTimeString();
            $input['reviewdep_status'] = 0;
            $pengajuann = pengajuan::create($input);
            $link = route('boilerplate.detail-reviewdep-pengajuan', $idf);
            // $isisuratkeluar = Isi_surat::create($isisurat);

                $mailto = DB::select('select email from role_user left join users on role_user.user_id=users.id where role_id=5 limit 1');
                $details = [
                    'title' => '',
                    'body' => 'Pengajuan '.$request->pengajuan,
                    'body2' => 'Untuk review pengajuan silahkan klik link ini '.$link,
                ];
            
            \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

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
        $pengajuan = pengajuan::leftJoin('isi_pengajuans', 'pengajuan_id', 'pengajuans.id')->leftJoin('jenis_pengajuans', 'jenis_pengajuans.id', 'pengajuans.jenis_pengajuan_id')->select('pengajuans.id as ida', 'pengajuans.user_id as suser_id', 'pengajuans.status as sstatus', 'isi_pengajuans.*', 'pengajuans.*', 'jenis_pengajuans.*')->where('pengajuans.id', $id)->first();
        if ($pengajuan->suser_id != Auth::user()->id || $pengajuan->sstatus==0) {
            return redirect()->route('boilerplate.saya-pengajuan')
                            ->with('growl', [__('Pengajuan tidak ada'), 'danger']);
        }
        return view('boilerplate::pengajuan.edit', compact('pengajuan'), 
        // compact('isisurat'), compact('approver'),compact('reviewer'), compact('jenis_surat'),compact('departemens'),
        [
            'isi_pengajuan' => Isi_pengajuan::where([['pengajuan_id', '=', $id], ['status', '=', 1]])->get(),
            'jenis_pengajuan' => jenis_pengajuan::all(),
            'departemens' => departemen::all(),
            'reviewdeppengajuan' => cekdeppengajuan::leftJoin('users', 'users.id', 'cekdeppengajuans.reviewerdep_id')->select('cekdeppengajuans.*', 'first_name')->where([['pengajuan_id', '=', $id], ['cekdeppengajuans.status', '=', 1]])->get(),
            'reviewpengajuan' => cekpengajuan::leftJoin('users', 'users.id', 'cekpengajuans.reviewer_id')->select('cekpengajuans.*', 'first_name')->where([['pengajuan_id', '=', $id], ['cekpengajuans.status', '=', 1]])->get(),
            'approvepengajuan' => approvepengajuan::leftJoin('users', 'users.id', 'approvepengajuans.approver_id')->select('approvepengajuans.*', 'first_name')->where([['pengajuan_id', '=', $id], ['approvepengajuans.status', '=', 1]])->get(),
        ]
        );
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
        if ($input->status==1 && ( $input->reviewdep_status==3 || $input->review_status==3 || $input->approve_status==3) ) {
            $inpengajuan = [];
            $total = 0;
            $this->validate($request, [
                    'departemen'  => 'required',
                    'tgl_pengajuan'  => 'required',
                    'pengajuan' => 'required',
                    'catatan' => 'required',
                    'file_lampiran' => 'mimes:pdf|max:20480',
            ]);
            $input['departemen_id'] = $request->departemen;
            $input['pengajuan'] = $request->pengajuan;
            $input['catatan'] = $request->catatan;
            $input['tgl_pengajuan'] = $request->tgl_pengajuan;

            $filename = Str::substr($input->lampiran, 19);
            $path ='';
            if ($request->file_lampiran!=null) {
                $path = $request->file('file_lampiran')->storeAs('lampiran-pengajuan', $filename);
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
            elseif ($request->jenis_pengajuan == 6) {
                $this->validate($request, [
                    'jumpc' => 'required',
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
                }
            }elseif ($request->jenis_pengajuan == 7) {
                $this->validate($request, [
                    'perusahaan' => 'required',
                    'alamat' => 'required',
                    'notelepon' => 'required',
                    'kontak' => 'required',
                    'email' => 'required',
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
                    $input['total_nominal'] = $total;
                    $input['perusahaan'] = $request->perusahaan;
                    $input['alamat'] = $request->alamat;
                    $input['phone'] = $request->notelepon;
                    $input['kontak'] = $request->kontak;
                    $input['email'] = $request->email;
                }
            }

            switch ($request->submitbutton) {
            case 'Kirim':
                // send
                if ($input->send_status == 1 && ( $input->reviewdep_status==3 || $input->review_status==3 || $input->approve_status==3)) {
                    $input['reviewdep_status'] = 5;
                }elseif ($input->send_status == 0) {
                    $input['send_status'] = 1;
                }else {
                    return redirect()->route('boilerplate.saya-pengajuan')
                        ->with('growl', [__('Pengajuan berhasil tidak perlu update'), 'danger']);
                }
                
                $input['send_time'] = Carbon::now()->toDateTimeString();
                $pengajuann = $input->save();
                $link = route('boilerplate.detail-reviewdep-pengajuan', $id);

                    $mailto = DB::select('select email from role_user left join users on role_user.user_id=users.id where role_id=5 limit 1');
                    $details = [
                        'title' => '',
                        'body' => 'Pengajuan '.$request->pengajuan,
                        'body2' => 'Untuk review pengajuan silahkan klik link ini '.$link,
                    ];
                
                \Mail::to($mailto)->send(new \App\Mail\Buatsuratkeluar($details));

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
}
