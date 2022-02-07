<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Approvesuratkeluar;
use Auth;
use DB;

class LogReportSuratkeluarSayaDatatable extends Datatable
{
    public $slug = 'log-report-suratkeluar-saya';

    public function datasource()
    {
        $approvesuratkeluar = Approvesuratkeluar::leftJoin('users', 'users.id', 'approvesuratkeluars.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approvesuratkeluars.created_at as waktu_komentar', 'komentar', 'first_name', 'last_name', 'kode', DB::raw('"approver" as role, if(approve_status=2, "disetujui", if(approve_status=3, "revisi", if(approve_status=4, "ditolak", null))) as statuss, concat(first_name, " ", last_name) as name'), 'users.id as uid', 'surat_keluar_id', 'approver_id as usr_id')->where([['approver_id', '=', Auth::user()->id], ['approvesuratkeluars.status', '=', 1]])->orderByDesc('waktu_komentar')->get();

        return $approvesuratkeluar;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Waktu Review/Approve')
                ->data('waktu_komentar'),

            Column::add('ID Reviewer/Approver')
                ->data('usr_id'),
            
            Column::add('Nama Reviewer/Approver')
                ->data('name'),

            Column::add('Role')
                ->data('role'),

            Column::add('ID Surat Keluar')
                ->data('surat_keluar_id'),

            Column::add('Komentar')
                ->data('komentar'),

            Column::add('Status Review/Approve')
                ->data('statuss'),
        ];
    }
}