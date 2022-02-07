@extends('boilerplate::layout.indexreapp', [
    'title' => __('Surat Keluar'),
    'subtitle' => __('Detail Surat Keluar'),
    'breadcrumb' => [
        __('Detail Surat Keluar') 
    ]
])

@section('content')
    <x-boilerplate::form :route="['boilerplate.surat-keluar-approve.approve', $surat->ida]" method="put" files>
        @csrf
        <x-boilerplate::card>
            <x-slot name="header">
                <b>Komentar</b>
            </x-slot>
            @foreach ( $approve as $approve)
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{ $approve->first_name }}&nbsp;</span>
                        <span class="badge badge-pill badge-secondary float-left">{{ $approve->kode }}</span>
                        @if ($approve->statuss == 2)
                            <span class="badge badge-pill badge-success float-right">disetujui</span>
                        @endif
                        @if ($approve->statuss == 3)
                            <span class="badge badge-pill badge-warning float-right">revisi</span>
                        @endif
                        @if ($approve->statuss == 4)
                            <span class="badge badge-pill badge-danger float-right">ditolak</span>
                        @endif
                        <span class="direct-chat-timestamp float-right">{{ $approve->waktu_komentar }}&nbsp;</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <img src="{{ App\Models\Boilerplate\User::where('id', $approve->uid)->first()->avatar_url }}" class="direct-chat-img" alt="{{ Auth::user()->name }}" width="30" height="30">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                        {{ $approve->komentar }}
                    </div>
                    <!-- /.direct-chat-text -->
                </div>
            @endforeach
            
            <div @if ($surat->approve_status==2 || $surat->approve_status==3 || $surat->approve_status==4)
                style='display:none;'
                @endif>
                <x-boilerplate::input name="komentar" autofocus/>
                
            </div>
            <div>
                <a target="_blank" href="/surat-keluar-approve-preview/{{ $surat->ida }}" ><button class="btn btn-secondary" form="a">Lihat Surat</button></a>
                &nbsp;
                <input class="btn btn-warning" name="submitbutton" type="submit" value="Revisi" @if ($surat->approve_status==2 || $surat->approve_status==3 || $surat->approve_status==4)
                style='display:none;'
                @endif>
                &nbsp;
                <input class="btn btn-danger" name="submitbutton" type="submit" value="Tolak" @if ($surat->approve_status==2 || $surat->approve_status==3 || $surat->approve_status==4)
                style='display:none;'
                @endif>
                &nbsp;
                <input class="btn btn-primary" name="submitbutton" type="submit" value="Setujui" @if ($surat->approve_status==2 || $surat->approve_status==3 || $surat->approve_status==4)
                style='display:none;'
                @endif>
            </div>
            
        </x-boilerplate::card>
        <x-boilerplate::card>
            <x-boilerplate::input name="jenis_surat" label="Jenis Surat" value="{{ $surat->jenis_surat }}" disabled/>
            <x-boilerplate::input name="departemen" label="Departemen" value="{{ $surat->departemen }}" disabled/>
            <x-boilerplate::input name="perihal" label="Perihal" value="{{ $surat->perihal }}" disabled/>
            <x-boilerplate::datetimepicker value="{{ $surat->tgl_surat }}" name="tgl_surat" label='Tanggal Surat' disabled/>
                <div class="form-group" @if ($surat->lampiran!=null) @else style='display:none;' @endif>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><span class="fas fa-file"></span></span>
                        </div>
                        <a target="_blank" href="/surat-keluar-approve-lampiran/{{ $surat->ida }}"><button class="btn btn-secondary" form="a">Lihat Lampiran</button></a>
                    </div>
                </div>
        </x-boilerplate::card>
    </x-boilerplate::form>
@endsection