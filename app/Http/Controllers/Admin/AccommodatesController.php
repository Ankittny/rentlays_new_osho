<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AccommodatesDataTable ;
use App\Models\Accommodates;
use Validator, Common, Cache;

class AccommodatesController extends Controller
{
    public function index(AccommodatesDataTable $dataTable)
    {
        return $dataTable->render('admin.Accommodates.view');
    }

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
            return view('admin.Accommodates.add');
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'accommodates'   => 'required|max:100',
                    'status'         => 'required'
                    );

            $fieldNames = array(
                        'accommodates'      => 'Accommodates',
                        'status'            => 'Status'
                        );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $Accommodates  = new Accommodates;
                $Accommodates->accommodates_number = $request->accommodates;
                $Accommodates->status        = $request->status;
                $Accommodates->save();
                Cache::forget(config('cache.prefix') . '.property.types.property');
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/accommodates');
            }
        }
    }

    public function update(Request $request)
    {
        if (! $request->isMethod('post')) {
             $data['result'] = Accommodates::find($request->id);
            return view('admin.Accommodates.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'accommodates'   => 'required|max:100',
                'status'         => 'required'
                );

        $fieldNames = array(
                    'accommodates'      => 'Accommodates',
                    'status'            => 'Status'
                    );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $Accommodates  = Accommodates::find($request->id);
                $Accommodates->accommodates_number = $request->accommodates;
                $Accommodates->status        = $request->status;
                $Accommodates->save();

                Cache::forget(config('cache.prefix') . '.property.types.property');
                Common::one_time_message('success', 'Updated Successfully');

                return redirect('admin/settings/accommodates');
            }
        }
    }

    public function delete(Request $request)
    {
        Accommodates::find($request->id)->delete();
        Cache::forget(config('cache.prefix') . '.property.types.property');
        Common::one_time_message('success', 'Deleted Successfully');

        return redirect('admin/settings/accommodates');
    }
}
