<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="@lang('boilerplate::layout.direction')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ 'BDPay E-Office' }}</title>
    <link rel="shortcut icon" href="{{ config('boilerplate.theme.favicon') ?? mix('favicon.png', '/assets/vendor/boilerplate') }}">
@stack('plugin-css')
    <link rel="stylesheet" href="{{ mix('/plugins/fontawesome/fontawesome.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="stylesheet" href="{{ mix('/adminlte.min.css', '/assets/vendor/boilerplate') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">
@stack('css')
    <script src="{{ mix('/bootstrap.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/admin-lte.min.js', '/assets/vendor/boilerplate') }}"></script>
    <script src="{{ mix('/boilerplate.min.js', '/assets/vendor/boilerplate') }}"></script>

    {{-- logic view form --}}
    <script>
        $(document).ready(function(){
             if ( "{{ $surat->jenis_surat_id }}" == '1')
                //.....................^.......
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT KEPUTUSAN</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    
                    // $("#def-form").hide();
                    // $("#1").show();
                    
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '2')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT PERNYATAAN</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").show();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '3')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT PEMBERITAHUAN</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").show();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '4')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT KETERANGAN</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").show();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '5')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT PERMOHONAN</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").show();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '6')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT KUASA</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").show();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '7')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT PENGANTAR</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").show();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '8')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT UNDANGAN</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").show();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '9')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT BALASAN</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").show();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '10')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT PEMINJAMAN</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").show();
                    // $("#11").hide();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '11')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM SURAT PERINTAH</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").show();
                    // $("#12").hide();
                }
                else if("{{ $surat->jenis_surat_id }}" == '12')
                {
                    // $("#card-form").show();
                    $("#button1").show();
                    document.getElementById("forma").innerHTML = 
                    "<h3><b id='head-form'>FORM PERJANJIAN KERJA SAMA</b></h3><div class='form-group'><label for='item1'>Nama pihak pertama</label><input class='form-control' id='item1' autocomplete='off' name='item1' type='text' disabled></div>       <div class='form-group'>    <label for='item2'>Jabatan pihak pertama</label>    <input class='form-control' id='item2' autocomplete='off' name='item2' type='text' disabled></div><div class='form-group'> <label for='item3'>NIK pihak pertama</label><input class='form-control' id='item3' autocomplete='off' name='item3' type='text' disabled></div><div class='form-group'><label for='item4'>Alamat pihak pertama</label><input class='form-control' id='item4' autocomplete='off' name='item4' type='text' disabled></div><div class='form-group'><label for='item5'>No. HP pihak pertama</label> <input class='form-control' id='item5' autocomplete='off' name='item5' type='text' disabled></div><div class='form-group'> <label for='item6'>Bertindak untuk Atas Nama</label> <input class='form-control' id='item6' autocomplete='off' name='item6' type='text' disabled></div><div class='form-group'><label for='item7'>Badan hukum</label><input class='form-control' id='item7' autocomplete='off' name='item7' type='text' disabled></div><div class='form-group'><label for='item8'>Alamat untuk Atas Nama</label> <input class='form-control' id='item8' autocomplete='off' name='item8' type='text' disabled></div><div class='form-group'><label for='item9'>Nama pihak kedua</label><input class='form-control' id='item9' autocomplete='off' name='item9' type='text' disabled></div>  <div class='form-group'> <label for='item10'>Jabatan pihak kedua</label>    <input class='form-control' id='item10' autocomplete='off' name='item10' type='text' disabled></div>       <div class='form-group'>    <label for='item11'>NIK pihak kedua</label>    <input class='form-control' id='item11' autocomplete='off' name='item11' type='text' disabled></div>       <div class='form-group'>    <label for='item12'>Alamat pihak kedua</label>    <input class='form-control' id='item12' autocomplete='off' name='item12' type='text' disabled></div>                  <div class='form-group'>    <label for='item13'>No. HP pihak kedua</label>    <input class='form-control' id='item13' autocomplete='off' name='item13' type='text' disabled></div>                            <div class='form-group'>    <label for='item14'>Tujuan</label>    <input class='form-control' id='item14' autocomplete='off' name='item14' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item15' style='visibility: hidden' autocomplete='off' name='item15' type='text' disabled></div> <div class='form-group'>    <input class='form-control' id='item16' style='display:none;' autocomplete='off' name='item16' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item17' style='display:none;' autocomplete='off' name='item17' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item18' style='display:none;' autocomplete='off' name='item18' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item19' style='display:none;' autocomplete='off' name='item19' type='text' disabled></div>                            <div class='form-group'>    <input class='form-control' id='item20' style='display:none;' autocomplete='off' name='item20' type='text' disabled></div>";
                    // $("#def-form").hide();
                    // $("#1").hide();
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").show();
                }
                    
                    // $("#def-form").hide();
                    // $("#1").show();
                    
                    // $("#2").hide();
                    // $("#3").hide();
                    // $("#4").hide();
                    // $("#5").hide();
                    // $("#6").hide();
                    // $("#7").hide();
                    // $("#8").hide();
                    // $("#9").hide();
                    // $("#10").hide();
                    // $("#11").hide();
                    // $("#12").hide();
                
                document.getElementById("head-form").innerHTML = "{{ $surat->jenis_surat }}";
                document.getElementById("item1").value = "{{ $surat->item1 }}";
                document.getElementById("item2").value = "{{ $surat->item2 }}";
                document.getElementById("item3").value = "{{ $surat->item3 }}";
                document.getElementById("item4").value = "{{ $surat->item4 }}";
                document.getElementById("item5").value = "{{ $surat->item5 }}";
                document.getElementById("item6").value = "{{ $surat->item6 }}";
                document.getElementById("item7").value = "{{ $surat->item7 }}";
                document.getElementById("item8").value = "{{ $surat->item8 }}";
                document.getElementById("item9").value = "{{ $surat->item9 }}";
                document.getElementById("item10").value = "{{ $surat->item10 }}";
                document.getElementById("item11").value = "{{ $surat->item11 }}";
                document.getElementById("item12").value = "{{ $surat->item12 }}";
                document.getElementById("item13").value = "{{ $surat->item13 }}";
                document.getElementById("item14").value = "{{ $surat->item14 }}";
                document.getElementById("item15").value = "{{ $surat->item15 }}";
                document.getElementById("item16").value = "{{ $surat->item16 }}";
                document.getElementById("item17").value = "{{ $surat->item17 }}";
                document.getElementById("item18").value = "{{ $surat->item18 }}";
                document.getElementById("item19").value = "{{ $surat->item19 }}";
                document.getElementById("item20").value = "{{ $surat->item20 }}";
                
            
        });
    </script>
