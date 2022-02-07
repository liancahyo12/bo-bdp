@extends('boilerplate::layout.index', [
    'title' => __('Closing Pengajuan'),
    'subtitle' => __('Closing Pengajuan'),
    'breadcrumb' => [
        __('Closing Pengajuan') 
    ]
])

@section('content')
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
<div class="row">
    <div class="col-md-6">
        <x-boilerplate::form :route="['boilerplate.update-closing-pengajuan', $closing->ida]" method="put" files>
        @csrf
            <x-boilerplate::card>
                <x-slot name="header">
                    <h4><b>Form Closing</b></h4>
                </x-slot>
                <x-boilerplate::datetimepicker name="tgl_closing" label='Tanggal Closing*' value="{{ $closing->tgl_closing}}"/>
                <div id="form-closing">
                </div>
                <x-boilerplate::input name="catatana" type="text" label="Catatan*" value="{{$closing->catatan}}"/>
                <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran* (PDF Maks 20MB)" />
                <div class="form-group" @if ($closing->lampiran!=null)
                
                    @else
                    style='display:none;'
                    @endif id="unduh-lamiran-lama">
                    <br>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><span class="fas fa-file"></span></span>
                        </div>
                        <a target="_blank" href="/edit-closing-pengajuan-lampiran/{{ $closing->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                    </div>
                </div>
                <div class="row">
                    &nbsp; &nbsp;
                    {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
                </div>
            </x-boilerplate::card>
        </x-boilerplate::form>            
                
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
            <x-boilerplate::input name="catatana" type="text" label="Catatan" value="{{$closing->catatan}}"/>
            <br>
            <div class="form-group" @if ($pengajuan->lampiran!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-lamiran">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/edit-pengajuan-lampiran/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                </div>
            </div>
        </x-boilerplate::card>
    </div>
</div>
    <script>        
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
            if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 3){
                document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td></tr>@endforeach <tr><td><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></td></tr></table>        <label for='catatan'>Catatan**</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening**</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
                document.getElementById("form-closing").innerHTML = "<table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksia'>Keterangan</label> @else @endif <input class='form-control' type='text' name='transaksia[]' value='{{ $position->transaksi }}' id='transaksia'></td><td> @if ($loop->first) <label for='nominala'>Nominal</label> @else @endif <input class='form-control' type='number' name='nominala[]' value='{{ $position->nominal }}' id='nominala'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td>@else <td><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>Hapus</button></td>@endif </tr>@endforeach </table> <a>*klik apapun untuk hitung</a>     <table class='table'><tr><td><label for='totalclosing'>Total</label> </td><td> <input class='form-control' type='text' name='totalclosing' id='totalclosing' disabled></td></tr><tr><td><label for='selisih'>Selisih dengan pengajuan</label><div id='icselisih'></div></td><td> <input class='form-control' type='text' name='selisih' id='selisih' disabled></td></tr></table>"
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
                var no =1;
                $('#tambah').click(function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='number' name='nominala[]' id='nominal"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                });
                $(document).on('click', '.btn_removea', function(){
                    var button_id = $(this).attr("id"); 
                    $('#'+button_id+'').remove();
                });       
                $(document).on('change', '.form-control', function() {
                    var nom = document.getElementsByName('nominala[]');
                    var tot=0;
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
                });
            }else if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 6){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)</label><input class='form-control' name='jumpc' value='"+jumpc+"' type='text' id='jumpc' disabled></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='jenistr'>Jenis Transaksi</label> @else @endif<input class='form-control' type='text' name='jenistr[]' value='{{ $position->jenis_transaksi }}' id='jenistr' disabled></td> </tr>@endforeach</table> <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled>"
                document.getElementById("form-closing").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_closing as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first)<label for='coa'>COA</label> @else @endif<input class='form-control' type='text' name='coa[]' value='{{ $position->coa }}' id='coa' ></td><td>@if ($loop->first) <label for='transaksia'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksia[]' value='{{ $position->transaksi }}' id='transaksia' ></td><td> @if ($loop->first)<label for='nominala'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominala[]' value='{{ $position->nominal }}' id='nominala' ></td> <td>@if ($loop->first)<label for='saldoa'>Saldo</label> <input class='form-control' type='text' name='saldoa[]' value='{{ $position->saldo }}' id='saldoa' >@else<input class='form-control' type='text' name='saldoa[]' value='{{ $position->saldo }}' id='saldoa' readonly> @endif</td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td>          @else <td><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>Hapus</button></td>@endif</tr>@endforeach</table></div>"
                $('#tambah').click(function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='coa[]' id='coa"+no+"'></td><td><input class='form-control' type='text' name='transaksia[]' id='transaksia"+no+"'></td><td><input class='form-control nominala' type='number' name='nominala[]' id='nominala"+no+"'></td><td><input class='form-control saldoa' type='number' name='saldoa[]' id='saldoa"+no+"' readonly></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                });
                $(document).on('click', '.btn_removea', function(){
                    var button_id = $(this).attr("id"); 
                    $('#'+button_id+'').remove();
                });
                $(document).on('change', '.form-control', function() {
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
                });
            }
            
        });
    </script>
@endsection