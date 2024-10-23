<?php

namespace App\DataTables;

use App\Models\PmsHistory;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
use App\Http\Helpers\Common;
use Auth;
use Carbon\Carbon;

class PmsRequestHistoryDataTable extends DataTable
{
  

    public function ajax()
    {
        $pms_new_request = $this->query();
        return datatables()
            ->of($pms_new_request)
            ->addColumn('action', function ($pms_new_request) {
                $view = '<a href="' . url('admin/pms-history/' . $pms_new_request->id) . '" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#view-pms-request" data-id="' . $pms_new_request->id . '"><i class="fa fa-eye"></i></a>&nbsp;';
                return $view;
            })
            ->addColumn('created_at', function ($pms_new_request) {
                return dateFormat($pms_new_request->created_at);
            })
            ->make(true);
    }

    public function query()
    {
        $pms_new_request = PmsHistory::where('pms_onboard_id',$this->id);
        $get_user_role =Common::get_roles(Auth::guard('admin')->user()->id);
        // dd($get_user_role);
        // if($get_user_role !='admin'){

        // }
        // $user_role_id = RoleAdmin::where('admin_id', Auth::guard('admin')->user()->id)->first();
        // $user_role = Roles::where('id', $user_role_id->role_id)->pluck('display_name')->first();
        // if ($user_role === 'supervisor') {
        //     $pms_new_request->where('assign_to_supervisor', Auth::guard('admin')->user()->id);
        // } elseif ($user_role === 'helpdesk') {
        //     $pms_new_request->where('helpdesk_user_id', Auth::guard('admin')->user()->id);
        // }elseif ($user_role === 'sitemanager'){
        //     $pms_new_request->where('assign_to_sitemanager', Auth::guard('admin')->user()->id);
        // }

        // Handle date filters
        // if ($from = request()->from) {
        //     $fromDate = setDateForDb($from);
        //     $pms_new_request->whereDate('created_at', '>=', $fromDate);
        // }

        // if ($to = request()->to) {
        //     $toDate = setDateForDb($to);
        //     $pms_new_request->whereDate('created_at', '<=', $toDate);
        // }

        // if ($status = request()->status) {
        //     $pms_new_request->where('status', '=', $status);
        // }

        return $this->applyScopes($pms_new_request);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Id'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Name'])
            ->addColumn(['data' => 'bedrooms', 'name' => 'bedrooms', 'title' => 'Bedrooms', 'orderable' => false, 'searchable' => false])  
            ->addColumn(['data' => 'beds', 'name' => 'beds', 'title' => 'Beds', 'orderable' => false, 'searchable' => false])  // Disable if sorting on related fields is not required
            ->addColumn(['data' => 'bathrooms', 'name' => 'bathrooms', 'title' => 'Bathrooms'])
            ->addColumn(['data' => 'property_square', 'name' => 'property_square', 'title' => 'Property Square', 'orderable' => false, 'searchable' => false])  // Same here
            ->addColumn(['data' => 'number_of_floor', 'name' => 'number_of_floor', 'title' => 'Number of floor', 'orderable' => false, 'searchable' => false])  // Same here
            ->addColumn(['data' => 'number_of_rooms', 'name' => 'number_of_rooms', 'title' => 'Number of rooms', 'orderable' => false, 'searchable' => false])  // Same here
            ->addColumn(['data' => 'booking_type', 'name' => 'booking_type', 'title' => 'Booking Type', 'orderable' => false, 'searchable' => false])  // Same here
            ->addColumn(['data' => 'cancellation', 'name' => 'cancellation', 'title' => 'Cancellation', 'orderable' => false, 'searchable' => false])  // Same here
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status', 'orderable' => false, 'searchable' => false])  // Same here
            ->addColumn(['data' => 'created_at', 'name' => 'created_at', 'title' => 'Date'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }
    

    protected function filename()
    {
        return 'pmsnewrequestdatatables_' . time();
    }
}

