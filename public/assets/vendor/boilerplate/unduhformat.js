$(document).ready(function(){
    $('#jenis_surat').on('change', function() {
        document.getElementById("unduh-format").innerHTML = "<div class='input-group-prepend'> <span class='input-group-text'><span class='fas fa-file'></span></span> </div> <a target='_blank' href='/surat-keluar-buat-format/"+this.value+"' ><button class='btn btn-secondary' form='a'>Unduh Format Surat</button></a>"
        document.getElementById("ket").innerHTML = "<p>Note : Format dapat diubah sesuai kebutuhan namun kata yang terdapat karakter ${} tidak perlu diubah</p>"
    });
    $('input[type=radio][name="lampiran_radio"]').change(function() {
        if ( this.value == '2')
        {
            $("#lampiran-input").show();
        }else{
            $("#lampiran-input").hide();
        }
        
    });
});