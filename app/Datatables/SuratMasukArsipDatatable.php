<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Suratmasuk;
use App\Models\User;
use Auth;
use DB;

class SuratMasukArsipDatatable extends Datatable
{
    public $slug = 'surat-masuk-arsip';

    public function datasource()
    {
        return Suratmasuk::leftJoin('departemens', 'departemen_id', 'departemens.id')->where('suratmasuks.status', '1')->orderByDesc('suratmasuks.updated_at')->get(['suratmasuks.id',
        'ringkasan',
        'tgl_surat',
        'tgl_diterima',
        'departemen',
        'no_surat',
        'pengirim',]);
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('No Surat')
                ->data('no_surat'),

            Column::add('Tgl Terima')
                ->data('tgl_diterima'),

            Column::add('Tgl Surat')
                ->data('tgl_surat'),

            Column::add('Departemen')
                ->data('departemen'),
            
            Column::add('Ringkasan')
                ->data('ringkasan'),

            Column::add()
                ->actions(function(Suratkeluar $suratkeluar) {
                    if ($suratkeluar->send_status == 1 && ($suratkeluar->review_status == 3 ||  $suratkeluar->approve_status == 3)) {
                        return join([
                        Button::edit('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),          
                    ]);
                    }else if($suratkeluar->send_status == 1){
                        return join([
                        Button::show('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),           
                    ]);  
                    }
                    return join([
                        Button::edit('boilerplate.surat-keluar-saya.edit', $suratkeluar->id),    
                        Button::delete('boilerplate.surat-keluar-saya.destroy', $suratkeluar->id),           
                    ]);
                    
                }),
        ];
    }
}