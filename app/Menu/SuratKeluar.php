<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class SuratKeluar
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Surat Keluar', [
            'icon' => 'envelope',
            'order' => 1000,
        ]);
        $item->add('Buat Surat', [
            'route' => 'boilerplate.surat-keluar-buat',
            'active' => 'boilerplate.surat-keluar-buat',
            'permission' => 'backend_access',
            'order' => 100,
        ]);
        $item->add('Surat Saya', [
            'route' => 'boilerplate.surat-keluar-saya.index',
            'active' => 'boilerplate.surat-keluar-saya.index',
            'permission' => 'backend_access',
            'order' => 101,
        ]);
        $item->add('Review Surat', [
            'route' => 'boilerplate.surat-keluar-review',
            'active' => 'boilerplate.surat-keluar-review',
            'permission' => 'review_surat',
            'order' => 102,
        ]);
        $item->add('Approve Surat', [
            'route' => 'boilerplate.surat-keluar-approve',
            'active' => 'boilerplate.surat-keluar-approve',
            'permission' => 'approve_surat, ',
            'order' => 103,
        ]);
        $item->add('Arsip Surat', [
            'route' => 'boilerplate.surat-keluar-arsip',
            'active' => 'boilerplate.surat-keluar-arsip',
            'permission' => 'arsip_surat',
            'order' => 104,
        ]);
    }
}
