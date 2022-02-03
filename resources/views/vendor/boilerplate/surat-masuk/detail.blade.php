@extends('boilerplate::layout.index', [
    'title' => __('Detail Surat Masuk'),
    'subtitle' => __('Detail Surat Masuk'),
    'breadcrumb' => [
        __('Detail Surat Masuk') 
    ]
])

@section('content')
        <x-boilerplate::card>
            <x-boilerplate::datetimepicker name="tgl_diterima" label='Tanggal Diterima*' value="{{ $suratmasuk->tgl_diterima}}" disabled/>
            <x-boilerplate::datetimepicker name="tgl_surat" label='Tanggal Surat*' value="{{ $suratmasuk->tgl_surat}}" disabled/>
            <x-boilerplate::select2 name="departemen" label="Departemen Tujuan*" disabled>
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}" @if ( $position->id==$suratmasuk->departemen_id)
                        selected
                    @endif>{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="no_surat" label="Nomor Surat*" value="{{ $suratmasuk->no_surat}}" disabled/>
            <x-boilerplate::input name="pengirim" label="Pengirim*" value="{{ $suratmasuk->pengirim}}" disabled/>
            <x-boilerplate::input name="ringkasan" label="Ringkasan*" value="{{ $suratmasuk->ringkasan}}" disabled/>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" 
                    @if (\Request::is('surat-masuk-saya-detail/*'))
                    href="/surat-masuk-file-saya/{{ $suratmasuk->id }}"
                    @endif 
                    @if (\Request::is('surat-masuk-arsip-detail/*'))
                    href="/surat-masuk-file-arsip/{{ $suratmasuk->id }}"
                    @endif
                    @if (\Request::is('surat-masuk-detail/*'))
                    href="/surat-masuk-file/{{ $suratmasuk->id }}"
                    @endif><button class="btn btn-secondary" form="a">Lihat Dokumen Surat</button></a>
                </div>
            </div>
        </x-boilerplate::card>
@endsection