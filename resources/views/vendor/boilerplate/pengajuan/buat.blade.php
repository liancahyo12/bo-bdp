@extends('boilerplate::layout.index', [
    'title' => __('Buat Pengajuan'),
    'subtitle' => __('Buat Pengajuan'),
    'breadcrumb' => [
        __('Buat Pengajuan') 
    ]
])

@section('content')

    <x-boilerplate::form :route="['boilerplate.buat-pengajuan']" method="post" files>
    @csrf
        <x-boilerplate::card>
            <x-boilerplate::datetimepicker name="tgl_pengajuan" label='Tanggal Pengajuan*' required/>
            <x-boilerplate::select2 name="jenis_pengajuan" label="Pilih Jenis Pengajuan*" id='jenis_pengajuan' required>
                @foreach ($jenis_pengajuan as $position)
                    <option value="{{ $position->id }}">{{ $position->jenis_pengajuan }}</option>
                @endforeach
            </x-boilerplate::select2>
            <div id="postpaid" style='display:none;'>
                <x-boilerplate::input name="noinvoice" id="noinvoice" type="text" label="Nomor Invoice*" />
                <x-boilerplate::datetimepicker name="jatuhtempo" id="jatuhtempo" format="DD/MM/YYYY HH:mm" label='Tanggal Jatuh Tempo*'/>
                <p>Note: Jika tidak ada jatuh tempo pada invoice maka masukan tanggal jatuh tempo 30 hari setelah tanggal invoice</p>
            </div>            
            <div id="form-pengajuan">
            </div>
            <x-boilerplate::input name="file_lampiran" type="file" label="Unggah Lampiran (PDF Maks 20MB)" />
        </x-boilerplate::card>
        <div class="row">
            &nbsp; &nbsp;
            {{ Form::submit('Simpan Draft', array('class' => 'btn btn-secondary', 'name' => 'submitbutton', 'id' => 'submitbutton',)) }}
            &nbsp;
            {{ Form::submit('Kirim', array('class' => 'btn btn-primary', 'name' => 'submitbutton', 'id' => 'submitbutton')) }}
        </div>
    </x-boilerplate::form>
    <script src="{{ mix('/form-pengajuan.js', '/assets/vendor/boilerplate') }}"></script>
    <script> $(document).keypress(
        function(event){
            if (event.which == '13') {
            event.preventDefault();
            }
        });
    </script>
@endsection