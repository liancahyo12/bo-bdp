$(document).ready(function(){
    $('#jenis_pengajuan').on('change', function() {
        var no =1;
        if ( this.value <= 3){
            document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'><tr id='row'><td><label for='transaksi'>Keterangan*</label><input class='form-control' type='text' name='transaksi[]' id='transaksi'></td><td><label for='nominal'>Nominal*</label><input class='form-control angka' type='number' name='nominal[]' id='nominal'></td><td><br><button type='button' id='tambah' class='btn btn-success tambah1'>Tambah</button></td></tr></table>        <table class='table'><tr><td style='width:41%'><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total' id='total' readonly></td><td style='width:18%'> </td></tr></table>        <label for='catatan'>Catatan*</label><input class='form-control' type='text' name='catatan' id='catatan' required><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening*</label><input class='form-control' name='namarek' type='text' id='namarek'><label for='norek'>No Rekening*</label><input class='form-control' name='norek' type='number' id='norek'><label for='bank'>Bank*</label><input class='form-control' name='bank' type='text' id='Bank'></div>"
            $(document).on('click', '.tambah1', function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control angka' type='number' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah1'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
                hitungTotal();
            });

            $(document).on('input', '.angka', hitungTotal);

        }else if ( this.value == 4){
            document.getElementById("form-pengajuan").innerHTML = "<div><label for='noinvoice'>No Invoice*</label><input class='form-control' type='text' name='noinvoice' id='noinvoice'>    <table class='table' id='dynamic'><tr id='row'><td><label for='transaksi'>Keterangan*</label><input class='form-control' type='text' name='transaksi[]' id='transaksi'></td><td><label for='nominal'>Nominal*</label><input class='form-control angka' type='number' name='nominal[]' id='nominal'></td><td><br><button type='button' id='tambah' class='btn btn-success tambah2'>Tambah</button></td></tr></table>          <table class='table'><tr><td style='width:41%'><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total' id='total' readonly></td><td style='width:18%'> </td></tr></table>       <label for='catatan'>Catatan*</label><input class='form-control' type='text' name='catatan' id='catatan' required><br><h3>Tujuan</h3><label for='namarek'>Nama Rekening*</label><input class='form-control' name='namarek' type='text' id='namarek'><label for='norek'>No Rekening*</label><input class='form-control' name='norek' type='number' id='norek'><label for='bank'>Bank*</label><input class='form-control' name='bank' type='text' id='Bank'></div>"
            $(document).on('click', '.tambah2', function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control angka' type='number' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah2'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
                hitungTotal();
            });

            $(document).on('input', '.angka', hitungTotal);
        }else if ( this.value == 5){
            document.getElementById("form-pengajuan").innerHTML = "<div>    <table class='table' id='dynamic'><tr id='row'><td><label for='coa'>COA*</label><input class='form-control' type='text' name='coa[]' id='coa'></td><td><label for='transaksi'>Keterangan*</label><input class='form-control' type='text' name='transaksi[]' id='transaksi'></td><td><label for='nominal'>Nominal*</label><input class='form-control angka' type='number' name='nominal[]' id='nominal'></td><td><label for='saldo'>Saldo*</label><input class='form-control angka' type='text' name='saldo[]' id='saldo'></td><td><br><button type='button' id='tambah' class='btn btn-success tambah3'>Tambah</button></td></tr></table>      <label for='catatan'>Catatan</label><br><input class='form-control' type='text' name='catatan' id='catatan' required><h3>Tujuan</h3><label for='namarek'>Nama Rekening*</label><input class='form-control' name='namarek' type='text' id='namarek'><label for='norek'>No Rekening*</label>            <input class='form-control' name='norek' type='number' id='norek'><label for='bank'>Bank*</label>           <input class='form-control' name='bank' type='text' id='Bank'></div>"
            $(document).on('click', '.tambah3', function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='coa[]' id='coa"+no+"'></td><td><input class='form-control' type='text' name='transaksi[]' id='transaksi"+no+"'></td><td><input class='form-control angka' type='number' name='nominal[]' id='nominal"+no+"'></td><td><input class='form-control angka' type='text' name='saldo[]' id='saldo"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah3'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
                hitungTotal();
            });

            $(document).on('input', '.angka', hitungTotal);
        }
        else if(this.value == 6){
            document.getElementById("form-pengajuan").innerHTML = "<div><label for='jumpc'>Jumlah Petty Cash(dalam rupiah)*</label><input class='form-control angka' name='jumpc' type='number' id='jumpc'></input></div>       <br><h3>Kebutuhan</h3><table class='table' id='dynamic'><tr id='row'><td><label for='jenistr"+no+"'>Jenis Transaksi*</label><input class='form-control' type='text' name='jenistr[]' id='jenistr'></td><td><br><button type='button' id='tambah' class='btn btn-success tambah4'>Tambah</button></td></tr></table> <label for='catatan'>Catatan*</label><input class='form-control' type='text' name='catatan' id='catatan' required><h3>Tujuan</h3><label for='namarek'>Nama Rekening*</label><input class='form-control' name='namarek' type='text' id='namarek'><label for='norek'>No Rekening*</label>            <input class='form-control' name='norek' type='number' id='norek'><label for='bank'>Bank*</label>           <input class='form-control' name='bank' type='text' id='Bank'>"
            $(document).on('click', '.tambah4', function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='jenistr[]' id='jenistr"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah4'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
            });

        }else{
            document.getElementById("form-pengajuan").innerHTML = "<label for='perusahaan'>Perusahaan*</label><input class='form-control' name='perusahaan' type='text' id='perusahaan'><label for='alamat'>Alamat*</label><input class='form-control' name='alamat' type='text' id='alamat'><label for='notelepon'>No Telepon*</label><input class='form-control' name='notelepon' type='number' id='notelepon'><label for='kontak'>Nama Kontak*</label><input class='form-control' name='kontak' type='text' id='kontak'><label for='email'>Email*</label><input class='form-control' name='email' type='text' id='email'>        <table class='table' id='dynamic'><tr id='row'><td><label for='pembelian'>Pembelian*</label><input class='form-control' type='text' name='pembelian[]' id='pembelian'></td><td><label for='nominal'>Nominal*</label><input class='form-control angka' type='number' name='nominal[]' id='nominal'></td><td><br><button type='button' id='tambah' class='btn btn-success tambah5'>Tambah</button></td></tr></table>           <table class='table'><tr><td style='width:41%'><label for='total'>Total</label> </td><td> <input class='form-control' type='text' name='total' id='total' readonly></td><td style='width:18%'> </td></tr></table>      <table class='table'> <tr><td><label for='dpp'>DPP*</label></td><td><input class='form-control angka' type='number' name='dpp' id='dpp'></td></tr><tr><td><label for='ppn'>PPN 10%*</label></td><td><input class='form-control angka' type='number' name='ppn' id='ppn'> </td></tr></table>        <label for='catatan'>Catatan*</label><input class='form-control' type='text' name='catatan' id='catatan' required><br>"
            $(document).on('click', '.tambah5', function(){
                no++;
                $('#dynamic').append("<tr id='row"+no+"'><td><input class='form-control' type='text' name='pembelian[]' id='pembelian"+no+"'></td><td><input class='form-control angka' type='number' name='nominal[]' id='nominal"+no+"'></td><td><button type='button' id='tambah"+no+"' class='btn btn-success tambah5'>+</button><button type='button' id='"+no+"' class='btn btn-danger btn_remove'>x</button></td></tr>");
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id"); 
                $('#row'+button_id+'').remove();
                hitungTotal();
            });

            $(document).on('input', '.angka', hitungTotal);
        }

        // $(document).on('keyup', '.angka', function(){
        //     var angka_id = $(this).attr("id"); 
        //     $('#'+angka_id).val(formatRupiah(this.value));
        // });

        // function formatRupiah(angka, prefix)
        // {
        //     var number_string = angka.replace(/[^,\d]/g, '').toString(),
        //     split   		= number_string.split(','),
        //     sisa     		= split[0].length % 3,
        //     rupiah     		= split[0].substr(0, sisa),
        //     ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
        
        //     // tambahkan titik jika yang di input sudah menjadi angka ribuan
        //     if(ribuan){
        //         separator = sisa ? '.' : '';
        //         rupiah += separator + ribuan.join('.');
        //     }
        
        //     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        //     return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        // }
        function hitungTotal() {
            var nom = document.getElementsByName('nominal[]');
            var tot=0;
            for(var i=0;i<nom.length;i++){
                if(parseFloat(nom[i].value))
                    tot += parseFloat(nom[i].value);
            }
            document.getElementById("total").value = tot;
        }
    });
    
});