<?php

namespace App\DataTables;

use App\Models\PmsServiceMaster;
use Yajra\DataTables\Services\DataTable;
use Common;

class ServiceMasterDataTable extends DataTable
{
    public function ajax()
    {
        $sub_category_master = $this->query();

        return datatables()
            ->of($sub_category_master)

            ->addColumn('action', function ($sub_category_master) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_service_master')) {

                    $edit = '<a href="' . url('admin/edit-service-master/' . $sub_category_master->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_service_master')) {
                    $delete = '<a href="' . url('admin/delete-service-master/' . $sub_category_master->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }
                return $edit . $delete;
            })

           

            ->addColumn('created_at', function ($sub_category_master) {
                return dateFormat($sub_category_master->created_at);
            })
        ->make(true);
    }


    public function query()
    {

        $sub_category_master = PmsServiceMaster::join('pms_department_masters', function ($join) {
            $join->on('pms_service_masters.department_id', '=', 'pms_department_masters.id');
         })->select(['pms_service_masters.*', 'pms_department_masters.name as department_name']);
        return $this->applyScopes($sub_category_master);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'department_name',

            'name',
            'description',
            'status',
            'created_at'

        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
