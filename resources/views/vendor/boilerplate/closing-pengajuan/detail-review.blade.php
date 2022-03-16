@extends('boilerplate::layout.index', [
    'title' => __('Review Closing Pengajuan'),
    'subtitle' => __('Review Closing Pengajuan'),
    'breadcrumb' => [
        __('Review Closing Pengajuan') 
    ]
])

@section('content')
<div class="row">
    <div class="col-md-6">
        <x-boilerplate::card>
            <x-slot name="header">
                <h4><b>Closing</b></h4>
            </x-slot>
            <x-boilerplate::datetimepicker name="tgl_closing" label='Tanggal Closing' value="{{ $closing->tgl_closing}}" disabled/>
            <div id="form-closing">
            </div>
            <x-boilerplate::input name="catatana" type="text" label="Catatan" value="{{$closing->catatan}}" disabled/>
            <div class="form-group" @if ($closing->lampiran!=null)
            
                @else
                style='display:none;'
                @endif id="unduh-lamiran">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/detail-review-closing-pengajuan-lampiran/{{ $closing->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                </div>
            </div>
            <div class="form-group" @if ($closing->bukti_pengembalian!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-bukti">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/detail-review-closing-pengajuan-bukti/{{ $closing->ida }}"><button class="btn btn-secondary" form="a">Lihat Bukti Pengembalian</button></a>
                </div>
            </div>
        </x-boilerplate::card>
    </div>
    <div class="col-md-6">
        <x-boilerplate::card>
            <x-slot name="header">
                <h4><b>Pengajuan</b></h4>
            </x-slot>
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
                    <a target="_blank" href="/detail-review-pengajuan-lampiran/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                </div>
            </div>
        </x-boilerplate::card>
    </div>
</div>
<x-boilerplate::form :route="['boilerplate.update-review-closing-pengajuan', $closing->ida]" method="put" files>
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
        <div @if ($closing->review_status==1 || $closing->review_status==5 || $closing->pengembalian_status==4 || $closing->pengembalian_status==5)
            
            @else
                style='display:none;'
            @endif>
            <x-boilerplate::input name="komentar" />
            
        </div>
        <div @if ($closing->review_status==1 || $closing->review_status==5 || $closing->pengembalian_status==4 || $closing->pengembalian_status==5)
            
            @else
                style='display:none;'
            @endif>
            <input class="btn btn-warning" name="submitbutton" type="submit" value="Revisi">
            &nbsp;
            <input class="btn btn-primary" name="submitbutton" type="submit" value="Setujui">
        </div>
    </x-boilerplate::card>
</x-boilerplate::form>
    <script>        
    $(document).keypress(
        function(event){
            if (event.which == '13') {
            event.preventDefault();
            }
        });
        $(document).ready(function(){
            var pengajuann = "{{ $pengajuan->pengajuan }}";
            var catatan = "{{ $pengajuan->catatan }}";
            var bank = "{{ $pengajuan->bank }}";
            var norek = "{{ $pengajuan->no_rek }}";
            var namarek = "{{ $pengajuan->nama_rek }}";
            var total = "{{ $pengajuan->total_nominal }}";
            var nom = document.getElementsByName('nominala[]');
            var jumpc = "{{ $pengajuan->jumlah_pc }}";
            var tot=0;
            if ( "{{ $closing->jenis_pengajuan_id }}" == 3){
                document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_closing as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td></tr>@endforeach <tr><td><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></td></tr></table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
                document.getElementById("form-closing").innerHTML = "<table class='table' id='dynamic'>@foreach ($isi_closing as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksia'>Keterangan</label> @else @endif <input class='form-control' type='text' name='transaksia[]' value='{{ $position->transaksi }}' id='transaksia' disabled></td><td> @if ($loop->first) <label for='nominala'>Nominal</label> @else @endif <input class='form-control' type='number' name='nominala[]' value='{{ $position->nominal }}' id='nominala' disabled></td> </tr>@endforeach </table>      <table class='table'><tr><td><label for='totalclosing'>Total</label> </td><td> <input class='form-control' type='text' name='totalclosing' id='totalclosing' disabled></td></tr><tr><td><label for='selisih'>Selisih dengan pengajuan</label><div id='icselisih'></div></td><td> <input class='form-control' type='text' name='selisih' id='selisih' disabled></td></tr></table>"
                for(var i=0;i<nom.length;i++){
                    if(parseFloat(nom[i].value))
                        tot += parseFloat(nom[i].value);
                }
                document.getElementById("totalclosing").value = tot;
                document.getElementById("selisih").value = total-tot;
                if (total>tot) {
                    document.getElementById("icselisih").innerHTML ='<span class="badge badge-pill badge-warning">kurang dari pengajuan</span>';
                }else if (total<tot) {
                    document.getElementById("icselisih").innerHTML ='<span class="badge badge-pill badge-danger">melebihi pengajuan</span>';
                }else {
                    document.getElementById("icselisih").innerHTML ='<span class="badge badge-pill badge-success">sesuai pengajuan</span>';
                }
            }else if ( "{{ $closing->jenis_pengajuan_id }}" == 6){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)</label><input class='form-control' name='jumpc' value='"+jumpc+"' type='text' id='jumpc' disabled></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='jenistr'>Jenis Transaksi</label> @else @endif<input class='form-control' type='text' name='jenistr[]' value='{{ $position->jenis_transaksi }}' id='jenistr' disabled></td> </tr>@endforeach</table> <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled>"
                document.getElementById("form-closing").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_closing as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first)<label for='coa'>COA</label> @else @endif<input class='form-control' type='text' name='coa[]' value='{{ $position->coa }}' id='coa' disabled></td><td>@if ($loop->first) <label for='transaksia'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksia[]' value='{{ $position->transaksi }}' id='transaksia' disabled></td><td> @if ($loop->first)<label for='nominala'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominala[]' value='{{ $position->nominal }}' id='nominala' disabled></td> <td>@if ($loop->first)<label for='saldoa'>Saldo</label> @else @endif<input class='form-control' type='text' name='saldoa[]' value='{{ $position->saldo }}' id='saldoa' disabled></td> </tr>@endforeach</table><table class='table'><tr><td><label for='totalclosing'>Total nominal</label> </td><td> <input class='form-control' type='text' name='totalclosing' id='totalclosing' disabled></td></tr><tr><td><label for='selisih'>Selisih saldo</label><div id='icselisih'></div></td><td> <input class='form-control' type='text' name='selisih' id='selisih' disabled></td></tr></table></div>"
                var nom = document.getElementsByName('nominala[]');
                var sald = document.getElementsByName('saldoa[]');
                var totb=0;
                for(var i=0;i<nom.length;i++){
                    a=i-1;
                    if(i==0){
                        
                    }else if (i>0){
                        totb = parseFloat(sald[a].value)-parseFloat(nom[i].value);
                        sald[i].value = totb;
                    }
                }
                for(var i=0;i<nom.length;i++){
                    if(parseFloat(nom[i].value))
                        tot += parseFloat(nom[i].value);
                }
                document.getElementById("totalclosing").value = tot;
                document.getElementById("selisih").value = totb;
                if (totb>0) {
                    document.getElementById("icselisih").innerHTML ='<span class="badge badge-pill badge-warning">kurang dari saldo</span>';
                }else if (totb<0) {
                    document.getElementById("icselisih").innerHTML ='<span class="badge badge-pill badge-danger">melebihi saldo</span>';
                }else if (totb=0){
                    document.getElementById("icselisih").innerHTML ='<span class="badge badge-pill badge-success">sesuai saldo</span>';
                }
            }
        });
    </script>
@endsection