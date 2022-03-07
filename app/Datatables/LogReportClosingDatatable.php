<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\reviewdepclosing;
use App\Models\reviewclosing;
use App\Models\approveclosing;
use Auth;
use DB;

class LogReportClosingDatatable extends Datatable
{
    public $slug = 'log-report-closing';

    public function datasource()
    {
        $reviewdeppengajuan = reviewdepclosing::leftJoin('users', 'users.id', 'reviewdepclosings.reviewerdep_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('reviewdepclosings.created_at as waktu_komentar', 'komentar', 'first_name', 'last_name', 'kode', DB::raw('"reviewerdep" as role, if(reviewdep_status=2, "disetujui", if(reviewdep_status=3, "revisi", if(reviewdep_status=4, "ditolak", null))) as statuss, concat(first_name, " ", last_name) as name'), 'users.id as uid', 'closing_id', 'reviewdepclosings.reviewerdep_id as usr_id')->where('reviewdepclosings.status', 1);
        $reviewpengajuan = reviewclosing::leftJoin('users', 'users.id', 'reviewclosings.reviewer_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('reviewclosings.created_at as waktu_komentar', 'komentar', 'first_name', 'last_name', 'kode',DB::raw('"reviewer" as role, if(review_status=2, "disetujui", if(review_status=3, "revisi", if(review_status=4, "ditolak", null))) as statuss, concat(first_name, " ", last_name) as name'), 'users.id as uid', 'closing_id', 'reviewer_id as usr_id')->where('reviewclosings.status', 1);
        $approveclosing = approveclosing::leftJoin('users', 'users.id', 'approveclosings.approver_id')->leftJoin('departemens', 'departemen_id', 'departemens.id')->select('approveclosings.created_at as waktu_komentar', 'komentar', 'first_name', 'last_name', 'kode', DB::raw('"approver" as role, if(approve_status=2, "disetujui", if(approve_status=3, "revisi", if(approve_status=4, "ditolak", null))) as statuss, concat(first_name, " ", last_name) as name'), 'users.id as uid', 'closing_id', 'approver_id as usr_id')->where('approveclosings.status', 1)->union($reviewdeppengajuan)->union($reviewpengajuan)->orderByDesc('waktu_komentar')->get();

        return $approveclosing;
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

            Column::add('ID Closing')
                ->data('closing_id'),

            Column::add('Komentar')
                ->data('komentar'),

            Column::add('Status Review/Approve')
                ->data('statuss'),
        ];
    }
}