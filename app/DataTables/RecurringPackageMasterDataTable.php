<?php

namespace App\DataTables;

use App\Models\PmsRecurringPackage;
use Yajra\DataTables\Services\DataTable;
use Common;

class RecurringPackageMasterDataTable extends DataTable
{
    public function ajax()
    {
        $recurring_package_master = $this->query();

        return datatables()
            ->of($recurring_package_master)

            ->addColumn('action', function ($recurring_package_master) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_recurring_package_master')) {

                    $edit = '<a href="' . url('admin/edit-recurring-package-master/' . $recurring_package_master->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_recurring_package_master')) {
                    $delete = '<a href="' . url('admin/delete-recurring-package-master/' . $recurring_package_master->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }
                return $edit . $delete;
            })

           

            ->addColumn('created_at', function ($recurring_package_master) {
                return dateFormat($recurring_package_master->created_at);
            })
        ->make(true);
    }


    public function query()
    {
        $recurring_package_master =PmsRecurringPackage::select();
        return $this->applyScopes($recurring_package_master);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'package_name',           
            'price',
            'offer_price',
            'status',
            'created_at'

        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
