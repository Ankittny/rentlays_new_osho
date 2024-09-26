<?php

namespace App\DataTables;

use App\Models\{PmsHelpdesk,RoleAdmin,Roles};
use Yajra\DataTables\Services\DataTable;
use Common,Auth;

class ServiceRequestDataTable extends DataTable
{
    public function ajax()
    {
        $service_request = $this->query();

        return datatables()
            ->of($service_request)

            ->addColumn('action', function ($service_request) {
                $edit = $view = $delete = '' ;
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_service_request')) {
                    $edit = '<a href="' . url('admin/edit-service-request/' . $service_request->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_service_request')) {
                    $delete = '<a href="' . url('admin/delete-service-request/' . $service_request->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }

                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'service_request_view')) {
                    $view = '<a href="' . url('admin/service-request-view/' . $service_request->id) . '" class="btn btn-xs black bg-darken-4"><i class="fa fa-eye" aria-hidden="true"></i> ';
                }
                return $edit . $delete .$view;
            })

         

            ->addColumn('created_at', function ($service_request) {
                return dateFormat($service_request->created_at);
            })

         
        ->rawColumns(['action','review'])
        ->make(true);
    }


    public function query()
    {
        $role_id = RoleAdmin::getAll()->where('admin_id', Auth::guard('admin')->user()->id)->first();
         $service_request = PmsHelpdesk::join('properties', function ($join) {
            $join->on('pms_helpdesks.property_id', '=', 'properties.id');
        })->join('admin', function ($join) {
            $join->on('pms_helpdesks.assign_to_supervisor', '=', 'admin.id');
            
        })->join('role_admin', function ($join) {
            $join->on('admin.id', '=', 'role_admin.admin_id');
            
        })->leftJoin('admin as a', function ($join) {
            $join->on('pms_helpdesks.assign_to_sitemanager', '=', 'a.id');
            
        });
        $role = Roles::find($role_id->role_id)->name;
        if ($role != 'admin') {
            $service_request = $service_request->where('pms_helpdesks.assign_to_supervisor', $role_id->admin_id);
        }
        return $this->applyScopes($service_request->select([
        'pms_helpdesks.*', 
        'properties.name as properties_name',
        'admin.username as assign_to_supervisor',
        'a.username as assign_to_sitemanager'
        ]));
        return $this->applyScopes($service_request);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'properties_name',
            'issue',
            'description',
            'priority',
            'assign_to_supervisor',
            'assign_to_sitemanager',
            'status',
            'created_at'

        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
