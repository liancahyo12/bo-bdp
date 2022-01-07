@extends('boilerplate::layout.index', [
    'title' => __('Surat Keluar'),
    'subtitle' => 'Permintaan Surat Keluar Saya',
    'breadcrumb' => ['Permintaan Surat Keluar Saya']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Permintaan Surat Keluar Saya
        </x-slot>
            <x-boilerplate::datatable name="requestsuratkeluarsaya" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection