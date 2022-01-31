<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\closing;
use Auth;

class ApproveClosingDatatable extends Datatable
{
    public $slug = 'approve-closing';

    public function datasource()
    {
        return closing::leftJoin('jenis_pengajuans', 'closings.jenis_pengajuan_id', 'jenis_pengajuans.id')->whereRaw('status = 1 and ( review_status=2 or approver_id =?)', Auth::user()->id)->orderByDesc('closings.updated_at')->get(['closings.id',
        'closing',
        'tgl_closing',
        'jenis_pengajuan',
        'review_status',
        'review_time',
        'reviewdep_status',
        'reviewdep_time',
        'approve_status',
        'approve_time',
        'send_time',
        'send_status',]);
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

            Column::add('Id')
                ->data('id'),
            
            Column::add('Jenis Pengajuan')
                ->data('jenis_pengajuan'),

            Column::add('Closing')
                ->data('closing'),

            Column::add('Tgl Closing')
                ->data('tgl_closing'),

            Column::add('Status Review')
                ->width('40px')
                ->data('review_status', function (closing $closing) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($closing->review_status == 0) {
                        return sprintf($badge1, 'info', __('baru'));
                    }else if($closing->review_status == 1){
                        return sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($closing->review_status == 2){
                        return sprintf($badge1, 'success', __('disetujui'));
                    }else if($closing->review_status == 3){
                        return sprintf($badge1, 'warning', __('revisi'));
                    }else if($closing->review_status == 4){
                        return sprintf($badge1, 'danger', __('ditolak'));
                    }else if($closing->review_status == 5){
                        return sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    return sprintf($badge1, 'secondary', __('draft'));
                })
                ->notSortable(),

            Column::add('Waktu Review')
                ->data('review_time'),
                
            Column::add()
            ->actions(function(closing $closing) {
                        return join([
                        Button::show('boilerplate.detail-approve-closing-pengajuan', $closing->id),           
                    ]);
                    
                }),
        ];
    }
}