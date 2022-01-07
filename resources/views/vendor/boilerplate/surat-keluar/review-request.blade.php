@extends('boilerplate::layout.index', [
    'title' => __('Permintaan Surat Keluar'),
    'subtitle' => __('Review Permintaan Surat Keluar'),
    'breadcrumb' => [
        __('Review Permintaan Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-request-review.review', $reqsurat->ida]" method="put" files onsubmit="return confirm('Are you sure?')">
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
        
        <div @if ($reqsurat->request_status==0 || $reqsurat->request_status==1 || $reqsurat->request_status==6)
        @else style='display:none;' @endif>
            <x-boilerplate::input name="komentar" autofocus/>
            {{ Form::submit('Revisi', array('class' => 'btn btn-warning', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Tolak', array('class' => 'btn btn-danger', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Buat Surat', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
            
        </div>
    </x-boilerplate::card>
    </x-boilerplate::form>
    <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surat" label="Pilih Jenis Surat" id='jenis_surat' disabled>
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}" @if ( $reqsurat->jenis_surat_id==$position->id)
                        selected
                    @endif>{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen" disabled>
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}" @if ( $reqsurat->departemen_id==$position->id)
                        selected
                    @endif>{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="perihal" label="Perihal" value="{{ $reqsurat->perihal }}" disabled />
            <x-boilerplate::input name="ketarangan" label="Keterangan" value="{{ $reqsurat->keterangan }}" disabled />
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-request-review-lampiran/{{ $reqsurat->ida }}"><button class="btn btn-secondary">Lihat lampiran</button></a>
                </div>
            </div>
            
        </x-boilerplate::card>
@endsection