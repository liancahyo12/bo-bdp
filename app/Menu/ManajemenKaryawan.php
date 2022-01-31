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
            'order' => 100,
        ]);

        $item->add('Rekening Karyawan', [
            'permission' => 'tambah_rekening',
            'active' => 'boilerplate.rekening-karyawan,buat-rekening-karyawan,edit-rekening-karyawan',
            'route' => 'boilerplate.rekening-karyawan',
        ]);
    }
}
