@extends('boilerplate::layout.index', [
    'title' => __('Log Report Surat Keluar'),
    'subtitle' => 'Daftar Log Report Surat Keluar',
    'breadcrumb' => ['Daftar Log Report Surat Keluar']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Log Report Surat Keluar
        </x-slot>
            <x-boilerplate::datatable name="log-report-suratkeluar" />
    </x-boilerplate::card>
@endsection