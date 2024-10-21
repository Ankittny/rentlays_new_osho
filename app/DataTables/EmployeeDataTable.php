<?php

namespace App\DataTables;

use App\Models\Employee;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;
use App\Models\RoleAdmin;

class EmployeeDataTable extends DataTable
{
    public function ajax()
    {
        return datatables()
            ->eloquent($this->query())
            ->addColumn('pancard_image', function ($employee) {
                if ($employee->pancard_image) {
                    return '<a href="' . $employee->pancard_image . '" download>
                                <img src="' . $employee->pancard_image . '" alt="Pan Card" style="width: 50px; height: 50px;"/>
                            </a>';
                }
                return 'No Image';
            })
            ->addColumn('aadhar_front_image', function ($employee) {
                if ($employee->aadhar_front_image) {
                    return '<a href="' . $employee->aadhar_front_image . '" download>
                                <img src="' . $employee->aadhar_front_image . '" alt="Pan Card" style="width: 50px; height: 50px;"/>
                            </a>';
                }
                return 'No Image';
            })
            ->addColumn('aadhar_back_image', function ($employee) {
                if ($employee->aadhar_back_image) {
                    return '<a href="' . $employee->aadhar_back_image . '" download>
                                <img src="' . $employee->aadhar_back_image . '" alt="Pan Card" style="width: 50px; height: 50px;"/>
                            </a>';
                }
                return 'No Image';
            })
            ->addColumn('action', function ($employee) {

                $edit = '<a href="' . url('admin/edit-employee/' . $employee->id) . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i></a>&nbsp;';
                $delete = '<a href="' . url('admin/delete-employee/' . $employee->id) . '" class="btn btn-xs btn-danger delete-warning"><i class="fa fa-trash"></i></a>';

                return $edit . ' ' . $delete;
            })
            ->rawColumns(['pancard_image', 'action','aadhar_back_image','aadhar_front_image'])
            ->make(true);
    }

    public function query()
    {
        $query = Employee::query();
        $role_id = RoleAdmin::getAll()->where('admin_id', Auth::guard('admin')->user()->id)->first();
        if($role_id->role_id != 1){
            $query->where('supervisor_id', $role_id->admin_id);
        }
        return $this->applyScopes($query);
    }

    public function html()
    {
        return $this->builder()
            ->addColumn(['data' => 'id', 'name' => 'id', 'title' => 'Sr no'])
            ->addColumn(['data' => 'name', 'name' => 'name', 'title' => 'Name'])
            ->addColumn(['data' => 'email', 'name' => 'email', 'title' => 'Email'])
            ->addColumn(['data' => 'pincode', 'name' => 'pincode', 'title' => 'Pincode'])
            ->addColumn(['data' => 'aadhar_front_image', 'name' => 'aadhar_front_image', 'title' => 'Aadhar Front Image'])
            ->addColumn(['data' => 'aadhar_back_image', 'name' => 'aadhar_back_image', 'title' => 'Aadhar Back Image'])
            ->addColumn(['data' => 'pancard_image', 'name' => 'pancard_image', 'title' => 'Pan Card Image'])
            ->addColumn(['data' => 'joining_date', 'name' => 'joining_date', 'title' => 'Joining Date'])
            ->addColumn(['data' => 'date_of_end', 'name' => 'date_of_end', 'title' => 'Date of End'])
            ->addColumn(['data' => 'status', 'name' => 'status', 'title' => 'Status'])
            ->addColumn(['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false])
            ->parameters(dataTableOptions());
    }

    protected function filename()
    {
        return 'spacetypedatatables_' . time();
    }
}

