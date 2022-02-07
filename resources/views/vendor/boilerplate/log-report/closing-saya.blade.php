@extends('boilerplate::layout.index', [
    'title' => __('Log Report Closing Pengajuan'),
    'subtitle' => 'Daftar Log Report Closing Pengajuan Saya',
    'breadcrumb' => ['Daftar Log Report Closing Pengajuan Saya']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Log Report Closing Pengajuan Saya
        </x-slot>
            <x-boilerplate::datatable name="log-report-closing-saya" />
    </x-boilerplate::card>
@endsection