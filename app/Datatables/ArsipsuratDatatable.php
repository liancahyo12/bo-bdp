<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Suratkeluar;
use App\Models\User;
use Auth;
use DB;

class ArsipsuratDatatable extends Datatable
{
    public $slug = 'arsipsurat';

    public function datasource()
    {
        return Suratkeluar::leftJoin('jenis_surats', 'suratkeluars.jenis_surat_id', 'jenis_surats.id')->where([['user_id', '=', Auth::user()->id], ['status', '=', '1'], ['approve_status', '=', '2']])->orderByDesc('suratkeluars.approve_time')->get(['suratkeluars.id',
        'perihal',
        'tgl_surat',
        'jenis_surat',
        'review_status',
        'approve_status',
        'approve_time',
        'send_time',
        'no_surat',
        'request_surat_keluar_id',
        'send_status',]);
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
                 
            Column::add('Id')
                ->data('id'),

            // Column::add('Id Permintaan')
            //     ->data('request_surat_keluar_id'),

            Column::add('Waktu Approve')
                ->data('approve_time'),
            
            Column::add('Jenis Surat')
                ->data('jenis_surat'),

            Column::add('Perihal Surat')
                ->data('perihal'),

            Column::add('Tgl Surat')
                ->data('tgl_surat'),
            
            Column::add('No Surat')
                ->data('no_surat'),

            Column::add()
                ->actions(function(Suratkeluar $suratkeluar) {
                    if ($suratkeluar->surat_scan == null) {
                        return join([
                        Button::edit('boilerplate.surat-keluar-arsip-edit', $suratkeluar->id),          
                    ]);
                    }else{
                        return join([
                        Button::show('boilerplate.surat-keluar-arsip-edit', $suratkeluar->id),           
                    ]);  
                    }
                    
                }),
        ];
    }
}