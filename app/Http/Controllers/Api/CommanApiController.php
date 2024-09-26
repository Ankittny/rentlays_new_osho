<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\{
    Country,
    Reviews,
    PropertyType,
    SpaceType,
    warehouetype,
    PropertyTypeoption,
    ProperTypeOptionset,
    UsersVerification,
    FloorType,
    BedType,
    Currency,
    UserDetails,
    AmenityType,
    Settings,
    Language,
    StartingCities,
    Testimonials,
    PropertyDates,
    Properties,
    Bookings,
    wallet,
    Withdrawal,
    Favourite,
    PayoutSetting,
    PmsJobApproval,
    PmsSubscriptionIds,
    User,
};
use Common,Illuminate\Support\Facades\DB;
use Session,Auth,Validator;
class CommanApiController extends Controller
{ 
    // response status set
    const HTTP_STATUS_OK = 200;
    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    private $helper;

    public function __construct()
    {
        $this->helper = new Common;
    }


    public function country()
    {
        try{
            $CountryData =  Country::select('id','short_name','name','iso3','number_code')->get();
            if($CountryData->count()>0){
                return response()->json(['status'=>true,'CountryData'=>$CountryData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'CountryData'=>$CountryData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function propertyType()
    {
        try{
            $propertyTypeData =  PropertyType::select('id','name','image')->where('status','Active')->get();
            if($propertyTypeData->count()>0){
                return response()->json(['status'=>true,'propertyTypeData'=>$propertyTypeData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'propertyTypeData'=>$propertyTypeData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }


    public function spaceType()
    {
        try{
            $spaceTypeData =  SpaceType::select('id','name')->get();
            if($spaceTypeData->count()>0){
                return response()->json(['status'=>true,'spaceTypeData'=>$spaceTypeData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'spaceTypeData'=>$spaceTypeData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function wareHouseType()
    {
        try{
            $wareHouseTypeData =  warehouetype::select('id','name')->where('status','Active')->get();
            if($wareHouseTypeData->count()>0){
                return response()->json(['status'=>true,'wareHouseTypeData'=>$wareHouseTypeData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'wareHouseTypeData'=>$wareHouseTypeData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function propertyTypeOption()
    {
        try{
            $propertyTypeOptionData =  PropertyTypeoption::select('id','name')->where('status','Active')->get();
            if($propertyTypeOptionData->count()>0){
                return response()->json(['status'=>true,'propertyTypeOptionData'=>$propertyTypeOptionData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'propertyTypeOptionData'=>$propertyTypeOptionData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function propertyTypeSetOption($id)
    {
        try{
            $propertyTypeSetOptionData =  ProperTypeOptionset::select('property_type_id','property_option_type_id')->with('propertytypeoption')->where('property_type_id',$id)->get();
           // dd($propertyTypeSetOptionData);
            if($propertyTypeSetOptionData->count()>0){
                return response()->json(['status'=>true,'propertyTypeSetOptionData'=>$propertyTypeSetOptionData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'propertyTypeSetOptionData'=>$propertyTypeSetOptionData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function floorType()
    {
        try{
            $floorTypeData =  FloorType::select('id','name','description')->where('status','Active')->get();
            if($floorTypeData->count()>0){
                return response()->json(['status'=>true,'floorTypeData'=>$floorTypeData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'floorTypeData'=>$floorTypeData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function bedType()
    {
        try{
            $bedTypeData =  BedType::select('id','name')->get();
            if($bedTypeData->count()>0){
                return response()->json(['status'=>true,'bedTypeData'=>$bedTypeData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'bedTypeData'=>$bedTypeData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function currency()
    {
        try{
            $currencyData =  Currency::select('id','name','code','symbol','rate','default')->where('status','Active')->get();
            if($currencyData->count()>0){
                return response()->json(['status'=>true,'currencyData'=>$currencyData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'currencyData'=>$currencyData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function currencywithid($id)
    {
        try{
            $currencyData =  Currency::select('id','name','code','symbol','rate','default')->where('status','Active')->where('id',$id)->first();
            if(!empty($currencyData)){
                return response()->json(['status'=>true,'currencyData'=>$currencyData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'currencyData'=>$currencyData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function amenitiesType()
    {
        try{
            $amenitiesTypeData = AmenityType::select('id','name','description')->get();
            if($amenitiesTypeData->count()>0){
                return response()->json(['status'=>true,'amenitiesTypeData'=>$amenitiesTypeData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'amenitiesTypeData'=>$amenitiesTypeData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function socialLinks()
    {
        try{
            $socialLinksData = Settings::getAll()->where('type', 'join_us')->toArray();
            if($socialLinksData){
                return response()->json(['status'=>true,'socialLinksData'=>$socialLinksData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'socialLinksData'=>$socialLinksData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function language()
    {
        try{
            $languageData = Language::select('id','name','short_name')->where('status','Active')->get();
            if($languageData->count()>0){
                return response()->json(['status'=>true,'languageData'=>$languageData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'languageData'=>$languageData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function languageWithid($id)
    {
        try{
            $languageData = Language::select('id','name','short_name')->where(['status'=>'Active','id'=>$id])->first();
            if(!empty($languageData)){
                return response()->json(['status'=>true,'languageData'=>$languageData],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'languageData'=>$languageData],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function Top_Destination(){
        try{
            $Top_Destination = StartingCities::select('id','name','image')->get();
            if($Top_Destination->count()>0){
                return response()->json(['status'=>true,'Top_Destination'=>$Top_Destination],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'Top_Destination'=>$Top_Destination],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status'=>false,'message'=>$e->getMessage()],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function Testimonials()
    {
        try {
            $Testimonials = Testimonials::select('id', 'name', 'image')->get();
            if ($Testimonials->count() > 0) {
                // Add image URLs to each testimonial
                $Testimonials->transform(function ($testimonial) {
                    $testimonial->image_url = url('/').'/public/front/images/testimonials/'.$testimonial->image;
                    return $testimonial;
                });
                return response()->json(['status' => true, 'Testimonials' => $Testimonials], self::HTTP_STATUS_OK);
            } else {
                return response()->json(['status' => false, 'Testimonials' => $Testimonials], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    function searchResult(Request $request)
    {   
        $full_address = $request->input('location');
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $guest = $request->input('guest');
        $bedrooms = $request->input('bedrooms');
        $beds = $request->input('beds');
        $bathrooms = $request->input('bathrooms');
        $property_type = $request->input('property_type');
        $space_type = $request->input('space_type');
        $amenities = $request->input('amenities');
        $book_type = $request->input('book_type');
        $map_details = $request->input('map_details');
        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');



        if (!is_array($property_type)) {
            if ($property_type != '') {
                $property_type = explode(',', $property_type);
            } else {
                $property_type = [];
            }
        }

        if (!is_array($space_type)) {
            if ($space_type != '') {
                $space_type = explode(',', $space_type);
            } else {
                $space_type = [];
            }
        }

        if (!is_array($book_type)) {
            if ($book_type != '') {
                $book_type = explode(',', $book_type);
            } else {
                $book_type = [];
            }
        }
        if (!is_array($amenities)) {
            if ($amenities != '') {
                $amenities = explode(',', $amenities);
            } else {
                $amenities = [];
            }
        }

        $property_type_val = [];
        $properties_whereIn = [];
        $space_type_val = [];

        $address = str_replace([" ", "%2C"], ["+", ","], "$full_address");
        $map_where = 'https://maps.google.com/maps/api/geocode/json?key=' . config("vrent.google_map_key") . '&address=' . $address . '&sensor=false&libraries=places';
        $geocode = $this->content_read($map_where);
        $json = json_decode($geocode);
        if ($map_details != '') {
            $map_data = explode('~', $map_details);
            $minLat = $map_data[2];
            $minLong = $map_data[3];
            $maxLat = $map_data[4];
            $maxLong = $map_data[5];
        } else {
            if ($json->{'results'}) {
                $data['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $data['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};

                $minLat = $data['lat'] - 0.35;
                $maxLat = $data['lat'] + 0.35;
                $minLong = $data['long'] - 0.35;
                $maxLong = $data['long'] + 0.35;
            } else {
                $data['lat'] = 0;
                $data['long'] = 0;

                $minLat = -1100;
                $maxLat = 1100;
                $minLong = -1100;
                $maxLong = 1100;
            }
        }

        $users_where['users.status'] = 'Active';

        $checkin = date('Y-m-d', strtotime($checkin));
        $checkout = date('Y-m-d', strtotime($checkout));

        $days = $this->helper->get_days($checkin, $checkout);
        unset($days[count($days) - 1]);

        $calendar_where['date'] = $days;

        $not_available_property_ids = PropertyDates::whereIn('date', $days)->where('status', 'Not available')->distinct()->pluck('property_id');
        $properties_where['properties.accommodates'] = $guest;
     
        $properties_where['properties.status'] = 'Listed';
        $property_approval = Settings::where('name', 'property_approval')->first()->value;
        $property_approval === 'Yes' ? ($properties_where['properties.is_verified'] = 'Approved') : '';
        if ($bedrooms) {
            $properties_where['properties.bedrooms'] = $bedrooms;
        }

        if ($bathrooms) {
            $properties_where['properties.bathrooms'] = $bathrooms;
        }

        if ($beds) {
            $properties_where['properties.beds'] = $beds;
        }

        if (count($space_type)) {
            foreach ($space_type as $space_value) {
                array_push($space_type_val, $space_value);
            }
            $properties_whereIn['properties.space_type'] = $space_type_val;
        }

        if (count($property_type)) {
            foreach ($property_type as $property_value) {
                array_push($property_type_val, $property_value);
            }

            $properties_whereIn['properties.property_type'] = $property_type_val;
        }

        $currency_rate = Currency::getAll()
            ->firstWhere('code', \Session::get('currency'))
            ->rate;

        $properties = Properties::with([
            'property_address',
            'property_price',
            'users'
        ])
            ->whereHas('property_address', function ($query) use ($minLat, $maxLat, $minLong, $maxLong) {
                $query->whereRaw("latitude between $minLat and $maxLat and longitude between $minLong and $maxLong");
            })
            ->whereHas('property_price', function ($query) use ($min_price, $max_price, $currency_rate) {
                $query->join('currency', 'currency.code', '=', 'property_price.currency_code');
                $query->whereRaw('((price / currency.rate) * ' . $currency_rate . ') >= ' . $min_price . ' and ((price / currency.rate) * ' . $currency_rate . ') <= ' . $max_price);
            })
            ->whereHas('users', function ($query) use ($users_where) {
                $query->where($users_where);
            })
            ->whereNotIn('id', $not_available_property_ids);
        
        if ($properties_where) {
            foreach ($properties_where as $row => $value) {
                if ($row == 'properties.accommodates' || $row == 'properties.bathrooms' || $row == 'properties.bedrooms' || $row == 'properties.beds') {
                    $operator = '>=';
                } else {
                    $operator = '=';
                }

                if ($value == '') {
                    $value = 0;
                }

                $properties = $properties->where(function ($query) use ($row, $operator, $value) {
                                            $query->where($row, $operator, $value);
                                            $query->orWhereNull('properties.is_verified');
                                        });
            }
        }
       
        if ($properties_whereIn) {
            foreach ($properties_whereIn as $row_properties_whereIn => $value_properties_whereIn) {
                $properties = $properties->whereIn($row_properties_whereIn, array_values($value_properties_whereIn));
            }
        }

        if (count($amenities)) {
            foreach ($amenities as $amenities_value) {
                $properties = $properties->whereRaw('find_in_set(' . $amenities_value . ', amenities)');
            }
        }
        if (count($book_type) && count($book_type) != 2) {
            foreach ($book_type as $book_value) {
                $properties = $properties->where('booking_type', $book_value);
            }
        }
        $properties = $properties;
            return response()->json(['status'=>true, 'data'=>$properties]);
        echo $properties;
    }


    public function listing(){
        $properties = Properties::with([
            'property_address',
            'property_price',
            'users'
        ])->where(['status'=>'Listed','is_verified'=>'Approved'])->paginate(10);
        if($properties){
            return response()->json(['status'=>true, 'data'=>$properties]);
        } else {
            return response()->json(['status'=>false, 'data'=>$properties]);
        }
    }   

    public function propertyDetail($id){
        $properties = Properties::with([
            'property_address',
            'property_price',
            'users',
        ])->where(['status'=>'Listed','is_verified'=>'Approved','id'=>$id])->first();
        if($properties){
            return response()->json(['status'=>true, 'data'=>$properties]);
        } else {
            return response()->json(['status'=>false, 'data'=>$properties]);
        }
    }
    
    public function content_read($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public function myList($user_id){
        $data = Properties::where('host_id', $user_id)->count();
        if($data){
            return response()->json(['status'=>true, 'data'=>['list'=>$data]]);
        } else {
            return response()->json(['status'=>false, 'data'=>['list'=>$data]]);
        }
    }

    public function trips($user_id){
        $data = Bookings::where(['user_id' =>$user_id, 'status' => 'Accepted'])->count();
        if($data){
            return response()->json(['status'=>true, 'data'=>$data]);
        } else {
            return response()->json(['status'=>false, 'data'=>$data]);
        }
    }
    public function my_wallet($user_id){
        $trip = Bookings::where(['user_id' =>$user_id, 'status' => 'Accepted'])->count();
        if($trip){
            return response()->json(['status'=>true, 'data'=>['trip'=>$trip]]);
        } else {
            return response()->json(['status'=>false, 'data'=>['trip'=>$trip]]);
        }
    }

    public function myWallet($user_id)
    {
        $wallet  = wallet::where('user_id', $user_id)->first();
        $currentCurrency = $this->helper->getCurrentCurrency();
        if($wallet){
            return response()->json(['status'=>true, 'data'=>[
                'currentCurrency' => $currentCurrency->symbol,
                'wallet' => $wallet->total
            ]]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }
    public function latestBooking($user_id){
        $data = Bookings::with('users', 'properties')
                        ->where(['host_id' => $user_id, 'status' => 'Accepted'])
                        ->orderBy('id', 'desc')->take(5)->get();
        if($data){
            return response()->json(['status'=>true, 'data'=>$data]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }

    public function latestTransactions($user_id)
    {
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
        if($data['transactions'] && $data['transactions']->count()){
            return response()->json(['status'=>true, 'data'=>$data['transactions']]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }


    public function userProperties(Request $request)
    {
        switch ($request->status) {
            case 'Listed':
            case 'Unlisted':
                $pram = [['status', '=', $request->status]];
                break;
            default:
                $pram = [];
                break;
        }
        $data['property_approval'] = Settings::getAll()->firstWhere('name', 'property_approval')->value;
        $data['status'] = $request->status;
        $data['properties'] = Properties::with('property_price', 'property_address')
                                ->where('host_id', $request->user_id)
                                ->where($pram)
                                ->orderBy('id', 'desc')
                                ->paginate(Session::get('row_per_page'));
        $data['currentCurrency'] =  Common::getCurrentCurrency();
        if ($data['properties']->count()) {
            return response()->json(['status'=>true, 'data'=>$data]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }

    public function myBookings(Request $request)
    {
        switch ($request->status) {
            case 'Expired':
                $params  = [['created_at', '<', Carbon::yesterday()], ['status', '!=', 'Accepted']];
                break;
            case 'Current':
                $params  = [['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')],['status', 'Accepted']];
                break;
            case 'Upcoming':
                $params  = [['start_date', '>', date('Y-m-d')], ['status', 'Accepted']];
                break;
            case 'Completed':
                $params  = [['end_date', '<', date('Y-m-d')],['status', 'Accepted']];
                break;
            case 'Pending':
                $params           = [['created_at', '>', Carbon::yesterday()], ['status', $request->status]];
                break;
            default:
                $params           = [];
                break;
        }
        $data['yesterday'] = Carbon::yesterday();
        $data['status']  = $request->status;
        $data['title']   = "Bookings";
        $data['bookings'] = Bookings::with(['users','properties'])
            ->orWhere(['host_id'=>$request->user_id,'user_id'=>$request->user_id])
            ->where($params)->orderBy('id', 'desc')
            ->paginate(Session::get('row_per_page'));
        if ($data['bookings']->count()) {
            return response()->json(['status'=>true, 'data'=>$data]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }

    public function myTrips(Request $request)
    {
        switch ($request->status) {
            case 'Expired':
                $params  = [['created_at', '<', Carbon::yesterday()], ['status', '!=', 'Accepted']];
                break;
            case 'Current':
                $params  = [['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')],['status', 'Accepted']];
                break;
            case 'Upcoming':
                $params  = [['start_date', '>', date('Y-m-d')], ['status', 'Accepted']];
                break;
            case 'Completed':
                $params  = [['end_date', '<', date('Y-m-d')],['status', 'Accepted']];
                break;
            case 'Pending':
                $params           = [['created_at', '>', Carbon::yesterday()], ['status', $request->status]];
                break;
            default:
                $params           = [];
                break;
        }
        $data['yesterday'] = Carbon::yesterday();
        $data['status']    = $request->status;
        $data['bookings']  = Bookings::with('host','properties')
            ->where('user_id', $request->user_id)
            ->where($params)->orderBy('id', 'desc')
            ->paginate(Session::get('row_per_page'));

        if ($data['bookings']->count()) {
            return response()->json(['status'=>true, 'data'=>$data]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }

    public function userBookmark(Request $request)
    {

        $data['bookings'] = Favourite::with(['properties' => function ($q) {
            $q->with('property_address');
        }])->where(['user_id' => $request->id, 'status' => 'Active'])->orderBy('id', 'desc')
            ->paginate(Settings::getAll()->where('name', 'row_per_page')->first()->value);
        if ($data['bookings']->count()) {
            return response()->json(['status'=>true, 'data'=>$data]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }

    public function userPayoutList(Request $request)
    {
        $data['title'] = 'Payouts';
        $data['from'] = isset(request()->from) ? request()->from : null;
        $data['to'] = isset(request()->to) ? request()->to : null;
        $data['walletBalance'] = Wallet::where(['user_id' => $request->user_id])->first();
        $data['payouts'] = PayoutSetting::where(['user_id' => $request->user_id])->get();
        $data['currentCurrency'] = Currency::getAll()->firstWhere('code',
            Session::get('currency') ?? Common::getCurrentCurrencyCode());

        $withdrawals = Withdrawal::with('user', 'currency', 'payment_methods')->where('user_id', $request->user_id);
        if (isset($data['from'])) {
            $withdrawals->whereDate('created_at', '>=', setDateForDb($data['from']));
        }
        if (isset($data['to'])) {
            $withdrawals->whereDate('created_at', '<=', setDateForDb($data['to']));
        }

        $data['withdrawals'] = $withdrawals->get();
        if ($data['withdrawals']->count()) {
            return response()->json(['status'=>true, 'data'=>$data]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }

    public function transactionHistory(Request $request)
    {
        $data['title'] = 'Transaction History';
        $user_id = $request->user_id;
        $from = $request->input('from') ? setDateForDb($request->input('from')) : null;
        $to = $request->input('to') ? setDateForDb($request->input('to')) : null;
    
        $withdrawals = Withdrawal::join('currency', 'withdrawals.currency_id', '=', 'currency.id')
            ->join('payment_methods', 'withdrawals.payment_method_id', '=', 'payment_methods.id')
            ->select([
                'withdrawals.id as id',
                'withdrawals.amount as amount',
                'withdrawals.currency_id AS c',
                'currency.symbol AS symbol',
                'currency.code AS code',
                'payment_methods.name AS p_method',
                'withdrawals.created_at AS date',
                DB::raw('0 as type')
            ])
            ->where('withdrawals.user_id', '=', $user_id)
            ->where('withdrawals.status', '=', 'Success');
    
        if ($from) {
            $withdrawals->whereDate('withdrawals.created_at', '>=', $from);
        }
    
        if ($to) {
            $withdrawals->whereDate('withdrawals.created_at', '<=', $to);
        }
    
        $bookings = Bookings::join('currency', 'bookings.currency_code', '=', 'currency.code')
            ->join('gateways', 'bookings.payment_method_id', '=', 'gateways.id')
            ->select([
                'bookings.id as id',
                DB::raw('(bookings.total - bookings.service_charge - bookings.accomodation_tax - bookings.iva_tax) as amount'),
                'bookings.currency_code AS c',
                'currency.symbol AS symbol',
                'currency.code AS code',
                'gateways.name AS p_method',
                'bookings.created_at AS date',
                DB::raw('1 as type')
            ])
            ->where('bookings.host_id', '=', $user_id)
            ->where('bookings.status', '=', 'Accepted');
    
        if ($from) {
            $bookings->whereDate('bookings.created_at', '>=', $from);
        }
    
        if ($to) {
            $bookings->whereDate('bookings.created_at', '<=', $to);
        }
    
        $trips = Bookings::join('currency', 'bookings.currency_code', '=', 'currency.code')
            ->join('gateways', 'bookings.payment_method_id', '=', 'gateways.id')
            ->select([
                'bookings.id as id',
                'bookings.total AS amount',
                'bookings.currency_code AS c',
                'currency.symbol AS symbol',
                'currency.code AS code',
                'gateways.name AS p_method',
                'bookings.created_at AS date',
                DB::raw('-1 as type')
            ])
            ->where('bookings.user_id', '=', $user_id)
            ->where('bookings.status', '=', 'Accepted');
    
        if ($from) {
            $trips->whereDate('bookings.created_at', '>=', $from);
        }
    
        if ($to) {
            $trips->whereDate('bookings.created_at', '<=', $to);
        }
    
        $query = $withdrawals->union($bookings)->union($trips)->orderBy('date', 'desc')->get();
    
        return response()->json([
            'status' => true,
            'data' => [
                'title' => $data['title'],
                'transactions' => $query
            ]
        ]);
    }

    public function jobApproval(Request $request){
        $data['title']  = 'Job Approval';
        $user_id = $request->user_id;
       // $pmsJobApproval = PmsJobApproval::where('user_id', $user_id)->first();
        $data['pmsJobApproval'] = PmsJobApproval::where('pms_job_approval.user_id', $user_id)
            ->join('pms_jobs', 'pms_jobs.id', '=', 'pms_job_approval.job_id')
            ->join('properties', 'properties.id', '=', 'pms_jobs.property_id')
            ->join('admin', 'admin.id', '=', 'pms_job_approval.assign_to_id')
            ->select('pms_jobs.*', 'properties.host_id', 'admin.username', 'pms_job_approval.status as ApprovalStatus','pms_job_approval.id as job_id', 'pms_job_approval.*')->get();
        if ($data['pmsJobApproval']->count()) {
            return response()->json(['status'=>true, 'data'=>$data]);
        } else {
            return response()->json(['status'=>false, 'data'=>[]]);
        }
    }

    public function packageList(Request $request){
        $query = PmsSubscriptionIds::join('properties', function ($join) {
            $join->on('pms_subscription_ids.property_id', '=', 'properties.id');
        })
        ->join('pms_recurring_packages', function ($join) {
            $join->on('pms_subscription_ids.package_id', '=', 'pms_recurring_packages.id');
        })
        ->join('users', function ($join) {
            $join->on('properties.host_id', '=', 'users.id');
        })
        ->select([
            'pms_subscription_ids.id as id',
            'pms_subscription_ids.subscription_type as subscription_type',
            'pms_subscription_ids.start_date_time as start_date_time',
            'pms_subscription_ids.created_at',
            'properties.name as property_name',
            'users.first_name as property_name_user',  // Include user's first name
            'pms_recurring_packages.package_name as package_name',
            'pms_recurring_packages.price as price',
            'pms_recurring_packages.pms_recurring_service_ids as pms_recurring_service_ids',
            'pms_recurring_packages.offer_price as offer_price'
        ])
        ->where('pms_subscription_ids.status', '=', '1');
        // Apply date filtering if necessary
        $from = request()->get('from');  // Assuming 'from' is passed as a query parameter
        $to = request()->get('to');      // Assuming 'to' is passed as a query parameter
        if (!empty($from)) {
            $query->whereDate('pms_subscription_ids.created_at', '>=', $from);
        }
        if (!empty($to)) {
            $query->whereDate('pms_subscription_ids.created_at', '<=', $to);
        }
        // Execute query and process results
        $results = $query->get()->map(function ($package) {
            // Split service IDs
            $serviceIds = explode(',', str_replace(' ', '', $package->pms_recurring_service_ids));
            // Fetch service details
            $services = DB::table('pms_recurring_services')
                ->whereIn('id', $serviceIds)
                ->select('service_id', 'duration_time')
                ->get();
            
            // Fetch service names
            $serviceIdsForName = $services->pluck('service_id');
            $serviceNames = DB::table('pms_service_masters')
                ->whereIn('id', $serviceIdsForName)
                ->pluck('name', 'id');
            
            // Format services into a single line with HTML line breaks
            $formattedServices = $services->map(function ($service) use ($serviceNames) {
                return $serviceNames[$service->service_id] . '-  ' . $service->duration_time;
            });

            // Add formatted services to the package
            $package->services = $formattedServices;

            return $package;
        });

        return response()->json([
            'status' => true,
            'data' => $results
        ]);

    }

    public function profile(Request $request, EmailController $email_controller)
    {
        $user = User::find($request->user_id);
        if ($request->isMethod('post')) {
            $rules = array(
                'first_name'      => 'required|max:255',
                'last_name'       => 'required|max:255',
                'email'           => 'required|max:255|email|unique:users,email,'.$request->user_id,
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
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 400);
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
                        UserDetails::updateOrCreate(['user_id' =>$request->user_id, 'field' => $key], ['value' => $value]);
                    }
                }

                if ($new_email == 'yes') {
                    $email_controller->change_email_confirmation($user);

                    return response()->json([
                        'status' => true,
                        'message' => __('Email confirmaion mail is sent to your email address')
                    ]);
                } else {
                    return response()->json([
                        'status' => true,
                        'message' => __('Profile updated successfully')
                    ]);
                }
            }
        }

        $data['profile']   = User::find($request->user_id);

        $data['timezone'] = Cache::remember('timezone', 86400, function () {
            return Timezone::get()->pluck('zone', 'value');
            });

        $data['country'] = Cache::remember('country', 86400, function () {
            return Country::get()->pluck('name', 'short_name');
            });


        $data['details']   = $details = UserDetails::where('user_id',$request->user_id)->pluck('value', 'field')->toArray();

        if (isset($details['date_of_birth'])) {
            $data['date_of_birth'] = explode('-', $details['date_of_birth']);
        } else {
            $data['date_of_birth'] = [];
        }
        $data['country'] = Country::orderBy('id','DESC')->get();
        return response()->json($data);
    }
    
    public function media(Request $request)
    {
        $user = User::find($request->user_id);
        if ($request->isMethod('get')) {
            if ($user) {
                return response()->json([
                    'status' => true,
                    'data' => [
                        'user_id' => $user->id,
                        'profile_image' => $user->profile_image
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('User not found.')
                ]);
            }
        }
        if ($request->isMethod('post')) {
            if ($request->hasFile('photos')) {
                $files = $request->file('photos');
                $response = ['status' => false, 'message' => '', 'data' => []];
                foreach ($files as $file) {
                    $name = 'profile_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = public_path('images/profile/' . $request->user_id);
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    if (!empty($user->profile_image)) {
                        $oldImagePath = $path . '/' . $user->profile_image;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    if ($file->move($path, $name)) {
                        $user->profile_image = $name;
                        $user->save();
                        $response['status'] = true;
                        $response['message'] = __('Profile picture changed successfully.');
                        $response['data'] = ['profile_image' => $name];
                    } else {
                        $response['message'] = __('Failed to upload image.');
                        break;
                    }
                }
                return response()->json($response);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => __('No files were uploaded.')
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => __('Invalid request method.')
        ]);
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
                return response()->json([
                    'status'  => false,
                    'message' => 'Validation failed.',
                    'errors'  => $validator->errors()->all()
                ], 422);
            } else {
                $user = User::find($request->user_id);

                if (!Hash::check($request->old_password, $user->password)) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Your Old Password is Incorrect.',
                    ], 401);
                }

                $user->password = bcrypt($request->new_password);

                $user->save();

                return response()->json([
                    'status'  => true,
                    'message' => 'Profile password updated successfully.',
                ]);
            }
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid request method.',
            ], 405);
        }
    }

    public function reviews(Request $request)
    {
        $data['title'] = "Reviews";
        $data['reviewsAboutYou'] = Reviews::where('receiver_id',$request->user_id)
        ->orderBy('id', 'desc')
        ->get();
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function reviewsByYou(Request $request)
    {
        $data['title'] = "Reviews";
        $data['reviewsByYou'] = Reviews::with('properties','bookings')->where('sender_id',$request->user_id)
                                ->orderBy('id', 'desc')
                                ->paginate(Session::get('row_per_page'), ['*'], 'you');

        $data['reviewsToWrite'] = Bookings::with('properties','host','users')->whereRaw('DATEDIFF(now(),end_date) <= 14')
            ->whereRaw('DATEDIFF(now(),end_date)>=1')
            ->where('status', 'Accepted')
            ->where(function ($query) use ($request) {
                return $query->where('user_id',$request->user_id)->orWhere('host_id',$request->user_id);
            })
            ->whereDoesntHave('reviews')->paginate(Session::get('row_per_page'), ['*'], 'write');

        $data['expiredReviews'] = Bookings::with(['reviews'])->whereRaw('DATEDIFF(now(),end_date) > 14')->where('status', 'Accepted')->where(function ($query) use ($request) {
            return $query->where('user_id',$request->user_id)->orWhere('host_id',$request->user_id);
        })->has('reviews', '<', 1)->paginate(Session::get('row_per_page'), ['*'], 'expired');

        if ($request->expired) {
            $data['expired'] = 'active';
        } elseif ($request->you) {
            $data['you'] = 'active';
        } else {
            $data['write'] = 'active';
        }
        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

}


