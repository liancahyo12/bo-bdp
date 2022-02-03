@extends('boilerplate::layout.index', [
    'title' => __('Surat Masuk'),
    'subtitle' => 'Surat Masuk Saya',
    'breadcrumb' => ['Surat Masuk Saya']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Surat Masuk Saya
        </x-slot>
            <x-boilerplate::datatable name="surat-masuk-saya" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection