<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Designation;
use Validator, Cache, Common;
use App\DataTables\DesignationDataTable;

class DesignationController extends Controller
{
  
    public function index(DesignationDataTable $dataTable)
    {
        return $dataTable->render('admin.designation.index');
    }

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
                return view('admin.designation.add');
        } elseif ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'status' => 'required',
            ]);
            $designation = new Designation();
            $designation->name = $request->name;
            $designation->status = $request->status;
            $designation->save();
            Common::one_time_message('success', 'Added Successfully');
        }
        return redirect()->route('designation')->with('success', 'Designation added successfully');
    }

    public function update(Request $request, $id)
    {
        if (! $request->isMethod('post')) {
               $designation = Designation::find($request->id);
                return view('admin.designation.edit', compact('designation'));
        } elseif ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'status' => 'required',
            ]);

            $designation = Designation::findOrFail($id);
            $designation->name = $request->name;
            $designation->status = $request->status;
            $designation->save();
            Common::one_time_message('success', 'Updated Successfully');
        }
        return redirect()->route('designation')->with('success', 'Designation Updated successfully');
    }

    public function delete($id)
    {
        if (Designation::where('id', $id)->exists()) {
            $designation = Designation::findOrFail($id);
            $designation->delete();
            Common::one_time_message('success', 'Deleted Successfully');
            return redirect()->route('designation')->with('success', 'Designation deleted successfully');
        } else {
            return redirect()->route('designation')->with('error', 'Designation not found');
        }
    }
}

