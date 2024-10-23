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
            ->addColumn('action', function ($pms_new_request) {
                $view = '<a href="' . url('admin/view-pms-request/' . $pms_new_request->id) . '" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#view-pms-request" data-id="' . $pms_new_request->id . '"><i class="fa fa-eye"></i></a>&nbsp;';
                return $view;
            })
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

        // Subquery to get the latest entry for each pms_onboard_id from pms_history
        $subQuery = \DB::table('pms_history as ph1')
            ->select('ph1.pms_onboard_id', 'ph1.status', 'ph1.created_at')
            ->whereRaw('ph1.created_at = (select MAX(ph2.created_at) from pms_history as ph2 where ph2.pms_onboard_id = ph1.pms_onboard_id)');

        // Main query
        $pms_new_request = PmsHelpdesk::with(['getHelpdesk:username,id', 'getSupervisor:username,id', 'property_name:name,id'])
            ->leftJoinSub($subQuery, 'pms_history', function($join) {
                $join->on('pms_helpdesks.id', '=', 'pms_history.pms_onboard_id');
            })
            ->selectRaw('pms_helpdesks.*, IF(pms_history.status IS NOT NULL, pms_history.status, pms_helpdesks.status) as final_status')
            ->where('pms_helpdesks.status', 'New Task');
        
        // Role-based filtering
        if ($user_role === 'supervisor') {
            $pms_new_request->where('pms_helpdesks.assign_to_supervisor', Auth::guard('admin')->user()->id);
        } elseif ($user_role === 'helpdesk') {
            $pms_new_request->where('pms_helpdesks.helpdesk_user_id', Auth::guard('admin')->user()->id);
        } elseif ($user_role === 'sitemanager') {
            $pms_new_request->where('pms_helpdesks.assign_to_sitemanager', Auth::guard('admin')->user()->id); 
        }

        // Date filters
        if ($from = request()->from) {
            $fromDate = setDateForDb($from);
            $pms_new_request->whereDate('pms_helpdesks.created_at', '>=', $fromDate);
        }

        if ($to = request()->to) {
            $toDate = setDateForDb($to);
            $pms_new_request->whereDate('pms_helpdesks.created_at', '<=', $toDate);
        }

        // Status filter
        if ($status = request()->status) {
            $pms_new_request->where('pms_helpdesks.status', '=', $status);
        }

        return $this->applyScopes($pms_new_request);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'description', 'name' => 'description', 'title' => 'Description'])
            ->addColumn(['data' => 'property_name.name', 'name' => 'property_name.name', 'title' => 'Property Name', 'orderable' => false, 'searchable' => false])
            ->addColumn(['data' => 'getHelpdesk.username', 'name' => 'getHelpdesk.username', 'title' => 'Helpdesk User', 'orderable' => false, 'searchable' => false])
            ->addColumn(['data' => 'final_status', 'name' => 'final_status', 'title' => 'Status'])
            ->addColumn(['data' => 'getSupervisor.username', 'name' => 'getSupervisor.username', 'title' => 'Assign To Supervisor', 'orderable' => false, 'searchable' => false])
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Date'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'pmsnewrequestdatatables_' . time();
    }
}


