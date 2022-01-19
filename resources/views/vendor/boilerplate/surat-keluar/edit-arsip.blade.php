@extends('boilerplate::layout.index', [
    'title' => __('Surat Keluar'),
    'subtitle' => __('Detail Arsip Surat Keluar'),
    'breadcrumb' => [
        __('Detail Arsip Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-arsip-update', $arsip->ida]" method="put" onsubmit="return confirm('Are you sure?')" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="jenis_surat" label="Jenis Surat" value="{{ $arsip->jenis_surat }}" disabled/>
            <x-boilerplate::input name="departemen" label="Departemen" value="{{ $arsip->departemen }}" disabled/>
            <x-boilerplate::input name="perihal" label="Perihal" value="{{ $arsip->perihal }}" disabled/>
            <x-boilerplate::input name="nosurat" label="No Surat" value="{{ $arsip->no_surat }}" disabled/>
            <x-boilerplate::datetimepicker value="{{ $arsip->tgl_surat }}" name="tgl_surat" label='Tanggal Surat' disabled/>
            <div @if ($arsip->surat_scan==null) @else style='display:none;' @endif>
                <x-boilerplate::input type="file" name="file" label="Unggah Surat Scan" />
            </div>
            <div class="form-group" @if ($arsip->surat_scan!=null) @else style='display:none;' @endif>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-surat-scan/{{ $arsip->ida }}"><button class="btn btn-secondary" form="c">Lihat Surat Keluar Scan</button></a>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-surat/{{ $arsip->ida }}"><button class="btn btn-secondary" form="b">Lihat Surat Keluar</button></a>
                </div>
            </div>
            <div class="form-group" @if ($arsip->lampiran!=null) @else style='display:none;' @endif>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-arsip-lampiran/{{ $arsip->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                </div>
            </div>
        </x-boilerplate::card>
        <div>
            <input class="btn btn-primary" name="submitbutton" type="submit" value="Kirim" @if ($arsip->surat_scan==null) @else style='display:none;' @endif>
        </div>
    </x-boilerplate::form>
@endsection