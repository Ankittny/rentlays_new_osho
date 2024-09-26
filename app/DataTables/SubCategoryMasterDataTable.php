<?php

namespace App\DataTables;

use App\Models\PmsInventorySubcategoryMasters;
use Yajra\DataTables\Services\DataTable;
use Common;

class SubCategoryMasterDataTable extends DataTable
{
    public function ajax()
    {
        $sub_category_master = $this->query();

        return datatables()
            ->of($sub_category_master)

            ->addColumn('action', function ($sub_category_master) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_sub_category_master')) {

                    $edit = '<a href="' . url('admin/edit-sub-category-master/' . $sub_category_master->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_sub_category_master')) {
                    $delete = '<a href="' . url('admin/delete-sub-category-master/' . $sub_category_master->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
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

        $sub_category_master = PmsInventorySubcategoryMasters::join('pms_inventory_category_masters', function ($join) {
            $join->on('pms_inventory_subcategory_masters.category_id', '=', 'pms_inventory_category_masters.id');
         })->select(['pms_inventory_subcategory_masters.*', 'pms_inventory_category_masters.name as cate_name']);



        // $sub_category_master =PmsInventorySubcategoryMasters::select();


        return $this->applyScopes($sub_category_master);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'cate_name',

            'name',
            'description',
            'status',
            'created_at'

        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
