@extends('boilerplate::layout.index', [
    'title' => __('Edit Surat Keluar'),
    'subtitle' => __('Edit Surat Keluar'),
    'breadcrumb' => [
        __('Edit Surat Keluar') 
    ]
])

@section('content')
<x-boilerplate::card>
            <x-slot name="header">
                <b>Komentar</b>
            </x-slot>
            @foreach ( $approve as $approve)
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{ $approve->first_name }}&nbsp;</span>
                        <span class="badge badge-pill badge-secondary float-left">{{ $approve->kode }}</span>
                        @if ($approve->statuss == 2)
                            <span class="badge badge-pill badge-success float-right">disetujui</span>
                        @endif
                        @if ($approve->statuss == 3)
                            <span class="badge badge-pill badge-warning float-right">revisi</span>
                        @endif
                        @if ($approve->statuss == 4)
                            <span class="badge badge-pill badge-danger float-right">ditolak</span>
                        @endif
                        <span class="direct-chat-timestamp float-right">{{ $approve->waktu_komentar }}&nbsp;</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img src="{{ App\Models\Boilerplate\User::where('id', $approve->uid)->first()->avatar_url }}" class="direct-chat-img" alt="{{ $approve->first_name }}" width="30" height="30">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {{ $approve->komentar }}
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
            @endforeach            
        </x-boilerplate::card>
    <x-boilerplate::form :route="['boilerplate.surat-keluar-edit', $surat->ida]" method="put" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surat" label="Pilih Jenis Surat*" id='jenis_surat' required>
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}" @if ( $surat->jenis_surat_id==$position->id)
                        selected
                    @endif>{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen*" required>
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}" @if ( $surat->departemen_id==$position->id)
                        selected
                    @endif>{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::datetimepicker value="{{ $surat->tgl_surat }}" name="tgl_surat" label='Tanggal Surat*' required/>
            <x-boilerplate::input name="perihal" label="Perihal*" value="{{ $surat->perihal }}" required/>
            <div class="form-group" @if ($surat->approve_status!=2)
                
                @else
                style='display:none;'
                @endif>
                <div class="input-group" id="unduh-format">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-buat-format/{{ $surat->jenis_surat_id }}"><button class="btn btn-secondary" form="a">Unduh Format Surat</button></a>
                </div>
            </div>
            <div @if ($surat->send_status==0 || $surat->approve_status==3)\
                @else
                    style='display:none;'
                @endif>
                <label for="file_surat">Unggah Surat Keluar* (Word DOCX Maks 20MB)</label> <br>
            <input type="file" name="file_surat"> <br>
            <h3> </h3>
            </div>
            
            <div class="form-group" @if ($surat->isi_surat!=null)
                
                @else
                style='display:none;'
                @endif
                class="form-group" @if ($surat->approve_status!=2)
                
                @else
                style='display:none;'
                @endif>
                <div class="input-group" id="unduh-format">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-surat-lama/{{ $surat->ida }}"><button class="btn btn-secondary" form="a">Lihat Surat Lama</button></a>
                </div>
            </div>
            <div class="form-group" @if ($surat->approve_status==2)
                
                @else
                style='display:none;'
                @endif>
                <div class="input-group" id="unduh-format">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-surat-jadi/{{ $surat->ida }}"><button class="btn btn-secondary" form="a">Lihat Surat Approved</button></a>
                </div>
            </div>              
            <div id="lampiran-input" >  
                <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran" />
                
            </div>
            <div class="form-group" @if ($surat->lampiran!=null)
                
                @else
                style='display:none;'
                @endif id="unduh-lamiran-lama">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-lampiran/{{ $surat->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran Lama</button></a>
                </div>
            </div>
                   

        </x-boilerplate::card>
        <div class="row" @if ($surat->send_status==0 || $surat->approve_status==3)
        @else
            style='display:none;'
        @endif>
            &nbsp; 
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
    <script> $(document).keypress(
        function(event){
            if (event.which == '13') {
            event.preventDefault();
            }
        });
    </script>
@endsection