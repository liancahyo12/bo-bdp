<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

use App\Models\pengajuan;

class PengajuansDatatable extends Datatable
{
    public $slug = 'pengajuans';

    public function datasource()
    {
        // return User::query();
        return collect([
            ['id' => 1, 'name' => 'John'],
            ['id' => 2, 'name' => 'Jane'],
            ['id' => 3, 'name' => 'James'],
        ]);
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Id')
                ->data('id'),

            Column::add('Pengajuan')
                ->data('name'),

            // Column::add('Waktu Pengajuan')
            //     ->data('send_time')
            //     ->dateFormat(),

            // Column::add('Status Pengajuan')
            //     ->data(''),
                
            // Column::add()
            //     ->actions(function(User $user) {
            //         return join([
            //             Button::edit('boilerplate.users.edit', $user),          
            //             Button::delete('boilerplate.users.edit', $user),          
            //         ]);
            //     }),
        ];
    }
}