@extends('boilerplate::layout.index', [
    'title' => __('Log Report Pengajuan'),
    'subtitle' => 'Daftar Log Report Pengajuan Saya',
    'breadcrumb' => ['Daftar Log Report Pengajuan Saya']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Log Report Pengajuan Saya
        </x-slot>
            <x-boilerplate::datatable name="log-report-pengajuan-saya" />
    </x-boilerplate::card>
@endsection