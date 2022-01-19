@extends('boilerplate::layout.index', [
    'title' => __('Approve Pengajuan'),
    'subtitle' => 'Daftar Pengajuan',
    'breadcrumb' => ['Approve Pengajuan']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="approvepengajuan" />
    </x-boilerplate::card>
@endsection