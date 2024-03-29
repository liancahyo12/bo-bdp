<?php

namespace App\Datatables;

use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;
use App\Models\rek_user;
use Auth;

class RekUserDatatable extends Datatable
{
    public $slug = 'rek-user';

    public function datasource()
    {
    }

    public function setUp()
    {
    }

    public function columns(): array
    {
        return [
            Column::add()
                ->width('20px')
                ->actions(function () {
                    return join([
                        Button::add()->icon('pencil-alt')->color('primary')->make(),
                    ]);
                }),
        ];
    }
}