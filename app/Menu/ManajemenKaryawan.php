<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class ManajemenKaryawan
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Manajemen Karyawan', [
            'permission' => 'tambah_rekening',
            'icon' => 'users-cog',
            'order' => 1002,
        ]);

        $item->add('Daftar Karyawan', [
            'permission' => 'edit_karyawan,detail_karyawan,nonaktif_karyawan,hapus_karyawan',
            'active' => 'boilerplate.karyawan,boilerplate.edit-karyawan,boilerplate.detail-karyawan',
            'route' => 'boilerplate.karyawan',
        ]);
    }
}
