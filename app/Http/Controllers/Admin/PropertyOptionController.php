<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PropertyTypeDataTable;
use App\Models\PropertyType;
use App\Models\PropertyTypeoption;
use App\Models\ProperTypeOptionset;
use Validator, Common, Cache;

class PropertyOptionController extends Controller
{
    public function index()
    {
        $data['result'] = ProperTypeOptionset::with('propertyOptionTypeSets')->latest()->get();
        return view('admin.propertyoptionset.view',$data);
        //return $dataTable->render('admin.propertyoptionset.view');
    }

    public function add(Request $request)
    {
        if (! $request->isMethod('post')) {
            $result['PropertyType'] = PropertyType::where('status','Active')->orderBy('id','DESC')->get();
            $result['PropertyOption'] = PropertyTypeoption::where('status','Active')->orderBy('id','DESC')->get();
            return view('admin.propertyoptionset.add',$result);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                    'property_type_id' => 'required|max:100',
                    'options'          => 'required|max:255',
                    );

            $fieldNames = array(
                        'property_type_id' => 'Property_Type_Id',
                        'options'          => 'Option',
                    );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
             foreach($request->options as $items){
            //     $check = ProperTypeOptionset::where('property_option_type_id',$items)->first();
            //        if(empty($check)){
                        $propertyTypeOption                          = new ProperTypeOptionset;
                        $propertyTypeOption->property_type_id        = $request->property_type_id;
                        $propertyTypeOption->property_option_type_id = $items;
                        $propertyTypeOption->save();
                //    }
                 } 

                Cache::forget(config('cache.prefix') . '.property.types.property');
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/settings/property-type-set-option');
            }
        }
    }

    public function update(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['PropertyType'] = PropertyType::where('status','Active')->orderBy('id','DESC')->get();
            $data['PropertyOption'] = PropertyTypeoption::where('status','Active')->orderBy('id','DESC')->get();
            $data['result'] = ProperTypeOptionset::find($request->id);
            return view('admin.propertyoptionset.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'property_type_id' => 'required|max:100',
                'options'          => 'required|max:255',
                );
            $fieldNames = array(
                    'property_type_id' => 'Property_Type_Id',
                    'options'          => 'Option',
                );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                
                foreach ($request->options as $item) {
                    $existingRecord = ProperTypeOptionset::find($request->id);
                
                    if ($existingRecord) {
                        $existingRecord->property_type_id = $request->property_type_id;
                        $existingRecord->property_option_type_id = $item;
                        $existingRecord->save();
                    } else {
                        ProperTypeOptionset::create([
                            'id' => $request->id,
                            'property_type_id' => $request->property_type_id,
                            'property_option_type_id' => $item,
                        ]);
                    }
                }
                Cache::forget(config('cache.prefix') . '.property.types.property');
                Common::one_time_message('success', 'Updated Successfully');

                return redirect('admin/settings/property-type-set-option');
            }
        }
    }

    public function delete(Request $request)
    {
        ProperTypeOptionset::find($request->id)->delete();
        Cache::forget(config('cache.prefix') . '.property.types.property');
        Common::one_time_message('success', 'Deleted Successfully');
        return redirect('admin/settings/property-type-set-option');
    }
}
