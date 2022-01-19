<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Pengajuan
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Pengajuan', [
            'icon' => 'tasks',
            'order' => 1001,
        ]);
        $item->add('Buat Pengajuan', [
            'route' => 'boilerplate.buat-pengajuan',
            'active' => 'boilerplate.buat-pengajuan',
            'permission' => 'pengajuan',
            'order' => 100,
        ]);
        $item->add('Pengajuan Saya', [
            'route' => 'boilerplate.saya-pengajuan',
            'active' => 'boilerplate.saya-pengajuan,boilerplate.edit-pengajuan',
            'permission' => 'pengajuan',
            'order' => 101,
        ]);
        $item->add('Approvement', [
            'route' => 'boilerplate.approve-pengajuan',
            'active' => 'boilerplate.approve-pengajuan,boilerplate.detail-approve-pengajuan',
            'permission' => 'approve_pengajuan',
            'order' => 102,
        ]);
        $item->add('Review Pengajuan', [
            'route' => 'boilerplate.reviewdep-pengajuan',
            'active' => 'boilerplate.reviewdep-pengajuan,boilerplate.detail-reviewdep-pengajuan',
            'permission' => 'reviewdep_pengajuan',
            'order' => 103,
        ]);
        $item->add('Review Pengajuan', [
            'route' => 'boilerplate.review-pengajuan',
            'active' => 'boilerplate.review-pengajuan,boilerplate.detail-review-pengajuan',
            'permission' => 'review_pengajuan',
            'order' => 103,
        ]);
    }
}
