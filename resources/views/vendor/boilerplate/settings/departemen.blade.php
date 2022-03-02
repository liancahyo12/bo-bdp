@extends('boilerplate::layout.index', [
    'title' => __('Departemen'),
    'subtitle' => 'Daftar Departemen',
    'breadcrumb' => ['Daftar Departemen']]
)

@section('content')
    
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Departemen
        </x-slot>
            <x-boilerplate::datatable name="departemen" />
        <x-slot name="footer">
            <a href="/buat-departemen"><button class="btn btn-primary" form="a">Tambah Departemen</button></a>
        </x-slot>
    </x-boilerplate::card>
@endsection