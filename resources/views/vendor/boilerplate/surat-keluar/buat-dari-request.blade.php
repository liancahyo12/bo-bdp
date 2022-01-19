@extends('boilerplate::layout.index', [
    'title' => __('Buat Surat Keluar'),
    'subtitle' => __('Buat Surat Keluar'),
    'breadcrumb' => [
        __('Buat Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form name="form" :route="['boilerplate.surat-keluar-buata', $reqsurat->ida]" method="put" files>
        @csrf
        <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surat" label="Pilih Jenis Surat" id='jenis_surat'>
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}" @if ( $reqsurat->jenis_surat_id==$position->id)
                        selected
                    @endif>{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}" @if ( $reqsurat->departemen_id==$position->id)
                        selected
                    @endif>{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            {{-- <x-boilerplate::select2 name="reviewer" label="Pilih Reviewer">
                @foreach ($reviewer as $position)
                    <option value="{{ $position->id }}">{{ $position->first_name }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="approver" label="Pilih Approver">
                @foreach ($approver as $position)
                    <option value="{{ $position->id }}">{{ $position->first_name }}</option>
                @endforeach
            </x-boilerplate::select2> --}}
            <x-boilerplate::datetimepicker name="tgl_surat" label='Tanggal Surat'/>
            <x-boilerplate::input name="perihal" label="Perihal" value="{{ $reqsurat->perihal }}"/>
            <div class="form-group">
                <div class="input-group" id="unduh-format">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><span class="fas fa-file"></span></span>
                    </div>
                    <a target="_blank" href="/surat-keluar-buat-format/{{ $reqsurat->jenis_surat_id }}"><button class="btn btn-secondary" form="a">Unduh Format Surat</button></a>
                </div>
            </div>
            <x-boilerplate::input name="file_surat" type="file" label="Unggah Surat Keluar" />
            <label for="">Lampiran</label>
            <div class="row">
                <div class="col">
                    <x-boilerplate::icheck label="Gunakan Lampiran Permintaan" type="radio" name="lampiran_radio"  value="1" />
                </div>
                <div class="col">
                    <x-boilerplate::icheck label="Unggah Lampiran Baru" type="radio" name="lampiran_radio"  value="2" />
                </div>
                <div class="col">
                    <x-boilerplate::icheck label="Tanpa Lampiran" type="radio" name="lampiran_radio"  value="3" />
                </div>
            </div>
            <div id="lampiran-input" style='display:none;'>  
                <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran" />
            </div>
            
            {{-- <div style='display:none;' id='form-surat1'>Form Surat<br/>&nbsp;
                @include('boilerplate::surat-keluar.form1')
            </div> --}}
                   

        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
            &nbsp;
            {{-- {{ Form::submit('Preview Surat', array('class' => 'btn btn-warning', 'name' => 'submitbutton')) }}
            &nbsp; --}}
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
@endsection