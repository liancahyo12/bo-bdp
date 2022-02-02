@extends('boilerplate::layout.index', [
    'title' => __('Detail Pengajuan Saya'),
    'subtitle' => __('Detail Pengajuan Saya'),
    'breadcrumb' => [
        __('Detail Pengajuan Saya') 
    ]
])

@section('content')
    <x-boilerplate::form method="get" >
    @csrf
        <x-boilerplate::card>
            <x-slot name="header">
                <b>Komentar</b>
            </x-slot>
            @foreach ( $komentar as $komentar)
            <div class="direct-chat-msg">
                <div class="direct-chat-infos clearfix">
                    <span class="direct-chat-name float-left">{{ $komentar->first_name }}&nbsp;</span>
                    <span class="badge badge-pill badge-secondary float-left">{{ $komentar->kode }}</span>
                    @if ($komentar->statuss == 2)
                        <span class="badge badge-pill badge-success float-right">disetujui</span>
                    @endif
                    @if ($komentar->statuss == 3)
                        <span class="badge badge-pill badge-warning float-right">revisi</span>
                    @endif
                    @if ($komentar->statuss == 4)
                        <span class="badge badge-pill badge-danger float-right">ditolak</span>
                    @endif
                    <span class="direct-chat-timestamp float-right">{{ $komentar->waktu_komentar }}&nbsp;</span>
                </div>
                <!-- /.direct-chat-infos -->
                <img src="{{ App\Models\Boilerplate\User::where('id', $komentar->uid)->first()->avatar_url }}" class="direct-chat-img" alt="{{ $komentar->first_name }}" width="30" height="30">
                <!-- /.direct-chat-img -->
                <div class="direct-chat-text">
                    {{ $komentar->komentar }}
                </div>
                <!-- /.direct-chat-text -->
            </div>
            @endforeach
            
        </x-boilerplate::card>
        <x-boilerplate::card>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen" disabled>
                    <option value="{{ $pengajuan->departemen_id }}" selected>{{ $pengajuan->departemen }} </option>
            </x-boilerplate::select2>
            <x-boilerplate::datetimepicker name="tgl_pengajuan" label='Tanggal Pengajuan' value="{{ $pengajuan->tgl_pengajuan}}" disabled/>
            <x-boilerplate::select2 name="jenis_pengajuan" label="Pilih Jenis Pengajuan" id='jenis_pengajuan' disabled>
                    <option value="{{ $pengajuan->jenis_pengajuan_id }}" selected>{{ $pengajuan->jenis_pengajuan }}</option>
            </x-boilerplate::select2>
            <div id="form-pengajuan">
            </div>
            <br>
            <div class="form-group" @if ($pengajuan->lampiran!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-lamiran">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/detail-reviewdep-pengajuan-lampiran/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                </div>
            </div>
            
            <div class="form-group" @if ($pengajuan->bukti_bayar!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-bukti">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/edit-pengajuan-bukti/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat Bukti Bayar</button></a>
                </div>
            </div>
            <div class="form-group" @if ($pengajuan->pengajuan_jadi!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-pengajuan">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/edit-pengajuan-jadi/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat File Pengajuan</button></a>
                </div>
            </div>
        </x-boilerplate::card>
        
        
    </x-boilerplate::form>
    <script>        
        $(document).ready(function(){
            var pengajuann = "{{ $pengajuan->pengajuan }}";
            var perusahaan = "{{ $pengajuan->perusahaan }}";
            var alamat = "{{ $pengajuan->alamat }}";
            var phone = "{{ $pengajuan->phone }}";
            var kontak = "{{ $pengajuan->kontak }}";
            var email = "{{ $pengajuan->email }}";
            var catatan = "{{ $pengajuan->catatan }}";
            var noinvoice = "{{ $pengajuan->no_invoice }}";
            var jumpc = "{{ $pengajuan->jumlah_pc }}";
            var bank = "{{ $pengajuan->bank }}";
            var norek = "{{ $pengajuan->no_rek }}";
            var namarek = "{{ $pengajuan->nama_rek }}";
            var total = "{{ $pengajuan->total_nominal }}";
            var ppn = "{{ $pengajuan->ppn }}";
            var dpp = "{{ $pengajuan->dpp }}";
            if ( "{{ $pengajuan->jenis_pengajuan_id }}" <= 3){
                document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td></tr>@endforeach <tr><td><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></td></tr></table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
            }else if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 4){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='noinvoice'>No Invoice</label><input class='form-control' type='text' name='noinvoice' value='"+noinvoice+"' id='noinvoice' disabled>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td></tr>@endforeach <tr><td  ><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></td></tr></table>       <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label><input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label><input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
            }else if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 5){
                document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first)<label for='coa'>COA</label> @else @endif<input class='form-control' type='text' name='coa[]' value='{{ $position->coa }}' id='coa' disabled></td><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td> <td>@if ($loop->first)<label for='saldo'>Saldo</label> @else @endif<input class='form-control' type='text' name='saldo[]' value='{{ $position->saldo }}' id='saldo' disabled></td> </tr>@endforeach</table>      <label for='catatan'>Catatan</label><br><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
            }
            else if("{{ $pengajuan->jenis_pengajuan_id }}" == 6){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)</label><input class='form-control' name='jumpc' value='"+jumpc+"' type='text' id='jumpc' disabled></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='jenistr'>Jenis Transaksi</label> @else @endif<input class='form-control' type='text' name='jenistr[]' value='{{ $position->jenis_transaksi }}' id='jenistr' disabled></td> </tr>@endforeach</table> <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled>"
            }else{
                document.getElementById("form-pengajuan").innerHTML = "<label for='perusahaan'>Perusahaan</label><input class='form-control' name='perusahaan' value='"+perusahaan+"' type='text' id='perusahaan' disabled><label for='alamat'>Alamat</label><input class='form-control' name='alamat' value='"+alamat+"' type='text' id='alamat' disabled><label for='notelepon'>No Telepon</label><input class='form-control' name='notelepon' value='"+phone+"' type='text' id='notelepon' disabled><label for='kontak'>Nama Kontak</label><input class='form-control' name='kontak' value='"+kontak+"' type='text' id='kontak' disabled><label for='email'>Email</label><input class='form-control' name='email' value='"+email+"' type='text' id='email' disabled>        <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='pembelian'>Pembelian</label> @else @endif<input class='form-control' type='text' name='pembelian[]' value='{{ $position->transaksi }}' id='pembelian' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td> </tr>@endforeach <tr><td  ><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></table> <table class='table'> <tr><td><label for='dpp'>DPP</label></td><td><input class='form-control' type='text' name='dpp' id='dpp' value='"+dpp+"' disabled></td></tr><tr><td><label for='ppn'>PPN 10%</label></td><td><input class='form-control' type='text' name='ppn' id='ppn' value='"+ppn+"' disabled> </td></tr></table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br>"
            }            
        });
    </script>
@endsection