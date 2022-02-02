@extends('boilerplate::layout.index', [
    'title' => __('Bayar Pengajuan'),
    'subtitle' => __('Bayar Pengajuan'),
    'breadcrumb' => [
        __('Bayar Pengajuan') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.update-bayar-pengajuan', $pengajuan->ida]" method="put" files>
    @csrf
    
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
                    <a target="_blank" href="/detail-approve-pengajuan-lampiran/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                </div>
            </div>
        </x-boilerplate::card>
        <x-boilerplate::card>
            <x-slot name="header">
                <b>Bayar</b>
            </x-slot>
            <div @if ($pengajuan->bayar_status==2)
                style='display:none;'
                @endif>
                <x-boilerplate::input name="bukti_bayar" type="file"/>
                
            </div>
            <div class="form-group" @if ($pengajuan->bukti_bayar!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-lamiran">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/detail-bayar-pengajuan-lampiran/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat Bukti Bayar</button></a>
                </div>
            </div>
            <div>
                <input class="btn btn-primary" name="submitbutton" type="submit" value="Bayar" @if ($pengajuan->bayar_status==2)
                style='display:none;'
                @endif>
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
            var custodian = "{{ $pengajuan->first_name }} {{ $pengajuan->last_name }}";
            if ( "{{ $pengajuan->jenis_pengajuan_id }}" <= 3){
                document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td></tr>@endforeach <tr><td><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></td></tr></table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
            }else if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 4){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='noinvoice'>No Invoice</label><input class='form-control' type='text' name='noinvoice' value='"+noinvoice+"' id='noinvoice' disabled>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td></tr>@endforeach <tr><td  ><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></td></tr></table>       <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label><input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label><input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
            }else if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 5){
                document.getElementById("form-pengajuan").innerHTML = "<div>    <label for='custodian'>Custodian</label><br><input class='form-control' type='text' name='custodian' value='"+custodian+"' id='custodian' disabled><table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first)<label for='coa'>COA</label> @else @endif<input class='form-control' type='text' name='coa[]' value='{{ $position->coa }}' id='coa' disabled></td><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td> <td>@if ($loop->first)<label for='saldo'>Saldo</label> @else @endif<input class='form-control' type='text' name='saldo[]' value='{{ $position->saldo }}' id='saldo' disabled></td> </tr>@endforeach</table>      <label for='catatan'>Catatan</label><br><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
            }
            else if("{{ $pengajuan->jenis_pengajuan_id }}" == 6){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='custodian'>Custodian</label><br><input class='form-control' type='text' name='custodian' value='"+custodian+"' id='custodian' disabled><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)</label><input class='form-control' name='jumpc' value='"+jumpc+"' type='text' id='jumpc' disabled></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='jenistr'>Jenis Transaksi</label> @else @endif<input class='form-control' type='text' name='jenistr[]' value='{{ $position->jenis_transaksi }}' id='jenistr' disabled></td> </tr>@endforeach</table> <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled>"
            }else{
                document.getElementById("form-pengajuan").innerHTML = "<label for='perusahaan'>Perusahaan</label><input class='form-control' name='perusahaan' value='"+perusahaan+"' type='text' id='perusahaan' disabled><label for='alamat'>Alamat</label><input class='form-control' name='alamat' value='"+alamat+"' type='text' id='alamat' disabled><label for='notelepon'>No Telepon</label><input class='form-control' name='notelepon' value='"+phone+"' type='text' id='notelepon' disabled><label for='kontak'>Nama Kontak</label><input class='form-control' name='kontak' value='"+kontak+"' type='text' id='kontak' disabled><label for='email'>Email</label><input class='form-control' name='email' value='"+email+"' type='text' id='email' disabled>        <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='pembelian'>Pembelian</label> @else @endif<input class='form-control' type='text' name='pembelian[]' value='{{ $position->transaksi }}' id='pembelian' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td> </tr>@endforeach <tr><td  ><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br>"
            }            
        });
    </script>
@endsection