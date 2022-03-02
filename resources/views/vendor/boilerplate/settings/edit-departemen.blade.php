@extends('boilerplate::layout.index', [
    'title' => __('Departemen'),
    'subtitle' => __('Edit Departemen'),
    'breadcrumb' => [
        __('Edit Departemen') 
    ]
])

@section('content')

    <x-boilerplate::form :route="['boilerplate.store-departemen']" method="post">
    @csrf
        <x-boilerplate::card>
            <x-boilerplate::input name="kode" type="text" label="Kode Departemen*" value="{{ $depart->kode }}"/>
            <x-boilerplate::input name="departemen" type="text" label="Nama Departemen*" value="{{ $depart->departemen }}"/>
            <x-boilerplate::select2 name="reviewerdep" label="Pilih Reviewer Departemen*">
                @foreach ($reviewerdep as $position)
                    <option value="{{ $position->idr }}" @if ( $position->idr==$depart->reviewerdep_id)
                        selected
                    @endif>{{ $position->nama }}</option>
                @endforeach
            </x-boilerplate::select2>
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton', 'id' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection