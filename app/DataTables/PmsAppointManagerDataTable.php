<?php

namespace App\DataTables;

use App\Models\PmsAppointManager;
use Yajra\DataTables\Services\DataTable;

class PmsAppointManagerDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('action', function ($appointManager) {
                $edit = '<a href="' . url('admin/edit-appoint-managers/' . $appointManager->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/delete-appoint-managers/' . $appointManager->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                
                return $edit . ' ' . $delete;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function query()
    {
        $query = PmsAppointManager::join('admin', 'pms_appoint_managers.assign_by_id', '=', 'admin.id')
            ->join('admin as a', 'pms_appoint_managers.assign_to_id', '=', 'a.id')
            ->select('admin.username', 'a.username as assign_to', 'pms_appoint_managers.city', 'pms_appoint_managers.*');
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'admin.id', 'title' => 'SrNo.'])
            ->addColumn(['data' => 'username', 'name' => 'admin.username', 'title' => 'Assigned By'])
            ->addColumn(['data' => 'assign_to', 'name' => 'a.username', 'title' => 'Assigned To'])
            ->addColumn(['data' => 'city', 'name' => 'pms_appoint_managers.city', 'title' => 'City'])
            ->addColumn(['data' => 'map_address', 'name' => 'pms_appoint_managers.map_address', 'title' => 'Map Address'])
            ->addColumn(['data' => 'pin_code', 'name' => 'pms_appoint_managers.pin_code', 'title' => 'Pin Code'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'pmsappointmanager_' . time();
    }
}
