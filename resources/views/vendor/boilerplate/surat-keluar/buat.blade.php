@extends('boilerplate::layout.index', [
    'title' => __('Buat Surat Keluar'),
    'subtitle' => __('Buat Surat Keluar'),
    'breadcrumb' => [
        __('Buat Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-buat']" method="post" files>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    <br>
        <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surat" label="Pilih Jenis Surat" id='jenis_surat'>
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}">{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}">{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="reviewer" label="Pilih Reviewer">
                @foreach ($reviewer as $position)
                    <option value="{{ $position->id }}">{{ $position->first_name }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="approver" label="Pilih Approver">
                @foreach ($approver as $position)
                    <option value="{{ $position->id }}">{{ $position->first_name }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::datetimepicker name="tgl_surat" label='Tanggal Surat'/>
            <x-boilerplate::input name="perihal" label="Perihal" />
            {{-- <div style='display:none;' id='form-surat1'>Form Surat<br/>&nbsp;
                @include('boilerplate::surat-keluar.form1')
            </div> --}}
                   

        </x-boilerplate::card>
        
        {{-- <div style='display:none;' id='card-form'><br/>
            <x-boilerplate::card> --}}
                @foreach ($jenis_surat as $position)
                <div style='display:none;' id={{ $position->id }}>
                    <x-boilerplate::card>
                        <h3><b>FORM {{ $position->jenis_surat }}</b></h3> 
                        @include('boilerplate::surat-keluar.form.form'. $position->id )
                    </x-boilerplate::card>
                </div>
                @endforeach
                
            <div class="row" style='display:none;' id='button1'>
                &nbsp; &nbsp;
                {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
                &nbsp;
                {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
            </div>
        </div>
        
    </x-boilerplate::form>
@endsection