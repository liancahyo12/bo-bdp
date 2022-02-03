<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class SuratKeluar
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Surat Keluar', [
            'icon' => 'envelope',
            'permission' => 'request_surat_keluar,review_surat,buat_surat_keluar,approve_surat,arsip_surat',
            'order' => 1004,
        ]);
        // $item->add('Buat Permintaan Surat', [
        //     'route' => 'boilerplate.surat-keluar-request-buat',
        //     'active' => 'boilerplate.surat-keluar-request-buat',
        //     'permission' => 'request_surat_keluar',
        //     'order' => 98,
        // ]);
        // $item->add('Permintaan Surat Saya', [
        //     'route' => 'boilerplate.surat-keluar-request-saya.index',
        //     'active' => 'boilerplate.surat-keluar-request-saya.index,boilerplate.surat-keluar-request-saya.edit',
        //     'permission' => 'request_surat_keluar',
        //     'order' => 99,
        // ]);
        // $item->add('Permintaan Surat', [
        //     'route' => 'boilerplate.surat-keluar-request-review',
        //     'active' => 'boilerplate.surat-keluar-request-review,boilerplate.surat-keluar-request-review.edit',
        //     'permission' => 'review_surat',
        //     'order' => 99,
        // ]);
        $item->add('Buat Surat', [
            'route' => 'boilerplate.surat-keluar-buat',
            'active' => 'boilerplate.surat-keluar-buat',
            'permission' => 'buat_surat_keluar',
            'order' => 100,
        ]);
        $item->add('Surat Saya', [
            'route' => 'boilerplate.surat-keluar-saya.index',
            'active' => 'boilerplate.surat-keluar-saya.index,boilerplate.surat-keluar-saya.edit',
            'permission' => 'buat_surat_keluar',
            'order' => 101,
        ]);
        $item->add('Review Surat', [
            'route' => 'boilerplate.surat-keluar-review.index',
            'active' => 'boilerplate.surat-keluar-review.index,boilerplate.surat-keluar-review.edit',
            'permission' => 'review_surat',
            'order' => 102,
        ]);
        $item->add('Approve Surat', [
            'route' => 'boilerplate.surat-keluar-approve.index',
            'active' => 'boilerplate.surat-keluar-approve.index,boilerplate.surat-keluar-approve.edit',
            'permission' => 'approve_surat',
            'order' => 103,
        ]);
        $item->add('Arsip Surat', [
            'route' => 'boilerplate.surat-keluar-arsip',
            'active' => 'boilerplate.surat-keluar-arsip,boilerplate.surat-keluar-arsip-edit',
            'permission' => 'arsip_surat',
            'order' => 104,
        ]);
    }
}
