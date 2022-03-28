<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\pengajuan;
use Auth;
use DB;

class ReviewdeppengajuanDatatable extends Datatable
{
    public $slug = 'reviewdeppengajuan';

    public function datasource()
    {
        return pengajuan::leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('isi_pengajuans', 'isi_pengajuans.pengajuan_id', 'pengajuans.id')->leftJoin('departemens', 'departemens.id', 'departemen_id')->whereRaw('any_value(departemen_id) = ? and any_value(send_status) = 1 and any_value(pengajuans.status) = 1', Auth::user()->departemen_id)->orwhereRaw('any_value(departemens.reviewerdep_id) = ? and any_value(send_status) = 1 and any_value(pengajuans.status) = 1', Auth::user()->id)->groupBy('isi_pengajuans.pengajuan_id')->orderByRaw('any_value(pengajuans.updated_at) desc')->get([DB::raw('any_value(pengajuans.id) as  id'),
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
            
            Column::add('Waktu Review')
                ->data('reviewdep_time'),

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
                        Button::show('boilerplate.detail-reviewdep-pengajuan', $pengajuan->id),           
                    ]);
                    
                }),
        ];
    }
}