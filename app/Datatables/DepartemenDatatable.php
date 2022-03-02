<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\departemen;
use DB;

class DepartemenDatatable extends Datatable
{
    public $slug = 'departemen';

    public function datasource()
    {
        $depart = departemen::leftJoin('users', 'users.id', 'departemens.reviewerdep_id')->where('status', 1)->get(['departemens.id', 'kode', 'departemen', DB::raw('concat(first_name, " ", last_name) as nama')]);

        return $depart;
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add('Id')
                ->data('id'),

            Column::add('Kode')
                ->data('kode'),
            
            Column::add('Departemen')
                ->data('departemen'),

            Column::add('Reviewer Departemen')
                ->data('nama'),
                
            Column::add()
                ->actions(function(departemen $departemen) {
                        return join([
                        Button::edit('boilerplate.edit-departemen', $departemen->id),          
                    ]);
                    
                }),
        ];
    }
}