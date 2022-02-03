<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class SuratMasuk
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Surat Masuk', [
            'permission' => 'surat_masuk',
            'icon' => 'inbox',
            'order' => 999,
        ]);
        $item->add('Tambah Surat Masuk', [
            'route' => 'boilerplate.surat-masuk-buat',
            'active' => 'boilerplate.surat-masuk-buat,',
            'permission' => 'buat_surat_masuk',
            'order' => 100,
        ]);
        $item->add('Surat Masuk', [
            'route' => 'boilerplate.surat-masuk',
            'active' => 'boilerplate.surat-masuk,boilerplate.surat-masuk-detail',
            'permission' => 'surat_masuk',
            'order' => 101,
        ]);
        $item->add('Arsip Surat Masuk', [
            'route' => 'boilerplate.surat-masuk-arsip',
            'active' => 'boilerplate.surat-masuk-arsip,boilerplate.surat-masuk-arsip-detail',
            'permission' => 'arsip_surat_masuk',
            'order' => 102,
        ]);
        $item->add('Surat Masuk Saya', [
            'route' => 'boilerplate.surat-masuk-saya',
            'active' => 'boilerplate.surat-masuk-saya,boilerplate.surat-masuk-saya-detail',
            'permission' => 'buat_surat_masuk',
            'order' => 103,
        ]);
    }
}
