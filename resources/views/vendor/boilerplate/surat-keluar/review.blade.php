@extends('boilerplate::layout.index', [
    'title' => __('Surat Keluar'),
    'subtitle' => 'Review Surat Keluar',
    'breadcrumb' => ['Review Surat Keluar']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Surat Keluar
        </x-slot>
            <x-boilerplate::datatable name="reviewsuratkeluar" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection