@extends('boilerplate::layout.index', [
    'title' => __('Buat Pengajuan'),
    'subtitle' => __('Buat Pengajuan'),
    'breadcrumb' => [
        __('Buat Pengajuan') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.buat-pengajuan']" method="post" files>
        <x-boilerplate::card>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}">{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::datetimepicker name="tgl_pengajuan" label='Tanggal Pengajuan'/>
            <x-boilerplate::select2 name="jenis_pengjuan" label="Pilih Jenis Pengajuan" id='jenis_pengajuan'>
                @foreach ($jenis_pengajuan as $position)
                    <option value="{{ $position->id }}">{{ $position->jenis_pengajuan }}</option>
                @endforeach
            </x-boilerplate::select2>
            <div id="form-pengajuan">
            </div>
            <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran" />
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection