<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\{
    Controllers\Controller,
    Controllers\EmailController,

};
use App\Rules\GoogleReCaptcha;
use Illuminate\Support\Facades\Cache;
use App\DataTables\TransactionDataTable;
use App\DataTables\JobApprovalDataTable;
use App\DataTables\PackageListDataTable;
use App\DataTables\UserServiceRequestDataTable;
use Auth, Validator, Socialite, DateTime, Hash, DB, Session, Common;
use Pdf;
use Mail;
use Storage;
use Carbon\Carbon;
use App\Models\{
    UserServiceRequest,
    User,
    UserDetails,
    Country,
    PasswordResets,
    Timezone,
    Reviews,
    Accounts,
    UsersVerification,
    Properties,
    Payouts,
    Bookings,
    Currency,
    Settings,
    Wallet,
    Withdrawal,
    PmsJobApproval,
    PmsJobs,
    PmsJobsItems,
    PmsInvoice,
    PmsHelpdesk,
    PmsRecurringService,
    PmsSubscriptionIds,
    PmsPackageHistory
};

class UserController extends Controller
{
    protected $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }

    public function create(Request $request, EmailController $email_controller)
    {   
        $rules = array(
            'first_name'      => 'required|max:255',
            'last_name'       => 'required|max:255',
            'email'           => 'required|max:255|email|unique:users',
            'password'        => 'required|min:6',
            'country'         => 'required',
            'date_of_birth'   => 'check_age',
            'birthday_day'    => 'required',
            'birthday_month'  => 'required',
            'birthday_year'   => 'required',
        );

        $messages = array(
            'required'                => ':attribute is required.',
            'birthday_day.required'   => 'Birth date field is required.',
            'birthday_month.required' => 'Birth month field is required.',
            'birthday_year.required'  => 'Birth year field is required.',
        );

        $fieldNames = array(
            'first_name'      => 'First name',
            'last_name'       => 'Last name',
            'email'           => 'Email',
            'password'        => 'Password',
        );
        
        if (!empty(settings('recaptcha_preference')) && !empty(settings('recaptcha_key'))) {
            if (str_contains(settings('recaptcha_preference'), 'user_reg')) {
                $captchaRule = array('g-recaptcha-response' => ['required', new GoogleReCaptcha]);
                $captchaMessage = array('g-recaptcha-response.required' => 'The google recaptcha is required.');
                $captchaFieldname = array('g-recaptcha-response' => 'Google reCaptcha');

                $rules = array_merge($rules, $captchaRule);
                $messages = array_merge($messages, $captchaMessage);
                $fieldNames = array_merge($fieldNames, $captchaFieldname);

            
            }
        }
        

        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->setAttributeNames($fieldNames);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        } else {
            $user = new User;
            $user->first_name   =   strip_tags($request->first_name);
            $user->last_name    =   strip_tags($request->last_name);
            $user->email        =   $request->email;
            $user->password     =   bcrypt($request->password);
            $user->status       =   'Inactive';
            $formattedPhone        = str_replace('+' . $request->carrier_code, "", $request->formatted_phone);
            $user->phone           = !empty($request->phone) ? preg_replace("/[\s-]+/", "", $formattedPhone) : NULL;
            $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
            $user->country         = $request->country;
            $user->carrier_code    = isset($request->carrier_code) ? $request->carrier_code : NULL;
            $user->formatted_phone = isset($request->formatted_phone) ? $request->formatted_phone : NULL;
            $user->save();

            $user_details             = new UserDetails;
            $user_details->user_id    = $user->id;
            $user_details->field      = 'date_of_birth';
            $user_details->value      = $request->birthday_year.'-'.$request->birthday_month.'-'.$request->birthday_day;
            $user_details->save();

            $user_verification  = new UsersVerification;
            $user_verification->user_id  =   $user->id;
            $user_verification->save();

            $this->wallet($user->id);
            $errorMessage = '';
            try {

                $email_controller->welcome_email($user);

            } catch (\Exception $e) {

                $errorMessage = ' Email was not sent due to '.$e->getMessage();
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Common::one_time_message('error', __("User is inactive. Please check your email send verification link "));
                // // $this->helper->one_time_message('success', __('You have registered successfully.').''.$errorMessage);
                 Session::put('error','User is inactive. Please check your email send verification link');
                return redirect('login');
                // commit by ankit 07/06/2024
                /*$this->helper->one_time_message('success', __('You have registered successfully.').''.$errorMessage);
                  return redirect()->intended('dashboard'); */
            } else {
                $this->helper->one_time_message('danger', __('Log In Failed. Please Check Your Email/Password.'));
                return redirect('login');
            }

        }
    }


    public function dashboard()
    {
        $data['title'] = 'Dashboard';
        $user_id = Auth::user()->id;
        $data['wallet'] = wallet::where('user_id', $user_id)->first();
        $data['list'] = Properties::where('host_id', $user_id)->count();
        $data['trip'] = Bookings::where(['user_id' => $user_id, 'status' => 'Accepted'])->count();

        $bookings = Bookings::select('payment_method_id','gateways.name as p_method', 'currency_code',
            DB::raw('(total - service_charge - iva_tax - accomodation_tax) as total'), 'bookings.created_at', DB::raw('1 as type'))
            ->join('gateways', function ($join) {
                $join->on('bookings.payment_method_id', '=', 'gateways.id');
            })
            ->where(['host_id' => $user_id, 'bookings.status' => 'Accepted']);

        $trips = Bookings::select('payment_method_id','gateways.name as p_method', 'currency_code', 'total', 'bookings.created_at', DB::raw('-1 as type'))
            ->join('gateways', function ($join) {
                $join->on('bookings.payment_method_id', '=', 'gateways.id');
            })
            ->where(['user_id' => $user_id, 'bookings.status' => 'Accepted']);

        $data['transactions'] = Withdrawal::join('currency', function ($join) {
                    $join->on('withdrawals.currency_id', '=', 'currency.id');
                })->join('payment_methods', function ($join) {
                    $join->on('withdrawals.payment_method_id', '=', 'payment_methods.id');
                })
            ->select('payment_method_id','payment_methods.name as p_method', 'currency_id', 'amount', 'withdrawals.created_at', DB::raw('0 as type'))
            ->where(['user_id' => $user_id, 'withdrawals.status' => 'Success'])->union($bookings)->union($trips)
            ->orderBy('created_at', 'desc')->take(9)->get();

        $data['bookings'] = Bookings::with('users', 'properties')
            ->where(['host_id' => $user_id, 'status' => 'Accepted'])
            ->orderBy('id', 'desc')->take(5)->get();
        $data['currentCurrency'] = $this->helper->getCurrentCurrency();
        return view('users.dashboard', $data);

    }

    public function profile(Request $request, EmailController $email_controller)
    {
        $user = User::find(Auth::user()->id);
        if ($request->isMethod('post')) {
            $rules = array(
                'first_name'      => 'required|max:255',
                'last_name'       => 'required|max:255',
                'email'           => 'required|max:255|email|unique:users,email,'.Auth::user()->id,
                'birthday_day'    => 'required',
                'birthday_month'  => 'required',
                'birthday_year'   => 'required',
                'phone'           => 'required',
            );
            $messages = array(
                'required'                => ':attribute is required.',
                'birthday_day.required'   => 'Birth date field is required.',
                'birthday_month.required' => 'Birth date field is required.',
                'birthday_year.required'  => 'Birth date field is required.',
            );
            $fieldNames = array(
                'first_name'      => 'First name',
                'last_name'       => 'Last name',
                'email'           => 'Email',
            );
            $validator = Validator::make($request->all(), $rules, $messages);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $new_email = ($user->email != $request->email) ? 'yes' : 'no';

                $user->first_name      = $request->first_name;
                $user->last_name       = $request->last_name;
                $user->country       = $request->country;
                $user->email           = $request->email;
                $formattedPhone        = str_replace('+' . $request->carrier_code, "", $request->formatted_phone);
                $user->phone           = !empty($request->phone) ? preg_replace("/[\s-]+/", "", $formattedPhone) : NULL;
                $user->default_country = isset($request->default_country) ? $request->default_country : NULL;
                $user->carrier_code    = isset($request->carrier_code) ? $request->carrier_code : NULL;
                $user->formatted_phone = isset($request->formatted_phone) ? $request->formatted_phone : NULL;
                $user->save();

                $user_verification = UsersVerification::where('user_id', $user->id)->first();
                $user_verification->email = 'no';
                $user_verification->save();

                $temp_details = $request->details;
                $temp_details['date_of_birth'] = $request->birthday_year.'-'.$request->birthday_month.'-'.$request->birthday_day;
                foreach ($temp_details as $key => $value) {
                    if (!is_null($value) && $value != '') {
                        UserDetails::updateOrCreate(['user_id' => Auth::user()->id, 'field' => $key], ['value' => $value]);
                    }
                }

                if ($new_email == 'yes') {
                    $email_controller->change_email_confirmation($user);

                    $this->helper->one_time_message('success', __('Email confirmaion mail is sent to your email address'));
                } else {
                    $this->helper->one_time_message('success', __('Profile updated successfully'));
                }
            }
        }

        $data['profile']   = User::find(Auth::user()->id);

        $data['timezone'] = Cache::remember('timezone', 86400, function () {
            return Timezone::get()->pluck('zone', 'value');
            });

        $data['country'] = Cache::remember('country', 86400, function () {
            return Country::get()->pluck('name', 'short_name');
            });


        $data['details']   = $details = UserDetails::where('user_id', Auth::user()->id)->pluck('value', 'field')->toArray();

        if (isset($details['date_of_birth'])) {
            $data['date_of_birth'] = explode('-', $details['date_of_birth']);
        } else {
            $data['date_of_birth'] = [];
        }
        $data['country'] = Country::orderBy('id','DESC')->get();
        return view('users.profile', $data);
    }

    public function media()
    {
        $data['result'] = $user = User::find(Auth::user()->id);
        if (isset($_FILES["photos"]["name"])) {
            foreach ($_FILES["photos"]["error"] as $key => $error) {
                $tmp_name     = $_FILES["photos"]["tmp_name"][$key];
                $name         = str_replace(' ', '_', $_FILES["photos"]["name"][$key]);
                $ext          = pathinfo($name, PATHINFO_EXTENSION);
                $name         = 'profile_'.time().'.'.$ext;
                $path         = 'public/images/profile/'.Auth::user()->id;
                $oldImagePath =  public_path('images/profile').'/'.Auth::user()->id.'/'.$data['result']->profile_image;
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif') {
                    if (!empty($user->profile_image) && file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    if (move_uploaded_file($tmp_name, $path."/".$name)) {
                        $user->profile_image  = $name;
                        $user->save();
                        $this->helper->one_time_message('success', __('Profile picture changed successfully.'));
                    }
                }

            }
        }
        return view('users.media', $data);
    }


    public function accountPreferences(Request $request, EmailController $email_controller)
    {
        $data['currency_code'] = Currency::where('default', 1)->first();
        $currency_code = $data['currency_code']->code;

        if (!$request->isMethod('post')) {
            $data['payouts']   = Accounts::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            $data['country']   = Country::all()->pluck('name', 'short_name');
            return view('account.preferences', $data);
        } else {
            $account                    =   new Accounts;
            $account->user_id           = Auth::user()->id;
            $account->address1          = $request->address1;
            $account->address2          = $request->address2;
            $account->city              = $request->city;
            $account->state             = $request->state;
            $account->postal_code       = $request->postal_code;
            $account->country           = $request->country;
            $account->payment_method_id = $request->payout_method;
            $account->account           = $request->account;
            $account->currency_code     = $currency_code;

            $account->save();


            $account_check = Accounts::where('user_id', Auth::user()->id)->where('selected', 'Yes')->get();

            if ($account_check->count() == 0) {
                $account->selected = 'Yes';
                $account->save();
            }
            $updateTime = dateFormat($account->updated_at);


            $email_controller->account_preferences($account->id,$type = "update", $updateTime);

            $this->helper->one_time_message('success', __('Payout Method has been updated successfully.'));
            return redirect('users/account-preferences');
        }
    }

    public function accountDelete(Request $request, EmailController $email_controller)
    {
        $account = Accounts::find($request->id);
        if ($account->selected == 'Yes') {
            $this->helper->one_time_message('success', "Selected payout is default");
            return redirect('users/account-preferences');
        } else {


            $account->delete();
            $updateTime = dateFormat($account->updated_at);
            $email_controller->account_preferences($account->id, 'delete', $updateTime);

            $this->helper->one_time_message('success', "Payout account successfully deleted");
            return redirect('users/account-preferences');
        }
    }

    public function accountDefault(Request $request, EmailController $email_controller)
    {
        $account = Accounts::find($request->id);
        
        if ($account->selected == 'Yes') {
            $this->helper->one_time_message('success', __('Payount account is set to default'));
            return redirect('users/account-preferences');
        } else {
            $account_all       = Accounts::where('user_id', \Auth::user()->id)->update(['selected'=>'No']);
            $account->selected = 'Yes';
            $account->save();
            $updateTime = dateFormat($account->updated_at);

            $email_controller->account_preferences($account->id, 'default_update', $updateTime );

            $this->helper->one_time_message('success', __('Selected payout method is set to default'));
            return redirect('users/account-preferences');
        }
    }

    public function security(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'old_password'          => 'required',
                'new_password'          => 'required|min:6|max:30|different:old_password',
                'password_confirmation' => 'required|same:new_password|different:old_password'
            );

            $fieldNames = array(
                'old_password'          => 'Old Password',
                'new_password'          => 'New Password',
                'password_confirmation' => 'Confirm Password'
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $user = User::find(Auth::user()->id);

                if (!Hash::check($request->old_password, $user->password)) {
                    return back()->withInput()->withErrors(['old_password' => __('Your Old Password is Incorrect.')]);
                }

                $user->password = bcrypt($request->new_password);

                $user->save();

                $this->helper->one_time_message('success', __('Profile password updated successfully'));
                return redirect('users/security');
            }
        }
        return view('account.security');
    }

    public function show(Request $request)
    {
        $data['result'] = User::findOrFail($request->id);
        $data['details'] = UserDetails::where('user_id', $request->id)->pluck('value', 'field')->toArray();
        $data['reviews_from_guests'] = Reviews::with('users', 'properties')->where(['receiver_id'=>$request->id, 'reviewer'=>'guest'])->orderBy('id', 'desc')->get();
        $data['reviews_from_hosts'] = Reviews::with('users', 'properties')->where(['receiver_id'=>$request->id, 'reviewer'=>'host'])->orderBy('id', 'desc')->get();
        $data['reviews_count'] = $data['reviews_from_guests']->count() + $data['reviews_from_hosts']->count();
        $data['title'] = $data['result']->first_name."'s Profile ";
        return view('users.show', $data);
    }

    public function transactionHistory(TransactionDataTable $dataTable)
    {
        $data['from'] = isset(request()->from) ? request()->from : null;
        $data['to']   = isset(request()->to) ? request()->to : null;
        $data['title']  = 'Transaction History';
        return $dataTable->render('account.transaction_history',$data);
    }

    public function jobApproval(){
        $data['title']  = 'Job Approval';
        $user_id = Auth::id();
       // $pmsJobApproval = PmsJobApproval::where('user_id', $user_id)->first();
        $data['pmsJobApproval'] = PmsJobApproval::where('pms_job_approval.user_id', $user_id)
            ->join('pms_jobs', 'pms_jobs.id', '=', 'pms_job_approval.job_id')
            ->join('properties', 'properties.id', '=', 'pms_jobs.property_id')
            ->join('admin', 'admin.id', '=', 'pms_job_approval.assign_to_id')
            ->select('pms_jobs.*', 'properties.host_id', 'admin.username', 'pms_job_approval.status as ApprovalStatus','pms_job_approval.id as job_id', 'pms_job_approval.*')->get();
            return view('jobapproval.job_approval',$data);
    }

    public function updateJobApproval(Request $request){
        if($request->type=="pms"){
            $previous_url = url()->previous();
            $pmsJobApproval = PmsJobApproval::where('job_id', $request->job_id)->first();
            
            $pmsJobApproval->status = $request->status;
            $pmsJobApproval->remark = $request->remark;
            if($pmsJobApproval->save()){
                return redirect($previous_url)->with('success', __('Job approval status updated successfully.'));
            } else {
                return redirect($previous_url)->with('error', __('Job approval status not updated successfully.'));
            }  
        } else {
            $pmsJobApproval = PmsJobApproval::where('job_id', $request->job_id)->first();
            $pmsJobApproval->status = $request->status;
            $pmsJobApproval->remark = $request->remark;
            if($pmsJobApproval->save()){
                $this->helper->one_time_message('success', __('Job approval status updated successfully.'));
                return redirect('users/job-approval');
            } else {
                $this->helper->one_time_message('error', __('Job approval status not updated successfully.'));
                return redirect('users/job-approval');
            } 
        }
    }
    public function paynow(Request $request){
        if($request->type=="pms"){
            $Withdrawal = new Withdrawal();
            $Withdrawal->user_id = $request->user_id;
            $Withdrawal->amount = $request->payable_amount;
            $Withdrawal->subtotal = $request->payable_amount;
            $Withdrawal->payment_method_id = $request->payment_method_id;
            $Withdrawal->payout_id = 1;
            $Withdrawal->currency_id = 3;
            $Withdrawal->uuid = uniqid();
            $Withdrawal->status = "completed";
            if($Withdrawal->save()){
                $this->invoice($request->job_id);
                $this->CompleteJob($request->job_id);
                return redirect('thank-you'); 
            } else {
                return redirect('thank-you'); 
            }
        } else{
        $Withdrawal = new Withdrawal();
        $Withdrawal->user_id = $request->user_id;
        $Withdrawal->amount = $request->payable_amount;
        $Withdrawal->subtotal = $request->payable_amount;
        $Withdrawal->payment_method_id = $request->payment_method_id;
        $Withdrawal->payout_id = 1;
        $Withdrawal->currency_id = 3;
        $Withdrawal->uuid = $request->uuid;
        $Withdrawal->status = $request->status;
        if($Withdrawal->save()){
            $this->manage_history($request->job_id, $request->property_id);
            $this->CompleteJob($request->job_id);
            $this->helper->one_time_message('success', __('Payment has been done successfully.'));
            return redirect('users/transaction-history');
        } else {
            $this->helper->one_time_message('error', __('Payment has been not done successfully.'));
            return redirect('users/transaction-history');
        }
     }
    }

    public function thank_you(){
        return view('thankyou.thankyou');
    }
    public function invoice($job_id) {
        $data['invoice'] = $this->GenerateInvoice($job_id);
        $user = User::where('id', $data['invoice']->customer_id)->first();
        $pdf = \PDF::loadView('invoice.invoice', $data);
        $pdfFileName = 'invoice_' . $job_id . '.pdf';
        $pdfDirectory = storage_path('app/public/invoices/');
        if (!file_exists($pdfDirectory)) {
            mkdir($pdfDirectory, 0755, true);
        }
        $pdfPath = $pdfDirectory . $pdfFileName;
        $pdf->save($pdfPath);
        \Mail::send('invoice.invoice', $data, function($message) use ($pdfPath, $pdfFileName, $user) {
            $message->to($user->email, 'Recipient Name')
                    ->subject('Invoice for Job ID')
                    ->attach($pdfPath, [
                        'as' => $pdfFileName,
                        'mime' => 'application/pdf',
                    ]);
        });
        if (file_exists($pdfPath)) {
            unlink($pdfPath);
        }
    
        return $pdf->download($pdfFileName);
    }
    
    
    

    protected function CompleteJob($job_id){
        $pmsjob = PmsJobs::where('id', $job_id)->first();
        $pmsjob->status = 'Completed';
        $pmsjob->save();
        PmsJobApproval::where('job_id', $job_id)->update(['status' => 'completed']);
        PmsHelpdesk::where('id', $pmsjob->helpdesk_id)->update(['status' => 'Completed']);
    }

    public function manage_history($job_id, $property_id) {
        $jobData = PmsJobsItems::where(['pms_job_id'=>$job_id,'payable_amount'=>0,'price'=>0])->get();
        foreach ($jobData as $items) {
            $subscription = PmsSubscriptionIds::where(['property_id' => $property_id, 'status' => '1'])->first();
            if ($subscription && $subscription->subscription_type == 'requrring') {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', $subscription->start_date_time);
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', $subscription->end_date_time);
                $now = Carbon::now();
                
                if ($subscription->subscription_type == 'requrring' && $now->between($start_date, $end_date)) {
                    $serviceIds = PmsRecurringService::where('service_id', $items->service_id)->first();
                    
                    if ($serviceIds) {
                        $data = new PmsPackageHistory();
                        $data->pms_job_id = $items->pms_job_id;
                        $data->service_count = $serviceIds->duration_time - 1;
                        $data->service_id = $items->service_id;
                        $data->property_id = $subscription->property_id;
                        $data->save();
                    }
                }
            }
        }
    }
    
    protected function GenerateInvoice($job_id){
        $jobData = PmsJobs::where('id', $job_id)->first();
        $user_id = PmsJobApproval::where('job_id', $job_id)->first()->user_id;
        $existInvoice = PmsInvoice::where('job_id', $job_id)->first();
        if($existInvoice){
            return $existInvoice;
        }
        $invoiceCount = PmsInvoice::count() + 1;
        $invoiceNumber = 'Pms' . str_pad($invoiceCount, 3, '0', STR_PAD_LEFT);
        $PmsInvoice = new PmsInvoice();
        $PmsInvoice->invoice_number = $invoiceNumber;
        $PmsInvoice->job_id = $job_id;
        $PmsInvoice->customer_id = $user_id;
        $PmsInvoice->invoice_date = date('Y-m-d');
        $PmsInvoice->due_date = date('Y-m-d');
        $PmsInvoice->total_amount = $jobData->price_amount;
        $PmsInvoice->paid_amount = $jobData->price_amount;
        $PmsInvoice->balance_amount = 0.00;
        $PmsInvoice->notes = 'Invoice Generated on '.date('Y-m-d');

        if($PmsInvoice->save()){
            PmsJobs::where('id', $job_id)->update(['status' => 'Completed']);
            return $PmsInvoice;   
        } else {
            return $PmsInvoice;
        }
    }
    
    
    public function getCompletedTransaction(Request $request)
    {
        $transaction        = $this->transaction_result();

        if ($request->from) {

            $transaction->whereDate('payouts.created_at', '>=', $request->from);
        }
        if ($request->to) {
            $transaction->whereDate('payouts.created_at', '<=', $request->to);
        }
        if ($request->status) {
            $transaction->where('payouts.status', '=', $request->status);
        }
        $transaction_result = $transaction->paginate(Session::get('row_per_page'))->toJson();
        echo $transaction_result;
    }

    public function transaction_result()
    {
        $where['user_id']   = Auth::user()->id;

        $transaction        = Payouts::join('properties', function ($join) {
            $join->on('properties.id', '=', 'payouts.property_id');
        })
        ->select('payouts.*', 'properties.name as property_name')
        ->where($where)
        ->orderBy('updated_at', 'DESC');

        return $transaction;
    }


    public function verification(Request $request)
    {
        $data          = [];
        $data['title'] = 'Verify your account';
        return view('users.verification', $data);
    }

    public function confirmEmail(Request $request)
    {
        $password_resets = PasswordResets::whereToken($request->code);
        if ($password_resets->count() &&  $password_resets->first()->email) {
            $password_result = $password_resets->first();
            $datetime1 = new DateTime();
            $datetime2 = new DateTime($password_result->created_at);
            $interval  = $datetime1->diff($datetime2);
            $hours     = $interval->format('%h');
            if ($hours >= 1) {
                $password_resets->delete();
                $this->helper->one_time_message('success', __('Token Expired'));
                return redirect('login');
            }
            $data['result'] = User::whereEmail($password_result->email)->first();
            $data['token']  = $request->code;
            $user = User::find($data['result']->id);
            $user->status = "Active";
            $user->save();
            $user_verification = UsersVerification::where('user_id', $data['result']->id)->first();
            $user_verification->email = 'yes';
            $user_verification->save();
            $password_resets->delete();
            $this->helper->one_time_message('success', __('Your Email has Confirmed.'));
            return redirect('dashboard');
        } else {
            $this->helper->one_time_message('success', __('Invalid Token'));
            return redirect('dashboard');
        }
    }
    public function newConfirmEmail(Request $request, EmailController $emailController)
    {
        $userInfo = User::find(Auth::user()->id);

        $errorMessage = '';
        try {
            $emailController->new_email_confirmation($userInfo);
        } catch (\Exception $e) {
            $errorMessage = 'Email was not sent due to '.$e->getMessage();
        }

        if ($errorMessage != '') {
            $this->helper->one_time_message('danger', $errorMessage);
        } else {
            $this->helper->one_time_message('success', __('A new link to confirm your email has been sent to :email.', ['email'=>$userInfo->email]));
        }

        if ($request->redirect == 'verification') {
            return redirect('users/edit-verification');
        } else {
            return redirect('dashboard');
        }
    }

    public function facebookLoginVerification()
    {
        Session::put('verification', 'yes');
        return Socialite::with('facebook')->redirect();
    }

    public function facebookConnect(Request $request)
    {
        $facebook_id = $request->id;

        $verification = UsersVerification::find(Auth::user()->id);
        $verification->facebook = 'yes';
        $verification->fb_id = $facebook_id;
        $verification->save();
        $this->helper->one_time_message('success', __(':social Connected Successfully', ['social'=>'Facebook']));
        return redirect('users/edit-verification');
    }

    public function facebookDisconnectVerification(Request $request)
    {
        $verification = UsersVerification::find(Auth::user()->id);
        $verification->facebook = 'no';
        $verification->fb_id = '';
        $verification->save();
        $this->helper->one_time_message('success', __(':social Disconnected Successfully', ['social'=>'Facebook']));
        return redirect('users/edit-verification');
    }

    public function googleLoginVerification()
    {
        Session::put('verification', 'yes');
        return Socialite::with('google')->redirect();
    }

    public function googleConnect(Request $request)
    {
        $google_id = $request->id;

        $verification = UsersVerification::find(Auth::user()->id);

        $verification->google = 'yes';
        $verification->google_id = $google_id;

        $verification->save();

        $this->helper->one_time_message('success', __(':social Connected Successfully', ['social'=>'Google']));
        return redirect('users/edit-verification');
    }

    public function googleDisconnect(Request $request)
    {
        $verification = UsersVerification::find(Auth::user()->id);

        $verification->google = 'no';
        $verification->google_id = '';

        $verification->save();

        $this->helper->one_time_message('success', __(':social Disconnected Successfully', ['social'=>'Google']));
        return redirect('users/edit-verification');
    }


    public function reviews(Request $request)
    {
        $data['title'] = "Reviews";
        $data['reviewsAboutYou'] = Reviews::where('receiver_id', Auth::user()->id)
        ->orderBy('id', 'desc')
        ->get();
        return view('users.reviews_tpl', $data);
    }

    public function reviewsByYou(Request $request)
    {
        $data['title'] = "Reviews";
        $data['reviewsByYou'] = Reviews::with('properties','bookings')->where('sender_id', Auth::user()->id)
                                ->orderBy('id', 'desc')
                                ->paginate(Session::get('row_per_page'), ['*'], 'you');

        $data['reviewsToWrite'] = Bookings::with('properties','host','users')->whereRaw('DATEDIFF(now(),end_date) <= 14')
            ->whereRaw('DATEDIFF(now(),end_date)>=1')
            ->where('status', 'Accepted')
            ->where(function ($query) {
                return $query->where('user_id', Auth::id())->orWhere('host_id', Auth::id());
            })
            ->whereDoesntHave('reviews')->paginate(Session::get('row_per_page'), ['*'], 'write');

        $data['expiredReviews'] = Bookings::with(['reviews'])->whereRaw('DATEDIFF(now(),end_date) > 14')->where('status', 'Accepted')->where(function ($query) {
            return $query->where('user_id', Auth::user()->id)->orWhere('host_id', Auth::user()->id);
        })->has('reviews', '<', 1)->paginate(Session::get('row_per_page'), ['*'], 'expired');

        if ($request->expired) {
            $data['expired'] = 'active';
        } elseif ($request->you) {
            $data['you'] = 'active';
        } else {
            $data['write'] = 'active';
        }

        return view('users.reviews_you', $data);
    }

    public function editReviews(Request $request)
    {
        $data['title']  = 'Update your reviews';
        $data['result'] = $reservationDetails = Bookings::findOrFail($request->id);

        if (Auth::user()->id == $reservationDetails->user_id) {
            $reviewsChecking = Reviews::where(['booking_id'=>$request->id, 'reviewer'=>'guest'])->get();
            $data['review_id'] = ($reviewsChecking->count()) ? $reviewsChecking[0]->id : '';
        } else {
            $reviewsChecking = Reviews::where(['booking_id'=>$request->id, 'reviewer'=>'host'])->get();
            $data['review_id'] = ($reviewsChecking->count()) ? $reviewsChecking[0]->id : '';
        }

        if (!$request->isMethod('post')) {
            if ($reservationDetails->user_id == Auth::user()->id) {
                return view('users.edit_reviews_guest', $data);
            } elseif ($reservationDetails->host_id == Auth::user()->id) {
                return view('users.edit_reviews_host', $data);
            } else {
                return abort(404);
            }
        } else {
            $data  = $request;
            if ($data->review_id == '') {
                $reviews = new Reviews;
            } else {
                $reviews = Reviews::find($data->review_id);
            }

            $reviews->booking_id = $reservationDetails->id;
            $reviews->property_id = $reservationDetails->property_id;

            if ($reservationDetails->user_id == Auth::user()->id) {
                $reviews->sender_id = $reservationDetails->user_id;
                $reviews->receiver_id = $reservationDetails->host_id;
                $reviews->reviewer = 'guest';
            } elseif ($reservationDetails->host_id == Auth::user()->id) {
                $reviews->sender_id = $reservationDetails->host_id;
                $reviews->receiver_id = $reservationDetails->user_id;
                $reviews->reviewer = 'host';
            }

            foreach ($data->all() as $key => $value) {
                if ($key != 'section' && $key != 'review_id') {
                    $reviews->$key = $value;
                }
            }


            $reviews->save();

            return json_encode(['success'=>true, 'review_id'=>$reviews->id]);
        }
    }


    public function reviewDetails(Request $request)
    {
        $review_id = $request->id;
        $data['reviewDetails'] = Reviews::where('id', '=', $review_id)->where(function($query) {
            return $query->where('sender_id', Auth::id())->orWhere('receiver_id', Auth::id());
            return $query;
        })->firstOrFail();
        return view('users.reviews_details', $data)->render();
    }


    /**
     * Check duplicate phone number for new user
     *
     * @param Request $request
     *
     * @return status true/false
     *
     * @return message fail/success
     */

    public function duplicatePhoneNumberCheck(Request $request)
    {
        $req_id = $request->id;

        if (isset($req_id)) {
            $user = User::where(['phone' => preg_replace("/[\s-]+/", "", $request->phone), 'carrier_code' => $request->carrier_code])->where(function ($query) use ($req_id)
            {
                $query->where('id', '!=', $req_id);
            })->first(['phone', 'carrier_code']);
        } else {
            $user = User::where(['phone' => preg_replace("/[\s-]+/", "", $request->phone), 'carrier_code' => $request->carrier_code])->first(['phone', 'carrier_code']);
        }

        if (!empty($user->phone) && !empty($user->carrier_code)) {
            $data['status'] = true;
            $data['fail']   = "The phone number has already been taken!";
        } else {
            $data['status']  = false;
            $data['success'] = "The phone number is Available!";
        }
        return json_encode($data);
    }

    /**
     * Checking duplicate hone numebr for existing customer during manual booking
     *
     * @param string Request as $request
     *
     * @return status and message
     */

    public function duplicatePhoneNumberCheckForExistingCustomer(Request $request)
    {

        $req_id = isset($request->id) ? $request->id : $request->customer_id;

        if (isset($req_id)) {
            $user = User::where(['phone' => preg_replace("/[\s-]+/", "", $request->phone), 'carrier_code' => $request->carrier_code])->where(function ($query) use ($req_id)
            {
                $query->where('id', '!=', $req_id);
            })->first(['phone', 'carrier_code']);
        } else {
            $user = User::where(['phone' => preg_replace("/[\s-]+/", "", $request->phone), 'carrier_code' => $request->carrier_code])->first(['phone', 'carrier_code']);
        }

        if (!empty($user->phone) && !empty($user->carrier_code)) {
            $data['status'] = true;
            $data['fail']   = "The phone number has already been taken!";
        } else {
            $data['status']  = false;
            $data['success'] = "The phone number is Available!";
        }
        return json_encode($data);
    }
       /**
     * Add for user wallet info
     *
     * @param string Request as $request
     *
     * @return  user info
     */
       public function wallet($userId)
       {
           $defaultCurrencyId    = Settings::getAll()->where('name', 'default_currency')->first();
           $wallet               = new Wallet();
           $wallet->user_id      = $userId;
           $wallet->currency_id  = (int)$defaultCurrencyId->value;
           $wallet->save();

       }

    //    public function transactionHistory(TransactionDataTable $dataTable)
    //    {
    //        $data['from'] = isset(request()->from) ? request()->from : null;
    //        $data['to']   = isset(request()->to) ? request()->to : null;
    //        $data['title']  = 'Transaction History';
    //        return $dataTable->render('account.transaction_history',$data);
    //    }
   


       public function packageList(PackageListDataTable $dataTable)
      {
        return $dataTable->render('users.package_list');
       }

       
       public function serviceRequest(UserServiceRequestDataTable $dataTable)
       {
         return $dataTable->render('users.service-request.index');
       }

       public function addServiceRequest()
       {
         $data['title'] = 'Add Service Request';
         return view('users.service-request.add',compact('data'));
       }


       public function storeServiceRequest(Request $request)
       {
         $request->validate([
            'issue' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|string',
         ]);
         $serviceRequest = new UserServiceRequest();
         $serviceRequest->user_id = Auth::user()->id;
         $serviceRequest->name = Auth::user()->first_name;
         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/service-request/' . $filename);
            $serviceRequest->image = $filename;
         }
         $serviceRequest->issue = $request->issue;
         $serviceRequest->description = $request->description;
         $serviceRequest->priority = $request->priority;
         $serviceRequest->property_id = Bookings::where('user_id',Auth::user()->id)->first('property_id')->property_id;
         $serviceRequest->save();
         Common::one_time_message('success', __('Service Request Added Successfully'));
         return redirect('users/service-request');
       }

       
       public function editServiceRequest($id)
       {
         $data['serviceRequest'] = UserServiceRequest::find($id);
         $data['title'] = 'Edit Service Request';
         return view('users.service-request.edit',compact('data'));
       }

       public function updateServiceRequest(Request $request,$id)
       {
         $request->validate([
            'issue' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|string',
         ]);
         $serviceRequest = UserServiceRequest::find($id);
         $serviceRequest->issue = $request->issue;
         $serviceRequest->description = $request->description;
         $serviceRequest->priority = $request->priority;
         if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/service-request/' . $filename);
            if (file_exists($serviceRequest->image)) {
               unlink($serviceRequest->image);
            }
            $serviceRequest->image = $filename;
         }
         $serviceRequest->save();
         Common::one_time_message('success', __('Service Request Updated Successfully'));
         return redirect('users/service-request');
       }

       public function deleteServiceRequest($id)
       {
         if(UserServiceRequest::find($id)){
            $serviceRequest = UserServiceRequest::find($id)->delete();
            Common::one_time_message('success', __('Service Request Deleted Successfully'));
         }else{
            Common::one_time_message('error', __('Service Request Not Found'));
         }
         return redirect('users/service-request');
       }
   }

