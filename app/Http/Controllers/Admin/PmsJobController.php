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
use App\DataTables\PmsInventoryDataTable;
use App\DataTables\PmsnewrequestDatatable;
use App\DataTables\PmsJobDataTable;
use App\DataTables\PmsRequestHistoryDataTable;
use App\Models\Testimonials;
use App\Models\Properties;
use App\Models\Admin;
use App\Models\PmsHelpdesk;
use App\Models\PmsInventoryProducts;
use App\Models\PmsInventoryBrandMaster;
use App\Models\PmsInventoryCategoryMasters;
use App\Models\PmsInventorySubcategoryMasters;
use App\Models\PmsJobs;
use App\Models\PmsJobsItems;
use App\Models\PmsServiceMaster;
use App\Models\RoleAdmin;
use App\Models\Roles;
use App\Models\PmsOnboard;
use App\Models\PmsJobApproval;
use App\Models\User;
use App\Models\Employee;
use App\Models\PmsHistory;
use App\Models\PmsDepartmentMaster;
use App\Models\PmsSubscriptionIds;
use App\Models\PmsRecurringPackage;
use App\Models\PmsRecurringService;
use Illuminate\Support\Facades\DB;
use Auth;
use Carbon\Carbon;
use App\Models\PmsPackageHistory;
use Validator, Common;

class PmsJobController extends Controller
{

    public function pms_job_index(PmsJobDataTable $dataTable)
    {
        return $dataTable->render('admin.pmsJob.view');
    }

