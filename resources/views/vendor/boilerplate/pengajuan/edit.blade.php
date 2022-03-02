@extends('boilerplate::layout.index', [
    'title' => __('Edit Pengajuan'),
    'subtitle' => __('Edit Pengajuan'),
    'breadcrumb' => [
        __('Edit Pengajuan') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.update-pengajuan', $pengajuan->ida]" method="put" files>
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
            <x-boilerplate::datetimepicker name="tgl_pengajuan" label='Tanggal Pengajuan*' value="{{ $pengajuan->tgl_pengajuan}}"/>
            <x-boilerplate::select2 name="jenis_pengajuan" label="Pilih Jenis Pengajuan*" id='jenis_pengajuan' disabled>
                @foreach ($jenis_pengajuan as $position)
                    <option value="{{ $position->id }}" @if ( $pengajuan->jenis_pengajuan_id==$position->id)
                        selected
                    @endif>{{ $position->jenis_pengajuan }}</option>
                @endforeach
            </x-boilerplate::select2>
            <div id="form-pengajuan">
            </div>
            <div @if ($pengajuan->send_status==0 || $pengajuan->approve_status==3 || $pengajuan->reviewdep_status==3 || $pengajuan->review_status==3)
                @else
                    style='display:none;'
                @endif>  
                <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran  (PDF Maks 20MB)" />
                
            </div>
            <div class="form-group" @if ($pengajuan->lampiran!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-lamiran-lama">
                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/edit-pengajuan-lampiran/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                </div>
            </div>
        </x-boilerplate::card>
        <div class="row"  @if ($pengajuan->send_status==0 || $pengajuan->revisi_status==1)
            @else
                style='display:none;'
            @endif>
            &nbsp; &nbsp;
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
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
            var perusahaan = "{{ $pengajuan->perusahaan }}";
            var alamat = "{{ $pengajuan->alamat }}";
            var phone = "{{ $pengajuan->phone }}";
            var kontak = "{{ $pengajuan->kontak }}";
            var email = "{{ $pengajuan->email_po }}";
            var catatan = "{{ $pengajuan->catatan }}";
            var noinvoice = "{{ $pengajuan->no_invoice }}";
            var jumpc = "{{ $pengajuan->jumlah_pc }}";
            var bank = "{{ $pengajuan->bank }}";
            var norek = "{{ $pengajuan->no_rek }}";
            var namarek = "{{ $pengajuan->nama_rek }}";
            var ppn = "{{ $pengajuan->ppn }}";
            var dpp = "{{ $pengajuan->dpp }}";
            if ( "{{ $pengajuan->jenis_pengajuan_id }}" <= 3){
                document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi'></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='number' name='nominal[]' value='{{ $position->nominal }}' id='nominal'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success tambah'>Tambah</button></td>          @else <td><button type='button' id='tambah' class='btn btn-success tambah'>+</button><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>x</button></td>@endif</tr>@endforeach</table>        <label for='catatan'>Catatan*</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' required><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening*</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek'><label for='norek'>No Rekening*</label><input class='form-control' name='norek' value='"+norek+"' type='number' id='norek'><label for='bank'>Bank*</label><input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank'></div>"
                var no =1;
                $(document).on('click', '.tambah', function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='number' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                });
                $(document).on('click', '.btn_removea', function(){
                    var button_id = $(this).attr("id"); 
                    $('#'+button_id+'').remove();
                });
            }else if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 4){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='noinvoice'>No Invoice*</label><input class='form-control' type='text' name='noinvoice' value='"+noinvoice+"' id='noinvoice'>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi'></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='number' name='nominal[]' value='{{ $position->nominal }}' id='nominal'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success tambah'>Tambah</button></td>          @else <td><button type='button' id='tambah' class='btn btn-success tambah'>+</button><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>x</button></td>@endif</tr>@endforeach</table>       <label for='catatan'>Catatan*</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' required><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening*</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek'><label for='norek'>No Rekening*</label><input class='form-control' name='norek' value='"+norek+"' type='number' id='norek'><label for='bank'>Bank*</label><input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank'></div>"
                var no =1;
                $(document).on('click', '.tambah', function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='number' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                });
                $(document).on('click', '.btn_removea', function(){
                    var button_id = $(this).attr("id"); 
                    $('#'+button_id+'').remove();
                });
            }else if ( "{{ $pengajuan->jenis_pengajuan_id }}" == 5){
                document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first)<label for='coa'>COA</label> @else @endif<input class='form-control' type='text' name='coa[]' value='{{ $position->coa }}' id='coa'></td><td>@if ($loop->first) <label for='transaksi'>Keterangan</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi'></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='number' name='nominal[]' value='{{ $position->nominal }}' id='nominal'></td> <td>@if ($loop->first)<label for='saldo'>Saldo</label> @else @endif<input class='form-control' type='text' name='saldo[]' value='{{ $position->saldo }}' id='saldo'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success tambah'>Tambah</button></td>          @else <td><button type='button' id='tambah' class='btn btn-success tambah'>+</button><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>x</button></td>@endif</tr>@endforeach</table>      <label for='catatan'>Catatan</label><br><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' required><h3>Tujuan</h3><label for='namarek'>Nama Rekening*</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek'><label for='norek'>No Rekening*</label><input class='form-control' name='norek' value='"+norek+"' type='number' id='norek'><label for='bank'>Bank*</label><input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank'></div>"
                var no =1;
                $(document).on('click', '.tambah', function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='coa[]' id='coa"+no+"'></td><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='number' name='nominal[]' id='nominal"+no+"'></td><td><input class='form-control' type='text' name='saldo[]' id='saldo"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                });
                $(document).on('click', '.btn_removea', function(){
                    var button_id = $(this).attr("id"); 
                    $('#'+button_id+'').remove();
                });
            }
            else if("{{ $pengajuan->jenis_pengajuan_id }}" == 6){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)*</label><input class='form-control' name='jumpc' value='"+jumpc+"' type='number' id='jumpc'></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='jenistr'>Jenis Transaksi</label> @else @endif<input class='form-control' type='text' name='jenistr[]' value='{{ $position->jenis_transaksi }}' id='jenistr'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success tambah'>Tambah</button></td>          @else <td><button type='button' id='tambah' class='btn btn-success tambah'>+</button><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>x</button></td>@endif</tr>@endforeach</table> <label for='catatan'>Catatan*</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' required><h3>Tujuan</h3><label for='namarek'>Nama Rekening*</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek'><label for='norek'>No Rekening*</label><input class='form-control' name='norek' value='"+norek+"' type='number' id='norek'><label for='bank'>Bank*</label><input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank'>"
                var no =1;
                $(document).on('click', '.tambah', function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='jenistr[]' id='jenistr"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                });
                $(document).on('click', '.btn_removea', function(){
                    var button_id = $(this).attr("id"); 
                    $('#'+button_id+'').remove();
                });
            }else{
                document.getElementById("form-pengajuan").innerHTML = "<label for='perusahaan'>Perusahaan*</label><input class='form-control' name='perusahaan' value='"+perusahaan+"' type='text' id='perusahaan'><label for='alamat'>Alamat*</label><input class='form-control' name='alamat' value='"+alamat+"' type='text' id='alamat'><label for='notelepon'>No Telepon*</label><input class='form-control' name='notelepon' value='"+phone+"' type='number' id='notelepon'><label for='kontak'>Nama Kontak*</label><input class='form-control' name='kontak' value='"+kontak+"' type='text' id='kontak'><label for='email'>Email*</label><input class='form-control' name='email' value='"+email+"' type='text' id='email'>        <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='pembelian'>Pembelian</label> @else @endif<input class='form-control' type='text' name='pembelian[]' value='{{ $position->transaksi }}' id='pembelian'></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='number' name='nominal[]' value='{{ $position->nominal }}' id='nominal'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success tambah'>Tambah</button></td>          @else <td><button type='button' id='tambah' class='btn btn-success tambah'>+</button><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>x</button></td>@endif</tr>@endforeach</table><table class='table'> <tr><td><label for='dpp'>DPP*</label></td><td><input class='form-control' type='text' name='dpp' id='dpp' value='"+dpp+"'></td></tr><tr><td><label for='ppn'>PPN 10%*</label></td><td><input class='form-control' type='text' name='ppn' id='ppn' value='"+ppn+"'> </td></tr></table>        <label for='catatan'>Catatan*</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan' required><br>"
                var no =1;
                $(document).on('click', '.tambah', function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='pembelian[]' id='pembelian"+no+"'></td><td><input class='form-control' type='number' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
                });

                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("id"); 
                    $('#row'+button_id+'').remove();
                });
                $(document).on('click', '.btn_removea', function(){
                    var button_id = $(this).attr("id"); 
                    $('#'+button_id+'').remove();
                });
            }            
        });
    </script>
@endsection