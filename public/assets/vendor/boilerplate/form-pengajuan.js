$(document).ready(function(){
    $('#jenis_pengajuan').on('change', function() {
        if ( this.value <= 3){
            document.getElementById("form-pengajuan").innerHTML = "<div><label for='pengajuan'>Pengajuan</label><input class='form-control' name='pengajuan' type='text' id='pengajuan'>    <table class='table' id='dynamic'><tr id='row'><td><label for='transaksi'>Transaksi</label><input class='form-control' type='text' name='transaksi[]' id='transaksi'></td><td><label for='nominal'>Nominal</label><input class='form-control' type='text' name='nominal[]' id='nominal'></td><td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td></tr></table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' id='catatan'><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening</label><input class='form-control' name='namarek' type='text' id='namarek'><label for='norek'>No Rekening</label>            <input class='form-control' name='norek' type='text' id='norek'><label for='bank'>Bank</label>           <input class='form-control' name='bank' type='text' id='Bank'></div>"
            var no =1;
            $('#tambah').click(function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='text' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        }else if ( this.value == 4){
            document.getElementById("form-pengajuan").innerHTML = "<div><label for='pengajuan'>Pengajuan</label><input class='form-control' name='pengajuan' type='text' id='pengajuan'><label for='noinvoice'>No Invoice</label><input class='form-control' type='text' name='noinvoice' id='noinvoice'>    <table class='table' id='dynamic'><tr id='row'><td><label for='transaksi'>Transaksi</label><input class='form-control' type='text' name='transaksi[]' id='transaksi'></td><td><label for='nominal'>Nominal</label><input class='form-control' type='text' name='nominal[]' id='nominal'></td><td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td></tr></table>       <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' id='catatan'><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' type='text' id='namarek'><label for='norek'>No Rekening Tujuan</label><input class='form-control' name='norek' type='text' id='norek'><label for='bank'>Bank Tujuan</label><input class='form-control' name='bank' type='text' id='Bank'></div>"
            var no =1;
            $('#tambah').click(function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='text' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        }else if ( this.value == 5){
            document.getElementById("form-pengajuan").innerHTML = "<div><label for='pengajuan'>Pengajuan</label><input class='form-control' name='pengajuan' type='text' id='pengajuan'>    <table class='table' id='dynamic'><tr id='row'><td><label for='coa'>COA</label><input class='form-control' type='text' name='coa[]' id='coa'></td><td><label for='transaksi'>Transaksi</label><input class='form-control' type='text' name='transaksi[]' id='transaksi'></td><td><label for='nominal'>Nominal</label><input class='form-control' type='text' name='nominal[]' id='nominal'></td><td><label for='saldo'>Saldo</label><input class='form-control' type='text' name='saldo[]' id='saldo'></td><td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td></tr></table>      <label for='catatan'>Catatan</label><br><input class='form-control' type='text' name='catatan' id='catatan'><h3>Tujuan</h3><label for='namarek'>Nama Rekening Tujuan</label><input class='form-control' name='namarek' type='text' id='namarek'><label for='norek'>No Rekening Tujuan</label>            <input class='form-control' name='norek' type='text' id='norek'><label for='bank'>Bank Tujuan</label>           <input class='form-control' name='bank' type='text' id='Bank'></div>"
            var no =1;
            $('#tambah').click(function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='coa[]' id='coa"+no+"'></td><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control' type='text' name='nominal[]' id='nominal"+no+"'></td><td><input class='form-control' type='text' name='saldo[]' id='saldo"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        }
        else if(this.value == 6){
            document.getElementById("form-pengajuan").innerHTML = "<div><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)</label><input class='form-control' name='jumpc' type='text' id='jumpc'></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'><tr id='row'><td><label for='jenistr"+no+"'>Jenis Transaksi</label><input class='form-control' type='text' name='jenistr[]' id='jenistr'></td><td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td></tr></table> <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' id='catatan'>"
            var no =1;
            $('#tambah').click(function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='jenistr[]' id='jenistr"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        }else{
            document.getElementById("form-pengajuan").innerHTML = "<label for='perusahaan'>Perusahaan</label><input class='form-control' name='perusahaan' type='text' id='perusahaan'><label for='alamat'>Alamat</label><input class='form-control' name='alamat' type='text' id='alamat'><label for='notelepon'>No Telepon</label><input class='form-control' name='notelepon' type='text' id='notelepon'><label for='kontak'>Kontak</label><input class='form-control' name='kontak' type='text' id='kontak'><label for='email'>Email</label><input class='form-control' name='email' type='text' id='email'>        <table class='table' id='dynamic'><tr id='row'><td><label for='pembelian'>Pembelian</label><input class='form-control' type='text' name='pembelian[]' id='pembelian'></td><td><label for='nominal'>Nominal</label><input class='form-control' type='text' name='nominal[]' id='nominal'></td><td><br><button type='button' id='tambah' class='btn btn-success'>Tambah</button></td></tr></table>        <label for='catatan'>Catatan</label><input class='form-control' type='text' name='catatan' id='catatan'><br>"
            var no =1;
            $('#tambah').click(function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='pembelian[]' id='pembelian"+no+"'></td><td><input class='form-control' type='text' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>Hapus</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });
        }
    });
    
});