<?php

namespace App\DataTables;

use App\Models\Admin;
use App\Models\PmsHelpdesk;
use App\Models\PmsInventoryProducts;
use App\Models\PmsJobs;
use Yajra\DataTables\Services\DataTable;
use Common;
use Illuminate\Support\Facades\Auth;

class PmsJobDataTable extends DataTable
{
    public function ajax()
    {
        $pms_job = $this->query();
        return datatables()
            ->of($pms_job)
            ->addColumn('action', function ($pms_job) {
                $edit =  $delete = '' ;
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'edit_pms_job')) {
                    $edit = '<a href="' . url('admin/edit-pms-job/' . $pms_job->id).'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                }
                if (Common::has_permission(\Auth::guard('admin')->user()->id, 'delete_pms_job')) {
                    $delete = '<a href="' . url('admin/delete-pms-job/' . $pms_job->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';
                }

                return $edit . $delete ;
            })

         

            ->addColumn('created_at', function ($pms_job) {
                return dateFormat($pms_job->created_at);
            })

         
        ->rawColumns(['action','review'])
        ->make(true);
    }


    public function query()
    {
        $user = \Auth::guard('admin')->user();
        $pms_job = PmsJobs::join('properties', function ($join) {
            $join->on('pms_jobs.property_id', '=', 'properties.id');
        })->join('pms_helpdesks', function ($join) {
            $join->on('pms_jobs.helpdesk_id', '=', 'pms_helpdesks.id');
        })->join('admin as a', function ($join) {
            $join->on('pms_jobs.user_id', '=', 'a.id');
        });
        if (($user->username != 'admin') && ($user->username != 'pms') && ($user->username != 'help')) {
            $help_desk_user = Admin::where('pincode', $user->pincode)->pluck('id')->toArray();
            $pms_job = $pms_job->whereIn('pms_helpdesks.assign_to_sitemanager', $help_desk_user)->whereIn('pms_helpdesks.assign_to_supervisor', $help_desk_user);
        }

        return $this->applyScopes($pms_job->select([
            'pms_jobs.*',
            'properties.name as properties_name',
            'pms_helpdesks.issue as helpdesk_name',
            'a.username as assign_to_sitemanager'
        ]));
    }

    public function html()
    {
        return $this->builder()
        ->columns([
            'id',
            'properties_name',
            'assign_to_sitemanager',
            'helpdesk_name',
            'type',
            'start_time',
            'end_time',
            'start_time_otp',
            'end_time_otp',
            'price',
            'status',
            'created_at'

        ])
        ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
        ->parameters(dataTableOptions());
    }
}
