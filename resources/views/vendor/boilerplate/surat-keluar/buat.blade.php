@extends('boilerplate::layout.index', [
    'title' => __('Buat Surat Keluar'),
    'subtitle' => __('Buat Surat Keluar'),
    'breadcrumb' => [
        __('Buat Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-buat']" method="post" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surat" label="Pilih Jenis Surat*" id='jenis_surat'>
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}">{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen*">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}">{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::datetimepicker name="tgl_surat" label='Tanggal Surat*'/>
            <x-boilerplate::input name="perihal" label="Perihal*" />
            <div class="form-group">
                <div class="input-group" id="unduh-format">
                </div>
            </div>
            <x-boilerplate::input name="file_surat" type="file" label="Unggah Surat Keluar* (Word DOCX Maks 20MB)" />
            <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran (PDF Maks 20MB)" />
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection