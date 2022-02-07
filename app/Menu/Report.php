<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;

class Report
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Log Report', [
            'permission' => 'log_report_pengajuan_saya,log_report_pengajuan,log_report_suratkeluar_saya,log_report_suratkeluar',
            'icon' => 'clipboard-list',
            'order' => 1200,
        ]);
        $item->add('Log Report Pengajuan - Saya', [
            'route' => 'boilerplate.log-report-pengajuan-saya',
            'active' => 'boilerplate.log-report-pengajuan-saya',
            'permission' => 'log_report_pengajuan_saya',
            'order' => 100,
        ]);
        $item->add('Log Report Pengajuan', [
            'route' => 'boilerplate.log-report-pengajuan',
            'active' => 'boilerplate.log-report-pengajuan',
            'permission' => 'log_report_pengajuan',
            'order' => 101,
        ]);
        $item->add('Log Report Closing Pengajuan - Saya', [
            'route' => 'boilerplate.log-report-closing-saya',
            'active' => 'boilerplate.log-report-closing-saya',
            'permission' => 'log_report_closing_saya',
            'order' => 102,
        ]);
        $item->add('Log Report Closing Pengajuan', [
            'route' => 'boilerplate.log-report-closing',
            'active' => 'boilerplate.log-report-closing',
            'permission' => 'log_report_closing',
            'order' => 103,
        ]);
        $item->add('Log Report Surat Keluar - Saya', [
            'route' => 'boilerplate.log-report-suratkeluar-saya',
            'active' => 'boilerplate.log-report-suratkeluar-saya',
            'permission' => 'log_report_suratkeluar_saya',
            'order' => 104,
        ]);
        $item->add('Log Report Surat Keluar', [
            'route' => 'boilerplate.log-report-suratkeluar',
            'active' => 'boilerplate.log-report-suratkeluar',
            'permission' => 'log_report_suratkeluar',
            'order' => 105,
        ]);
    }
}
