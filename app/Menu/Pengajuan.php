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
        $item->add('Pengajuan Saya', [
            'route' => 'boilerplate.pengajuan',
            'active' => 'boilerplate.pengajuan',
            'permission' => 'pengajuan',
            'order' => 100,
        ]);
        $item->add('Approvement', [
            'route' => 'boilerplate.approve-pengajuan',
            'active' => 'boilerplate.approve-pengajuan',
            'permission' => 'approve_pengajuan',
            'order' => 101,
        ]);
        $item->add('Review Pengajuan', [
            'route' => 'boilerplate.review-pengajuan',
            'active' => 'boilerplate.review-pengajuan',
            'permission' => 'review_pengajuan',
            'icon' => 'clipboard-check',
            'order' => 102,
        ]);
    }
}
