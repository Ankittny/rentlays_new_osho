<?php

namespace App\Http\Controllers;

use Auth, DB, Session, Validator, Common;
use App\Http\Controllers\CalendarController;
use Illuminate\Http\Request;
use App\Models\{
    Favourite,
    Properties,
    PropertyDetails,
    PropertyAddress,
    PropertyPhotos,
    PmsJobs,
    PropertyPrice,
    PropertyType,
    PmsHelpdesk,
    PropertyDescription,
    Currency,
    Settings,
    Bookings,
    SpaceType,
    RoleAdmin,
    Admin,
    BedType,
    PropertySteps,
    Country,
    Amenities,
    AmenityType,
    Warehouetype,
    FloorType,
    ProperTypeOptionset,
    PropertyMetadata,
    User
};
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{

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
       // dd($data['property_approval']);
        $data['status'] = $request->status;
        $data['properties'] = Properties::with('property_price', 'property_address')
                                ->where('host_id', Auth::id())
                                ->where($pram)
                                ->orderBy('id', 'desc')
                                ->paginate(Session::get('row_per_page'));
        $data['currentCurrency'] =  Common::getCurrentCurrency();
        return view('property.listings', $data);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = array(
                'property_type_id'  => 'required',
                'space_type'        => 'required',
                'accommodates'      => 'required',
                'map_address'       => 'required',
            );

            $fieldNames = array(
                'property_type_id'  => 'Home Type',
                'space_type'        => 'Room Type',
                'accommodates'      => 'Accommodates',
                'map_address'       => 'City',
            );
            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            } else {
                $property                  = new Properties;
                $property->host_id         = Auth::id();
                if($request->space_type=="8" || $request->space_type=="7"){
                  $property->name            = Warehouetype::getAll()->find($request->space_type)->name . ' in ' . $request->city;
                } else {
                  $property->name            = SpaceType::getAll()->find($request->space_type)->name . ' in ' . $request->city;
                }
                $property->property_type   = $request->property_type_id;
                $property->space_type      = $request->space_type;
                $property->accommodates    = $request->accommodates;
                $property->slug            = Common::pretty_url($property->name);
                $adminPropertyApproval= Settings::getAll()->firstWhere('name', 'property_approval')->value;
                $property->is_verified  = ($adminPropertyApproval == 'Yes') ? 'Pending' : 'Approved';
                $property->save();

                $property_address                 = new PropertyAddress;
                $property_address->property_id    = $property->id;
                $property_address->address_line_1 = $request->route;
                $property_address->city           = $request->city;
                $property_address->state          = $request->state;
                $property_address->country        = $request->country;
                $property_address->postal_code    = $request->postal_code;
                $property_address->latitude       = $request->latitude;
                $property_address->longitude      = $request->longitude;
                $property_address->save();

                $property_price                 = new PropertyPrice;
                $property_price->property_id    = $property->id;
                $property_price->currency_code  = \Session::get('currency');
                $property_price->save();

                $property_steps                   = new PropertySteps;
                $property_steps->property_id      = $property->id;
                $property_steps->save();

                $property_description              = new PropertyDescription;
                $property_description->property_id = $property->id;
                $property_description->save();

                return redirect('listing/' . $property->id . '/basics');
            }
        }

        $data['property_type'] = PropertyType::getAll()->where('status', 'Active')->pluck('name', 'id');
        $data['space_type']    = SpaceType::getAll()->where('status', 'Active')->pluck('name', 'id');
        $data['warehouse']    = Warehouetype::getAll()->where('status', 'Active')->pluck('name', 'id');

        return view('property.create', $data);
    }

    public function listing(Request $request, CalendarController $calendar)
    {

        $step            = $request->step;
        $property_id     = $request->id;
        $data['step']    = $step;
        $data['result']  = Properties::where('host_id', Auth::id())->findOrFail($property_id);
        $data['details'] = PropertyDetails::pluck('value', 'field');
        $data['missed']  = PropertySteps::where('property_id', $request->id)->first();


        if ($step == 'basics') {
            if ($request->isMethod('post')) {
                $property                     = Properties::find($property_id);
                if(!empty($request->bedrooms) && !empty($request->beds) && !empty($request->bathrooms) && !empty($request->bed_type)){
                    $property->bedrooms           = $request->bedrooms;
                    $property->beds               = $request->beds;
                    $property->bathrooms          = $request->bathrooms;
                    $property->bed_type           = $request->bed_type;
                } else {
                    $property->floor              = $request->floor;
                    $property->super_area         = $request->super_area;
                    $property->property_age       = $request->property_age;
                }
                $property->property_type      = $request->property_type;
                $property->space_type         = $request->space_type;
                $property->accommodates       = $request->accommodates;
                $property->save();
                $property_steps         = PropertySteps::where('property_id', $property_id)->first();
                $property_steps->basics = 1;
                $property_steps->save();

                if (!empty($request->other) && isset($request->platform)) {
                    foreach ($request->other as $index => $platformName) {
                        if (isset($request->platform[$index])) {
                            $registrationId = $request->platform[$index];
                            $existingMetadata = PropertyMetadata::where('property_id', $property_id)
                                ->where('where_list', $platformName)
                                ->first();
                            if (!$existingMetadata) {
                                $metadata = new PropertyMetadata();
                                $metadata->property_id = $property->id;
                                $metadata->where_list = $platformName;
                                $metadata->property_registration_id = $registrationId;
                                $metadata->save();
                            }
                        } else {
                            \Log::warning("Registration ID not found for index $index");
                        }
                    }
                }
                return redirect('listing/' . $property_id . '/description');
            }
            $data['bed_type']       = BedType::getAll()->pluck('name', 'id');
            $data['property_type']  = PropertyType::getAll()->where('status', 'Active')->pluck('name', 'id');
            $data['space_type']     = SpaceType::getAll()->pluck('name', 'id');
            // add by ankit 06/11/2024
            $data['warehouse_type']     = Warehouetype::getAll()->pluck('name', 'id');
            $data['floor_type']         = FloorType::getAll()->pluck('name', 'id');
            $property                   = Properties::find($property_id);
            $data['ProperTypeOptionset']   = ProperTypeOptionset::where('property_type_id',$property->property_type)->get();
        } elseif ($step == 'description') {
            if ($request->isMethod('post')) {
                $rules = array(
                    'name'     => 'required|max:50',
                    'summary'  => 'required|max:1000',
                    'for_property'  => 'required|max:1000'
                );

                $fieldNames = array(
                    'name'     => 'Name',
                    'summary'  => 'Summary',
                    'for_property'  => 'For Property'
                );

                $validator = Validator::make($request->all(), $rules);
                $validator->setAttributeNames($fieldNames);

                if ($validator->fails())
                {
                    return back()->withErrors($validator)->withInput();
                }
                else
                {
                    $property           = Properties::find($property_id);
                    $property->name     = $request->name;
                    $property->for_property = $request->for_property;
                    $property->slug     = Common::pretty_url($request->name);
                    $property->save();
                    $property_description              = PropertyDescription::where('property_id', $property_id)->first();
                    $property_description->summary     = $request->summary;
                    $property_description->save();
                    $property_steps    = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->description = 1;
                    $property_steps->save();
                    return redirect('listing/' . $property_id . '/location');
                }
            }
            $data['description']       = PropertyDescription::where('property_id', $property_id)->first();
        } elseif ($step == 'details') {
            if ($request->isMethod('post')) {
                $property_description                       = PropertyDescription::where('property_id', $property_id)->first();
                $property_description->about_place          = $request->about_place;
                $property_description->place_is_great_for   = $request->place_is_great_for;
                $property_description->guest_can_access     = $request->guest_can_access;
                $property_description->interaction_guests   = $request->interaction_guests;
                $property_description->other                = $request->other;
                $property_description->about_neighborhood   = $request->about_neighborhood;
                $property_description->get_around           = $request->get_around;
                $property_description->save();

                return redirect('listing/' . $property_id . '/description');
            }
        } elseif ($step == 'location') {
            if ($request->isMethod('post')) {
                $rules = array(
                    'address_line_1'    => 'required|max:250',
                    'address_line_2'    => 'max:250',
                    'country'           => 'required',
                    'city'              => 'required',
                    'state'             => 'required',
                    'latitude'          => 'required|not_in:0',
                );

                $fieldNames = array(
                    'address_line_1' => 'Address Line 1',
                    'country'        => 'Country',
                    'city'           => 'City',
                    'state'          => 'State',
                    'latitude'       => 'Map',
                );

                $messages = [
                    'not_in' => 'Please set :attribute pointer',
                ];

                $validator = Validator::make($request->all(), $rules, $messages);
                $validator->setAttributeNames($fieldNames);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                } else {
                    $property_address                 = PropertyAddress::where('property_id', $property_id)->first();
                    $property_address->address_line_1 = $request->address_line_1;
                    $property_address->address_line_2 = $request->address_line_2;
                    $property_address->latitude       = $request->latitude;
                    $property_address->longitude      = $request->longitude;
                    $property_address->city           = $request->city;
                    $property_address->state          = $request->state;
                    $property_address->country        = $request->country;
                    $property_address->postal_code    = $request->postal_code;
                    $property_address->save();

                    $property_steps           = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->location = 1;
                    $property_steps->save();

                    return redirect('listing/' . $property_id . '/amenities');
                }
            }
            $data['country']       = Country::pluck('name', 'short_name');
        } elseif ($step == 'amenities') {
            if ($request->isMethod('post') && is_array($request->amenities)) {
                $rules = array(
                    'property_square'     => 'required|max:50',
                    'number_of_floor'  => 'required|max:1000',
                    'number_of_rooms'  => 'required|max:1000'
                );

                $fieldNames = array(
                    'property_square'     => 'Property Square',
                    'number_of_floor'  => 'Number of Floor',
                    'number_of_rooms'  => 'Number of Rooms'
                );

                $validator = Validator::make($request->all(), $rules);
                $validator->setAttributeNames($fieldNames);

                if ($validator->fails())
                {
                    return back()->withErrors($validator)->withInput();
                }

                $rooms            = Properties::find($request->id);
                $rooms->amenities = implode(',', $request->amenities);
                $rooms->property_square =$request->property_square ?? null;
                $rooms->number_of_floor =$request->number_of_floor ?? null;
                $rooms->number_of_rooms =$request->number_of_rooms ?? null;
                $rooms->save();
                return redirect('listing/' . $property_id . '/photos');
            }
            $data['property_amenities'] = explode(',', $data['result']->amenities);
            $data['amenities']          = Amenities::where('status', 'Active')->get();
            $data['amenities_type']     = AmenityType::get();
        } elseif ($step == 'photos') {
            if ($request->isMethod('post')) {
               // dd($request->all());
                if ($request->crop == 'crop' && $request->photos) {
                    $baseText = explode(";base64,", $request->photos);
                    $name = explode(".", $request->img_name);
                    $convertedImage = base64_decode($baseText[1]);
                    $request->request->add(['type'=>end($name)]);
                    $request->request->add(['image'=>$convertedImage]);


                    $validate = Validator::make($request->all(), [
                        'type' => 'required|in:png,jpg,JPG,JPEG,jpeg,bmp',
                        'img_name' => 'required',
                        'photos' => 'required',
                    ]);
                    } else {
                        $validate = Validator::make($request->all(), [
                            'file' => 'required|file|mimes:jpg,jpeg,bmp,png,gif,JPG|dimensions:min_width=640,min_height=360',
                        ]);
                    }
                //dd($validate->fails());
                if ($validate->fails()) {
                    return back()->withErrors($validate)->withInput();
                }

                $path = public_path('images/property/' . $property_id . '/');

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                if ($request->crop == "crop") {
                    $image = $name[0].uniqid() . '.' . end($name);
                    $uploaded = file_put_contents($path . $image, $convertedImage);
                } else {
                    if (isset($_FILES["file"]["name"])) {
                        $tmp_name = $_FILES["file"]["tmp_name"];
                        $name = str_replace(' ', '_', $_FILES["file"]["name"]);
                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                        $image = time() . '_' . $name;
                        $path = 'public/images/property/' . $property_id;
                        if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'JPG') {
                            $uploaded = move_uploaded_file($tmp_name, $path . "/" . $image);
                        }
                    }
                }

                if ($uploaded) {
                    $photos = new PropertyPhotos;
                    $photos->property_id = $property_id;
                    $photos->photo = $image;
                    $photos->serial = 1;
                    $photos->cover_photo = 1;

                    $exist = PropertyPhotos::orderBy('serial', 'desc')
                        ->select('serial')
                        ->where('property_id', $property_id)
                        ->take(1)->first();

                    if (!empty($exist->serial)) {
                        $photos->serial = $exist->serial + 1;
                        $photos->cover_photo = 0;
                    }
                    $photos->save();
                    $property_steps = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->photos = 1;
                    $property_steps->save();
                }

                return redirect('listing/' . $property_id . '/photos')->with('success', 'File Uploaded Successfully!');

            }

            $data['photos'] = PropertyPhotos::where('property_id', $property_id)
                ->orderBy('serial', 'asc')
                ->get();

        } elseif ($step == 'pricing') {
            if ($request->isMethod('post')) {
                $bookings = Bookings::where('property_id', $property_id)->where('currency_code', '!=', $request->currency_code)->first();
                if ($bookings) {
                    return back()->withErrors(['currency' => __('Booking has been made using the current currency. It cannot be changed now')]);
                }
                $rules = array(
                    'price' => 'required|numeric|min:5',
                    'weekly_discount' => 'nullable|numeric|max:99|min:0',
                    'monthly_discount' => 'nullable|numeric|max:99|min:0'
                );

                $fieldNames = array(
                    'price'  => 'Price',
                    'weekly_discount' => 'Weekly Discount Percent',
                    'monthly_discount' => 'Monthly Discount Percent'
                );

                $validator = Validator::make($request->all(), $rules);
                $validator->setAttributeNames($fieldNames);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                } else {
                    $property_price                    = PropertyPrice::where('property_id', $property_id)->first();
                    $property_price->price             = $request->price;
                    $property_price->weekly_discount   = $request->weekly_discount;
                    $property_price->monthly_discount  = $request->monthly_discount;
                    $property_price->currency_code     = $request->currency_code;
                    $property_price->cleaning_fee      = $request->cleaning_fee;
                    $property_price->guest_fee         = $request->guest_fee;
                    $property_price->guest_after       = $request->guest_after;
                    $property_price->security_fee      = $request->security_fee;
                    $property_price->weekend_price     = $request->weekend_price;
                    $property_price->save();

                    $property_steps = PropertySteps::where('property_id', $property_id)->first();
                    $property_steps->pricing = 1;
                    $property_steps->save();

                    return redirect('listing/' . $property_id . '/booking');
                }
            }
        } elseif ($step == 'booking') {
            if ($request->isMethod('post')) {
                $property_steps          = PropertySteps::where('property_id', $property_id)->first();
                $property_steps->booking = 1;
                $property_steps->save();
                $properties               = Properties::find($property_id);
                $properties->booking_type = $request->booking_type;
                $properties->status       = ($properties->steps_completed == 0 ) ?  'Unlisted' : 'Listed';
                $properties->save();
                return redirect('listing/' . $property_id . '/calendar');
            }
        } elseif ($step == 'calendar') {
            $service_request = new PmsHelpdesk;
            $service_request->issue  = null;
            $service_request->image    = 'default.png';
            $service_request->status   = 'New Task';
            $service_request->description   = 'Onboard';
            $service_request->property_id   = $request->id;
            $service_request->priority   = 'Medium';
            $service_request->assign_to_sitemanager   = 0;
            $service_request->assign_to_supervisor   = self::getUser($request->id,'supervisor');
            $service_request->helpdesk_user_id   = self::getUser($request->id,'helpdesk');
            $service_request->save();
            $pms_job = new PmsJobs();
            $pms_job->user_id  = Auth::user()->id;
            $pms_job->property_id   = $request->id;
            $pms_job->helpdesk_id   = $service_request->id;
            $pms_job->status   = 'Onboard';
            $pms_job->save();
            $data['calendar'] = $calendar->generate($request->id);
        }
        return view("listing.$step", $data);
    }

    public function getUser($id,$role)
    {
        $data = Admin::where('pincode', PropertyAddress::where('property_id', $id)->value('postal_code'))->pluck('id')->toArray();
        if($role == 'supervisor'){
            foreach ($data as $value) {
                if (Common::get_roles($value) == 'supervisor') {
                    return $value;
                    break;
                }
            }
        }else{
            foreach ($data as $value) {
                if (Common::get_roles($value) == 'helpdesk') {
                    return $value;
                    break;
                }
            }
        }
        return 0;
    }

    public function updateStatus(Request $request)
    {
        $property_id = $request->id;
        $reqstatus = $request->status;
        if ($reqstatus == 'Listed') {
            $status = 'Unlisted';
        } else {
            $status = 'Listed';
        }
        $properties         = Properties::where('host_id', Auth::id())->find($property_id);
        $properties->status = $status;
        $properties->save();
        $properties->prop_status = __($status);
        return  response()->json($properties);

    }

    public function getPrice(Request $request)
    {

        return Common::getPrice($request->property_id, $request->checkin, $request->checkout, $request->guest_count);
    }

    public function single(Request $request)
    {
        $data['property_slug'] = $request->slug;

        $data['result'] = $result = Properties::where('slug', $request->slug)->first();
        
        $userActive = $result->Users()->where('id', $result->host_id)->first();
        if ($userActive->status == 'Inactive' ) {
            return view('property.host_inactive');

        } elseif ($data['result']->status == 'Unlisted' ) {
            return view('property.unlisted_property');

        } elseif ($data['result']->is_verified == 'Pending') {
            return view('property.pending_property');

        } else {
            if ( empty($result) ) {
                abort('404');
            }

            $data['property_id']      = $id = $result->id;
            $data['booking_status']   = Bookings::where('property_id',$id)->select('status')->first();

            $data['property_photos']  = PropertyPhotos::where('property_id', $id)->orderBy('serial', 'asc')
                ->get();

            $data['amenities']        = Amenities::normal($id);
            $data['safety_amenities'] = Amenities::security($id);

            $newAmenityTypes          = Amenities::newAmenitiesType();
            $data['all_new_amenities']= [];

            foreach ($newAmenityTypes as $amenites) {
                $data['all_new_amenities'][$amenites->name] = Amenities::newAmenities($id, $amenites->id);
            }

            $data['all_new_amenities']= array_filter($data['all_new_amenities']);

            $property_address         = $data['result']->property_address;

            $latitude                 = $property_address->latitude;

            $longitude                = $property_address->longitude;

            $data['checkin']          = (isset($request->checkin) && $request->checkin != '') ? $request->checkin:'';
            $data['checkout']         = (isset($request->checkout) && $request->checkout != '') ? $request->checkout:'';

            $data['guests']           = (isset($request->guests) && $request->guests != '')?$request->guests:'';

            $data['similar']  = Properties::join('property_address', function ($join) {
                                            $join->on('properties.id', '=', 'property_address.property_id');
            })
                                        ->select(DB::raw('*, ( 3959 * acos( cos( radians(' . $latitude . ') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude ) ) ) ) as distance'))
                                        ->having('distance', '<=', 30)
                                        ->where('properties.host_id', '!=', Auth::id())
                                        ->where('properties.id', '!=', $id)
                                        ->where('properties.status', 'Listed')
                                        ->get();

            $data['title']    =   $data['result']->name . ' in ' . $data['result']->property_address->city;
            $data['symbol'] = Common::getCurrentCurrencySymbol();
            $data['shareLink'] = url('properties/' . $data['property_slug']);

            $data['date_format'] = Settings::getAll()->firstWhere('name', 'date_format_type')->value;

            $data['adminPropertyApproval'] = Settings::getAll()->firstWhere('name', 'property_approval')->value;
            return view('property.single', $data);

        }
    }

    public function currencySymbol(Request $request)
    {
        $symbol          = Currency::code_to_symbol($request->currency);
        $data['success'] = 1;
        $data['symbol']  = $symbol;

        return json_encode($data);
    }

    public function photoMessage(Request $request)
    {
        $property = Properties::find($request->id);
        if ($property->host_id == \Auth::user()->id) {
            $photos = PropertyPhotos::find($request->photo_id);
            $photos->message = $request->messages;
            $photos->save();
        }

        return json_encode(['success'=>'true']);
    }

    public function photoDelete(Request $request)
    {
        $property   = Properties::find($request->id);
        if ($property->host_id == \Auth::user()->id) {
            $photos = PropertyPhotos::find($request->photo_id);
            $photos->delete();
        }

        return json_encode(['success'=>'true']);
    }

    public function makeDefaultPhoto(Request $request)
    {

        if ($request->option_value == 'Yes') {
            PropertyPhotos::where('property_id', '=', $request->property_id)
            ->update(['cover_photo' => 0]);

            $photos = PropertyPhotos::find($request->photo_id);
            $photos->cover_photo = 1;
            $photos->save();
        }
        return json_encode(['success'=>'true']);
    }

    public function makePhotoSerial(Request $request)
    {

        $photos         = PropertyPhotos::find($request->id);
        $photos->serial = $request->serial;
        $photos->save();

        return json_encode(['success'=>'true']);
    }


    public function set_slug()
    {

       $properties   = Properties::where('slug', NULL)->get();
       foreach ($properties as $key => $property) {

           $property->slug     = Common::pretty_url($property->name);
           $property->save();
       }
       return redirect('/');

    }

    public function userBookmark()
    {

        $data['bookings'] = Favourite::with(['properties' => function ($q) {
            $q->with('property_address');
        }])->where(['user_id' => Auth::id(), 'status' => 'Active'])->orderBy('id', 'desc')
            ->paginate(Settings::getAll()->where('name', 'row_per_page')->first()->value);
        return view('users.favourite', $data);
    }

    public function addEditBookMark()
    {
        $property_id = request('id');
        $user_id = request('user_id');

        $favourite = Favourite::where('property_id', $property_id)->where('user_id', $user_id)->first();

        if (empty($favourite)) {
            $favourite = Favourite::create([
                'property_id' => $property_id,
                'user_id' => $user_id,
                'status' => 'Active',
            ]);

        } else {
            $favourite->status = ($favourite->status == 'Active') ? 'Inactive' : 'Active';
            $favourite->save();
        }

        return response()->json([
            'favourite' => $favourite
        ]);
    }

    public function unauthenticationFavourite($id) 
    {
        Session::put('favourite_property', $id);
        return redirect('login');

    }

    public function downloadPropertyAgreement(Request $request)
    {
        $user_id = Properties::find($request->id)->host_id;
        $user = User::where('id', $user_id)->first();
        if ($user) {
            $property = Properties::where('id', $request->id)->first();
            if ($request->routeIs('admin-download-agreement')) {
                $property->agreement_status = 'View by Admin';
            } else {
                $property->agreement_status = 'Downloaded';
            }
            $property->save();
            $pdf = \PDF::loadView('emails.aggrement', ['user' => $user]);
            return $pdf->download('aggrement.pdf');
        }
    }

    public function uploadPropertyAgreement(Request $request)
    {
        $request->validate([
            'agreement_file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);
        if ($request->file('agreement_file')) {
            $file = $request->file('agreement_file');
            $property = Properties::find($request->id);
            if ($property->agreement_upload) {
                Storage::disk('public')->delete($property->agreement_upload);
            }
            $path = $file->store('property_agreements', 'public');
            $property->agreement_upload = $path;
            $property->agreement_status = 'Uploaded';
            $property->save();
            return redirect()->back()->with('success', 'Agreement uploaded successfully');
        }
        return response()->json(['success' => false, 'message' => 'Failed to upload agreement']);
    }


    
    public function view_agreement(Request $request)
    {
        $property = Properties::find($request->id);
        if ($property && $property->agreement_upload) {
            $property->agreement_status = 'View by Admin';
            $property->save();
            $file = Storage::disk('public')->path($property->agreement_upload);
            return response()->download($file, basename($property->agreement_upload));
        }
        return response()->json(['success' => false, 'message' => 'No agreement uploaded'], 404);
    }

    

    public function updateAgreementStatus(Request $request)
    {
        $property = Properties::where('id', $request->id)->first();
        $property->agreement_status = $request->agreement_status;
        $property->unapprove_comment = $request->unapprove_comment ?? null;
        $property->save();
        return response()->json(['success' => true, 'message' => 'Agreement status updated successfully']);
    }
}
