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
        <div @if ($pengajuan->reviewerdep_id==null)
            style='display:none;'
        @endif>
            <x-boilerplate::card>
                <x-slot name="header">
                    <b>Komentar Review Dep</b>
                </x-slot>
                @foreach ( $reviewdeppengajuan as $reviewdeppengajuan)
                    <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">{{ $reviewdeppengajuan->first_name }}</span>
                            <span class="direct-chat-timestamp float-right">{{ $reviewdeppengajuan->created_at }}</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img src="{{ mix('/images/user128.jpg', '/assets/vendor/boilerplate') }}" class="direct-chat-img" alt="{{ $reviewdeppengajuan->first_name }}" width="30" height="30">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            {{ $reviewdeppengajuan->komentar }}
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                @endforeach
            </x-boilerplate::card>
        </div>
        <div @if ($pengajuan->reviewer_id==null)
            style='display:none;'
        @endif>
            <x-boilerplate::card>
                <x-slot name="header">
                    <b>Komentar Review</b>
                </x-slot>
                @foreach ( $reviewpengajuan as $reviewpengajuan)
                    <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">{{ $reviewpengajuan->first_name }}</span>
                            <span class="direct-chat-timestamp float-right">{{ $reviewpengajuan->created_at }}</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img src="{{ mix('/images/user128.jpg', '/assets/vendor/boilerplate') }}" class="direct-chat-img" alt="{{ $reviewpengajuan->first_name }}" width="30" height="30">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            {{ $reviewpengajuan->komentar }}
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                @endforeach
            </x-boilerplate::card>
        </div>
        <div @if ($pengajuan->approver_id==null)
            style='display:none;'
        @endif>
            <x-boilerplate::card>
                <x-slot name="header">
                    <b>Komentar Approve</b>
                </x-slot>
                @foreach ( $approvepengajuan as $approvepengajuan)
                    <div class="direct-chat-msg">
                        <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">{{ $approvepengajuan->first_name }}</span>
                            <span class="direct-chat-timestamp float-right">{{ $approvepengajuan->created_at }}</span>
                        </div>
                        <!-- /.direct-chat-infos -->
                        <img src="{{ mix('/images/user128.jpg', '/assets/vendor/boilerplate') }}" class="direct-chat-img" alt="{{ $approvepengajuan->first_name }}" width="30" height="30">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                            {{ $approvepengajuan->komentar }}
                        </div>
                        <!-- /.direct-chat-text -->
                    </div>
                @endforeach
            </x-boilerplate::card>
        </div>
        <x-boilerplate::card>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}" @if ( $pengajuan->departemen_id==$position->id)
                        selected
                    @endif>{{ $position->departemen }} </option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::datetimepicker name="tgl_pengajuan" label='Tanggal Pengajuan' value="{{ $pengajuan->tgl_pengajuan}}"/>
            <x-boilerplate::select2 name="jenis_pengajuan" label="Pilih Jenis Pengajuan" id='jenis_pengajuan' disabled>
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
                <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran" />
                
            </div>
            <div class="form-group" @if ($pengajuan->lampiran!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-lamiran-lama">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/edit-pengajuan-lampiran/{{ $pengajuan->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran Lama</button></a>
                </div>
            </div>
        </x-boilerplate::card>
        <div class="row"  @if ($pengajuan->send_status==0 || $pengajuan->approve_status==3 || $pengajuan->reviewdep_status==3 || $pengajuan->review_status==3)
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
            if ( "{{ $pengajuan->jenis_pengajuan_id }}" <= 3){
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='pengajuan'>Pengajuan</label><input class='form-control' name='pengajuan' value='"+pengajuann+"' type='text' id='pengajuan'>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Transaksi</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi'></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td>          @else <td><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>Hapus</button></td>@endif</tr>@endforeach</table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan'><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek'><label for='norek'>No Rekening</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek'><label for='bank'>Bank</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank'></div>"
                var no =1;
                $('#tambah').click(function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='text' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
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
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='pengajuan'>Pengajuan</label><input class='form-control' name='pengajuan' value='"+pengajuann+"' type='text' id='pengajuan'><label for='noinvoice'>No Invoice</label><input class='form-control' type='text' name='noinvoice' value='"+noinvoice+"' id='noinvoice'>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='transaksi'>Transaksi</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi'></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td>          @else <td><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>Hapus</button></td>@endif</tr>@endforeach</table>       <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan'><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek'><label for='norek'>No Rekening Tujuan</label><input class='form-control' name='norek' value='"+norek+"' type='text' id='norek'><label for='bank'>Bank Tujuan</label><input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank'></div>"
                var no =1;
                $('#tambah').click(function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='text' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
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
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='pengajuan'>Pengajuan</label><input class='form-control' name='pengajuan' value='"+pengajuann+"' type='text' id='pengajuan'>    <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first)<label for='coa'>COA</label> @else @endif<input class='form-control' type='text' name='coa[]' value='{{ $position->coa }}' id='coa'></td><td>@if ($loop->first) <label for='transaksi'>Transaksi</label> @else @endif<input class='form-control' type='text' name='transaksi[]' value='{{ $position->transaksi }}' id='transaksi'></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal'></td> <td>@if ($loop->first)<label for='saldo'>Saldo</label> @else @endif<input class='form-control' type='text' name='saldo[]' value='{{ $position->saldo }}' id='saldo'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td>          @else <td><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>Hapus</button></td>@endif</tr>@endforeach</table>      <label for='catatan'>Catatan</label><br><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan'><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' value='"+namarek+"' type='text' id='namarek'><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' value='"+norek+"' type='text' id='norek'><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' value='"+bank+"' type='text' id='Bank'></div>"
                var no =1;
                $('#tambah').click(function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='coa[]' id='coa"+no+"'></td><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='text' name='nominal[]' id='nominal"+no+"'></td><td><input class='form-control' type='text' name='saldo[]' id='saldo"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
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
                document.getElementById("form-pengajuan").innerHTML = "<div><label for='pengajuan'>Pengajuan</label><input class='form-control' name='pengajuan' value='"+pengajuann+"' type='text' id='pengajuan'><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)</label><input class='form-control' name='jumpc' value='"+jumpc+"' type='text' id='jumpc'></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='jenistr'>Jenis Transaksi</label> @else @endif<input class='form-control' type='text' name='jenistr[]' value='{{ $position->jenis_transaksi }}' id='jenistr'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td>          @else <td><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>Hapus</button></td>@endif</tr>@endforeach</table> <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan'>"
                var no =1;
                $('#tambah').click(function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='jenistr[]' id='jenistr"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
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
                document.getElementById("form-pengajuan").innerHTML = "<label for='pengajuan'>Pengajuan</label><input class='form-control' name='pengajuan' value='"+pengajuann+"' type='text' id='pengajuan'><label for='perusahaan'>Perusahaan</label><input class='form-control' name='perusahaan' value='"+perusahaan+"' type='text' id='perusahaan'><label for='alamat'>Alamat</label><input class='form-control' name='alamat' value='"+alamat+"' type='text' id='alamat'><label for='notelepon'>No Telepon</label><input class='form-control' name='notelepon' value='"+phone+"' type='text' id='notelepon'><label for='kontak'>Kontak</label><input class='form-control' name='kontak' value='"+kontak+"' type='text' id='kontak'><label for='email'>Email</label><input class='form-control' name='email' value='"+email+"' type='text' id='email'>        <table class='table' id='dynamic'>@foreach ($isi_pengajuan as $key => $position) <tr id='ro{{ $position->id }}'><td>@if ($loop->first) <label for='pembelian'>Pembelian</label> @else @endif<input class='form-control' type='text' name='pembelian[]' value='{{ $position->transaksi }}' id='pembelian'></td><td> @if ($loop->first)<label for='nominal'>Nominal</label> @else @endif<input class='form-control' type='text' name='nominal[]' value='{{ $position->nominal }}' id='nominal'></td> @if ($loop->first) <td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td>          @else <td><button type='button' id='ro{{ $position->id }}' class='btn btn-danger btn_removea'>Hapus</button></td>@endif</tr>@endforeach</table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' value='"+catatan+"' id='catatan'><br>"
                var no =1;
                $('#tambah').click(function(){
                    no++;
                    $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='pembelian[]' id='pembelian"+no+"'></td><td><input class='form-control' type='text' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
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