@extends('boilerplate::layout.index', [
    'title' => __('Surat Keluar'),
    'subtitle' => 'Permintaan Surat Keluar',
    'breadcrumb' => ['Permintaan Surat Keluar']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Permintaan Surat Keluar
        </x-slot>
            <x-boilerplate::datatable name="requestsuratkeluar" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection