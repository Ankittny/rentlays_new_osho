<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PmsAppointManagerDataTable;
use App\Models\{PmsAppointManager,PmsDepartmentMaster,RoleAdmin};
use Validator, Common,Cache,Auth;
class AppointManagerController extends Controller
{
    public function pms_appoint_view(PmsAppointManagerDataTable $dataTable)
    {
        return $dataTable->render('admin.appoint_manager.view');
    }

    public function pms_appoint_add(Request $request)
    {
        if(! request()->isMethod('post')){
            try {
                $data['siteengineer'] = RoleAdmin::join('admin', 'role_admin.admin_id', '=', 'admin.id')
                    ->where('role_admin.role_id', '6')
                    ->select('admin.id', 'admin.username')
                    ->get();
                $data['department'] = PmsDepartmentMaster::select('id','name','description','status')->where('status','Active')->latest()->get();
                return view('admin.appoint_manager.add',$data);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }elseif(request()->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'siteengineer_id' => 'required',
                'service.*' => 'required',
                'service' => 'required',
                'map_address' => 'required',
                'pin_code' => 'required',
            ]);     
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }   
        $check = PmsAppointManager::where(['assign_to_id'=>$request->siteengineer_id,'pin_code'=>$request->pin_code])->first(); 
        if(empty($check)){
            $AppointManager = new PmsAppointManager();
            $AppointManager->assign_by_id = Auth::guard('admin')->user()->id;
            $AppointManager->city = $request->city;
            $AppointManager->state = $request->state;
            $AppointManager->country = $request->country;
            $AppointManager->latitude = $request->latitude;
            $AppointManager->longitude = $request->longitude;
            $AppointManager->assign_to_id = $request->siteengineer_id;
            $AppointManager->department_ids = json_encode($request->service);
            $AppointManager->map_address = $request->map_address;
            $AppointManager->pin_code = $request->pin_code;
            if($AppointManager->save()){
                Common::one_time_message('success', 'Appoint Manager Added Successfully');
                return redirect('admin/appoint-managers'); 
            } else{
                Common::one_time_message('success', 'Appoint Manager Not Added Successfully');
                return redirect('admin/add-appoint-managers'); 
            }
        }else{
            Common::one_time_message('success', 'All ready exgist');
            return redirect('admin/appoint-managers');   
        }
        } 
    }

    public function pms_appoint_update(Request $request){
        if(! request()->isMethod('post')){
            $data['siteengineer'] = RoleAdmin::join('admin', 'role_admin.admin_id', '=', 'admin.id')
                ->where('role_admin.role_id', '6')
                ->select('admin.id', 'admin.username')
                ->get();
            $data['department'] = PmsDepartmentMaster::select('id','name','description','status')->where('status','Active')->latest()->get();
            $data['result'] = PmsAppointManager::find($request->id);
            return view('admin.appoint_manager.edit',$data);
        }elseif(request()->isMethod('post')){
            $validator = Validator::make($request->all(), [
                // 'city' => 'required',
                // 'state' => 'required',
                // 'country' => 'required',
                // 'latitude' => 'required',
                // 'longitude' => 'required',
                'siteengineer_id' => 'required',
                'service.*' => 'required',
                'service' => 'required',
                'map_address' => 'required',
                'pin_code' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $AppointManager = PmsAppointManager::find($request->id);
            if(empty($request->city) && empty($request->state) && empty($request->country) && empty($request->latitude) && empty($request->longitude)){
                $AppointManager->city = $AppointManager->city;
                $AppointManager->state = $AppointManager->state;
                $AppointManager->country = $AppointManager->country;
                $AppointManager->latitude = $AppointManager->latitude;
                $AppointManager->assign_to_id = $request->siteengineer_id;
                $AppointManager->department_ids = json_encode($request->service);
                $AppointManager->map_address = $request->map_address;
                $AppointManager->pin_code = $request->pin_code;
                if($AppointManager->save()){
                    Common::one_time_message('success', 'Appoint Manager Updated Successfully');
                    return redirect('admin/appoint-managers'); 
                } else{
                    Common::one_time_message('success', 'Appoint Manager Not Updated Successfully');        
                    return redirect('admin/appoint-managers'); 
                }
            } else {    
                $AppointManager->city = $request->city;
                $AppointManager->state = $request->state;
                $AppointManager->country = $request->country;
                $AppointManager->latitude = $request->latitude;
                $AppointManager->longitude = $request->longitude;
                $AppointManager->assign_to_id = $request->siteengineer_id;
                $AppointManager->department_ids = json_encode($request->service);
                $AppointManager->map_address = $request->map_address;
                $AppointManager->pin_code = $request->pin_code;
                if($AppointManager->save()){
                    Common::one_time_message('success', 'Appoint Manager Updated Successfully');
                    return redirect('admin/appoint-managers'); 
                } else{
                    Common::one_time_message('success', 'Appoint Manager Not Updated Successfully');        
                    return redirect('admin/appoint-managers'); 
                }
            }   
        }   
    }
    public function pms_appoint_delete(Request $request){
        PmsAppointManager::find($request->id)->delete();
        Cache::forget(config('cache.prefix') . '.property.types.property');
        Common::one_time_message('success', 'Deleted Successfully');
        return redirect('admin/appoint-managers');
    }
}
