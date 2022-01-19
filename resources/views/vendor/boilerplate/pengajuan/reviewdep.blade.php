@extends('boilerplate::layout.index', [
    'title' => __('Review Pengajuan'),
    'subtitle' => 'Daftar Pengajuan',
    'breadcrumb' => ['Review Pengajuan']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="reviewdeppengajuan" />
    </x-boilerplate::card>
@endsection