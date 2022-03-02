<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Settings
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Settings', [
            'permission' => 'lihat_departemen,buat_departemen,edit_departemen,delete_departemen',
            'icon' => 'tools',
            'order' => 1199,
        ]);
        $item->add('Departemen', [
            'route' => 'boilerplate.departemen',
            'active' => 'boilerplate.departemen,boilerplate.buat-departemen,boilerplate.edit-departemen',
            'permission' => 'lihat_departemen,buat_departemen,edit_departemen,hapus_departemen',
            'order' => 100,
        ]);
    }
}
