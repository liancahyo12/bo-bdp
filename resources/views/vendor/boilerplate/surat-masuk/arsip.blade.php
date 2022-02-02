@extends('boilerplate::layout.index', [
    'title' => __('Surat Masuk'),
    'subtitle' => 'Arsip Surat Masuk',
    'breadcrumb' => ['Arsip Surat Masuk']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Arsip Surat Masuk
        </x-slot>
            <x-boilerplate::datatable name="surat-masuk-arsip" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection