@extends('boilerplate::layout.index', [
    'title' => __('Tambah Surat Masuk'),
    'subtitle' => __('Tambah Surat Masuk'),
    'breadcrumb' => [
        __('Tambah Surat Masuk') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-masuk-buat']" method="post" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::datetimepicker name="tgl_diterima" label='Tanggal Diterima*'/>
            <x-boilerplate::datetimepicker name="tgl_surat" label='Tanggal Surat*'/>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen Tujuan*">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}">{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::input name="no_surat" label="Nomor Surat*" />
            <x-boilerplate::input name="pengirim" label="Pengirim*" />
            <x-boilerplate::input name="ringkasan" label="Ringkasan*" />
            <x-boilerplate::input name="file_surat" type="file" label="Unggah Surat Masuk* (PDF Maks 20MB)" />
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection