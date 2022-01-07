<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\Suratkeluar;
use App\Models\User;
use Auth;
use DB;

class ReviewsuratkeluarDatatable extends Datatable
{
    public $slug = 'reviewsuratkeluar';

    public function datasource()
    {
        return Suratkeluar::leftJoin('jenis_surats', 'suratkeluars.jenis_surat_id', 'jenis_surats.id')->leftJoin('users', 'users.id', 'suratkeluars.user_id')->where([['reviewer_id', '=', Auth::user()->id], ['send_status', '=', '1']])->get(['suratkeluars.id',
        'perihal',
        'tgl_surat',
        'review_status',
        'users.first_name',
        'jenis_surat',
        'approve_status',
        'send_status',]);
        
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Status')
                ->width('40px')
                ->data('review_status', function (Suratkeluar $suratkeluar) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    if ($suratkeluar->review_status == 0) {
                        return sprintf($badge1, 'info', __('baru'));
                    }else if($suratkeluar->review_status == 1){
                        return sprintf($badge1, 'secondary', __('dilihat'));
                    }else if($suratkeluar->review_status == 2){
                        return sprintf($badge1, 'success', __('disetujui'));
                    }else if($suratkeluar->review_status == 3){
                        return sprintf($badge1, 'warning', __('revisi'));
                    }else if($suratkeluar->review_status == 4){
                        return sprintf($badge1, 'danger', __('ditolak'));
                    }else if($suratkeluar->review_status == 5){
                        return sprintf($badge1, 'info', __('telah direvisi'));
                    }
                    return sprintf($badge1, 'secondary', __('draft'));
                })
                ->notSortable(),
            Column::add('Id')
                ->data('id'),

            Column::add('Jenis Surat')
                ->data('jenis_surat'),

            Column::add('Perihal Surat')
                ->data('perihal'),
            
            Column::add('Pembuat')
                ->data('first_name'),

            Column::add('Tgl Surat')
                ->data('tgl_surat'),

            
            // Column::add('Status Pengajuan')
            //     ->data(''),
                
            Column::add()
                ->actions(function(Suratkeluar $suratkeluar) {
                        return join([
                        Button::show('boilerplate.surat-keluar-review.edit', $suratkeluar->id),           
                    ]); 
                }),
        ];
    }
}