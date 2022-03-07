<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\cekdeppengajuan;
use App\Models\cekpengajuan;
use App\Models\approvepengajuan;
use Auth;
use DB;

class LogReportPengajuanSayaDatatable extends Datatable
{
    public $slug = 'log-report-pengajuan-saya';

    public function datasource()
    {
        $reviewdeppengajuan = cekdeppengajuan::leftJoin('users', 'users.id', 'cekdeppengajuans.reviewerdep_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('cekdeppengajuans.created_at as waktu_komentar', 'komentar', 'first_name', 'last_name', 'kode', DB::raw('"reviewerdep" as role, if(reviewdep_status=2, "disetujui", if(reviewdep_status=3, "revisi", if(reviewdep_status=4, "ditolak", null))) as statuss, concat(first_name, " ", last_name) as name'), 'users.id as uid', 'pengajuan_id', 'cekdeppengajuans.reviewerdep_id as usr_id')->where([['cekdeppengajuans.reviewerdep_id', '=', Auth::user()->id], ['cekdeppengajuans.status', '=', 1]]);
        $reviewpengajuan = cekpengajuan::leftJoin('users', 'users.id', 'cekpengajuans.reviewer_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('cekpengajuans.created_at as waktu_komentar', 'komentar', 'first_name', 'last_name', 'kode',DB::raw('"reviewer" as role, if(review_status=2, "disetujui", if(review_status=3, "revisi", if(review_status=4, "ditolak", null))) as statuss, concat(first_name, " ", last_name) as name'), 'users.id as uid', 'pengajuan_id', 'reviewer_id as usr_id')->where([['reviewer_id', '=', Auth::user()->id], ['cekpengajuans.status', '=', 1]]);
        $approvepengajuan = approvepengajuan::leftJoin('users', 'users.id', 'approvepengajuans.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approvepengajuans.created_at as waktu_komentar', 'komentar', 'first_name', 'last_name', 'kode', DB::raw('"approver" as role, if(approve_status=2, "disetujui", if(approve_status=3, "revisi", if(approve_status=4, "ditolak", null))) as statuss, concat(first_name, " ", last_name) as name'), 'users.id as uid', 'pengajuan_id', 'approver_id as usr_id')->where([['approver_id', '=', Auth::user()->id], ['approvepengajuans.status', '=', 1]])->union($reviewdeppengajuan)->union($reviewpengajuan)->orderByDesc('waktu_komentar')->get();

        return $approvepengajuan;
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

            Column::add('ID Pengajuan')
                ->data('pengajuan_id'),

            Column::add('Komentar')
                ->data('komentar'),

            Column::add('Status Review/Approve')
                ->data('statuss'),
        ];
    }
}