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
        return pengajuan::leftJoin('jenis_pengajuans', 'pengajuans.jenis_pengajuan_id', 'jenis_pengajuans.id')->whereRaw('pengajuans.status = 1 and review_status=2 and reviewdep_status=2 and approve_status=2 and jenis_pengajuan_id<6')->orderByDesc('pengajuans.updated_at')->get(['pengajuans.id',
        'pengajuan',
        'tgl_pengajuan',
        'jenis_pengajuan',
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

            Column::add('Pengajuan')
                ->data('pengajuan'),

            Column::add('Tgl Pengajuan')
                ->data('tgl_pengajuan'),

            Column::add('Status Bayar')
                ->width('40px')
                ->data('bayar_status', function (pengajuan $pengajuan) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($pengajuan->bayar_status == 1) {
                        return sprintf($badge1, 'info', __('belum dibayar'));
                    }else if($pengajuan->bayar_status == 2){
                        return sprintf($badge1, 'success', __('sudah dibayar'));
                    }
                }),

            Column::add('Waktu Bayar')
                ->data('bayar_time'),
                
            Column::add('Aksi')
            ->actions(function(pengajuan $pengajuan) {
                        return join([
                        Button::show('boilerplate.detail-bayar-pengajuan', $pengajuan->id),           
                    ]);
                    
                }),
        ];
    }
}