<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Pengajuan
{
    public function make(Builder $menu)
    {
        $menu->add('Pengajuan Saya', [
            'route' => 'boilerplate.pengajuan',
            'active' => 'boilerplate.pengajuan',
            'permission' => 'pengajuan',
            'icon' => 'edit',
            'order' => 1001,
        ]);
        $menu->add('Approvement', [
            'route' => 'boilerplate.approve-pengajuan',
            'active' => 'boilerplate.approve-pengajuan',
            'permission' => 'approve_pengajuan',
            'icon' => 'check-double',
            'order' => 1003,
        ]);
        $menu->add('Review Pengajuan', [
            'route' => 'boilerplate.review-pengajuan',
            'active' => 'boilerplate.review-pengajuan',
            'permission' => 'review_pengajuan',
            'icon' => 'clipboard-check',
            'order' => 1002,
        ]);
    }
}
