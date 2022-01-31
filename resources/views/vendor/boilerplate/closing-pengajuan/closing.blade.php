@extends('boilerplate::layout.index', [
    'title' => __('Closing Pengajuan Saya'),
    'subtitle' => 'Daftar Closing Pengajuan Saya',
    'breadcrumb' => ['Closing Pengajuan Saya']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Closing Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="closing" />
    </x-boilerplate::card>
@endsection