@stack('plugin-js')
</head>
<body class="layout-fixed layout-navbar-fixed sidebar-mini{{ setting('darkmode', false) && config('boilerplate.theme.darkmode') ? ' dark-mode accent-light' : '' }}{{ setting('sidebar-collapsed', false) ? ' sidebar-collapse' : '' }}">
    <div class="wrapper">
        @include('boilerplate::layout.header')
        @include('boilerplate::layout.mainsidebar')
        <div class="content-wrapper">
            @include('boilerplate::layout.contentheader')
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @includeWhen(config('boilerplate.theme.footer.visible', true), 'boilerplate::layout.footer')
        <aside class="control-sidebar control-sidebar-{{ config('boilerplate.theme.sidebar.type') }} elevation-{{ config('boilerplate.theme.sidebar.shadow') }}">
            <button class="btn btn-sm" data-widget="control-sidebar"><span class="fa fa-times"></span></button>
            <div class="control-sidebar-content">
                <div class="p-3">
                    @yield('right-sidebar')
                </div>
            </div>
        </aside>
        <div class="control-sidebar-bg"></div>
    </div>
    @component('boilerplate::minify')
    <script>
        $.ajaxSetup({headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}});
        bootbox.setLocale('{{ App::getLocale() }}');
        var bpRoutes={
            settings:"{{ route('boilerplate.settings',null,false) }}"
        };
        var session={
            keepalive:"{{ route('boilerplate.keepalive', null, false) }}",
            expire:{{ time() +  config('session.lifetime') * 60 }},
            lifetime:{{ config('session.lifetime') * 60 }},
            id:"{{ session()->getId() }}"
        };
        @if(Session::has('growl'))
        @if(is_array(Session::get('growl')))
            growl("{!! Session::get('growl')[0] !!}", "{{ Session::get('growl')[1] }}");
        @else
            growl("{{Session::get('growl')}}");
        @endif
        @endif
    </script>
    @endcomponent
@stack('js')
<script src="{{ mix('/loading.js', '/assets/vendor/boilerplate') }}"></script>
<div id="waitttAmazingLover" style="display: none;
position: fixed;        
top: 0;
left: 0;
right: 0;
bottom: 0;
width: 100%;
background: rgba(0,0,0,0.75) url({{ mix('/images/Pulse-1s-200px.gif', '/assets/vendor/boilerplate') }}) no-repeat center center;
z-index: 10000;">
</div>
</body>
</html>
