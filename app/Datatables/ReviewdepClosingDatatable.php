<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\closing;
use Auth;

class ReviewdepClosingDatatable extends Datatable
{
    public $slug = 'reviewdep-closing';

    public function datasource()
    {
        return closing::leftJoin('jenis_pengajuans', 'closings.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('departemens', 'departemens.id', 'departemen_id')->where([['departemen_id', '=', Auth::user()->departemen_id], ['send_status', '=', '1'], ['closings.status', '=', '1']])->orWhere('departemens.reviewerdep_id', Auth::user()->id)->orderByDesc('closings.updated_at')->get(['closings.id',
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
            Column::add()
                ->width('40px')
                ->data('send_status', function (closing $closing) {
                    $badge = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($closing->send_status == 1) {
                        return sprintf($badge, 'success', __('Terkirim'));
                    }

                    return sprintf($badge, 'info', __('Draft'));
                })
                ->notSortable(),
            
            Column::add('Waktu Kirim')
                ->data('send_time'),

            Column::add('Id')
                ->data('id'),
            
            Column::add('Jenis Pengajuan')
                ->data('jenis_pengajuan'),

            Column::add('Closing')
                ->data('closing'),

            Column::add('Tgl Closing')
                ->data('tgl_closing'),

                Column::add('Status Pengajuan')
                ->width('40px')
                ->data('pengajuan_status', function (closing $closing) {
                    $badge1 = '<span class="badge badge-pill badge-%s">Review Dep %s</span>';
                    $badge2 = '<span class="badge badge-pill badge-%s">Review %s</span>';
                    $badge3 = '<span class="badge badge-pill badge-%s">Aprove %s</span>';
                    $a;
                    $b;
                    $c;
                    if ($closing->reviewdep_status == 0) {
                        $a= sprintf($badge1, 'info', __('baru'));
                    }else if($closing->reviewdep_status == 1){
                        $a= sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($closing->reviewdep_status == 2){
                        $a= sprintf($badge1, 'success', __('disetujui'));
                    }else if($closing->reviewdep_status == 3){
                        $a= sprintf($badge1, 'warning', __('revisi'));
                    }else if($closing->reviewdep_status == 4){
                        $a= sprintf($badge1, 'danger', __('ditolak'));
                    }else if($closing->reviewdep_status == 5){
                        $a= sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    if ($closing->review_status == 0) {
                        $b= sprintf($badge2, 'info', __('baru'));
                    }else if($closing->review_status == 1){
                        $b= sprintf($badge2, 'secondary', __('dilihat'));
                    }else if($closing->review_status == 2){
                        $b= sprintf($badge2, 'success', __('disetujui'));
                    }else if($closing->review_status == 3){
                        $b= sprintf($badge2, 'warning', __('revisi'));
                    }else if($closing->review_status == 4){
                        $b= sprintf($badge2, 'danger', __('ditolak'));
                    }else if($closing->review_status == 5){
                        $b= sprintf($badge2, 'info', __('telah direvisi'));
                    }
                    if ($closing->approve_status == 0) {
                        $c= sprintf($badge3, 'info', __('baru'));
                    }else if($closing->approve_status == 1){
                        $c= sprintf($badge3, 'secondary', __('dilihat'));
                    }else if($closing->approve_status == 2){
                        $c= sprintf($badge3, 'success', __('disetujui'));
                    }else if($closing->approve_status == 3){
                        $c= sprintf($badge3, 'warning', __('revisi'));
                    }else if($closing->approve_status == 4){
                        $c= sprintf($badge3, 'danger', __('ditolak'));
                    }else if($closing->approve_status == 5){
                        $c= sprintf($badge3, 'info', __('telah direvisi'));
                    }
                    return join([$a, $b, $c]);
                })
                ->notSortable(),

            Column::add('Waktu Perubahan Status')
                ->data('status_time', function (closing $closing) {
                    if ($closing->approve_time>$closing->review_time) {
                        return $closing->approve_time;
                    }else if ($closing->review_time>$closing->reviewdep_time) {
                        return $closing->review_time;
                    }else if ($closing->review_time<$closing->reviewdep_time) {
                        return $closing->reviewdep_time;
                    }
                }),

            Column::add()
                ->actions(function(closing $closing) {
                        return join([
                        Button::show('boilerplate.detail-reviewdep-closing-pengajuan', $closing->id),           
                    ]);
                    
                }),
        ];
    }
}