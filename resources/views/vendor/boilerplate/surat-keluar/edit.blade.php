@extends('boilerplate::layout.indexedit', [
    'title' => __('Edit Surat Keluar'),
    'subtitle' => __('Edit Surat Keluar'),
    'breadcrumb' => [
        __('Edit Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-edit', $surat->id]" method="put" files>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Preview Surat', array('class' => 'btn btn-warning', 'name' => 'submitbutton')) }}
            &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
        </div>
    <br>
        <x-boilerplate::card>
            <x-boilerplate::select2 name="jenis_surat" label="Pilih Jenis Surat" id='jenis_surat'>
                @foreach ($jenis_surat as $position)
                    <option value="{{ $position->id }}" @if ( $surat->jenis_surat_id==$position->id)
                        selected
                    @endif>{{ $position->jenis_surat }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="departemen" label="Pilih Departemen">
                @foreach ($departemens as $position)
                    <option value="{{ $position->id }}" @if ( $surat->departemen_id==$position->id)
                        selected
                    @endif>{{ $position->departemen }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="reviewer" label="Pilih Reviewer">
                @foreach ($reviewer as $position)
                    <option value="{{ $position->id }}" @if ( $surat->reviewer_id==$position->id)
                        selected
                    @endif>{{ $position->first_name }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::select2 name="approver" label="Pilih Approver">
                @foreach ($approver as $position)
                    <option value="{{ $position->id }}" @if ( $surat->approver_id==$position->id)
                        selected
                    @endif>{{ $position->first_name }}</option>
                @endforeach
            </x-boilerplate::select2>
            <x-boilerplate::datetimepicker value="{{ $surat->tgl_surat }}" name="tgl_surat" label='Tanggal Surat'/>
            <x-boilerplate::input name="perihal" label="Perihal" value="{{ $surat->perihal }}" />
            {{-- <div style='display:none;' id='form-surat1'>Form Surat<br/>&nbsp;
                @include('boilerplate::surat-keluar.form1')
            </div> --}}
                   

        </x-boilerplate::card>
        
        {{-- <div style='display:none;' id='card-form'><br/>
            <x-boilerplate::card> --}}
                {{-- @foreach ($jenis_surat as $position)
                <div style='display:none;' id={{ $position->id }}>
                    <x-boilerplate::card>
                        <h3><b>FORM {{ $position->jenis_surat }}</b></h3> 
                        @include('boilerplate::surat-keluar.form.form'. $position->id )
                    </x-boilerplate::card>
                </div>
                @endforeach --}}
                <div id='def-form'>
                    <x-boilerplate::card id="formcard">
                        <div id="forma">
                            <h3><b id="head-form">FORM {{ $surat->jenis_surat }}</b></h3> 
                            <x-boilerplate::input id='item1' name='item1' label="Nama pihak pertama"  value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item1 : '' }}" />
                            <x-boilerplate::input id="item2" name="item2" label="Jabatan pihak pertama" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item2 : '' }}" />
                            <x-boilerplate::input id="item3" name="item3" label="NIK pihak pertama" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item3 : '' }}" />
                            <x-boilerplate::input id="item4" name="item4" label="Alamat pihak pertama" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item4 : '' }}" />
                            <x-boilerplate::input id="item5" name="item5" label="No. HP pihak pertama" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item5 : '' }}"/>
                            <x-boilerplate::input id="item6" name="item6" label="Bertindak untuk Atas Nama" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item6 : '' }}"/>
                            <x-boilerplate::input id="item7" name="item7" label="Badan hukum" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item7 : '' }}"/>
                            <x-boilerplate::input id="item8" name="item8" label="Alamat untuk Atas Nama" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item8 : '' }}"/>
                            <x-boilerplate::input id="item9" name="item9" label="Nama pihak kedua" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item9 : '' }}"/>
                            <x-boilerplate::input id="item10" name="item10" label="Jabatan pihak kedua" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item10 : '' }}"/>
                            <x-boilerplate::input id="item11" name="item11" label="NIK pihak kedua" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item11 : '' }}"/>
                            <x-boilerplate::input id="item12" name="item12" label="Alamat pihak kedua" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item12 : '' }}"/>
                            <x-boilerplate::input id="item13" name="item13" label="No. HP pihak kedua" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item13 : '' }}"/>
                            <x-boilerplate::input id="item14" name="item14" label="Tujuan" value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item14 : '' }}"/>
                            <x-boilerplate::input id="item15" name="item15" style='visibility: hidden' value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item14 : '' }}"/>
                            <x-boilerplate::input id="item16" name="item16" style='display:none;' value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item14 : '' }}"/>
                            <x-boilerplate::input id="item17" name="item17" style='display:none;' value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item14 : '' }}"/>
                            <x-boilerplate::input id="item18" name="item18" style='display:none;' value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item14 : '' }}"/>
                            <x-boilerplate::input id="item19" name="item19" style='display:none;' value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item14 : '' }}"/>
                            <x-boilerplate::input id="item20" name="item20" style='display:none;' value="{{ (request()->is('surat-keluar-saya/*')) ? $surat->item14 : '' }}"/>
                        </div>
                    </x-boilerplate::card>
                </div>
            <div class="row" id='button1'>
                &nbsp; &nbsp;
                {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
                &nbsp;
                {{ Form::submit('Preview Surat', array('class' => 'btn btn-warning', 'name' => 'submitbutton')) }}
                &nbsp;
                {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
            </div>
        </div>
        
    </x-boilerplate::form>
@endsection