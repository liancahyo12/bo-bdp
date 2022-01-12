@extends('boilerplate::layout.index', [
    'title' => __('Permintaan Surat Keluar'),
    'subtitle' => __('Edit Permintaan Surat Keluar'),
    'breadcrumb' => [
        __('Edit Permintaan Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-request-saya', $reqsurat->ida]" method="put" files onsubmit="return confirm('Are you sure?')">
        <x-boilerplate::card>
            <x-slot name="header">
                <b>Komentar</b>
            </x-slot>
            @foreach ( $reqreview as $reqrev)
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{ Auth::user()->first_name }}</span>
                        <span class="direct-chat-timestamp float-right">{{ $reqrev->created_at }}</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img src="{{ Auth::user()->avatar_url }}" class="direct-chat-img" alt="{{ Auth::user()->name }}" width="30" height="30">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {{ $reqrev->komentar }}
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
            @endforeach
        </x-boilerplate::card>
        <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surat" label="Pilih Jenis Surat" id='jenis_surat'>
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}" @if ( $reqsurat->jenis_surat_id==$position->id)
                        selected
                    @endif>{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}" @if ( $reqsurat->departemen_id==$position->id)
                        selected
                    @endif>{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="perihal" label="Perihal" value="{{ $reqsurat->perihal }}" />
            <x-boilerplate::input name="keterangan" label="Keterangan" value="{{ $reqsurat->keterangan }}" />
            <div @if ($reqsurat->request_status==4)
            
                @else
                    style='display:none;'
                @endif>
                <x-boilerplate::input type="file" name="files" label="Unggah untuk mengganti lampiran"  />
            </div>
            <div class="form-group" @if ($reqsurat->lampiran!=null) @else style='display:none;' @endif>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-request-lampiran/{{ $reqsurat->ida }}" ><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                </div>
            </div>
            <div class="form-group" @if ($reqsurat->request_status==3) @else style='display:none;' @endif>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-request-suratkeluar/{{ $reqsurat->ida }}" ><button class="btn btn-secondary" form="a">Lihat Surat Keluar</button></a>
                </div>
            </div>
        </x-boilerplate::card>
        <div class="row" @if ($reqsurat->request_status==4)
        @else
            style='display:none;'
        @endif>
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection