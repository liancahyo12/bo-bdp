@extends('boilerplate::layout.index', [
    'title' => __('Bayar Pengajuan'),
    'subtitle' => 'Daftar Pengajuan',
    'breadcrumb' => ['Bayar Pengajuan']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="bayar-pengajuan" />
    </x-boilerplate::card>
@endsection