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
                        <span class="direct-chat-name float-left">{{ Auth::user()->first_name }}</span>
                        <span class="direct-chat-timestamp float-right">{{ $approve->created_at }}</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img src="{{ Auth::user()->avatar_url }}" class="direct-chat-img" alt="{{ Auth::user()->name }}" width="30" height="30">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {{ $approve->komentar }}
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
            @endforeach            
        </x-boilerplate::card>
    <x-boilerplate::form :route="['boilerplate.surat-keluar-edit', $surat->ida]" method="put" files onsubmit="return confirm('Are you sure?')">
        <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surat" label="Pilih Jenis Surat" id='jenis_surat'>
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}" @if ( $surat->jenis_surat_id==$position->id)
                        selected
                    @endif>{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}" @if ( $surat->departemen_id==$position->id)
                        selected
                    @endif>{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::datetimepicker value="{{ $surat->tgl_surat }}" name="tgl_surat" label='Tanggal Surat'/>
            <x-boilerplate::input name="perihal" label="Perihal" value="{{ $surat->perihal }}" />
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
                <label for="file_surat">Unggah Surat Keluar</label> <br>
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
            <label for="">Lampiran</label>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="icheck-primary">
                            <input type="radio" id="icheck_61dbe7e7b33b3" name="lampiran_radio" value="1" @if ($surat->lampiran==$surat->lprq)
                                checked
                            @endif
                            @if($surat->request_surat_keluar_id==null)
                                disabled
                            @endif @if ($surat->approve_status!=2)
                
                            @else
                            disabled
                            @endif>
                            <label for="icheck_61dbe7e7b33b3" class="font-weight-normal">Gunakan Lampiran Permintaan</label>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="icheck-primary">
                            <input type="radio" id="icheck_61dbe7e7b353e" name="lampiran_radio" value="2"  @if ($surat->lampiran!=$surat->lprq && $surat->request_surat_keluar_id!=null)
                            checked
                            @endif @if ($surat->approve_status!=2)
                
                            @else
                            disabled
                            @endif>
                            <label for="icheck_61dbe7e7b353e" class="font-weight-normal">Unggah Lampiran Baru</label>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="icheck-primary">
                            <input type="radio" id="icheck_61dc0ffdcad8b" name="lampiran_radio" value="3" autocomplete="off" @if ($surat->request_surat_keluar_id==null)
                            checked
                            @endif @if ($surat->approve_status!=2)
                
                            @else
                            disabled
                            @endif>
                            <label for="icheck_61dc0ffdcad8b" class="font-weight-normal">Tanpa Lampiran</label>
                        </div>
                    </div>
                </div>
            </div>
            <div id="lampiran-input" @if ($surat->lampiran!=$surat->lprq && $surat->request_surat_keluar_id!=null)
                
                @else
                style='display:none;'
                @endif >  
                <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran" />
                
            </div>
            <div class="form-group" @if ($surat->request_surat_keluar_id!=null)
                
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
        <div class="row" @if ($surat->send_status==0 || $surat->approve_status==3)\
        @else
            style='display:none;'
        @endif>
            &nbsp; 
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
            &nbsp;
            <input formtarget="_blank" class="btn btn-warning" name="submitbutton" type="submit" value="Preview Surat" >
            &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection