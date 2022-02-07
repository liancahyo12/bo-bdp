@extends('boilerplate::layout.index', [
    'title' => __('Log Report Surat Keluar'),
    'subtitle' => 'Daftar Log Report Surat Keluar Saya',
    'breadcrumb' => ['Daftar Log Report Surat Keluar Saya']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Log Report Surat Keluar Saya
        </x-slot>
            <x-boilerplate::datatable name="log-report-suratkeluar-saya" />
    </x-boilerplate::card>
@endsection