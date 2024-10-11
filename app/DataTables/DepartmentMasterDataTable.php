<?php

namespace App\DataTables;

use App\Models\PmsDepartmentMaster;
use Yajra\DataTables\Services\DataTable;
use Common;

class DepartmentMasterDataTable extends DataTable
{
    public function ajax()
    {
        $department_master = $this->query();

        return datatables()
            ->of($department_master)

            ->addColumn('action', function ($department_master) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_department_master')) {

                    $edit = '<a href="' . url('admin/edit-department-master/' . $department_master->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_department_master')) {
                    $delete = '<a href="' . url('admin/delete-department-master/' . $department_master->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }
                return $edit . $delete;
            })

           

            ->addColumn('created_at', function ($department_master) {
                return dateFormat($department_master->created_at);
            })
        ->make(true);
    }


    public function query()
    {
        $department_master =PmsDepartmentMaster::select();
        return $this->applyScopes($department_master);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'name',
            'description',
            'status',
            'created_at'
        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
