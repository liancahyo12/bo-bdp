@extends('boilerplate::layout.index', [
    'title' => __('Review Closing Pengajuan'),
    'subtitle' => 'Daftar Closing Pengajuan',
    'breadcrumb' => ['Review Closing Pengajuan']]
)

@section('content')
    <x-boilerplate::card>
        <x-slot name="header">
            Daftar Closing Pengajuan
        </x-slot>
            <x-boilerplate::datatable name="reviewdep-closing" />
    </x-boilerplate::card>
@endsection