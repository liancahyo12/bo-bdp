<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class SuratMasuk
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Surat Masuk', [
            'route' => 'boilerplate.dashboard',
            'active' => 'boilerplate.dashboard',
            'permission' => 'surat_masuk',
            'icon' => 'inbox',
            'order' => 999,
        ]);
        $item->add('Tambah Surat Masuk', [
            'route' => 'boilerplate.dashboard',
            'active' => 'boilerplate.dashboard',
            'permission' => 'tambah_surat_masuk',
            'order' => 100,
        ]);
        $item->add('Surat Masuk', [
            'route' => 'boilerplate.dashboard',
            'active' => 'boilerplate.dashboard',
            'permission' => 'surat_masuk',
            'order' => 101,
        ]);
        $item->add('Arsip Surat Masuk', [
            'route' => 'boilerplate.dashboard',
            'active' => 'boilerplate.dashboard',
            'permission' => 'arsip_surat_masuk',
            'order' => 102,
        ]);
    }
}
