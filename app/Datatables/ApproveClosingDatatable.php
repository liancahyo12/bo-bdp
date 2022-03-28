<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\closing;
use Auth;
use DB;

class ApproveClosingDatatable extends Datatable
{
    public $slug = 'approve-closing';

    public function datasource()
    {
        return closing::leftJoin('jenis_pengajuans', 'closings.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('isi_closings', 'isi_closings.closing_id', 'closings.id')->whereRaw('any_value(closings.status) = 1 and ( any_value(review_status)=2 or any_value(approver_id) =?)', Auth::user()->id)->groupBy('isi_closings.closing_id')->orderByRaw('any_value(closings.updated_at) desc')->get([DB::raw('any_value(closings.id) as  id'),
        DB::raw('any_value(tgl_closing) as tgl_closing'),
        DB::raw('any_value(jenis_pengajuan) as jenis_pengajuan'),
        DB::raw('any_value(no_pengajuan) as no_pengajuan'),
        DB::raw('any_value(review_status) as review_status'),
        DB::raw('any_value(review_time) as review_time'),
        DB::raw('any_value(reviewdep_status) as reviewdep_status'),
        DB::raw('any_value(reviewdep_time) as reviewdep_time'),
        DB::raw('any_value(approve_status) as approve_status'),
        DB::raw('any_value(approve_time) as approve_time'),
        DB::raw('any_value(send_time) as send_time'),
        DB::raw('any_value(send_status) as send_status'),
        DB::raw('any_value(transaksi) as transaksi')]);
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Status Approve')
                ->width('40px')
                ->data('approve_status', function (closing $closing) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($closing->approve_status == 0) {
                        return sprintf($badge1, 'info', __('baru'));
                    }else if($closing->approve_status == 1){
                        return sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($closing->approve_status == 2){
                        return sprintf($badge1, 'success', __('disetujui'));
                    }else if($closing->approve_status == 3){
                        return sprintf($badge1, 'warning', __('revisi'));
                    }else if($closing->approve_status == 4){
                        return sprintf($badge1, 'danger', __('ditolak'));
                    }else if($closing->approve_status == 5){
                        return sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    return sprintf($badge1, 'secondary', __('draft'));
                })
                ->notSortable(),

            Column::add('Waktu Approve')
                ->data('approve_time'),
            
            Column::add('No Pengajuan')
                ->data('no_pengajuan'),

            Column::add('Jenis Pengajuan')
                ->data('jenis_pengajuan'),

            Column::add('Closing')
                ->width('160px')
                ->data('transaksi'),

            Column::add('Tgl Closing')
                ->data('tgl_closing'),
                
            Column::add('Lihat')
            ->actions(function(closing $closing) {
                        return join([
                        Button::show('boilerplate.detail-approve-closing-pengajuan', $closing->id),           
                    ]);
                    
                }),
        ];
    }
}