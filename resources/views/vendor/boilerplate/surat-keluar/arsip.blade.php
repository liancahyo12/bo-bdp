@extends('boilerplate::layout.index', [
    'title' => __('Surat Keluar'),
    'subtitle' => 'Arsip Surat Keluar',
    'breadcrumb' => ['Arsip Surat Keluar']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Arsip Surat Keluar
        </x-slot>
            <x-boilerplate::datatable name="arsipsurat" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection