@extends('boilerplate::layout.index', [
    'title' => __('Log Report Pengajuan'),
    'subtitle' => 'Daftar Log Report Pengajuan',
    'breadcrumb' => ['Daftar Log Report Pengajuan']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Log Report Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="log-report-pengajuan" />
    </x-boilerplate::card>
@endsection