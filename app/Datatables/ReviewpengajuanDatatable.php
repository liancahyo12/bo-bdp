<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\pengajuan;
use Auth;
use DB;

class ReviewpengajuanDatatable extends Datatable
{
    public $slug = 'reviewpengajuan';

    public function datasource()
    {
        return pengajuan::leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('isi_pengajuans', 'isi_pengajuans.pengajuan_id', 'pengajuans.id')->whereRaw('any_value(pengajuans.status) = 1 and ( any_value(reviewdep_status)=2 or any_value(reviewer_id) =?) and any_value(isi_pengajuans.status) = 1', Auth::user()->id)->groupBy('isi_pengajuans.pengajuan_id')->orderByRaw('any_value(pengajuans.updated_at) desc')->get([DB::raw('any_value(pengajuans.id) as  id'),
        DB::raw('any_value(tgl_pengajuan) as tgl_pengajuan'),
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
        DB::raw('ifnull(any_value(transaksi), any_value(jenis_transaksi)) as transaksi')]);
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
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

            Column::add('Id')
                ->data('id'),
            
            Column::add('No Pengajuan')
                ->data('no_pengajuan'),

            Column::add('Jenis Pengajuan')
                ->data('jenis_pengajuan'),

            Column::add('Pengajuan')
                ->width('160px')
                ->data('transaksi'),

            Column::add('Tgl Pengajuan')
                ->data('tgl_pengajuan'),
                
            Column::add('Lihat')
                ->actions(function(pengajuan $pengajuan) {
                        return join([
                        Button::show('boilerplate.detail-review-pengajuan', $pengajuan->id),           
                    ]);
                    
                }),
        ];
    }
}