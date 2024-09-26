<?php

namespace App\DataTables;

use App\Models\PmsHelpdesk;
use App\Models\PmsInventoryProducts;

use Yajra\DataTables\Services\DataTable;
use Common;

class PmsInventoryDataTable extends DataTable
{
    public function ajax()
    {
        $pms_inventory = $this->query();

        return datatables()
            ->of($pms_inventory)

            ->addColumn('action', function ($pms_inventory) {
                $edit = $view = $delete = '' ;
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_pms_inventory')) {
                    $edit = '<a href="' . url('admin/edit-pms-inventory/' . $pms_inventory->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_pms_inventory')) {
                    $delete = '<a href="' . url('admin/delete-pms-inventory/' . $pms_inventory->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }

                return $edit . $delete ;
            })

         

            ->addColumn('created_at', function ($pms_inventory) {
                return dateFormat($pms_inventory->created_at);
            })

         
        ->rawColumns(['action','review'])
        ->make(true);
    }


    public function query()
    {
      
         $pms_inventory = PmsInventoryProducts::join('pms_inventory_brand_masters', function ($join) {
            $join->on('pms_inventory_products.brand_id', '=', 'pms_inventory_brand_masters.id');
       
        })->join('pms_inventory_category_masters', function ($join) {
            $join->on('pms_inventory_products.category_id', '=', 'pms_inventory_category_masters.id');
            
        })->join('pms_inventory_subcategory_masters', function ($join) {
            $join->on('pms_inventory_products.sub_category_id', '=', 'pms_inventory_subcategory_masters.id');
            
        })->join('admin as a', function ($join) {
            $join->on('pms_inventory_products.user_id', '=', 'a.id');
            
        })
        
        ->select(['pms_inventory_products.*', 'pms_inventory_brand_masters.name as brand_name','pms_inventory_category_masters.name as category_name', 'pms_inventory_subcategory_masters.name as sub_category_name',  'a.username as assign_to_sitemanager'  ]);
                
        return $this->applyScopes($pms_inventory);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'assign_to_sitemanager',
            'brand_name',
            'category_name',
            'sub_category_name',
            'description',
            'price',
            'qty',
            'sku',
            'status',
            'created_at'

        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
