<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Pengajuan
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Pengajuan', [
            'icon' => 'hand-holding-usd',
            'permission' => 'buat_pengajuan,approve_pengajuan,reviewdep_pengajuan,review_pengajuan',
            'order' => 1006,
        ]);
        $item->add('Buat Pengajuan', [
            'route' => 'boilerplate.buat-pengajuan',
            'active' => 'boilerplate.buat-pengajuan',
            'permission' => 'buat_pengajuan',
            'order' => 100,
        ]);
        $item->add('Daftar Pengajuan - Saya', [
            'route' => 'boilerplate.saya-pengajuan',
            'active' => 'boilerplate.saya-pengajuan,boilerplate.edit-pengajuan',
            'permission' => 'buat_pengajuan',
            'order' => 101,
        ]);
        $item->add('Daftar Pengajuan - Persetujuan', [
            'route' => 'boilerplate.approve-pengajuan',
            'active' => 'boilerplate.approve-pengajuan,boilerplate.detail-approve-pengajuan',
            'permission' => 'approve_pengajuan',
            'order' => 102,
        ]);
        $item->add('Daftar Pengajuan - Review Departemen', [
            'route' => 'boilerplate.reviewdep-pengajuan',
            'active' => 'boilerplate.reviewdep-pengajuan,boilerplate.detail-reviewdep-pengajuan',
            'permission' => 'reviewdep_pengajuan',
            'order' => 103,
        ]);
        $item->add('Daftar Pengajuan - Review', [
            'route' => 'boilerplate.review-pengajuan',
            'active' => 'boilerplate.review-pengajuan,boilerplate.detail-review-pengajuan',
            'permission' => 'review_pengajuan',
            'order' => 104,
        ]);
        $item->add('Daftar Pengajuan - Bayar', [
            'route' => 'boilerplate.bayar-pengajuan',
            'active' => 'boilerplate.bayar-pengajuan,boilerplate.detail-bayar-pengajuan',
            'permission' => 'bayar_pengajuan',
            'order' => 105,
        ]);
        $item->add('Daftar Closing Pengajuan - Saya', [
            'route' => 'boilerplate.saya-closing-pengajuan',
            'active' => 'boilerplate.saya-closing-pengajuan,boilerplate.edit-closing-pengajuan',
            'permission' => 'buat_pengajuan',
            'order' => 106,
        ]);
        $item->add('Daftar Closing Pengajuan - Persetujuan', [
            'route' => 'boilerplate.approve-closing-pengajuan',
            'active' => 'boilerplate.approve-closing-pengajuan,boilerplate.detail-approve-closing-pengajuan',
            'permission' => 'approve_pengajuan',
            'order' => 107,
        ]);
        $item->add('Daftar Closing Pengajuan - Review Departemen', [
            'route' => 'boilerplate.reviewdep-closing-pengajuan',
            'active' => 'boilerplate.reviewdep-closing-pengajuan,boilerplate.detail-reviewdep-closing-pengajuan',
            'permission' => 'reviewdep_pengajuan',
            'order' => 108,
        ]);
        $item->add('Daftar Closing Pengajuan - Review', [
            'route' => 'boilerplate.review-closing-pengajuan',
            'active' => 'boilerplate.review-closing-pengajuan,boilerplate.detail-review-closing-pengajuan',
            'permission' => 'review_pengajuan',
            'order' => 109,
        ]);
        
    }
}
