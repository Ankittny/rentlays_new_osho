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
use App\Http\Controllers\Controller;
use App\DataTables\BrandMasterDataTable;
use App\DataTables\CategoryMasterDataTable;
use App\DataTables\SubCategoryMasterDataTable;
use App\DataTables\DepartmentMasterDataTable;
use App\DataTables\ServiceMasterDataTable;
use App\DataTables\RecurringServiceMasterDataTable;

use App\DataTables\RecurringPackageMasterDataTable;
use App\DataTables\VendorMasterDataTable;




use App\Models\PmsInventoryBrandMaster;
use App\Models\PmsInventoryCategoryMasters;
use App\Models\PmsInventorySubcategoryMasters;
use App\Models\PmsDepartmentMaster;
use App\Models\PmsServiceMaster;
use App\Models\PmsRecurringService;
use App\Models\PmsRecurringPackage;
use App\Models\PmsVendorMaster;



use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Validator, Common;

class PmsMasterController extends Controller
{
    
    public function brandIndex(BrandMasterDataTable $dataTable)
    {
        return $dataTable->render('admin.pms-master.brand-master.view');
    }

    public function brandAdd(Request $request)
    {
        if (! $request->isMethod('post')) {
            return view('admin.pms-master.brand-master.add');
        } elseif ($request->isMethod('post')) {

             $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required',
            );
            $fieldNames = array(
                'name'           => 'Name',
                'description'    => 'Description',
                'status'    => 'Status',
                
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            
            else {
                // $image     =   $request->file('image');
                // $extension =   $image->getClientOriginalExtension();
                // $filename  =   'testimonial_'.time() . '.' . $extension;

                // $success   = $image->move('public/front/images/testimonial', $filename);
                
                // if (!isset($success)) {
                //     return back()->withError('Could not upload Image');
                // }

                $brand_master = new PmsInventoryBrandMaster;

                $brand_master->name  = $request->name;
               
                $brand_master->status   = $request->status;
                $brand_master->description   = $request->description;
             
          
                $brand_master->save();

                Common::vrCacheForget('vr-testimonials');
                
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/brand-master');
            }
        } 
        
        else {
            return redirect('admin/brand-master');
        }
    }
    public function brandUpdate(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsInventoryBrandMaster::find($request->id);
             

            return view('admin.pms-master.brand-master.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required', 
            );
            $fieldNames = array(
                'name'           => 'Name',
                'description'    => 'Description',
                'status'    => 'Status',
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                
                $brand_master = PmsInventoryBrandMaster::find($request->id);
                $brand_master->name 		 	= $request->name;
                $brand_master->status   		= $request->status;
                $brand_master->description   = $request->description;
                $brand_master->save();
                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/brand-master');
            }
        } else {
            return redirect('admin/brand-master');
        }
    }
    public function brandDelete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
           
            $brand_master = PmsInventoryBrandMaster::find($request->id);
            if ($brand_master) {
                $brand_master->delete();
            }
          
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/brand-master');
    }




    public function categoryIndex(CategoryMasterDataTable $dataTable)
    {

        
        return $dataTable->render('admin.pms-master.category-master.view');
    }


    public function categoryAdd(Request $request)
    {
        if (! $request->isMethod('post')) {
            return view('admin.pms-master.category-master.add');
        } elseif ($request->isMethod('post')) {

             $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required',
            );

            
            $fieldNames = array(
                'name'           => 'Name',
                'description'    => 'Description',
                'status'    => 'Status',
                
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            
            else {
                // $image     =   $request->file('image');
                // $extension =   $image->getClientOriginalExtension();
                // $filename  =   'testimonial_'.time() . '.' . $extension;

                // $success   = $image->move('public/front/images/testimonial', $filename);
                
                // if (!isset($success)) {
                //     return back()->withError('Could not upload Image');
                // }

                $brand_master = new PmsInventoryCategoryMasters();

                $brand_master->name  = $request->name;
               
                $brand_master->status   = $request->status;
                $brand_master->description   = $request->description;
             
          
                $brand_master->save();

                // Common::vrCacheForget('vr-testimonials');
                
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/category-master');
            }
        } 
        
        else {
            return redirect('admin/category-master');
        }
    }


    public function categoryUpdate(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsInventoryCategoryMasters::find($request->id);
             

            return view('admin.pms-master.category-master.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required',
               
               
            );

            
            $fieldNames = array(
                'name'           => 'Name',
                'description'    => 'Description',
                'status'    => 'Status',
                
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                
                $brand_master = PmsInventoryCategoryMasters::find($request->id);
                $brand_master->name 		 	= $request->name;
                $brand_master->status   		= $request->status;
                $brand_master->description   = $request->description;
              
                 
               

                $brand_master->save();

             

                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/category-master');
            }
        } else {
            return redirect('admin/category-master');
        }
    }



    public function categoryDelete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
           
            $category = PmsInventoryCategoryMasters::find($request->id);
            if ($category) {
                $category->delete();
            }
          
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/category-master');
    }




    public function subCategoryIndex(SubCategoryMasterDataTable $dataTable)
    {
        return $dataTable->render('admin.pms-master.sub-category-master.view');
    }




    public function subCategoryAdd(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['category']= PmsInventoryCategoryMasters::all();
            return view('admin.pms-master.sub-category-master.add', $data);
        } 
        elseif ($request->isMethod('post')) {
           
             $rules = array(
                'category_id'=>'required|max:100',
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required',
            );
            $fieldNames = array(
                'category_id'=>'Category_id',
                'name'           => 'Name',
                'description'    => 'Description',
                'status'    => 'Status',
            );
           
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            
            else {
               
                // $image     =   $request->file('image');
                // $extension =   $image->getClientOriginalExtension();
                // $filename  =   'testimonial_'.time() . '.' . $extension;

                // $success   = $image->move('public/front/images/testimonial', $filename);
                
                // if (!isset($success)) {
                //     return back()->withError('Could not upload Image');
                // }

                $sub_cate_master = new PmsInventorySubcategoryMasters();
                $sub_cate_master->category_id  = $request->category_id;
                $sub_cate_master->name  = $request->name;
                $sub_cate_master->status   = $request->status;
                $sub_cate_master->description   = $request->description;
                $sub_cate_master->save();
                // Common::vrCacheForget('vr-testimonials');
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/sub-category-master');
            }
        } 
        else {
            return redirect('admin/sub-category-master');
        }
    }



    public function subCategoryUpdate(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsInventorySubcategoryMasters::find($request->id);
             
            $data['category']= PmsInventoryCategoryMasters::all();
            return view('admin.pms-master.sub-category-master.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required',
               
               
            );

            
            $fieldNames = array(
                'name'           => 'Name',
                'description'    => 'Description',
                'status'    => 'Status',
                
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                
                $brand_master = PmsInventorySubcategoryMasters::find($request->id);
                $brand_master->name 		 	= $request->name;
                $brand_master->status   		= $request->status;
                $brand_master->description   = $request->description;
              
                 
               

                $brand_master->save();

             

                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/sub-category-master');
            }
        } else {
            return redirect('admin/sub-category-master');
        }
    }



    public function subCategoryDelete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $sub_category_master = PmsInventorySubcategoryMasters::find($request->id);
            if ($sub_category_master) {
                $sub_category_master->delete();
            }
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/sub-category-master');
    }


    public function departmentIndex(DepartmentMasterDataTable $dataTable)
    {
        return $dataTable->render('admin.pms-master.department-master.view');
    }
    public function departmentAdd(Request $request)
    {
        if (! $request->isMethod('post')) {
            return view('admin.pms-master.department-master.add');
        } 
        elseif ($request->isMethod('post')) {
           
             $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required',
               
            );
            $fieldNames = array(
                'name'           => 'Name',
                'description'    => 'Description',
                'status'    => 'Status',
                
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $department_master = new PmsDepartmentMaster();   
                $department_master->name  = $request->name;
                $department_master->status   = $request->status;
                $department_master->description   = $request->description;
                $department_master->save();
                // Common::vrCacheForget('vr-testimonials');
            
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/department-master');
            }
        } 
        
        else {
            return redirect('admin/department-master');
        }
    }



    public function departmentUpdate(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsDepartmentMaster::find($request->id);
             
            return view('admin.pms-master.department-master.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required',
            );
            $fieldNames = array(
                'name'           => 'Name',
                'description'    => 'Description',
                'status'    => 'Status',
                
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $department_master = PmsDepartmentMaster::find($request->id);
                $department_master->name 		 	= $request->name;
                $department_master->status   		= $request->status;
                $department_master->description   = $request->description;
                $department_master->save();
                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/department-master');
            }
        } else {
            return redirect('admin/department-master');
        }
    }


    public function departmentDelete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
           
            $department = PmsDepartmentMaster::find($request->id);
            if ($department) {
                $department->delete();
            }
          
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/department-master');
    }






    public function serviceIndex(ServiceMasterDataTable $dataTable)
    {

        
        return $dataTable->render('admin.pms-master.service-master.view');
    }




    public function serviceAdd(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['department']= PmsDepartmentMaster::all();
            return view('admin.pms-master.service-master.add', $data);
        } 
        elseif ($request->isMethod('post')) {
           
            // dd($request->all());
             $rules = array(
                'department_id'=>'required|max:100',
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'amount'    => 'required',
                'service_provider'    => 'required',
                'status'    => 'required',
            );
            $fieldNames = array(
                'department_id'=>'Department_id',
                'name'           => 'Name',
                'amount'           => 'Amount',
                'service_provider'   => 'Service Provider',
                'description'    => 'Description',
                'status'    => 'Status',
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
               
                // $image     =   $request->file('image');
                // $extension =   $image->getClientOriginalExtension();
                // $filename  =   'testimonial_'.time() . '.' . $extension;

                // $success   = $image->move('public/front/images/testimonial', $filename);
                
                // if (!isset($success)) {
                //     return back()->withError('Could not upload Image');
                // }

                $service_master = new PmsServiceMaster();
                $service_master->department_id  = $request->department_id;
                $service_master->name  = $request->name;
                $service_master->amount  = $request->amount;
                $service_master->service_provider  = $request->service_provider;
                $service_master->status   = $request->status;
                $service_master->description   = $request->description;
                $service_master->save();
              
                // Common::vrCacheForget('vr-testimonials');
              
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/service-master');
            }
        } 
        
        else {
            return redirect('admin/service-master');
        }
    }



    public function serviceUpdate(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsServiceMaster::find($request->id);
            $data['department']= PmsDepartmentMaster::all();
            return view('admin.pms-master.service-master.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
              
                'name'           => 'required|max:100',
                'description'    => 'required|max:100',
                'status'    => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $service_master = PmsServiceMaster::find($request->id);
                $service_master->name 		 	= $request->name;
                $service_master->status   		= $request->status;
                $service_master->description   = $request->description;
                $service_master->amount       = $request->amount;
                $service_master->service_provider  = $request->service_provider;
                $service_master->department_id  = $request->department_id;
                $service_master->save();
                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/service-master');
            }
        } else {
            return redirect('admin/service-master');
        }
    }



    public function serviceDelete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
           
            $service_master = PmsServiceMaster::find($request->id);
            if ($service_master) {
                $service_master->delete();
            }
          
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/service-master');
    }



    public function recurringServiceIndex(RecurringServiceMasterDataTable $dataTable)
    {
        
        return $dataTable->render('admin.pms-master.recurring-service-master.view');
    }

    public function recurringServiceAdd(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['service']= PmsServiceMaster::all();
            return view('admin.pms-master.recurring-service-master.add', $data);
        } 
        elseif ($request->isMethod('post')) {
             $rules = array(
                'service_id'   =>'required|max:100',
                'price'        => 'required',
                'duration_type'=> 'required',
                'duration_time'=> 'required',
                'status'       => 'required', 
            );
            $fieldNames = array(
                'service_id'=>'service_id',
                'price'           => 'Amount',
                'duration_type'   => 'Service Provider',
                'description'    => 'Description',
                'duration_time'   => 'Duration Time',
                'status'    => 'Status',
                
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            else {
                $recurring_service_master = new PmsRecurringService();
                $recurring_service_master->service_id  = $request->service_id;
                $recurring_service_master->price  = $request->price;
                $recurring_service_master->duration_type  = $request->duration_type;
                $recurring_service_master->duration_time  = $request->duration_time;
                $recurring_service_master->status   = $request->status;
                $recurring_service_master->save();
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/recurring-service-master');
            }
        } 
        else {
            return redirect('admin/recurring-service-master');
        }
    }

    public function recurringServiceUpdate(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsRecurringService::find($request->id);
            $data['service']= PmsServiceMaster::all();
            return view('admin.pms-master.recurring-service-master.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(    
                'status'    => 'required',
            );

            $validator = Validator::make($request->all(), $rules);
        

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $service_master = PmsRecurringService::find($request->id);
                $service_master->service_id     = $request->service_id;
                $service_master->duration_type  = $request->duration_type;
                $service_master->duration_time  = $request->duration_time;
                $service_master->price          = $request->price;
                $service_master->status   		= $request->status;
                $service_master->save();
                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/recurring-service-master');
            }
        } else {
            return redirect('admin/recurring-service-master');
        }
    }
    public function recurringServiceDelete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
           
            $service = PmsRecurringService::find($request->id);
            if ($service) {
                $service->delete();
            }
          
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/recurring-service-master');
    }




    public function recurringPackagesIndex(RecurringPackageMasterDataTable $dataTable)
    {
        
        return $dataTable->render('admin.pms-master.recurring-package-master.view');
    }

    public function recurringPackageAdd(Request $request)
    {
        if (! $request->isMethod('post')) {

            // $data['recurring_service']= PmsRecurringService::all();

            $data['recurring_service']  = PmsRecurringService::join('pms_service_masters', function ($join) {
                $join->on('pms_recurring_services.service_id', '=', 'pms_service_masters.id');
            })->select(['pms_recurring_services.*','pms_service_masters.name'])->get();
          


            return view('admin.pms-master.recurring-package-master.add', $data);
        } 
        elseif ($request->isMethod('post')) {
          
        //    dd($request->all());
             $rules = array(
               
                'price'    => 'required',
             
                'status'    => 'required',
               
               
            );
           
           
            $fieldNames = array(
           
            
                'price'           => 'Amount',
          
        
                'status'    => 'Status',
                
            );
           
            $validator = Validator::make($request->all(), $rules);
          
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } 
            
            else {
                $recurring_package_master = new PmsRecurringPackage();
                if(!empty($request->pms_recurring_service_ids)) {
                    $data= implode(', ', $request->pms_recurring_service_ids);
                    $recurring_package_master->pms_recurring_service_ids  = $data;
                }
                $recurring_package_master->price  = $request->price;
                $recurring_package_master->package_name  = $request->package_name;
                $recurring_package_master->offer_price  = $request->offer_price;
                $recurring_package_master->status   = $request->status;
                $recurring_package_master->save();
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/recurring-packages-master');
            }
        } 
        
        else {
            return redirect('admin/recurring-packages-master');
        }
    }

    public function recurringPackageUpdate(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsRecurringPackage::find($request->id);
            $data['recurring_service']  = PmsRecurringService::join('pms_service_masters', function ($join) {
                $join->on('pms_recurring_services.service_id', '=', 'pms_service_masters.id');
            })->select(['pms_recurring_services.*','pms_service_masters.name'])->get();
            // $data['recurring_service']= PmsRecurringService::all();
            return view('admin.pms-master.recurring-package-master.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(           
                'status'    => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $recurring_package_master = PmsRecurringPackage::find($request->id);
                if(!empty($request->pms_recurring_service_ids)){
                    $data= implode(', ', $request->pms_recurring_service_ids);
                    $recurring_package_master->pms_recurring_service_ids  = $data;
                }
                $recurring_package_master->price  = $request->price;
                $recurring_package_master->package_name  = $request->package_name;
                $recurring_package_master->offer_price  = $request->offer_price;
                $recurring_package_master->status   = $request->status;
                $recurring_package_master->save();
                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/recurring-packages-master');
            }
        } else {
            return redirect('admin/recurring-packages-master');
        }
    }
    public function recurringPackageDelete(Request $request)
    {
       
        if (env('APP_MODE', '') != 'test') {
            $recurring_package_master = PmsRecurringPackage::find($request->id);
            if($recurring_package_master){
                $recurring_package_master->delete();
            }
            Common::one_time_message('success', 'Deleted Successfully');
        }
        return redirect('admin/recurring-packages-master');
    }






    public function vendorMasterIndex(VendorMasterDataTable $dataTable)
    {
        return $dataTable->render('admin.pms-master.vendor-master.view');
    }

    public function VendorMasterAdd(Request $request)
    {
        if (! $request->isMethod('post')) {
            return view('admin.pms-master.vendor-master.add');
        } elseif ($request->isMethod('post')) {

             $rules = array(
                'name'           => 'required|max:100',
             
                'description'    => 'required|max:200',
              
                'image'          => 'required'
            );

            
            $fieldNames = array(
                'name'           => 'Name',
             
                'description'    => 'Description',
            
                'image'          => 'Image'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $image     =   $request->file('image');
                $extension =   $image->getClientOriginalExtension();
                $filename  =   'vendor_master_'.time() . '.' . $extension;

                $success   = $image->move('public/front/images/vendor_master', $filename);
                
                if (!isset($success)) {
                    return back()->withError('Could not upload Image');
                }


                

                $testimonial = new PmsVendorMaster;

                $testimonial->name  = $request->name;
                $testimonial->image    = $filename;
                $testimonial->status   = $request->status;
                $testimonial->description   = $request->description;
            
             
                $testimonial->save();

                // Common::vrCacheForget('vr-testimonials');
                
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/vendor-master');
            }
        } else {
            return redirect('admin/vendor-master');
        }
    }
    public function vendorMasterUpdate(Request $request)
    {
        if (! $request->isMethod('post')) {
            $data['result'] = PmsVendorMaster::find($request->id);
            return view('admin.pms-master.vendor-master.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
                'name'           => 'required|max:100',
                'description'    => 'required|max:200',
            );
            $fieldNames = array(
                'name'           => 'Name',
                'description'    => 'Description',
                'image'          => 'Image'
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                
                $testimonial = PmsVendorMaster::find($request->id);
                $testimonial->name 		 	= $request->name;
                $testimonial->status   		= $request->status;
                $testimonial->description   = $request->description;
                $image     =   $request->file('image');

                if ($image) {
                    $extension =   $image->getClientOriginalExtension();
                    $filename  =   'vendor_master_'.time() . '.' . $extension;
    
                    $success = $image->move('public/front/images/vendor_master', $filename);
        
                    if (! isset($success)) {
                         return back()->withError('Could not upload Image');
                    }

                    $testimonial->image = $filename;
                }

                $testimonial->save();

                // Common::vrCacheForget('vr-testimonials');

                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/vendor-master');
            }
        } else {
            return redirect('admin/vendor-master');
        }
    }
    public function vendorMasterDelete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $testimonial   = PmsVendorMaster::find($request->id);
            $file_path = public_path().'/front/images/vendor_master/'.$testimonial->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $testimonial = PmsVendorMaster::find($request->id);
            if ($testimonial) {
                $testimonial->delete();
            }
            // Common::vrCacheForget('vr-testimonials');
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/vendor-master');
    }

}



