<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Request_surat_keluar;

class RequestsuratkeluarDatatable extends Datatable
{
    public $slug = 'requestsuratkeluar';

    public function datasource()
    {
        return Request_surat_keluar::leftJoin('jenis_surats', 'request_surat_keluars.jenis_surat_id', 'jenis_surats.id')->leftJoin('users', 'users.id', 'request_surat_keluars.user_id')->where([['status', '=', '1'], ['send_status', '=', '1']])->get(['request_surat_keluars.id',
        'perihal',
        'request_status',
        'request_time',
        'users.first_name',
        'jenis_surat',
        'send_status',
        'send_time',]);
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Status')
                ->width('40px')
                ->data('request_status', function (Request_surat_keluar $request_surat_keluar) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if($request_surat_keluar->request_status == 0){
                        return sprintf($badge1, 'info', __('baru'));
                    }else if ($request_surat_keluar->request_status == 1) {
                        return sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($request_surat_keluar->request_status == 2){
                        return sprintf($badge1, 'primary', __('proses'));
                    }else if($request_surat_keluar->request_status == 3){
                        return sprintf($badge1, 'success', __('selesai'));
                    }else if($request_surat_keluar->request_status == 4){
                        return sprintf($badge1, 'warning', __('revisi'));
                    }else if($request_surat_keluar->request_status == 5){
                        return sprintf($badge1, 'danger', __('ditolak'));
                    }else if($request_surat_keluar->request_status == 6){
                        return sprintf($badge1, 'info', __('telah direvisi'));
                    }
                })
                ->notSortable(),
            Column::add('Id')
                ->data('id'),

            Column::add('Waktu Permintaan')
                ->data('send_time'),
            
            Column::add('Waktu Proses')
                ->data('request_time'),

            Column::add('Jenis Surat')
                ->data('jenis_surat'),

            Column::add('Perihal Surat')
                ->data('perihal'),
            
            Column::add('Pembuat')
                ->data('first_name'),

            
            // Column::add('Status Pengajuan')
            //     ->data(''),
                
            Column::add()
                ->actions(function(Request_surat_keluar $request_surat_keluar) {
                        return join([
                        Button::show('boilerplate.surat-keluar-request-review.edit', $request_surat_keluar->id),           
                    ]); 
                }),
        ];
    }
}