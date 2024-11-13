<?php

namespace App\DataTables;

use App\Models\{PmsHelpdesk,RoleAdmin,Roles, UserServiceRequest};
use Yajra\DataTables\Services\DataTable;
use Common,Auth;

class UserServiceRequestDataTable extends DataTable
{
    public function ajax()
    {
        $service_request = $this->query();

        return datatables()
            ->of($service_request)

            ->addColumn('action', function ($service_request) {
                $edit = $view = $delete = '' ;
                    $edit = '<a href="' . url('users/edit-service-request/' . $service_request->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                    $delete = '<a href="' . url('users/delete-service-request/' . $service_request->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                return $edit . $delete .$view;
            })
            ->addColumn('created_at', function ($service_request) {
                return dateFormat($service_request->created_at);
            })
        ->rawColumns(['action'])
        ->make(true);
    }


    public function query()
    {
        $service_request = UserServiceRequest::where('user_id',Auth::user()->id)->get();
        return $this->applyScopes($service_request);
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'issue',
            'description',
            'priority',
            'created_at'
        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
