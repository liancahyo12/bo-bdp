@extends('boilerplate::layout.indexreapp', [
    'title' => __('Surat Keluar'),
    'subtitle' => __('Detail Surat Keluar'),
    'breadcrumb' => [
        __('Detail Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-review.review', $surat->ida]" method="put" files>
    <div class="row">
        <div class="col">
            <x-boilerplate::card>
                <x-boilerplate::input name="jenis_surat" label="Jenis Surat" value="{{ $surat->jenis_surat }}" disabled/>
                <x-boilerplate::input name="departemen" label="Departemen" value="{{ $surat->departemen }}" disabled/>
                <x-boilerplate::input name="perihal" label="Perihal" value="{{ $surat->perihal }}" disabled/>
                <x-boilerplate::datetimepicker value="{{ $surat->tgl_surat }}" name="tgl_surat" label='Tanggal Surat' disabled/>
            </x-boilerplate::card>
        </div>
        <div class="col">
            <x-boilerplate::card>
                <x-boilerplate::input name="komentar" label="Komentar" />
            </x-boilerplate::card>
            <div class="row">
                &nbsp; &nbsp;
                {{ Form::submit('Preview Surat', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
                &nbsp;
                {{ Form::submit('Revisi', array('class' => 'btn btn-warning', 'name' => 'submitbutton')) }}
                &nbsp;
                {{ Form::submit('Setujui', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
            </div>
            <br>
        </div>
    </div>
    <div id='def-form'>
        <x-boilerplate::card id="formcard">
            <div id="forma">
                
            </div>
        </x-boilerplate::card>
    </div>
    <div class="row">
        &nbsp; &nbsp;
        {{ Form::submit('Preview Surat', array('class' => 'btn btn-secondary', 'name' => 'submitbutton')) }}
        &nbsp;
        {{ Form::submit('Revisi', array('class' => 'btn btn-warning', 'name' => 'submitbutton')) }}
        &nbsp;
        {{ Form::submit('Setujui', array('class' => 'btn btn-primary', 'name' => 'submitbutton')) }}
    </div>
    </x-boilerplate::form>
@endsection