    public function pms_job_add(Request $request)
    {   
        if (! $request->isMethod('post')) {
            $data['property'] = PmsOnboard::join('properties', 'pms_onboards.property_id', '=', 'properties.id')
            ->select('pms_onboards.*', 'properties.*')
            ->get();
            $data['pms_helpdesk'] = PmsHelpdesk::all();
            $data['brand'] = PmsInventoryBrandMaster::all();

            $data['category'] = PmsInventoryCategoryMasters::all();
            $data['sub_category'] = PmsInventorySubcategoryMasters::all();
            //  $data['assign_to_supervisor']  = Admin::join('role_admin', function ($join) {
            //     $join->on('admin.id', '=', 'role_admin.admin_id');
            // })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',5)->get();
            $data['pms_master_service'] = \App\Models\PmsServiceMaster::all();
            $data['addon_inventory'] = PmsInventoryProducts::all();
            $data['assign_to_sitemanager']  = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',6)->get();
            $data['role'] = RoleAdmin::getAll()->where('admin_id', Auth::guard('admin')->user()->id)->first();
            return view('admin.pmsJob.add',$data);

        } elseif ($request->isMethod('post')) {
            if($request->role=="admin" || $request->role=='supervisor'){
                $rules = array(
                   // 'user_id'       => 'required',
                    'property_id'=> 'required',
                    'helpdesk_id'=> 'required',
                    'type'       => 'required', 
                );
                $fieldNames = array(
                    'property_id'   => 'property id',
                    'helpdesk_id'   => 'helpdesk id',
                    'type'          => 'Type',
                    //'user_id'       => 'user id',
                );

                $validator = Validator::make($request->all(), $rules);
                $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }   else {
                $pms_job = new PmsJobs();
               // $pms_job->user_id       = $request->user_id;
                $pms_job->property_id   = $request->property_id;
                $pms_job->helpdesk_id   = $request->helpdesk_id;
                $pms_job->type   = $request->type; 
                if($pms_job->save()){
                    Common::one_time_message('success', 'Added Successfully');
                    return redirect('admin/pms_job'); 
                } else {
                    Common::one_time_message('success', 'Added Not Successfully');
                    return redirect('admin/pms_job');
                }
            }            
                
            }
             $rules = array(
                'upload_before_image'=> 'required',
                'user_id'=>'required',
                'upload_after_image'=>'required',
                'start_time'=>'required',
                'end_time'=>'required',
                'start_time_otp'=>'required',
                'end_time_otp'=>'required',
                'service'=>'required',
                'price'=>'required',
                'payable_amount'=>
                'required', );
            
            $fieldNames = array(
             
                // 'description'    => 'Description',
         
                // 'image'          => 'Image'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $image     =   $request->file('upload_before_image');
                $extension =   $image->getClientOriginalExtension();
                $filename  =   'pms_job_'.time() . '.' . $extension;

                $success   = $image->move('public/front/images/pms_inventory', $filename);
                
                if (!isset($success)) {
                    return back()->withError('Could not upload Image');
                }
                $service = implode(',', $request->service);
                $addon_inventory = array_unique($request->addon_invertory);
                $addon_inventory = implode(',', $addon_inventory);
                $pms_job = new PmsJobs();
                $pms_job->user_id  = $request->user_id;
                $pms_job->upload_before_image    = $filename;
                $pms_job->property_id   = $request->property_id;
                $pms_job->helpdesk_id   = $request->helpdesk_id;
                $pms_job->type   = $request->type; 
                $pms_job->start_time   = $request->start_time;
                $pms_job->end_time   = $request->end_time; 
                $pms_job->start_time_otp   = $request->start_time_otp; 
                $pms_job->end_time_otp   = $request->end_time_otp; 
                $pms_job->price   = $request->price; 
                $pms_job->service   = $service; 
                $pms_job->addon_inventory   = $addon_inventory; 
                $pms_job->price_amount   = $request->payable_amount; 
                $pms_job->upload_after_image   = $request->upload_after_image; 
                $pms_job->status   = $request->status; 
                $pms_job->save();
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/pms_job');
            }
        } else {
            return redirect('admin/pms_job');
        }
    }


    public function pms_inventory_getPrice(Request $request){
        $addon_id = explode(',',$request->addon_id);
        $pms_inventory_data1 =PmsInventoryProducts::select('id','description','price','sellprice')->WhereIn('id',$addon_id)->first();
        $pms_service_data =PmsServiceMaster::select('id','name','amount')->Where('id',$request->service_id)->first();

        $service_exit =PmsRecurringPackage::where('id',$request->package_id)->select('pms_recurring_service_ids')->first();
        if($service_exit){
            $service_exit_ids = array_map('intval', explode(',',$service_exit->pms_recurring_service_ids));
            if(in_array($pms_service_data->id,$service_exit_ids)){
                $pms_service_data->amount = 0;
            }        
        }
        $total_price = 0;
        foreach ($addon_id as $id) {
            $pms_inventory_data = PmsInventoryProducts::where('id', $id)->first();
            if ($pms_inventory_data) {
                $price = $pms_inventory_data->sellprice ? $pms_inventory_data->sellprice : $pms_inventory_data->price;
                $total_price += $price;
            }
        }
        if($request->type=='edit'){
            $addon_id = $addon_id[0];
            $result = $this->AddDataPmsItem($request->pms_job_id,$request->service_id,$addon_id,$request->property_id,$request->package_id);
            if($result==true){
                return response()->json(['success'=>true,'pms_inventory_data'=>$pms_inventory_data1,'pms_service_data'=>$pms_service_data,'pms_inventory_total_price'=>$total_price]);
            } else {
                return response()->json(['success'=>false]);
            }
        }  

        if($request->type=='service'){
            $result = $this->AddDataPmsService($request->pms_job_id,$request->service_id,$request->property_id,$request->package_id);
            if($result==true){
                return response()->json(['success'=>true,'pms_service_data'=>$pms_service_data,'pms_inventory_total_price'=>$total_price]);
            } else {
                return response()->json(['success'=>false]);
            }
        }
    }

    public function AddDataPmsService($pms_job_id,$service_id,$property_id,$package_id){
        $subcription =  PmsSubscriptionIds::where('property_id',$property_id)->first();
        if($subcription !== null && $subcription->subscription_type=='requrring'){
            if($subcription->package_id == $service_id){
                $PmsRecurringPackage = PmsRecurringPackage::whereIn('pms_recurring_service_ids', (array)$service_id)->first();
                $PmsRecurringService =  PmsPackageHistory::where('property_id',$property_id)->first();
               if($PmsRecurringService !== null && $PmsRecurringService->service_count!=0){
                  $current_date = Carbon::now();
                  $start_date = new Carbon($subcription->start_date_time);
                  $end_date = new Carbon($subcription->end_date_time);
                  $total_days = $start_date->diff($end_date)->days;
                    $expire_date = Carbon::now()->addDays($total_days);
                    if ($current_date > $expire_date || $current_date > $subcription->end_date_time) {
                        return false;
                    }

                    $check = PmsJobsItems::where('pms_job_id',$pms_job_id)->where('service_id',$service_id)->where('status','Pending')->first();
                    if($check){
                        $service_data  = PmsServiceMaster::find($service_id); 
                        $check->pms_job_id = $pms_job_id;
                        $check->service_id = $service_id;
                        $check->pms_inventory_product_id = $addon_id ?? "";
                        $check->price = 0;
                        $check->status = "Pending";
                        if($check->save()){
                            return false;
                        } else {
                            return false;
                        }   
                    } else {
                        $data = new PmsJobsItems();
                        $service_data  = PmsServiceMaster::find($service_id);
                        $data->pms_job_id = $pms_job_id;
                        $data->service_id = $service_id;
                        $data->pms_inventory_product_id = $addon_id ?? "";
                        $data->price = 0;
                        $data->status = "Pending";
                        if($data->save()){
                            return true;
                        } else {
                            return false;
                        }
                    }
                } else {
                    $data = new PmsJobsItems();
                    $service_data  = PmsServiceMaster::find($service_id);
                    $data->pms_job_id = $pms_job_id;
                    $data->service_id = $service_id;
                    $data->pms_inventory_product_id = $addon_id ?? "";
                    $data->price = $service_data->amount;
                    $data->status = "Pending";
                    if($data->save()){
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                 $check = PmsJobsItems::where('pms_job_id',$pms_job_id)->where('service_id',$service_id)->where('status','Pending')->first();
                    if($check){
                        $service_data  = PmsServiceMaster::find($service_id); 

                        $service_exit =PmsRecurringPackage::where('id',$package_id)->select('pms_recurring_service_ids')->first();
                        $service_exit_ids = array_map('intval', explode(',',$service_exit->pms_recurring_service_ids));
                        if(in_array($service_data->id,$service_exit_ids)){
                            $service_data->amount = 0;
                        }  

                        $check->pms_job_id = $pms_job_id;
                        $check->service_id = $service_id;
                        $check->pms_inventory_product_id = $addon_id ?? "";
                        $check->price = $service_data->amount;
                        $check->status = "Pending";
                        if($check->save()){
                            return false;
                        } else {
                            return false;
                        }  
                    } else {
                        $data = new PmsJobsItems();
                        $service_data  = PmsServiceMaster::find($service_id);
                        $service_exit =PmsRecurringPackage::where('id',$package_id)->select('pms_recurring_service_ids')->first();
                        $pms_recurring_services = PmsRecurringService::whereIn('id',explode(',',$service_exit->pms_recurring_service_ids))->pluck('service_id')->toArray();
                        // dd($pms_recurring_services);
                        // $service_exit_ids = array_map('intval', explode(',',$service_exit->pms_recurring_service_ids));
                        if(in_array($service_data->id,$pms_recurring_services)){
                            $service_data->amount = 0;
                        }  
                        $data->pms_job_id = $pms_job_id;
                        $data->service_id = $service_id;
                        $data->pms_inventory_product_id = $addon_id ?? "";
                        $data->price = $service_data->amount;
                        $data->status = "Pending";
                        if($data->save()){
                            return true;
                        } else {
                            return false;
                        }
                }
            }
        } else {
        $check = PmsJobsItems::where('pms_job_id',$pms_job_id)->where('service_id',$service_id)->where('status','Pending')->first();
        if($check){
            $service_data  = PmsServiceMaster::find($service_id); 
            $check->pms_job_id = $pms_job_id;
            $check->service_id = $service_id;
            $check->pms_inventory_product_id = $addon_id ?? "";
            $check->price = $service_data->amount;
            $check->status = "Pending";
            if($check->save()){
                return false;
            } else {
                return false;
            }   
        } else {
            $data = new PmsJobsItems();
            $service_data  = PmsServiceMaster::find($service_id);
            $data->pms_job_id = $pms_job_id;
            $data->service_id = $service_id;
            $data->pms_inventory_product_id = $addon_id ?? "";
            $data->price = $service_data->amount;
            $data->status = "Pending";
            if($data->save()){
                return true;
            } else {
                return false;
            }
        }
    }
    }


    // public function AddDataPmsService($pms_job_id, $service_id, $property_id) {
    //     $subscription = PmsSubscriptionIds::where('property_id', $property_id)->first();
    
    //     if (!$subscription) {
    //         return false;
    //     }
    
    //     if ($subscription->subscription_type == 'recurring' && $subscription->package_id == $service_id) {
    //         return $this->handleRecurringService($pms_job_id, $service_id, $subscription);
    //     }
    
    //     return $this->handleNonRecurringService($pms_job_id, $service_id);
    // }
    
    // private function handleRecurringService($pms_job_id, $service_id, $subscription) {
    //     $PmsRecurringPackage = PmsRecurringPackage::whereIn('pms_recurring_service_ids', (array)$service_id)->first();
    //     $PmsRecurringService = PmsRecurringService::where('id', $PmsRecurringPackage->pms_recurring_service_ids)->first();
    
    //     if ($PmsRecurringService->duration_type != 0) {
    //         $current_date = Carbon::now();
    //         $start_date = new Carbon($subscription->start_date_time);
    //         $end_date = new Carbon($subscription->end_date_time);
    //         $expire_date = $start_date->addDays($start_date->diffInDays($end_date));
    
    //         if ($current_date > $expire_date || $current_date > $subscription->end_date_time) {
    //             return false;
    //         }
    //     }
    
    //     return $this->updateOrCreatePmsJobItem($pms_job_id, $service_id, 0);
    // }
    
    // private function handleNonRecurringService($pms_job_id, $service_id) {
    //     $service_data = PmsServiceMaster::find($service_id);
    //     if (!$service_data) {
    //         return false;
    //     }
    //     return $this->updateOrCreatePmsJobItem($pms_job_id, $service_id, $service_data->amount);
    // }
    
    // private function updateOrCreatePmsJobItem($pms_job_id, $service_id, $price) {
    //     echo $price; die;
    //     $jobItem = PmsJobsItems::where('pms_job_id', $pms_job_id)
    //                             ->where('service_id', $service_id)
    //                             ->where('status', 'Pending')
    //                             ->first();
    
    //     if ($jobItem) {
    //         $jobItem->pms_inventory_product_id = $addon_id ?? "";
    //         $jobItem->price = $price;
    //         $jobItem->status = "Pending";
    
    //         return $jobItem->save() ? false : false;
    //     }
    
    //     $jobItem = new PmsJobsItems();
    //     $jobItem->pms_job_id = $pms_job_id;
    //     $jobItem->service_id = $service_id;
    //     $jobItem->pms_inventory_product_id = $addon_id ?? "";
    //     $jobItem->price = $price;
    //     $jobItem->status = "Pending";
    
    //     return $jobItem->save();
    // }
    


    public function AddDataPmsItem($pms_job_id,$service_id,$addon_id){
        $check = PmsJobsItems::where('pms_job_id',$pms_job_id)->where('pms_inventory_product_id',$addon_id)->where('service_id',$service_id)->where('status','Pending')->first();
        if($check){
            $pms_inventory_data  = PmsInventoryProducts::find($addon_id); 
            $check->pms_job_id = $pms_job_id;
            $check->service_id = $service_id;
            $check->pms_inventory_product_id = $addon_id;
            $check->price = $pms_inventory_data->sellprice ? $pms_inventory_data->sellprice : $pms_inventory_data->price;
            $check->status = "Pending";
            if($check->save()){
                return false;
            } else {
                return false;
            }   
        } else {
            $data = new PmsJobsItems();
            $pms_inventory_data  = PmsInventoryProducts::find($addon_id); 
            $data->pms_job_id = $pms_job_id;
            $data->service_id = $service_id;
            $data->pms_inventory_product_id = $addon_id;
            $data->price = $pms_inventory_data->sellprice ? $pms_inventory_data->sellprice : $pms_inventory_data->price;
            $data->status = "Pending";
            if($data->save()){
                return true;
            } else {
                return false;
            }
        }
    }


    public function pms_job_update(Request $request , EmailController $email)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsJobs::find($request->id);
            $data['property'] = PmsOnboard::join('properties', 'pms_onboards.property_id', '=', 'properties.id')
            ->select('pms_onboards.*', 'properties.*')
            ->get();
            $data['assign_to_sitemanager']  = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',5)->get();
            
            $data['pms_helpdesk'] = PmsHelpdesk::all();
            $data['assign_to_sitemanager']  = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',6)->get();
            $data['pms_master_service'] = \App\Models\PmsServiceMaster::all();
            $data['addon_inventory'] = PmsInventoryProducts::all();
            $data['role'] = RoleAdmin::getAll()->where('admin_id', Auth::guard('admin')->user()->id)->first();
            return view('admin.pmsJob.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                // 'property_id'=> 'required',
            );

            $fieldNames = array(
                // 'property_id' => 'Property',
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $service = $request->service ? implode(',', $request->service) : '';
                $addon_inventory = $request->addon_invertory ? array_unique($request->addon_invertory) : [];
                $addon_inventory = $addon_inventory ? implode(',', $addon_inventory) : '';
                $pms_job = PmsJobs::find($request->id);
                $property = Properties::find($pms_job->property_id);
                if(!empty($request->property_id)){
                    $pms_job->property_id   = $request->property_id;
                }
                if(!empty($request->helpdesk_id)){
                    $pms_job->helpdesk_id   = $request->helpdesk_id;
                }
                if(!empty($request->assign_to_supervisor)){
                    $pms_job->assign_to_supervisor   = $request->assign_to_supervisor;
                }
                if(!empty($request->user_id)){
                    $pms_job->user_id  = $request->user_id;
                }

                $pms_job->type             = $request->type; 
                $pms_job->start_time       = $request->start_time;
                $pms_job->end_time         = $request->end_time; 
                $pms_job->start_time_otp   = $request->start_time_otp; 
                $pms_job->end_time_otp     = $request->end_time_otp; 
                $pms_job->price            = $request->price; 
                $pms_job->service          = $service; 
                $pms_job->addon_inventory  = $addon_inventory; 
                $pms_job->price_amount     = $request->payable_amount; 
                $pms_job->status           = $request->status; 
                
                if ($request->hasFile('upload_before_image')) {
                    $image     =   $request->file('upload_before_image');
                    $extension =   $image->getClientOriginalExtension();
                    $filename  =   'upload_before_image_'.time() . '.' . $extension;
                    $success = $image->move('public/front/images/upload_before_image', $filename);
                    $pms_job->upload_before_image = $filename;
                }
                if ($request->hasFile('upload_after_image')) {
                    $image1     =   $request->file('upload_after_image');
                    $extension1 =   $image1->getClientOriginalExtension();
                    $filename1  =   'upload_before_image_'.time() . '.' . $extension1;
                    $success = $image1->move('public/front/images/upload_after_image', $filename1);
                    $pms_job->upload_after_image = $filename1;
                }
                if($pms_job->save()){
                    if(!empty($request->end_time) && $request->hasFile('upload_after_image')){
                        try {
                            $user = User::find($property->host_id);
                            $email->Payment_Verification($user);
                          } catch (\Exception $e) {
                          $errorMessage = ' Email was not sent due to'.' '.$e->getMessage();
                       }
                       $this->JobApproval($pms_job);
                    }
                    Common::one_time_message('success', 'Updated Successfully');
                    return redirect('admin/pms_job');
                }  else {
                    Common::one_time_message('success', 'Updated not Successfully');
                    return redirect('admin/pms_job');
                }
            }
        } else {
            return redirect('admin/pms_job');
        }
    }

    protected function JobApproval($pms_job){
        $pmsjobdata = PmsJobs::find($pms_job->id);
        $helpdesk = PmsHelpdesk::find($pmsjobdata->helpdesk_id);
        $property = Properties::find($pmsjobdata->property_id);
        $check_valide = PmsJobApproval::where('job_id', $pms_job->id)->first();
        if(empty($check_valide)) {
            $data = new PmsJobApproval();
            $data->job_id = $pms_job->id;
            $data->supervisor_id = $helpdesk->assign_to_supervisor;
            $data->assign_to_id = $helpdesk->assign_to_sitemanager;
            $data->payable_amount = $pms_job->price_amount;
            $data->timedate = date('Y-m-d H:i:s');
            $data->user_id = $property->host_id;
            $data->status = "pending";
            if($data->save()){
                return true;
            } else{
                return false;
            }
        } else {
            $check_valide->job_id = $pms_job->id;
            $check_valide->supervisor_id = $helpdesk->assign_to_supervisor;
            $check_valide->assign_to_id = $helpdesk->assign_to_sitemanager;
            $check_valide->payable_amount = $pms_job->price_amount;
            $check_valide->timedate = date('Y-m-d H:i:s');
            $check_valide->user_id = $property->host_id;
            $check_valide->status = "pending";
            if($check_valide->save()){
                return true;
            } else{
                return false;
            }
        }
        
    }

    public function update_service_selection(Request $request){
        $serviceSelections = $request->serviceSelection;
        foreach ($serviceSelections as $serviceSelection) {
            PmsJobsItems::updateOrCreate(
                ['pms_job_id' => $request->id, 'service_id' => $serviceSelection],
                ['price' => PmsServiceMaster::where('id', $serviceSelection)->where(['status' => 1])->value('amount')]
            );
        }
        return response()->json(['success'=>true]);
    }

    public function update_inventory_selection(Request $request){
        $inventorySelections = $request->inventoryId;
        foreach ($inventorySelections as $inventorySelection) {
            PmsJobsItems::updateOrCreate(
                ['pms_job_id' => $request->id, 'pms_inventory_product_id' => $inventorySelection],
                ['price' => PmsInventoryProducts::where('id', $inventorySelection)->value('price')]
            );
        }
        return response()->json(['success'=>true]);
    }
    public function pms_job_delete(Request $request,$id)
    {
        //dd($id,$request->all());
        if (env('APP_MODE', '') != 'test') {

            $pms_job = PmsJobs::find($id);
            $file_path = public_path().'/front/images/pms_job/'.$pms_job->upload_before_image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $file_path = public_path().'/front/images/pms_job/'.$pms_job->upload_after_image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $pms_job->delete();       
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/pms_job');
    }    
    public function getpmsjobitem($pms_job_id, $service_id = null, $addon_id = null,$package_id = null) 
    {
        // if (!empty($pms_job_id) && !empty($service_id) && !empty($addon_id)) {
        //     $data = PmsJobsItems::where('pms_job_id', $pms_job_id)
        //         ->where(function ($query) use ($addon_id, $service_id) {
        //             $query->where('pms_inventory_product_id', $addon_id)
        //                   ->orWhere('pms_inventory_product_id', $service_id);
        //         })
        //         ->where('service_id', $service_id)
        //         ->get();
        // } else {
            $data = PmsJobsItems::where('pms_job_id', $pms_job_id)->get();
        // }
        // dd($pms_job_id,$service_id,$addon_id);

        foreach ($data as $item) {
            $pmsInventoryProduct = PmsInventoryProducts::find($item->pms_inventory_product_id);
            if (!$pmsInventoryProduct) {
                $service = PmsServiceMaster::find($item->service_id);
                $item->description = "";
                $item->pms_inventory_price = $item->pms_inventory_price == 0 ?  $item->pms_inventory_price :  $service->amount ;
                $item->sellprice = 0;
                $item->discount = 0;
            } else {
                $item->description = $pmsInventoryProduct->description;
                $item->pms_inventory_price = $pmsInventoryProduct->price;
                $item->sellprice = $pmsInventoryProduct->sellprice;
                $item->discount = $pmsInventoryProduct->price > 0 ? (1 - $pmsInventoryProduct->sellprice / $pmsInventoryProduct->price) * 100 : 0;
            }
            $item->service = isset($service) ? $service->name : '';
            $item->pms_service_id = isset($service) ? $service->id : '';
            $item->discount = round($item->discount, 2);
        }
        if(!empty($package_id)){
            $service_exit =PmsRecurringPackage::where('id',$package_id)->select('pms_recurring_service_ids',)->first();
        }else{
            $service_exit =0;
        }
        return response()->json([
            'status' => true,
            'data' => $data->map(function($item) use ($service_exit) {
                // $data = PmsRecurringService::where('service_id',$item->service_id)->Select('duration_time')->first();
                if($service_exit){
                    $service_exit_ids = array_map('intval', explode(',',$service_exit->pms_recurring_service_ids));
                }
                if(!empty($service_exit) && in_array($item->pms_service_id,$service_exit_ids)){
                    $item->price = 0;
                }
                return [
                    'id' => $item->id,
                    'pms_job_id' => $item->pms_job_id,
                    'pms_inventory_product_id' => $item->pms_inventory_product_id,
                    'item_id'=>$item->pms_service_id,
                    'service_id' => $item->service_id,
                    'description' => $item->description,
                    'price' => $item->pms_inventory_price ?$item->pms_inventory_price : $item->price,
                    'sellprice' => $item->sellprice,
                    'service' => $item->service,
                    'discount' => $item->discount,
                ];
            }),
        ]);
    }
    
    


    public function delete_inventory_data($id){
        $delete = PmsJobsItems::find($id);
        if($delete){
            $delete->delete();
            return response()->json(['success'=>true]);
        }
        return response()->json(['success'=>false]);

    }


    public function pmsjobview(Request $request){
        if(!empty($request->pms_id)){
            $data = PmsHelpdesk::where('property_id', $request->pms_id)
                        ->where(function ($query) {
                            $query->whereNotNull('assign_to_supervisor')
                                    ->orWhereNotNull('assign_to_sitemanager');
                        })
                        ->where('status','Active')
                    ->first();
            $onboarddata  = PmsOnboard::where('property_id',$data->property_id)->first();
            if(!empty($data)){
            return response()->json(['status' => true, 'data' => $data,'onboarddata'=>$onboarddata]);
            } else {
                return response()->json(['status' => false, 'data' => $data]);
            }
        }
    }

   

    public function pms_new_request(PmsnewrequestDatatable $dataTable)
    {
       return $dataTable->render('admin.pmsrequest.pms-new-request');
    }


    public function view_pms_request($id)
    {
        $site_engineer = null;
        $user_role_id = RoleAdmin::where('admin_id', Auth::guard('admin')->user()->id)->first();
        if (!$user_role_id) {
            return PmsHelpdesk::where('status', 'New Task');
        }
        $user_role = Roles::where('id', $user_role_id->role_id)->pluck('display_name')->first();
        $pms_new_request = PmsHelpdesk::with(['getHelpdesk:username,id', 'getSupervisor', 'property_name'])
        ->where('status', 'New Task')->where('id', $id);
        // if ($user_role === 'supervisor') {
        //     $site_engineer = Admin::where('user_id',Auth::guard('admin')->user()->id)->get();
        //     $pms_new_request->where('assign_to_supervisor', Auth::guard('admin')->user()->id);
        // } elseif ($user_role === 'helpdesk') {
        //     $pms_new_request->where('helpdesk_user_id', Auth::guard('admin')->user()->id);
        // } elseif ($user_role === 'Admin') {
        //     $site_engineer = Admin::join('role_admin', 'admin.id', '=', 'role_admin.admin_id')
        //         ->select('admin.*')->where('role_admin.role_id',6)
        //         ->get();
        // }   
        $pms_request= $pms_new_request->first();
        if($pms_request->property_name){
           $user_property=User::where('id',$pms_request->property_name->host_id)->first();
        }else{
            $user_property=0;
        }
        $employee = Employee::where('designation_id', 14); 
        $get_user_role = Common::get_roles(Auth::guard('admin')->user()->id);
        if ($get_user_role != 'admin') {
            $employee->where('supervisor_id', Auth::guard('admin')->user()->id);
        }
        $employee = $employee->get(); 
        return view('admin.pmsrequest.view-pms-request', compact('pms_request','user_property','site_engineer','employee'));
    }

    public function area_site_engineer(Request $request)
    {
        PmsHelpdesk::where('id', $request->pms_request_id)->update([
            'id' => $request->pms_request_id,
            'assign_to_sitemanager' => $request->site_engineer_id
        ]);
        return response()->json(['success' => true,'message' => 'Assign Successfully']);
    }

    public function store_pms_request(Request $request)
    {
        $amenityStatus = [];
        $repairStatus = [];
        $cost = [];
        $remark = [];
        $working = [];
        $repairing=[];
        foreach ($request->input('amenities', []) as $amenityId => $value) {
            $amenityStatus[$amenityId] = $request->input('amenities_status')[$amenityId] ?? '';
            $repairStatus[$amenityId] = $request->input('repairing')[$amenityId] ?? '';
            $cost[$amenityId] = $request->input('estimated_cost')[$amenityId] ?? '';
            $remark[$amenityId] = $request->input('remarks')[$amenityId] ?? '';
            $repairing[$amenityId] = $request->input('repairing')[$amenityId] ?? '';
            $working[$amenityId] = $request->input('working')[$amenityId] ?? '';
        } 
        $request_data = $request->except('_token');
        $request_data['amenities'] = implode(',', array_keys($request->input('amenities', [])));

        $request_data['amenities_status'] = json_encode($amenityStatus);
        $request_data['repair_status'] = json_encode($repairStatus);
        $request_data['estimated_cost'] = json_encode($cost);
        $request_data['repairing'] = json_encode($repairing);
        $request_data['remarks'] = json_encode($remark);
        $request_data['working'] = json_encode($working);
        $request_data['assign_to_sitemanager'] = Auth::guard('admin')->user()->id;
        $data = PmsHistory::create($request_data);
        return redirect()->back()->with('message', 'Data Inserted Successfully');
    }
    

    

    public function pms_request_history(PmsRequestHistoryDataTable $dataTable, $id)
    {
        return $dataTable->with(['id' => $id])->render('admin.pmsrequest.pms-request-history');
    }

    public function pms_history($id)
    {
      $pms_history = PmsHistory::with(['getHelpdesk:username,id', 'getSupervisor', 'property_name'])->where('id',$id)->first();
      if(!empty($pms_history->amenities_status)){
        $pms_history->amenities_status = json_decode($pms_history->amenities_status, true);
      }
      if(!empty($pms_history->repair_status)){
        $pms_history->repair_status = json_decode($pms_history->repair_status, true);
      }
      if(!empty($pms_history->estimated_cost)){
        $pms_history->estimated_cost = json_decode($pms_history->estimated_cost, true);
      }
      if(!empty($pms_history->repairing)){
        $pms_history->repairing = json_decode($pms_history->repairing, true);
      }
      if(!empty($pms_history->remarks)){
        $pms_history->remarks = json_decode($pms_history->remarks, true);
      }
      if(!empty($pms_history->working)){
        $pms_history->working = json_decode($pms_history->working, true);
      }
      if($pms_history->property_name){
        $user_property=User::where('id',$pms_history->property_name->host_id)->first();
     }else{
         $user_property=0;
     }
      return view('admin.pmsrequest.pms-history',compact('pms_history','user_property'));
    }
  
}

