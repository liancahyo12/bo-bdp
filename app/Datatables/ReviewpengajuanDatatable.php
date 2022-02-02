<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\pengajuan;
use Auth;

class ReviewpengajuanDatatable extends Datatable
{
    public $slug = 'reviewpengajuan';

    public function datasource()
    {
        return pengajuan::leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->whereRaw('pengajuans.status = 1 and ( reviewdep_status=2 or reviewer_id =?)', Auth::user()->id)->orderByDesc('pengajuans.updated_at')->get(['pengajuans.id',
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
            Column::add('Status Review Saya')
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

            Column::add('Waktu Review Saya')
                ->data('review_time'),

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
                
            Column::add()
                ->actions(function(pengajuan $pengajuan) {
                        return join([
                        Button::show('boilerplate.detail-review-pengajuan', $pengajuan->id),           
                    ]);
                    
                }),
        ];
    }
}