@extends('boilerplate::layout.index', [
    'title' => __('Permintaan Surat Keluar'),
    'subtitle' => __('Buat Permintaan Surat Keluar'),
    'breadcrumb' => [
        __('Buat Permintaan Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-request-buat']" method="post" files onsubmit="return confirm('Are you sure?')">
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surata" label="Pilih Jenis Surat">
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}">{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}">{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="perihal" label="Perihal" />
            <x-boilerplate::input name="keterangan" label="Keterangan" />
            <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran" />
            {{-- @include('boilerplate::load.fileinput')
            @push('js')
                <script>
                    $('#files').fileinput()
                </script>
            @endpush --}}                 

        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
        
    </x-boilerplate::form>
@endsection