@extends('boilerplate::layout.index', [
    'title' => __('Review Pengajuan'),
    'subtitle' => 'Daftar Pengajuan',
    'breadcrumb' => ['Daftar Pengajuan']]
)

@section('content')
    @include('boilerplate::plugins.demo')
@endsection