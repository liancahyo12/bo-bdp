<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\pengajuan;
use Auth;

class BayarPengajuanDatatable extends Datatable
{
    public $slug = 'bayar-pengajuan';

    public function datasource()
    {
        return pengajuan::leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->whereRaw('pengajuans.status = 1 and review_status=2 and reviewdep_status=2 and approve_status=2')->orderByDesc('pengajuans.updated_at')->get(['pengajuans.id',
        'pengajuan',
        'tgl_pengajuan',
        'jenis_pengajuan',
        'jenis_pengajuan_id',
        'no_pengajuan',
        'bayar_status',
        'bayar_time',
        'approve_time',]);
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Waktu Approve')
                ->data('approve_time'),

            Column::add('Id')
                ->data('id'),

            Column::add('No Pengajuan')
                ->data('no_pengajuan'),
            
            Column::add('Jenis Pengajuan')
                ->data('jenis_pengajuan'),

            Column::add('Tgl Pengajuan')
                ->data('tgl_pengajuan'),

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