@extends('boilerplate::layout.index', [
    'title' => __('Closing Pengajuan'),
    'subtitle' => __('Closing Pengajuan'),
    'breadcrumb' => [
        __('Closing Pengajuan') 
    ]
])

@section('content')
<div class="row">
    <div class="col-md-6">
        <x-boilerplate::form :route="['boilerplate.buat-closing-pengajuan', $pengajuan->ida]" method="post" files>
        @csrf
            <x-boilerplate::card>
                <x-slot name="header">
                    <h4><b>Form Closing</b></h4>
                </x-slot>
                <x-boilerplate::datetimepicker name="tgl_closing" label='Tanggal Closing*' required/>
                <div id="form-closing">
                </div>
                <x-boilerplate::input name="catatana" type="text" label="Catatan*" required/>
                <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran* (PDF Maks 20MB)" required/>
                <div class="row">
                    &nbsp; &nbsp;
                    {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
                    &nbsp; 
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
                document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi' disabled></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal' disabled></td></tr>@endforeach <tr><td><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total[]' value='"+total+"' id='total' disabled></td></tr></table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled></div>"
                document.getElementById("form-closing").innerHTML = "<table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksia'>Keterangan</label> @else @endif <input class='form-control' type='text' name='transaksia[]' value='{{ $position->transaksi }}' id='transaksia' required></td><td> @if ($loop->first) <label for='nominala'>Nominal</label> @else @endif <input class='form-control angka' type='number' name='nominala[]' value='{{ $position->nominal }}' id='nominala' required></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td>@else <td><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>Hapus</button></td>@endif </tr>@endforeach </table>      <table class='table'><tr><td><label for='totalclosing'>Total</label> </td><td> <input class='form-control' type='text' name='totalclosing' id='totalclosing' disabled></td></tr><tr><td><label for='selisih'>Selisih dengan pengajuan</label><div id='icselisih'></div></td><td> <input class='form-control' type='text' name='selisih' id='selisih' disabled></td></tr></table>"
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
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksia[]' id='transaksia"+no+"' required></td><td><input class='form-control angka' type='number' name='nominala[]' id='nominal"+no+"' required></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                });
                $(document).on('click', '.btn_removea', function(){
                    var button_id = $(this).attr("id"); 
                    $('#'+button_id+'').remove();
                    hitungTotalca();
                });       
                $(document).on('input', '.angka', hitungTotalca);
                function hitungTotalca() {
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
                }
            }else if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 6){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)</label><input class='form-control' name='jumpc' value='"+jumpc+"' type='text' id='jumpc' disabled></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='jenistr'>Jenis Transaksi</label> @else @endif<input class='form-control' type='text' name='jenistr[]' value='{{ $position->jenis_transaksi }}' id='jenistr' disabled></td> </tr>@endforeach</table> <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' disabled><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek' disabled><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek' disabled><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank' disabled>"
                document.getElementById("form-closing").innerHTML = "<div>    <table class='table' id='dynamic'><tr id='row'><td width='12%'><label for='coa'>COA*</label><input class='form-control' type='text' name='coa[]' id='coa'></td><td><label for='transaksia'>Keterangan*</label><input class='form-control' type='text' name='transaksia[]' id='transaksia' placeholder='Saldo . . .' required></td><td><label for='nominala'>Nominal*</label><input class='form-control angka' type='number' name='nominala[]' id='nominala' readonly></td><td><label for='saldoa'>Saldo*</label><input class='form-control angka' type='number' name='saldoa[]' id='saldoa' required></td><td><br><button type='button' id='tambah' class='btn btn-success tambah'>Tambah</button></td></tr></table>        <table class='table'><tr><td><label for='totalclosing'>Total nominal</label> </td><td> <input class='form-control' type='text' name='totalclosing' id='totalclosing' disabled></td></tr><tr><td><label for='selisih'>Selisih saldo</label><div id='icselisih'></div></td><td> <input class='form-control' type='text' name='selisih' id='selisih' disabled></td></tr></table></div>"
                var no =1;
                $(document).on('click', '.tambah', function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='coa[]' id='coa"+no+"'></td><td><input class='form-control' type='text' name='transaksia[]' id='transaksia"+no+"' required></td><td><input class='form-control nominala angka' type='number' name='nominala[]' id='nominala"+no+"' required></td><td><input class='form-control saldoa angka' type='number' name='saldoa[]' id='saldoa"+no+"' readonly ></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                    hitungTotalpcc();
                });

                $(document).on('input', '.angka', hitungTotalpcc);

                function hitungTotalpcc() {
                    var nom = document.getElementsByName('nominala[]');
                    var sald = document.getElementsByName('saldoa[]');
                    var totb=0;
                    var tot=0;
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
            }
            
        });
    </script>
@endsection