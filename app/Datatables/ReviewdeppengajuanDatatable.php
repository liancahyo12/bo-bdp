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
        return pengajuan::leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->where([['departemen_id', '=', Auth::user()->departemen_id], ['send_status', '=', '1'], ['status', '=', '1']])->orderByDesc('pengajuans.updated_at')->get(['pengajuans.id',
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

            Column::add('Status Review Dep')
                ->width('40px')
                ->data('reviewdep_status', function (pengajuan $pengajuan) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($pengajuan->reviewdep_status == 0) {
                        return sprintf($badge1, 'info', __('baru'));
                    }else if($pengajuan->reviewdep_status == 1){
                        return sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($pengajuan->reviewdep_status == 2){
                        return sprintf($badge1, 'success', __('disetujui'));
                    }else if($pengajuan->reviewdep_status == 3){
                        return sprintf($badge1, 'warning', __('revisi'));
                    }else if($pengajuan->reviewdep_status == 4){
                        return sprintf($badge1, 'danger', __('ditolak'));
                    }else if($pengajuan->reviewdep_status == 5){
                        return sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    return sprintf($badge1, 'secondary', __('draft'));
                })
                ->notSortable(),

            Column::add('Waktu Review Dep')
                ->data('reviewdep_time'),
                
                Column::add('Status Review')
                ->width('40px')
                ->data('review_status', function (pengajuan $pengajuan) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($pengajuan->review_status == 0) {
                        return sprintf($badge1, 'info', __('baru'));
                    }else if($pengajuan->review_status == 1){
                        return sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($pengajuan->review_status == 2){
                        return sprintf($badge1, 'success', __('disetujui'));
                    }else if($pengajuan->review_status == 3){
                        return sprintf($badge1, 'warning', __('revisi'));
                    }else if($pengajuan->review_status == 4){
                        return sprintf($badge1, 'danger', __('ditolak'));
                    }else if($pengajuan->review_status == 5){
                        return sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    return sprintf($badge1, 'secondary', __('draft'));
                })
                ->notSortable(),

            Column::add('Waktu Review')
                ->data('review_time'),

            Column::add('Status Approve')
                ->width('40px')
                ->data('approve_status', function (pengajuan $pengajuan) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($pengajuan->approve_status == 0) {
                        return sprintf($badge1, 'info', __('baru'));
                    }else if($pengajuan->approve_status == 1){
                        return sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($pengajuan->approve_status == 2){
                        return sprintf($badge1, 'success', __('disetujui'));
                    }else if($pengajuan->approve_status == 3){
                        return sprintf($badge1, 'warning', __('revisi'));
                    }else if($pengajuan->approve_status == 4){
                        return sprintf($badge1, 'danger', __('ditolak'));
                    }else if($pengajuan->approve_status == 5){
                        return sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    return sprintf($badge1, 'secondary', __('draft'));
                })
                ->notSortable(),

            Column::add('Waktu Approve')
                ->data('approve_time'),

            Column::add()
                ->actions(function(pengajuan $pengajuan) {
                        return join([
                        Button::show('boilerplate.detail-reviewdep-pengajuan', $pengajuan->id),           
                    ]);
                    
                }),
        ];
    }
}