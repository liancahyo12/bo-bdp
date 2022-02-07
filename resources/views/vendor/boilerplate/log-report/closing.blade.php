@extends('boilerplate::layout.index', [
    'title' => __('Log Report Closing Pengajuan'),
    'subtitle' => 'Daftar Log Report Closing Pengajuan',
    'breadcrumb' => ['Daftar Log Report Closing Pengajuan']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Log Report Closing Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="log-report-closing" />
    </x-boilerplate::card>
@endsection