<?php

namespace App\DataTables;

use App\Models\PmsRecurringService;
use Yajra\DataTables\Services\DataTable;
use Common;

class RecurringServiceMasterDataTable extends DataTable
{
    public function ajax()
    {
        $recurring_service_master = $this->query();

        return datatables()
            ->of($recurring_service_master)

            ->addColumn('action', function ($recurring_service_master) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_recurring_service_master')) {

                    $edit = '<a href="' . url('admin/edit-recurring-service-master/' . $recurring_service_master->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_recurring_service_master')) {
                    $delete = '<a href="' . url('admin/delete-recurring-service-master/' . $recurring_service_master->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }
                return $edit . $delete;
            })

           

            ->addColumn('created_at', function ($recurring_service_master) {
                return dateFormat($recurring_service_master->created_at);
            })
        ->make(true);
    }


    public function query()
    {

        $recurring_service_master = PmsRecurringService::join('pms_service_masters', function ($join) {
            $join->on('pms_recurring_services.service_id', '=', 'pms_service_masters.id');
         })->select(['pms_recurring_services.*', 'pms_service_masters.name as service_name']);



        // $sub_category_master =PmsServiceMaster::select();


        return $this->applyScopes($recurring_service_master);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'service_name',
            'duration_type',
            'duration_time',
            'price',
            'status',
            'created_at'
        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
