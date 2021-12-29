@extends('boilerplate::layout.index', [
    'title' => __('Surat Keluar Saya'),
    'subtitle' => 'Daftar Surat Keluar Saya',
    'breadcrumb' => ['Surat Keluar Saya']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Surat Keluar
        </x-slot>
            <x-boilerplate::datatable name="suratkeluarsaya" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection