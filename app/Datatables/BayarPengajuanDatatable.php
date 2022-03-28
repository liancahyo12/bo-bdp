<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\pengajuan;
use Auth;
use DB;

class BayarPengajuanDatatable extends Datatable
{
    public $slug = 'bayar-pengajuan';

    public function datasource()
    {
        return pengajuan::leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->leftJoin('isi_pengajuans', 'isi_pengajuans.pengajuan_id', 'pengajuans.id')->whereRaw('any_value(pengajuans.status) = 1 and any_value(review_status)=2 and any_value(reviewdep_status)=2 and any_value(approve_status)=2 and any_value(isi_pengajuans.status) = 1')->groupBy('isi_pengajuans.pengajuan_id')->orderByRaw('any_value(pengajuans.updated_at) desc')->get([DB::raw('any_value(pengajuans.id) as  id'),
        DB::raw('any_value(tgl_pengajuan) as tgl_pengajuan'),
        DB::raw('any_value(jenis_pengajuan) as jenis_pengajuan'),
        DB::raw('any_value(pengajuans.jenis_pengajuan_id) as jenis_pengajuan_id'),
        DB::raw('any_value(no_pengajuan) as no_pengajuan'),
        DB::raw('any_value(review_status) as review_status'),
        DB::raw('any_value(review_time) as review_time'),
        DB::raw('any_value(reviewdep_status) as reviewdep_status'),
        DB::raw('any_value(reviewdep_time) as reviewdep_time'),
        DB::raw('any_value(approve_status) as approve_status'),
        DB::raw('any_value(approve_time) as approve_time'),
        DB::raw('any_value(send_time) as send_time'),
        DB::raw('any_value(send_status) as send_status'),
        DB::raw('any_value(bayar_time) as bayar_time'),
        DB::raw('any_value(bayar_status) as bayar_status'),
        DB::raw('ifnull(any_value(transaksi), any_value(jenis_transaksi)) as transaksi')]);
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Status Bayar')
                ->width('40px')
                ->data('custom_status', function (pengajuan $pengajuan) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($pengajuan->jenis_pengajuan_id == 2 || $pengajuan->jenis_pengajuan_id == 3 || $pengajuan->jenis_pengajuan_id == 4 || $pengajuan->jenis_pengajuan_id == 6) {
                        if ($pengajuan->bayar_status == 1) {
                            return sprintf($badge1, 'info', __('belum dibayar'));
                        }else if($pengajuan->bayar_status == 2){
                            return sprintf($badge1, 'success', __('sudah dibayar'));
                        }
                    }else {
                        return sprintf($badge1, 'secondary', __('-'));
                    }
                }),

            Column::add('Waktu Bayar')
                ->data('bayar_time'),

            Column::add('No Pengajuan')
                ->data('no_pengajuan'),

            Column::add('Jenis Pengajuan')
                ->width('160px')
                ->data('jenis_pengajuan'),
            
            Column::add('Pengajuan')
                ->width('160px')
                ->data('transaksi'),

            Column::add('Tgl Pengajuan')
                ->data('tgl_pengajuan'),
                
            Column::add('Aksi')
            ->actions(function(pengajuan $pengajuan) {
                if ($pengajuan->jenis_pengajuan_id == 2 || $pengajuan->jenis_pengajuan_id == 3 || $pengajuan->jenis_pengajuan_id == 4 || $pengajuan->jenis_pengajuan_id == 6) {
                    if ($pengajuan->bayar_status == 1) {
                            return Button::add('Bayar')->route('boilerplate.detail-bayar-pengajuan', $pengajuan->id)->color('primary')->make();
                        }else if($pengajuan->bayar_status == 2){
                            return Button::show('boilerplate.detail-bayar-pengajuan', $pengajuan->id);
                        }
                }else {
                    return Button::show('boilerplate.detail-bayar-pengajuan', $pengajuan->id);
                }
            }),
        ];
    }
}