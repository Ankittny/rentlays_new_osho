<?php

namespace App\DataTables;

use App\Models\Accommodates;
use Yajra\DataTables\Services\DataTable;

class AccommodatesDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($Accommodates) {

                $edit = '<a href="' . url('admin/settings/edit-accommodates/' . $Accommodates->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/settings/delete-accommodates/' . $Accommodates->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = Accommodates::query();
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'accommodates_number', 'name' => 'accommodates.accommodates_number', 'title' => 'Accommodates'])
            ->addColumn(['data' => 'status', 'name' => ' accommodates.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'spacetypedatatables_' . time();
    }
}
