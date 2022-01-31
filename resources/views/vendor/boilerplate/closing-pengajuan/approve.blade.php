@extends('boilerplate::layout.index', [
    'title' => __('Approve Closing Pengajuan'),
    'subtitle' => 'Daftar Closing Pengajuan',
    'breadcrumb' => ['Approve Closing Pengajuan']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Closing Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="approve-closing" />
    </x-boilerplate::card>
@endsection