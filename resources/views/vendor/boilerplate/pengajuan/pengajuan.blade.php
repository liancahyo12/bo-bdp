@extends('boilerplate::layout.index', [
    'title' => __('Pengajuan Saya'),
    'subtitle' => 'Daftar Pengajuan Saya',
    'breadcrumb' => ['Pengajuan Saya']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="pengajuans" />
        <x-slot name="footer">
            Card footer content
        </x-slot>
    </x-boilerplate::card>
@endsection