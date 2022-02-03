@extends('boilerplate::layout.index', [
    'title' => __('Surat Masuk'),
    'subtitle' => 'Surat Masuk',
    'breadcrumb' => ['Surat Masuk']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Surat Masuk
        </x-slot>
            <x-boilerplate::datatable name="surat-masuk" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection