<?php

namespace App\DataTables;

use App\Models\PmsInventoryBrandMaster;
use Yajra\DataTables\Services\DataTable;
use Common;

class BrandMasterDataTable extends DataTable
{
    public function ajax()
    {
        $brand_master = $this->query();

        return datatables()
            ->of($brand_master)

            ->addColumn('action', function ($brand_master) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_brand_master')) {

                    $edit = '<a href="' . url('admin/edit-brand-master/' . $brand_master->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_brand_master')) {
                    $delete = '<a href="' . url('admin/delete-brand-master/' . $brand_master->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }
                return $edit . $delete;
            })

           

            ->addColumn('created_at', function ($testimonials) {
                return dateFormat($testimonials->created_at);
            })
        ->make(true);
    }


    public function query()
    {
        $brand_master =PmsInventoryBrandMaster::select();
        return $this->applyScopes($brand_master);
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
