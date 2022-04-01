<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Suratkeluar;
use App\Models\User;
use Auth;
use DB;

class SuratkeluarsayaDatatable extends Datatable
{
    // protected $suratkeluar;
    public $slug = 'suratkeluarsaya';

    public function datasource()
    {
        
        return Suratkeluar::leftJoin('jenis_surats', 'suratkeluars.jenis_surat_id', 'jenis_surats.id')->where([['user_id', '=', Auth::user()->id], ['suratkeluars.status', '=', '1']])->orderByDesc('suratkeluars.updated_at')->get(['suratkeluars.id',
        'perihal',
        'tgl_surat',
        'no_surat',
        'surat_scan',
        'jenis_surat',
        'review_status',
        'approve_status',
        'approve_time',
        'send_time',
        'request_surat_keluar_id',
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
                ->data('send_status', function (Suratkeluar $suratkeluar) {
                    $badge = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($suratkeluar->send_status == 1) {
                        return sprintf($badge, 'success', __('Terkirim'));
                    }

                    return sprintf($badge, 'info', __('Draft'));
                })
                ->notSortable(),
            
            Column::add('Waktu Kirim')
                ->data('send_time'),

            Column::add('Id')
                ->data('id'),

            Column::add('No Surat')
                ->data('no_surat'),
            
            Column::add('Jenis Surat')
                ->data('jenis_surat'),

            Column::add('Perihal Surat')
                ->data('perihal'),

            Column::add('Tgl Surat')
                ->data('tgl_surat'),

            Column::add('Status Approve')
                ->width('40px')
                ->data('approve_status', function (Suratkeluar $suratkeluar) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($suratkeluar->approve_status == 0) {
                        return sprintf($badge1, 'info', __('baru'));
                    }else if($suratkeluar->approve_status == 1){
                        return sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($suratkeluar->approve_status == 2){
                        return sprintf($badge1, 'success', __('disetujui'));
                    }else if($suratkeluar->approve_status == 3){
                        return sprintf($badge1, 'warning', __('revisi'));
                    }else if($suratkeluar->approve_status == 4){
                        return sprintf($badge1, 'danger', __('ditolak'));
                    }else if($suratkeluar->approve_status == 5){
                        return sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    return sprintf($badge1, 'secondary', __('draft'));
                })
                ->notSortable(),

            Column::add('Waktu Approve')
                ->data('approve_time'),
            // Column::add('Status Pengajuan')
            //     ->data(''),
                
            Column::add('Aksi')
                ->actions(function(Suratkeluar $suratkeluar) {
                    if ($suratkeluar->send_status == 1 && ($suratkeluar->review_status == 3 ||  $suratkeluar->approve_status == 3)) {
                        return join([
                            Button::edit('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),          
                        ]);
                    }else if($suratkeluar->send_status == 1){
                        if ($suratkeluar->surat_scan == null && $suratkeluar->approve_status == 2) {
                            return join([
                                Button::edit('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),          
                            ]); 
                        }
                        return join([
                            Button::show('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),           
                        ]);  
                    }
                    return join([
                        Button::edit('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),    
                        Button::delete('boilerplate.surat-keluar-delete', $suratkeluar->id),           
                    ]);
                    
                }),
        ];
    }
}