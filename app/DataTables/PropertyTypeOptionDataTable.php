<?php

namespace App\DataTables;

use App\Models\PropertyTypeoption;
use Yajra\DataTables\Services\DataTable;

class PropertyTypeOptionDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($PropertyTypeoption) {

                $edit = '<a href="' . url('admin/settings/edit-property-type-option/' . $PropertyTypeoption->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/settings/delete-property-type-option/' . $PropertyTypeoption->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = PropertyTypeoption::query();
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'name', 'name' => 'property_option_type.name', 'title' => 'Name'])
            ->addColumn(['data' => 'status', 'name' => ' property_option_type.status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'spacetypedatatables_' . time();
    }
}
