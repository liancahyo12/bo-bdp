<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Boilerplate\User;
use App\Models\karyawan;
use App\Models\kontrak_karyawan;

class KaryawanDatatable extends Datatable
{
    public $slug = 'karyawan';

    public function datasource()
    {
    }

    public function setUp()
    {
        $karyawan = karyawan::leftJoin('users', 'users.id', 'karyawans.user_id')->leftJoin('kontrak_karyawans', 'kontrak_karyawans.karyawan_id', 'karyawans.id')->where([['users.id', '>', 1], ['karyawans.status', '=', 1]])->get(['kode_karyawan', 'karyawans.nama', 'jenis_kontrak', 'tgl_awal', 'tgl_akhir']);

        return $karyawan;
    }

    public function columns(): array
    {
        return [            
            Column::add('No Karyawan')
                ->data('kode_karyawan'),

            Column::add('Nama')
                ->data('nama'),

            Column::add('Jenis Kontrak')
                ->data('jenis_kontrak'),
            
            Column::add('Tgl Awal Kontrak')
                ->data('tgl_awal'),

            Column::add('Tgl akhir Kontrak')
                ->data('tgl_akhir'),
                
            Column::add()
                ->actions(function(Suratkeluar $suratkeluar) {
                    if ($suratkeluar->send_status == 1 && ($suratkeluar->review_status == 3 ||  $suratkeluar->approve_status == 3)) {
                        return join([
                        Button::edit('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),          
                    ]);
                    }else if($suratkeluar->send_status == 1){
                        return join([
                        Button::show('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),           
                    ]);  
                    }
                    return join([
                        Button::edit('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),    
                        Button::delete('boilerplate.surat-keluar-saya.destroy', $suratkeluar->id),           
                    ]);
                    
                }),
        ];
    }
}