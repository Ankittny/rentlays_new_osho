<?php

namespace App\DataTables;

use App\Models\PmsHelpdesk;
use App\Models\Properties;
use App\Models\RoleAdmin;
use App\Models\Roles;
use Yajra\DataTables\Services\DataTable;
use Request, Common;

class PmsnewrequestDatatable extends DataTable
{
    public function ajax()
    {
       
        $pms_new_request = $this->query();
        return datatables()
            ->of($pms_new_request)
            // ->addColumn('action', function ($pms_new_request) {
            //     $edit = '';
            //     if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_properties')) {
            //         $edit = '<a href="' . url('admin/listing/' . $pms_new_request->id) . '/basics" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
            //     }
            //     return $edit;
            // })
          
            ->addColumn('created_at', function ($pms_new_request) {
                return dateFormat($pms_new_request->created_at);
            })
            ->make(true);
    }

    public function query()
    {
        $user_role_id = RoleAdmin::getAll()->where('admin_id', Auth('admin')->user()->id)->first();
        $user_role = Roles::where('id', $user_role_id->role_id)->pluck('display_name');
        $pms_new_request = PmsHelpdesk::with('getHelpdesk:username,id','getSupervisor:username,id','property_name:name,id')
              ->where('status', 'New Task');
        if ($user_role[0] == 'supervisor') {
            $pms_new_request = $pms_new_request->where('assign_to_supervisor', Auth('admin')->user()->id);
        } else if ($user_role[0] == 'helpdesk') {
            $pms_new_request = $pms_new_request->where('helpdesk_user_id', Auth('admin')->user()->id);
        }
        // $status = isset(request()->status) ? request()->status : null;
        // $from = isset(request()->from) ? setDateForDb(request()->from) : null;
        // $to = isset(request()->to) ? setDateForDb(request()->to) : null;

        // if ($from) {
        //     $pms_new_request->whereDate('created_at', '>=', $from);
        // }
        // if ($to) {
        //     $pms_new_request->whereDate('created_at', '<=', $to);
        // }
        // if ($status) {
        //     $pms_new_request->where('status', '=', $status);
        // }
        return $this->applyScopes($pms_new_request);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'pms_helpdesks.id', 'title' => 'Id'])
            ->addColumn(['data' => 'description', 'name' => 'pms_helpdesks.description', 'title' => 'Description'])
            ->addColumn(['data' => 'name', 'name' => 'property_name.name', 'title' => 'Property Name'])
            ->addColumn(['data' => 'helpdesk_user_id', 'name' => 'pms_helpdesks.helpdesk_user_id', 'title' => 'Helpdesk User'])
            ->addColumn(['data' => 'status', 'name' => 'pms_helpdesks.status', 'title' => 'Status'])
            ->addColumn(['data' => 'assign_to_supervisor', 'name' => 'pms_helpdesks.assign_to_supervisor', 'title' => 'Assign To Supervisor'])
            ->addColumn(['data' => 'created_at', 'name' => 'pms_helpdesks.created_at', 'title' => 'Date'])
            ->parameters(dataTableOptions());
    }


    protected function filename()
    {
        return 'pmsnewrequestdatatables_' . time();
    }
}

