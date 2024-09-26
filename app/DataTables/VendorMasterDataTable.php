<?php

namespace App\DataTables;

use App\Models\PmsVendorMaster;
use Yajra\DataTables\Services\DataTable;
use Common;

class VendorMasterDataTable extends DataTable
{
    public function ajax()
    {
        $vendor_master = $this->query();

        return datatables()
            ->of($vendor_master)

            ->addColumn('action', function ($vendor_master) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_vendor_master')) {
                    $edit = '<a href="' . url('admin/edit-vendor-master/' . $vendor_master->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_vendor_master')) {
                    $delete = '<a href="' . url('admin/delete-vendor-master/' . $vendor_master->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }
                return $edit . $delete;
            })

       
            ->addColumn('created_at', function ($vendor_master) {
                return dateFormat($vendor_master->created_at);
            })

       
        ->rawColumns(['action','review'])
        ->make(true);
    }


    public function query()
    {
        $vendor_master =PmsVendorMaster::select();
        return $this->applyScopes($vendor_master);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'name',
          
            'description',
           'image',
            'status',
            'created_at'

        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
