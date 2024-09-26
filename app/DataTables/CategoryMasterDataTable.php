<?php

namespace App\DataTables;

use App\Models\PmsInventoryCategoryMasters;
use Yajra\DataTables\Services\DataTable;
use Common;

class CategoryMasterDataTable extends DataTable
{
    public function ajax()
    {
        $category_master = $this->query();

        return datatables()
            ->of($category_master)

            ->addColumn('action', function ($category_master) {
                $edit = $delete = '';
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_category_master')) {

                    $edit = '<a href="' . url('admin/edit-category-master/' . $category_master->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_category_master')) {
                    $delete = '<a href="' . url('admin/delete-category-master/' . $category_master->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }
                return $edit . $delete;
            })

           

            ->addColumn('created_at', function ($category_master) {
                return dateFormat($category_master->created_at);
            })
        ->make(true);
    }


    public function query()
    {
        $category_master =PmsInventoryCategoryMasters::select();
        return $this->applyScopes($category_master);
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
