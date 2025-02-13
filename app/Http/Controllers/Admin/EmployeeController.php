<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\EmployeeDataTable;
use App\Models\Employee;
use App\Models\RoleAdmin;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Admin;
use App\Models\Properties;
use Auth ,App\Http\Helpers\Common;

class EmployeeController extends Controller
{
    public function index(EmployeeDataTable $dataTable)
    {
        return $dataTable->render('admin.employee.index');
    }

   

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
            $deparment_list = \App\Models\PmsDepartmentMaster::all();
            $properties = Properties::whereIn('for_property',['pms','pmsandrentlays'])->get();
            return view('admin.employee.add',compact('deparment_list','properties'));
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'nullable|email|unique:employees,email|unique:users,email',
                'property_id'=>'required',
                'mobile' => 'required',
                'address' => 'required',
                'pan_photo' => 'required|image',
                'pincode' => 'required',
                'designation_id' => 'required',
                'aadhaar_front' => 'required|image',
                'aadhaar_back' => 'required|image',
                'date_of_joining' => 'required|date',
                'date_of_end' => 'nullable|date',
                'password' => 'required',
                'status' => 'required',
            ]);
    
            $employee = new \App\Models\Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->mobile;
            $employee->supervisor_id = $request->supervisor_id;
            $employee->property_id = $request->property_id;
            $employee->address = $request->address;
            $employee->password = bcrypt($request->password);
            if ($request->hasFile('pan_photo')) {
                $panPhoto = $request->file('pan_photo');
                $panPhotoName = uniqid() . '_' . $panPhoto->getClientOriginalName();
                $panPhoto->move(public_path('images'), $panPhotoName);
                $employee->pancard_image = url('images/' . $panPhotoName);
            }
            if ($request->hasFile('aadhaar_front')) {
                $aadhaarFront = $request->file('aadhaar_front');
                $aadhaarFrontName = uniqid() . '_' . $aadhaarFront->getClientOriginalName();
                $aadhaarFront->move(public_path('images'), $aadhaarFrontName);
                $employee->aadhar_front_image = url('images/' . $aadhaarFrontName);
            }
            if ($request->hasFile('aadhaar_back')) {
                $aadhaarBack = $request->file('aadhaar_back');
                $aadhaarBackName = uniqid() . '_' . $aadhaarBack->getClientOriginalName();
                $aadhaarBack->move(public_path('images'), $aadhaarBackName);
                $employee->aadhar_back_image = url('images/' . $aadhaarBackName);
            }
            $employee->pincode = $request->pincode;
            $employee->designation_id = $request->designation_id;
            $employee->joining_date = $request->date_of_joining;
            $employee->date_of_end = $request->date_of_end;
            $employee->status = $request->status;
            $employee->save();
            $admin = new Admin;
            $admin->user_id =  Auth('admin')->user()->id;
            $admin->employee_id = $employee->id;
            $admin->username = $request->name;
            $admin->email    = $request->email;
            $admin->pincode  = $request->pincode;
            $admin->password = bcrypt($request->password);
            $admin->status   = !empty($request->status) ? $request->status : 'Active';
            $admin->save();
            RoleAdmin::insert(['admin_id' => $admin->id, 'role_id' => 7]);
            Cache::forget(config('cache.prefix') . '.role_admin');
            Common::one_time_message('success', 'Employee created successfully');
            return redirect()->route('employee')->with('success', 'Employee created successfully');
        }
    }
    
    
    public function update(Request $request, \App\Models\Employee $employee)
    {
        if (! $request->isMethod('post')) {
            $employee = \App\Models\Employee::find($request->id);
            $properties = Properties::whereIn('for_property',['pms','pmsandrentlays'])->get();
            $deparment_list = \App\Models\PmsDepartmentMaster::all();
            return view('admin.employee.edit', compact('employee','deparment_list','properties'));
        } elseif ($request->isMethod('post')) {
            $request->validate([
                'name' => 'required',
                'email' => 'nullable|email|unique:employees,email,' . $request->id . '|unique:users,email,' . $request->id,
                'mobile' => 'required',
                'property_id'=>'required',
                'address' => 'required',
                'pincode' => 'required',
                'designation_id' => 'required',
                'date_of_joining' => 'required|date',
                'date_of_end' => 'nullable|date',
                'status' => 'required',
            ]);
            // Update fields
            $employee = \App\Models\Employee::find($request->id);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->mobile;
            $employee->property_id = $request->property_id;
            $employee->address = $request->address;
            $employee->supervisor_id = $request->supervisor_id;
            if ($request->filled('password')) {
                $employee->password = bcrypt($request->password);
            }
            if ($request->hasFile('pan_photo')) {
                // Delete old PAN photo if it exists
                if ($employee->pan_photo && file_exists(public_path(parse_url($employee->pan_photo, PHP_URL_PATH)))) {
                    unlink(public_path(parse_url($employee->pan_photo, PHP_URL_PATH)));
                }
                // Save new PAN photo
                $panPhoto = $request->file('pan_photo');
                $panPhotoName = uniqid() . '_' . $panPhoto->getClientOriginalName();
                $panPhoto->move(public_path('images'), $panPhotoName);
                $employee->pancard_image = url('images/' . $panPhotoName);
            }
            // Handle Aadhaar front update
            if ($request->hasFile('aadhaar_front')) {
                // Delete old Aadhaar front if it exists
                if ($employee->aadhar_front_image && file_exists(public_path(parse_url($employee->aadhar_front_image, PHP_URL_PATH)))) {
                    unlink(public_path(parse_url($employee->aadhar_front_image, PHP_URL_PATH)));
                }
    
                // Save new Aadhaar front
                $aadhaarFront = $request->file('aadhaar_front');
                $aadhaarFrontName = uniqid() . '_' . $aadhaarFront->getClientOriginalName();
                $aadhaarFront->move(public_path('images'), $aadhaarFrontName);
                $employee->aadhar_front_image = url('images/' . $aadhaarFrontName);
            }
            // Handle Aadhaar back update
            if ($request->hasFile('aadhaar_back')) {
                // Delete old Aadhaar back if it exists
                if ($employee->aadhar_back_image && file_exists(public_path(parse_url($employee->aadhar_back_image, PHP_URL_PATH)))) {
                    unlink(public_path(parse_url($employee->aadhar_back_image, PHP_URL_PATH)));
                }
                // Save new Aadhaar back
                $aadhaarBack = $request->file('aadhaar_back');
                $aadhaarBackName = uniqid() . '_' . $aadhaarBack->getClientOriginalName();
                $aadhaarBack->move(public_path('images'), $aadhaarBackName);
                $employee->aadhar_back_image = url('images/' . $aadhaarBackName);
            }
            $employee->pincode = $request->pincode;
            $employee->designation_id = $request->designation_id;
            $employee->joining_date = $request->date_of_joining;
            $employee->date_of_end = $request->date_of_end;
            $employee->status = $request->status;
            $employee->save();
            \App\Models\Admin::updateOrCreate(
                ['employee_id' => $request->id],
                [
                    'username' => $request->name,
                    'email' => $request->email,
                    'pincode' => $request->pincode,
                    'status' => !empty($request->status) ? $request->status :'Active',
                    'password' => isset($request->password) ? bcrypt($request->password) : \App\Models\Employee::where('id',$request->id)->value('password'),
                ]
            );
            // if ($admin = \App\Models\Admin::where('employee_id',$request->id)->first()) {
            //     $admin->delete();
            // }
            Common::one_time_message('success', 'Employee updated successfully');
            return redirect()->route('employee')->with('success', 'Employee updated successfully');
        }
    }
    
    public function delete($id)
    {
        if (Employee::where('id', $id)->exists()) {
            $employee = Employee::findOrFail($id);
            // Delete user from users table
            if (Admin::where('employee_id', $employee->id)->exists()) {
                Admin::where('employee_id', $employee->id)->delete();
            }
            $employee->delete();
            Common::one_time_message('success', 'Deleted Successfully');
            return redirect()->route('employee')->with('success', 'Employee deleted successfully');
        } else {
            return redirect()->route('employee')->with('error', 'Employee not found');
        }
    }
}

