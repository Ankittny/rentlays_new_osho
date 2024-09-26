<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Properties;
use App\Models\{PmsOnboard,PmsRecurringPackage,PmsSubscriptionIds,PmsRecurringService,PmsServiceMaster};
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subcribe(Request $request,$slug){
        if($request->isMethod('post')) {
            $check_duplicacy = PmsOnboard::where('property_id', $request->property_id)->where('subscription_type', $request->subscription_type)->where('source', 'rentlays')->first();
            if(!empty($check_duplicacy)){
                return redirect()->back()->with('error', 'This property already subscribed for this package');
            }
            $id = base64_encode($request->pms_recurring_packages_id);
            $property_id = base64_encode($request->property_id);
            $subscription_type = base64_encode($request->subscription_type);
            $pms_recurring_packages_id = base64_encode($request->pms_recurring_packages_id);
            $url = route('subscribe-details', [
                'id' => $id,
                'property_id' => $property_id,
                'subscription_type' => $subscription_type,
                'pms_recurring_packages_id'=>$pms_recurring_packages_id
            ]);
            return redirect($url);
            
            // if($PmsOnboard->save()){
            //     if(!empty($request->pms_recurring_packages_id)){
            //         $this->SubcriptionData($request->subscription_type,$request->property_id,$request->pms_recurring_packages_id);
            //     }
            // //    return redirect('thankyou')->with('success','Your Query Successful Send For admin');
            // } else {
            //    return redirect()->back()->with('success','Query not Run!');
            // }
        } else {
            $data['title']   = "Rentlays Subscribe";
            $data['package'] = PmsRecurringPackage::latest()->get();
            $data['properties'] = Properties::where('slug',$slug)->select('id')->latest()->first();
            return view('subscription.view',$data);
        }
    }

    public function subscribeDetails(Request $request,$id = null)
    {
        $data['id'] = base64_decode($request->route('id'));
        $data['property_id'] = base64_decode($request->route('property_id'));
        $data['subscription_type']= base64_decode($request->route('subscription_type'));
        $data['pms_recurring_packages_id']= base64_decode($request->route('pms_recurring_packages_id'));
        $data['result'] = PmsRecurringPackage::where('pms_recurring_service_ids', $data['id'])->first();
        $recurring_service_id = PmsRecurringService::whereIn('id', explode(',',$data['result']->pms_recurring_service_ids))->pluck('service_id');
        $data['recurring_service'] =PmsServiceMaster::whereIn('id',$recurring_service_id)->pluck('name');
        $data['title'] = "Subscription Details";
        return view('subscription.subscription-details',['data'=>$data]);
    }

    public function subscription_payments(Request $request)
    {
        $property_id  = base64_decode($request->route('property_id'));
        $subscription_type= base64_decode($request->route('subscription_type'));
        $pms_recurring_packages_id= base64_decode($request->route('pms_recurring_packages_id'));
        $PmsOnboard = new PmsOnboard();
        $PmsOnboard->property_id = $property_id;
        $PmsOnboard->assing_by_id = 0;
        $PmsOnboard->assing_to_id = 0;
        $PmsOnboard->subscription_type  =$subscription_type;
        $PmsOnboard->source = "rentlays";
        $PmsOnboard->remarks = "test";
        $PmsOnboard->status = "1";
        $PmsOnboard->save();
         if($PmsOnboard->save()){
            if(!empty($pms_recurring_packages_id)){
                $this->SubcriptionData($subscription_type,$property_id,$pms_recurring_packages_id);
            }
           return redirect('thankyou')->with('success','Your Query Successful Send For admin');
        } else {
            return redirect()->back()->with('success','Query not Run!');
        }
        // return redirect('thankyou')->with('success','Your Query Successful Send For admin');

    }

    public function SubcriptionData($subscription_type,$property_id,$pms_recurring_packages_id){
        $pms_recurring_services  = PmsRecurringService::find($pms_recurring_packages_id);
        if($pms_recurring_services->duration_type=="1"){
             $start_date_time = date('Y-m-d H:i:s');
             $end_date_time = date('Y-m-d H:i:s', strtotime('+1 year', strtotime($start_date_time)));
        } elseif($pms_recurring_services->duration_type=="2"){
            $start_date_time = date('Y-m-d H:i:s');
            $end_date_time = date('Y-m-d H:i:s', strtotime('+6 months', strtotime($start_date_time)));
        } elseif($pms_recurring_services->duration_type=="3"){
            $start_date_time = date('Y-m-d H:i:s');
            $end_date_time = date('Y-m-d H:i:s', strtotime('+3 months', strtotime($start_date_time)));
        }
        $pmssubscriptionids = new PmsSubscriptionIds();
        $pmssubscriptionids->property_id = $property_id;
        $pmssubscriptionids->subscription_type = $subscription_type;
        $pmssubscriptionids->package_id        = $pms_recurring_packages_id;
        $pmssubscriptionids->package_id        = $pms_recurring_packages_id;
        $pmssubscriptionids->start_date_time   = $start_date_time;
        $pmssubscriptionids->end_date_time     = $end_date_time;
        $pmssubscriptionids->user_id           =  Auth::user()->id;
        $pmssubscriptionids->status            = "1";
        if($pmssubscriptionids->save()){
            return true;
        } else{
            return false;
        }
    }

    public function ThankYou(){
        $data['title'] = "Thank You";
        return view('subscription.thankyou',$data);
    }
}
