<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PropertyTypeOptionDataTable;
use App\Models\PropertyTypeoption;
use Validator, Common, Cache;

class PropertyTypeOptionController extends Controller
{
    public function index(PropertyTypeOptionDataTable $dataTable)
    {
        return $dataTable->render('admin.PropertyOption.view');
    }

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
            return view('admin.PropertyOption.add');
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'name'           => 'required|max:100',
                    'status'         => 'required'
                    );

            $fieldNames = array(
                        'name'              => 'Name',
                        'status'            => 'Status'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $propertyOptionType                = new PropertyTypeoption;
                $propertyOptionType->name          = $request->name;
                $propertyOptionType->status        = $request->status;
                $propertyOptionType->save();
                Cache::forget(config('cache.prefix') . '.property.types.property');
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/property-type-option');
            }
        }
    }

    public function update(Request $request)
    {
        if (! $request->isMethod('post')) {
             $data['result'] = PropertyTypeoption::find($request->id);

            return view('admin.PropertyOption.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'name'           => 'required|max:110',
                    'status'         => 'required'
                    );

            $fieldNames = array(
                'name'              => 'Name',
                'status'            => 'Status'
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $propertyType  = PropertyTypeoption::find($request->id);
                $propertyType->name          = $request->name;
                $propertyType->status        = $request->status;
                $propertyType->save();
                Cache::forget(config('cache.prefix') . '.property.types.property');
                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/settings/property-type-option');
            }
        }
    }

    public function delete(Request $request)
    {
        PropertyTypeoption::find($request->id)->delete();
        Cache::forget(config('cache.prefix') . '.property.types.property');
        Common::one_time_message('success', 'Deleted Successfully');
        return redirect('admin/settings/property-type-option');
    }
}
