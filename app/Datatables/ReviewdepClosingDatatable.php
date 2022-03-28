<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\closing;
use Auth;
use DB;

class ReviewdepClosingDatatable extends Datatable
{
    public $slug = 'reviewdep-closing';

    public function datasource()
    {
        return closing::leftJoin('jenis_pengajuans', 'closings.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('isi_closings', 'isi_closings.closing_id', 'closings.id')->leftJoin('departemens', 'departemens.id', 'departemen_id')->whereRaw('departemen_id = ? and send_status = 1 and closings.status = 1 and any_value(isi_closings.status) = 1', Auth::user()->departemen_id)->orwhereRaw('departemens.reviewerdep_id = ? and send_status = 1 and closings.status = 1 and any_value(isi_closings.status) = 1', Auth::user()->id)->groupBy('isi_closings.closing_id')->orderByRaw('any_value(closings.updated_at) desc')->get([DB::raw('any_value(closings.id) as  id'),
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
            
            Column::add('Waktu Review')
                ->data('reviewdep_time'),

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
                        Button::show('boilerplate.detail-reviewdep-closing-pengajuan', $closing->id),           
                    ]);
                    
                }),
        ];
    }
}