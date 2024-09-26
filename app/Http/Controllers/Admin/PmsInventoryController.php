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
use App\DataTables\PmsInventoryDataTable;
use App\Models\Testimonials;
use App\Models\Properties;
use App\Models\Admin;
use App\Models\PmsHelpdesk;
use App\Models\PmsInventoryProducts;
use App\Models\PmsInventoryBrandMaster;
use App\Models\PmsInventoryCategoryMasters;
use App\Models\PmsInventorySubcategoryMasters;
use Illuminate\Support\Facades\DB;


use Validator, Common;

class PmsInventoryController extends Controller
{

    public function pms_inventory_index(PmsInventoryDataTable $dataTable)
    {

   
        return $dataTable->render('admin.pmsInventory.view');


    }
    
    public function getSubCategory(Request $request)
    {
        $category_id = $request->input('category_id');
        $data = PmsInventorySubcategoryMasters::where('category_id', $category_id)->get();
        return response()->json(['success' => true, 'data' => $data]);
    }
    public function pms_inventory_add(Request $request)
    {
        if (! $request->isMethod('post')) {

            // $data['property'] = Properties::all();

            $data['brand'] = PmsInventoryBrandMaster::all();

            $data['category'] = PmsInventoryCategoryMasters::all();
            $data['sub_category'] = PmsInventorySubcategoryMasters::all();


        
            //  $data['assign_to_supervisor']  = Admin::join('role_admin', function ($join) {
            //     $join->on('admin.id', '=', 'role_admin.admin_id');
            // })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',5)->get();
          
            $data['assign_to_sitemanager']  = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',6)->get();
                  
            return view('admin.pmsInventory.add',$data);


        } elseif ($request->isMethod('post')) {


            //  dd($request->all());


             $rules = array(
           
             
                'description'    => 'required|max:200',
               
                'image'          => 'required'
            );

            
            $fieldNames = array(

             
                'description'    => 'Description',
         
                'image'          => 'Image'
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $image     =   $request->file('image');
                $extension =   $image->getClientOriginalExtension();
                $filename  =   'pms_inventory_'.time() . '.' . $extension;

                $success   = $image->move('public/front/images/pms_inventory', $filename);
                
                if (!isset($success)) {
                    return back()->withError('Could not upload Image');
                }


               
                $pms_inventory = new PmsInventoryProducts;

                $pms_inventory->user_id  = $request->user_id;
                $pms_inventory->image    = $filename;
                $pms_inventory->brand_id   = $request->brand_id;
                $pms_inventory->category_id   = $request->category_id;
              
                $pms_inventory->sub_category_id   = $request->sub_category_id; 
                $pms_inventory->description   = $request->description;
                $pms_inventory->price   = $request->price; 
                $pms_inventory->sellprice   = $request->sellprice; 
                $pms_inventory->qty   = $request->qty; 
                $pms_inventory->sku   = $request->sku; 
                $pms_inventory->status   = $request->status; 
                $pms_inventory->save();

             
                
                Common::one_time_message('success', 'Added Successfully');
                return redirect('admin/pms_inventory');
            }
        } else {
            return redirect('admin/pms_inventory');
        }
    }
    public function pms_inventory_update(Request $request)
    {
        if (! $request->isMethod('post')) {

         
            $data['result'] = PmsInventoryProducts::find($request->id);
            // dd($data['result']);

            $data['brands'] = PmsInventoryBrandMaster::all();

            $data['category'] = PmsInventoryCategoryMasters::all();
            $data['sub_category'] = PmsInventorySubcategoryMasters::all();

           
          
            $data['assign_to_sitemanager']  = Admin::join('role_admin', function ($join) {
                $join->on('admin.id', '=', 'role_admin.admin_id');
            })->select(['admin.*','role_admin.role_id'])->where('role_admin.role_id',6)->get();
          

            return view('admin.pmsInventory.edit', $data);
        } elseif ($request->isMethod('post')) {
            $rules = array(
            
              
                'description'    => 'required|max:200',
             
            );

            
            $fieldNames = array(
            
            
                'description'    => 'Description',
        
                'image'          => 'Image'
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                
                $pms_inventory = PmsInventoryProducts::find($request->id);


                $pms_inventory->user_id  = $request->user_id;
              
                $pms_inventory->brand_id   = $request->brand_id;
                $pms_inventory->category_id   = $request->category_id;
                $pms_inventory->sub_category_id   = $request->sub_category_id; 
                $pms_inventory->description   = $request->description;
                $pms_inventory->price   = $request->price; 
                $pms_inventory->sellprice   = $request->sellprice; 
                $pms_inventory->qty   = $request->qty; 
                $pms_inventory->sku   = $request->sku; 
                $pms_inventory->status   = $request->status; 
                 
                $image     =   $request->file('image');

                if ($image) {
                    $extension =   $image->getClientOriginalExtension();
                    $filename  =   'service_req_'.time() . '.' . $extension;
    
                    $success = $image->move('public/front/images/service_request', $filename);
        
                    if (! isset($success)) {
                         return back()->withError('Could not upload Image');
                    }

                    $pms_inventory->image = $filename;
                }

                $pms_inventory->save();

            

                Common::one_time_message('success', 'Updated Successfully');
                return redirect('admin/pms_inventory');
            }
        } else {
            return redirect('admin/pms_inventory');
        }
    }
    public function pms_inventory_delete(Request $request)
    {
        if (env('APP_MODE', '') != 'test') {
            $pms_inventory   = PmsInventoryProducts::find($request->id);
            $file_path = public_path().'/front/images/pms_inventory/'.$pms_inventory->image;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            PmsInventoryProducts::find($request->id)->delete();
           
            Common::one_time_message('success', 'Deleted Successfully');
        }
        
        return redirect('admin/pms_inventory');
    }



  
}

