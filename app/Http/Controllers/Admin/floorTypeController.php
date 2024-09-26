<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\DataTables\FloorTypeDataTable;
use Illuminate\Http\Request;
use App\Models\FloorType;
use Validator, Cache, Common;

class floorTypeController extends Controller
{
    public function index(FloorTypeDataTable $dataTable)
    {
        return $dataTable->render('admin.FloorType.index');
    }
    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
             return view('admin.FloorType.add');
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
                $FloorType                = new FloorType;
                $FloorType->name          = $request->name;
                $FloorType->description   = $request->description;
                $FloorType->status        = $request->status;
                $FloorType->save();
                Cache::forget(config('cache.prefix') . '.property.types.floortype');
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/floor-type');
            }
        }
    }
    public function update(Request $request)
    {
        if (! $request->isMethod('post')) {
             $data['result'] = FloorType::find($request->id);
             return view('admin.FloorType.edit', $data);
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
                $FloorType  = FloorType::find($request->id);
                $FloorType->name          = $request->name;
                $FloorType->description   = $request->description;
                $FloorType->status        = $request->status;
                $FloorType->save();

                Cache::forget(config('cache.prefix') . '.property.types.warehouse');
                Common::one_time_message('success', 'Updated Successfully');

                return redirect('admin/settings/floor-type');
            }
        }
    }

    public function delete(Request $request)
    {
        FloorType::find($request->id)->delete();
        Cache::forget(config('cache.prefix') . '.property.types.space');
        Common::one_time_message('success', 'Deleted Successfully');

        return redirect('admin/settings/floor-type');
    }
}
