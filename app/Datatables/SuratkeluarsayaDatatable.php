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
        
        return Auth::user()->suratkeluar()->get(['id',
        'perihal',
        'tgl_surat',
        'review_status',
        'approve_status',
        'send_status',]);
        // return DB::table('suratkeluars')->select([
        // 'id',
        // 'perihal',
        // 'no_surat',
        // ])->where('user_id', Auth::user()->id)->get()->toArray();

    }

    public function setUp()
    {
        // $this->permissions('backend_access')
        //     ->locale([
        //         'deleteConfirm' => __('boilerplate::role.list.confirmdelete'),
        //         'deleteSuccess' => __('boilerplate::role.list.deletesuccess'),
        //     ])
        //     ->buttons([])
        //     ->noSearching()
        //     ->noOrdering()
        //     ->order('id', 'desc');
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
            Column::add('Id')
                ->data('id'),

            Column::add('Perihal Surat')
                ->data('perihal'),

            Column::add('Tgl Surat')
                ->data('tgl_surat'),

            Column::add('Status')
                ->width('40px')
                ->data('custom_status', function (Suratkeluar $suratkeluar) {
                    $badge1 = '<span class="badge badge-pill badge-%s">%s</span>';
                    $badge2 = '<span class="badge badge-pill badge-%s">%s</span><br><span class="badge badge-pill badge-%s">%s</span>';
                    if ($suratkeluar->review_status == null &&  $suratkeluar->approve_status == null) {
                        return sprintf($badge1, 'secondary', __(''),'a','a');
                    }

                    return sprintf($badge2, 'info', __('Draft'),'a','a');
                })
                ->notSortable(),
            // Column::add('Status Pengajuan')
            //     ->data(''),
                
            Column::add()
                ->actions(function(Suratkeluar $suratkeluar) {
                    if ($suratkeluar->send_status == 1) {
                        return join([
                        // Button::show('boilerplate.surat-keluar-saya.detail', $suratkeluar->id),           
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