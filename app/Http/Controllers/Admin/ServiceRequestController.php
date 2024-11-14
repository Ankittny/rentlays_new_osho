<?php

/**
 * Testimonials Controller
 *
 * Testimonial Controller manages testimonial in home page.
 *
 * @category   Testimonials
 * @package    vRent
 * @author     Techvillage Dev Team
 * @copyright  2020 Techvillage
 * @license
 * @version    2.9
 * @link       http://techvill.net
 * @email      support@techvill.net
 * @since      Version 2.9
 * @deprecated None
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\{Controller, EmailController};
use App\DataTables\ServiceRequestDataTable;
use App\Models\Testimonials;
use App\Models\Properties;
use App\Models\Admin;
use App\Models\PmsHelpdesk;
use App\Models\PmsJobs;
use App\Models\RoleAdmin;
use App\Models\PmsOnboard;
use App\Models\PropertyAddress;
use App\Models\PmsAppointManager;
use App\Models\PmsDepartmentMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use Validator, Common;

class ServiceRequestController extends Controller
{

    public function service_request_index(ServiceRequestDataTable $dataTable)
    {
        return $dataTable->render('admin.serviceRequest.view');
    }

    public function service_request_add(Request $request,EmailController $emial)
    {
        if (! $request->isMethod('post')) {
            // $data['property'] = PmsOnboard::join('properties', 'pms_onboards.property_id', '=', 'properties.id')
            // ->select('pms_onboards.*', 'properties.*')
            // ->get();
            $data['property'] = Properties::where('agreement_status',"approve")->get();
            // dd($data['property']);
             $data['assign_to_supervisor']  = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',5)->get();
          
            $data['assign_to_sitemanager']  = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',6)->get();
            return view('admin.serviceRequest.add',$data);
        } elseif ($request->isMethod('post')) {

             $rules = array(
                'issue'           => 'required|max:100',
                'description'    => 'required|max:200',
                'image'          => 'required'
            );
            $fieldNames = array(
                'issue'           => 'Issue',
                'description'    => 'Description',
                'image'          => 'Image'
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $image     =   $request->file('image');
                $extension =   $image->getClientOriginalExtension();
                $filename  =   'service_req_'.time() . '.' . $extension;
                $success   = $image->move('public/front/images/service_request', $filename);
                if (!isset($success)) {
                    return back()->withError('Could not upload Image');
                }
                $service_request = new PmsHelpdesk;
                $service_request->issue  = $request->issue;
                $service_request->image    = $filename;
                $service_request->status   = $request->status;
                $service_request->description   = $request->description;
                $service_request->property_id   = $request->property_id;
                $service_request->priority   = $request->priority; 
                $service_request->assign_to_sitemanager   = $request->assign_to_sitemanager; 
                $service_request->assign_to_supervisor   = $request->assign_to_supervisor; 
                $service_request->save();
                $pms_job = new PmsJobs();
                $pms_job->user_id  = $request->assign_to_supervisor;
                $pms_job->property_id   = $service_request->property_id;
                $pms_job->helpdesk_id   = $service_request->id;
                $pms_job->status   = '1'; 
                $pms_job->save();
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/service_request');
            }
        } else {
            return redirect('admin/service_request');
        }
    }
    public function service_request_update(Request $request,EmailController $emial)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsHelpdesk::find($request->id);
            // $data['property'] = PmsOnboard::join('properties', 'pms_onboards.property_id', '=', 'properties.id')
            // ->select('pms_onboards.*', 'properties.*')
            // ->get();
            $data['property'] = Properties::where('agreement_status',"approve")->get();
            $data['pms_department_master'] = PmsDepartmentMaster::where('status',"Active")->latest()->get();
            $adminId = Auth::guard('admin')->user()->id;
            $data['assign_to_supervisor']  = Admin::join('role_admin', function ($join) use ($adminId) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
                if($adminId != 1){
                    $join->where('role_admin.admin_id',$adminId);
                }
            })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',5)->get();
            $pincode = $data['assign_to_supervisor']->first()->pincode;
            $data['assign_to_sitemanager']  = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where('admin.pincode',$pincode)->where('role_admin.role_id',6)->get();
            $data['role'] = RoleAdmin::getAll()->where('admin_id', Auth::guard('admin')->user()->id)->first();
            return view('admin.serviceRequest.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'issue'           => 'required|max:100',
                'description'    => 'required|max:200',
            );
            $fieldNames = array(
                'issue'           => 'Issue',
                'description'    => 'Description',
                'image'          => 'Image'
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $service_request = PmsHelpdesk::find($request->id);
                $service_request->issue  = $request->issue;
                $service_request->status   = $request->status;
                $service_request->description   = $request->description;
                $service_request->property_id   = $request->property_id;
                $service_request->priority   = $request->priority; 
                $service_request->assign_to_sitemanager   = $request->assign_to_sitemanager; 
                $service_request->assign_to_supervisor   = $request->assign_to_supervisor; 
                $image     =   $request->file('image');
                if ($image) {
                    $extension =   $image->getClientOriginalExtension();
                    $filename  =   'service_req_'.time() . '.' . $extension;
                    $success = $image->move('public/front/images/service_request', $filename);
                    if (! isset($success)) {
                         return back()->withError('Could not upload Image');
                    }

                    $service_request->image = $filename;
                }

                $service_request->save();

                PmsJobs::where('helpdesk_id', $request->id)
                    ->update([
                        'user_id' => $request->assign_to_sitemanager,
                        'property_id' => $request->property_id,
                        'helpdesk_id' => $request->id,
                        'status' => '1'
                        
                    ]);

                    try {
                        $user = Admin::find($request->assign_to_sitemanager);
                        $emial->assign_to_site($user);
                    } catch (\Exception $e) {
        
                        $errorMessage = ' Email was not sent due to '.$e->getMessage();
                    }



                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/service_request');
            }
        } else {
            return redirect('admin/service_request');
        }
    }
    public function service_request_delete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $service_request   = PmsHelpdesk::find($request->id);
            $file_path = public_path().'/front/images/service_request/'.$service_request->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            PmsHelpdesk::find($request->id)->delete();
            PmsJobs::where('helpdesk_id', $request->id)->delete();
            Common::one_time_message('success', 'Deleted Successfully');
        }
        return redirect('admin/service_request');
    }




    public function service_request_view(Request $request)
    {
        // dd($request->all());


        // $data['pms_service']= PmsHelpdesk::join('properties', function ($join) {
        //     $join->on('pms_helpdesks.property_id', '=', 'properties.id');
        // })->join('admin', function ($join) {
        //     $join->on('pms_helpdesks.assign_to_supervisor', '=', 'admin.id');
            
        // })->join('role_admin', function ($join) {
        //     $join->on('admin.id', '=', 'role_admin.admin_id');
            
        // })->join('admin as a', function ($join) {
        //     $join->on('pms_helpdesks.assign_to_sitemanager', '=', 'a.id');
            
        // })
        
        // ->select(['pms_helpdesks.*', 'properties.name as properties_name','admin.username as assign_to_supervisor', 'a.username as assign_to_sitemanager'  ])->find('pms_helpdesks.id' , $request->id );
        $data['pms_service'] = PmsHelpdesk::find($request->id);
        return view('admin.serviceRequest.service_view', $data);
    }

    public function getSiteManager($id){
        $filterproperty = PropertyAddress::where('property_id', $id)->first();

        if(!empty($filterproperty)){
           $sitemanager = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where(['role_admin.role_id'=>6,'admin.pincode'=>$filterproperty->postal_code])->get();
            echo '<option value="">Select Site Manager</option>';
            foreach($sitemanager as $item){ ?>
                <option value="<?= $item->id ?>"><?= $item->username ?></option>
            <?php }
        } else {
           return response()->json(['status'=>false]);   
        }
    }

    public function getsitemanagerservice($id){
        $PmsAppointManager = PmsAppointManager::where('assign_to_id', $id)->first();
        if(!empty($PmsAppointManager)){
            $department_ids = json_decode($PmsAppointManager->department_ids, true);
            $pmsdepartmentmaster = PmsDepartmentMaster::whereIn('id', $department_ids)->get();
            foreach($pmsdepartmentmaster as $item){ ?>
                <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="department_ids[]" id="inlineCheckbox<?= $item->id ?>" value="<?= $item->id ?>" checked>
                <label class="form-check-label" for="inlineCheckbox<?= $item->id ?>"><?= $item->name ?></label>
                </div>
            <?php }
        }  else {
            return response()->json(['status'=>false]);
        }
    }

    public function sitemanagerdepartment($id){         
        $data = PmsAppointManager::whereJsonContains('department_ids', $id)->get();
            if(!empty($data)){
                echo '<option value="">Select Site Manager</option>';
                $itesm = array();
                foreach($data as $item){ ?> 
                    <option value="<?= Admin::where('id',$item->assign_to_id)->first()->id ?>"><?= ucfirst(Admin::where('id',$item->assign_to_id)->first()->username) ?></option>
               <?php }
            } else {
                return response()->json(['status'=>false]);
            }
    } 
}

