<?php

namespace App\DataTables;

use App\Models\warehouetype;
use Yajra\DataTables\Services\DataTable;

class WareHouseTypeDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($warehouetype) {

                $edit = '<a href="' . url('admin/settings/edit-ware-house-type/' . $warehouetype->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/settings/delete-where-house-type/' . $warehouetype->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = warehouetype::query();
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'ware_house_type.name', 'title' => 'Name'])
            ->addColumn(['data' => 'description', 'name' => 'ware_house_type.description', 'title' => 'Description'])
            ->addColumn(['data' => 'status', 'name' => 'ware_house_type.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'spacetypedatatables_' . time();
    }
}
