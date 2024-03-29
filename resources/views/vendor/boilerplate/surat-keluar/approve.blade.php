@extends('boilerplate::layout.index', [
    'title' => __('Surat Keluar'),
    'subtitle' => 'Approve Surat Keluar',
    'breadcrumb' => ['Approve Surat Keluar']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Surat Keluar
        </x-slot>
            <x-boilerplate::datatable name="approvesuratkeluar" />
        <x-slot name="footer">
        </x-slot>
    </x-boilerplate::card>
@endsection