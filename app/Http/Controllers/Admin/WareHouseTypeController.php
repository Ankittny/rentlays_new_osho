<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\WareHouseTypeDataTable;
use Illuminate\Http\Request;
use App\Models\Warehouetype;
use Validator, Cache, Common;

class WareHouseTypeController extends Controller
{
    public function index(WareHouseTypeDataTable $dataTable)
    {
        return $dataTable->render('admin.warehousetype.index');
    }
    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
             return view('admin.warehousetype.add');
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'name'           => 'required|max:25',
                    'description'    => 'required',
                    'status'         => 'required'
                    );

            $fieldNames = array(
                        'name'              => 'Name',
                        'description'       => 'Description',
                        'status'            => 'Status'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $warehouse                = new warehouetype;
                $warehouse->name          = $request->name;
                $warehouse->description   = $request->description;
                $warehouse->status        = $request->status;
                $warehouse->save();
                Cache::forget(config('cache.prefix') . '.property.types.warehouse');
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/ware-house-type');
            }
        }
    }
    public function update(Request $request)
    {
        if (! $request->isMethod('post')) {
             $data['result'] = warehouetype::find($request->id);
             return view('admin.warehousetype.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'name'           => 'required|max:25',
                    'description'    => 'required',
                    'status'         => 'required'
                    );

            $fieldNames = array(
                        'name'              => 'Name',
                        'description'       => 'Description',
                        'status'            => 'Status'
                        );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $warehouse  = warehouetype::find($request->id);
                $warehouse->name          = $request->name;
                $warehouse->description   = $request->description;
                $warehouse->status        = $request->status;
                $warehouse->save();

                Cache::forget(config('cache.prefix') . '.property.types.warehouse');
                Common::one_time_message('success', 'Updated Successfully');

                return redirect('admin/settings/ware-house-type');
            }
        }
    }

    public function delete(Request $request)
    {
        warehouetype::find($request->id)->delete();
        Cache::forget(config('cache.prefix') . '.property.types.space');
        Common::one_time_message('success', 'Deleted Successfully');

        return redirect('admin/settings/ware-house-type');
    }
}
