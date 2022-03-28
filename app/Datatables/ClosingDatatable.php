<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\closing;
use Auth;
use DB;

class ClosingDatatable extends Datatable
{
    public $slug = 'closing';

    public function datasource()
    {
        return closing::leftJoin('jenis_pengajuans', 'closings.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('isi_closings', 'isi_closings.closing_id', 'closings.id')->whereRaw('user_id = ? and closings.status = 1 and any_value(isi_closings.status) = 1', Auth::user()->id)->groupBy('isi_closings.closing_id')->orderByRaw('any_value(closings.updated_at) desc')->get([DB::raw('any_value(closings.id) as  id'),
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

            Column::add('No Pengajuan')
                ->data('no_pengajuan'),
            
            Column::add('Jenis Pengajuan')
                ->width('160px')
                ->data('jenis_pengajuan'),

            Column::add('Closing')
                ->width('160px')
                ->data('transaksi'),

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
                
            Column::add('Aksi')
                ->actions(function(closing $closing) {
                    if ($closing->send_status == 1 && $closing->revisi_status == 1) {
                        return join([
                            Button::edit('boilerplate.edit-closing-pengajuan', $closing->id),   
                        ]);
                    }else if($closing->send_status == 1){
                        return join([
                            Button::show('boilerplate.edit-closing-pengajuan', $closing->id),           
                        ]);  
                    }
                    return join([
                        Button::edit('boilerplate.edit-closing-pengajuan', $closing->id),           
                    ]);
                    
                }),
        ];
    }
}