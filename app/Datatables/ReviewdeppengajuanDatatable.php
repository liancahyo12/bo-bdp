<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\pengajuan;
use Auth;

class ReviewdeppengajuanDatatable extends Datatable
{
    public $slug = 'reviewdeppengajuan';

    public function datasource()
    {
        return pengajuan::leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('departemens', 'departemens.id', 'departemen_id')->where([['departemen_id', '=', Auth::user()->departemen_id], ['send_status', '=', '1'], ['pengajuans.status', '=', '1']])->orWhere([['departemens.reviewerdep_id', '=',Auth::user()->id], ['send_status', '=', '1'], ['pengajuans.status', '=', '1']])->orderByDesc('pengajuans.updated_at')->get(['pengajuans.id',
        'pengajuan',
        'tgl_pengajuan',
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
                ->data('send_status', function (pengajuan $pengajuan) {
                    $badge = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($pengajuan->send_status == 1) {
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

            Column::add('Pengajuan')
                ->data('pengajuan'),

            Column::add('Tgl Pengajuan')
                ->data('tgl_pengajuan'),

                Column::add('Status Pengajuan')
                ->width('40px')
                ->data('pengajuan_status', function (pengajuan $pengajuan) {
                    $badge1 = '<span class="badge badge-pill badge-%s">Review Dep %s</span>';
                    $badge2 = '<span class="badge badge-pill badge-%s">Review %s</span>';
                    $badge3 = '<span class="badge badge-pill badge-%s">Aprove %s</span>';
                    $a;
                    $b;
                    $c;
                    if ($pengajuan->reviewdep_status == 0) {
                        $a= sprintf($badge1, 'info', __('baru'));
                    }else if($pengajuan->reviewdep_status == 1){
                        $a= sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($pengajuan->reviewdep_status == 2){
                        $a= sprintf($badge1, 'success', __('disetujui'));
                    }else if($pengajuan->reviewdep_status == 3){
                        $a= sprintf($badge1, 'warning', __('revisi'));
                    }else if($pengajuan->reviewdep_status == 4){
                        $a= sprintf($badge1, 'danger', __('ditolak'));
                    }else if($pengajuan->reviewdep_status == 5){
                        $a= sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    if ($pengajuan->review_status == 0) {
                        $b= sprintf($badge2, 'info', __('baru'));
                    }else if($pengajuan->review_status == 1){
                        $b= sprintf($badge2, 'secondary', __('dilihat'));
                    }else if($pengajuan->review_status == 2){
                        $b= sprintf($badge2, 'success', __('disetujui'));
                    }else if($pengajuan->review_status == 3){
                        $b= sprintf($badge2, 'warning', __('revisi'));
                    }else if($pengajuan->review_status == 4){
                        $b= sprintf($badge2, 'danger', __('ditolak'));
                    }else if($pengajuan->review_status == 5){
                        $b= sprintf($badge2, 'info', __('telah direvisi'));
                    }
                    if ($pengajuan->approve_status == 0) {
                        $c= sprintf($badge3, 'info', __('baru'));
                    }else if($pengajuan->approve_status == 1){
                        $c= sprintf($badge3, 'secondary', __('dilihat'));
                    }else if($pengajuan->approve_status == 2){
                        $c= sprintf($badge3, 'success', __('disetujui'));
                    }else if($pengajuan->approve_status == 3){
                        $c= sprintf($badge3, 'warning', __('revisi'));
                    }else if($pengajuan->approve_status == 4){
                        $c= sprintf($badge3, 'danger', __('ditolak'));
                    }else if($pengajuan->approve_status == 5){
                        $c= sprintf($badge3, 'info', __('telah direvisi'));
                    }
                    return join([$a, $b, $c]);
                })
                ->notSortable(),

            Column::add('Waktu Perubahan Status')
                ->data('status_time', function (pengajuan $pengajuan) {
                    if ($pengajuan->approve_time>$pengajuan->review_time) {
                        return $pengajuan->approve_time;
                    }else if ($pengajuan->review_time>$pengajuan->reviewdep_time) {
                        return $pengajuan->review_time;
                    }else if ($pengajuan->review_time<$pengajuan->reviewdep_time) {
                        return $pengajuan->reviewdep_time;
                    }
                }),

            Column::add()
                ->actions(function(pengajuan $pengajuan) {
                        return join([
                        Button::show('boilerplate.detail-reviewdep-pengajuan', $pengajuan->id),           
                    ]);
                    
                }),
        ];
    }
}