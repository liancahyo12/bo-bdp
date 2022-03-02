@extends('boilerplate::layout.index', [
    'title' => __('Departemen'),
    'subtitle' => __('Tambah Departemen'),
    'breadcrumb' => [
        __('Tambah Departemen') 
    ]
])

@section('content')

    <x-boilerplate::form :route="['boilerplate.store-departemen']" method="post">
    @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="kode" type="text" label="Kode Departemen*" />
            <x-boilerplate::input name="departemen" type="text" label="Nama Departemen*" />
            <x-boilerplate::select2 name="reviewerdep" label="Pilih Reviewer Departemen*">
                @foreach ($reviewerdep as $position)
                    <option value="{{ $position->idr }}">{{ $position->nama }}</option>
                @endforeach
            </x-boilerplate::select2>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton', 'id' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection