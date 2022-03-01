@extends('boilerplate::layout.index', [
    'title' => __('Karyawan'),
    'subtitle' => 'Daftar Karyawan',
    'breadcrumb' => ['Daftar Karyawan']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Karyawan
        </x-slot>
            <x-boilerplate::datatable name="karyawan" />
    </x-boilerplate::card>
@endsection