<?php

namespace App\DataTables;

use App\Models\PmsHelpdesk;
use App\Models\RoleAdmin;
use App\Models\Roles;
use Yajra\DataTables\Services\DataTable;
use Common;
use Auth;

class PmsnewrequestDatatable extends DataTable
{
    public function ajax()
    {
        $pms_new_request = $this->query();
        return datatables()
            ->of($pms_new_request)
            // ->addColumn('action', function ($pms_new_request) {
            //     $edit = '';
            //     if (Common::has_permission(Auth::guard('admin')->user()->id, 'edit_properties')) {
            //         $edit = '<a href="' . url('admin/listing/' . $pms_new_request->id . '/basics') . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
            //     }
            //     return $edit;
            // })
            ->addColumn('getSupervisor.username', function ($pms_new_request) {
                return $pms_new_request->getSupervisor ? $pms_new_request->getSupervisor->username : 'Not Assigned';
            })
            ->addColumn('getHelpdesk.username', function ($pms_new_request) {
                return $pms_new_request->getHelpdesk ? $pms_new_request->getHelpdesk->username : 'Not Assigned';
            })
            ->addColumn('created_at', function ($pms_new_request) {
                return dateFormat($pms_new_request->created_at);
            })
            ->make(true);
    }

    public function query()
    {
        $user_role_id = RoleAdmin::where('admin_id', Auth::guard('admin')->user()->id)->first();
        if (!$user_role_id) {
            return PmsHelpdesk::where('status', 'New Task');
        }

        $user_role = Roles::where('id', $user_role_id->role_id)->pluck('display_name')->first();
        $pms_new_request = PmsHelpdesk::with(['getHelpdesk:username,id', 'getSupervisor:username,id', 'property_name:name,id'])
        ->where('status', 'New Task');

        if ($user_role === 'supervisor') {
            $pms_new_request->where('assign_to_supervisor', Auth::guard('admin')->user()->id);
        } elseif ($user_role === 'helpdesk') {
            $pms_new_request->where('helpdesk_user_id', Auth::guard('admin')->user()->id);
        }

        // Handle date filters
        if ($from = request()->from) {
            $fromDate = setDateForDb($from);
            $pms_new_request->whereDate('created_at', '>=', $fromDate);
        }

        if ($to = request()->to) {
            $toDate = setDateForDb($to);
            $pms_new_request->whereDate('created_at', '<=', $toDate);
        }

        if ($status = request()->status) {
            $pms_new_request->where('status', '=', $status);
        }

        return $this->applyScopes($pms_new_request);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => 'Description'])
            ->addColumn(['data' => 'property_name.name', 'name' => 'property_name.name', 'title' => 'Property Name', 'orderable' => false, 'searchable' => false])  // Disable ordering/searching if necessary
            ->addColumn(['data' => 'getHelpdesk.username', 'name' => 'getHelpdesk.username', 'title' => 'Helpdesk User', 'orderable' => false, 'searchable' => false])  // Disable if sorting on related fields is not required
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'getSupervisor.username', 'name' => 'getSupervisor.username', 'title' => 'Assign To Supervisor', 'orderable' => false, 'searchable' => false])  // Same here
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Date'])
            // ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }
    

    protected function filename()
    {
        return 'pmsnewrequestdatatables_' . time();
    }
}

