<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CalendarController;
use Illuminate\Http\Request;
use App\Models\{
    Favourite,
    Properties,
    PropertyDetails,
    PropertyAddress,
    PropertyPhotos,
    PropertyPrice,
    PropertyType,
    PropertyDescription,
    Currency,
    Settings,
    Bookings,
    SpaceType,
    BedType,
    PropertySteps,
    Country,
    Amenities,
    AmenityType,
    warehouetype,
    FloorType,
    ProperTypeOptionset,
    PropertyMetadata
};
use Auth, DB, Session, Validator, Common;
class PropertyController extends Controller
{
    // response status set
    const HTTP_STATUS_OK = 200;
    const HTTP_STATUS_VALIDATION_ERROR = 422;
    const HTTP_STATUS_INTERNAL_SERVER_ERROR = 500;

    public function create(Request $request)
    {
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
                return response(['errors' => $validator->errors()->all()],self::HTTP_STATUS_VALIDATION_ERROR);
            } else {
                $property                  = new Properties;
                $property->host_id         = Auth::id();
                if($request->space_type=="8" || $request->space_type=="7"){
                  $property->name            = warehouetype::getAll()->find($request->space_type)->name . ' in ' . $request->city;
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
                
                if($property_description->save()){
                    return response()->json(['status'=>true,'property_id'=>$property->id,'message'=>'Property created successfully.'],self::HTTP_STATUS_OK);
                } else{
                    return response()->json(['status'=>false,'message'=>'Something went wrong.'],self::HTTP_STATUS_INTERNAL_SERVER_ERROR);
                }
            }
    }



    public function basics(Request $request){
        $rules = array(
            'property_id'   => 'required',
            'bedrooms'      => 'required',
            'step'          => 'required',
            'beds'          => 'required',
            'bathrooms'     => 'required',
            'bed_type'      => 'required',
            'property_type' => 'required',
            'space_type'    => 'required',
            'accommodates'  => 'required'
            
        );

        $fieldNames = array(
            'property_id'   => 'Property_id',
            'bedrooms'      => 'Bedrooms',
            'Beds'          => 'Beds',
            'bathrooms'     => 'Bathrooms',
            'bed_type'      => 'Bed_type',
            'property_type' => 'Property_type',
            'space_type'    => 'Space_type',
            'accommodates'  => 'Accommodates',
            'step'          => 'Step',
        );

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($fieldNames);
        if ($validator->fails())
        {
            return response(['errors' => $validator->errors()->all()],self::HTTP_STATUS_VALIDATION_ERROR);
        }
        $property_id = $request->property_id;
        // check stap to form code 
        $data  = $this->checkStep($property_id, $request->step);

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
           

            if (!empty($request->other)) {
                foreach ($request->other as $index => $platformName) {
                    $registrationId = $request->platform[$index];
                    $existingMetadata = PropertyMetadata::where('property_id', $property->id)->first();
                    if (!$existingMetadata) {
                            $metadata = new PropertyMetadata();
                            $metadata->property_id = $property->id;
                            $metadata->where_list = $platformName;
                            $metadata->property_registration_id = $registrationId;
                            $metadata->save();
                        }
                    }
            }
            if( $property_steps->save()){
                return response()->json(['status'=>true,'details'=>$data,'message'=>'Basics updated successfully.'],self::HTTP_STATUS_OK); 
            } else{
                return response()->json(['status'=>false,'message'=>'Basics not updated.'],self::HTTP_STATUS_OK); 
                
            }
    }    

    public function description(Request $request){
            $rules = array(
                'property_id' => 'required|max:50',
                'name'        => 'required|max:50',
                'summary'     => 'required|max:1000'
            );

            $fieldNames = array(
                '$property_id' => 'Property_id',
                'name'         => 'Name',
                'summary'      => 'Summary',
            );

            $validator = Validator::make($request->all(), $rules);
            $validator->setAttributeNames($fieldNames);

            if ($validator->fails()){
                return response(['errors' => $validator->errors()->all()],self::HTTP_STATUS_VALIDATION_ERROR);
            }else{
                $property_id        = $request->property_id;
                $property           = Properties::find($property_id);
                $property->name     = $request->name;
                $property->slug     = Common::pretty_url($request->name);
                $property->save();

                $property_description              = PropertyDescription::where('property_id', $property_id)->first();
                $property_description->summary     = $request->summary;
                $property_description->save();

                $property_steps    = PropertySteps::where('property_id', $property_id)->first();
                $property_steps->description = 1;
                if($property_steps->save()){
                    // check stap to form code 
                    $data  = $this->checkStep($property_id, $request->step);
                     return response()->json(['status'=>true,'details'=>$data,'message'=>'Description updated successfully.'],self::HTTP_STATUS_OK);  
                } else{
                    return response()->json(['status'=>false,'message'=>'Description not updated.'],self::HTTP_STATUS_OK); 
                }
        }
    }
    
    public function location(Request $request){
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
            return response(['errors' => $validator->errors()->all()],self::HTTP_STATUS_VALIDATION_ERROR);
        } else {
            $property_id                     = $request->property_id;
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
            if($property_steps->save()){
                // check stap to form code
                $data  = $this->checkStep($property_id, $request->step);
                return response()->json(['status'=>true,'details'=>$data,'message'=>'Location updated successfully.'],self::HTTP_STATUS_OK); 
            } else{
                return response()->json(['status'=>false,'message'=>'Location not updated.'],self::HTTP_STATUS_OK);
            }
        }
    }


    public function amenities(Request $request){
        $rules = [
            'property_id' => 'required|max:50',
            'step' => 'required|max:50',
            'amenities'   => 'required|array',
            'amenities.*' => 'required|string',
        ];  

        $fieldNames = [
            'property_id' => 'Property_id',
            'amenities'   => 'Amenities',
            'step'        => 'Step',
        ];

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($fieldNames);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()],self::HTTP_STATUS_VALIDATION_ERROR);
        }
        
        if ($request->isMethod('post') && is_array($request->amenities)) {
            $rooms            = Properties::find($request->property_id);
            $rooms->amenities = implode(',', $request->amenities);
            if($rooms->save()){
                $data  = $this->checkStep($request->property_id, $request->step);
                return response()->json(['status'=>true,'details'=>$data,'message'=>'Amenities updated successfully.'],self::HTTP_STATUS_OK);
            } else{
                return response()->json(['status'=>false,'message'=>'Amenities not updated.'],self::HTTP_STATUS_OK);
            }
        }
    }

    public function photos(Request $request){
        $property_id = $request->property_id;
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
        if ($validate->fails()) {
            return response(['errors' => $validate->errors()->all()],self::HTTP_STATUS_VALIDATION_ERROR);
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
            if($property_steps->save()) {
                return response()->json(['status'=>true,'message'=>'Photos uploaded successfully.'],self::HTTP_STATUS_OK);
            } else {
                return response()->json(['status'=>false,'message'=>'Photos not uploaded.'],self::HTTP_STATUS_OK);
            }

        }
    }


    public function pricing(Request $request){
            $property_id = $request->property_id;
            $bookings = Bookings::where('property_id', $property_id)->where('currency_code', '!=', $request->currency_code)->first();
            if ($bookings) {
                return response()->json(['status'=>false,'message'=>'Booking has been made using the current currency. It cannot be changed now.'],self::HTTP_STATUS_OK);
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
                return response(['errors' => $validator->errors()->all()],self::HTTP_STATUS_VALIDATION_ERROR);
            } else {
                //dd($request->price);
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
                if($property_steps->save()) {
                    $data = $this->checkStep($property_id,$request->step);
                    return response()->json(['status'=>true,'details'=>$data,'message'=>'Price updated successfully.'],self::HTTP_STATUS_OK);
                } else {
                    return response()->json(['status'=>false,'message'=>'Price not updated.'],self::HTTP_STATUS_OK);
                }
            }
    }



    public function booking(Request $request){
        $rules = [
            'booking_type' => 'required',
            'property_id'  => 'required|numeric',
            'step'  => 'required|string',
        ];
        $fieldNames = array(
            'booking_type' => 'Booking Type',
            'property_id'  => 'Property Id',
            'step'  => 'Step',
        );

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($fieldNames);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()],self::HTTP_STATUS_VALIDATION_ERROR);
        }

            $property_id = $request->property_id;
            $property_steps          = PropertySteps::where('property_id', $property_id)->first();
            $property_steps->booking = 1;
            $property_steps->save();
            $properties               = Properties::find($property_id);
            $properties->booking_type = $request->booking_type;
            $properties->status       = ($properties->steps_completed == 0 ) ?  'Unlisted' : 'Listed';
            if($properties->save()){
                $data = $this->checkStep($property_id,$request->step);
                return response()->json(['status'=>true,'details'=>$data,'message'=>'Property updated successfully.'],self::HTTP_STATUS_OK);
            } else {
                return response()->json(['status'=>false,'message'=>'Property not updated.'],self::HTTP_STATUS_OK);
            }
            //return redirect('listing/' . $property_id . '/calendar');
    }

    public function calendar($id,CalendarController $calendar){
        return response()->json(['status'=>true,'calendar'=>$calendar->generate($id)],self::HTTP_STATUS_OK);
        //return view('listing.calendar');
    }

    protected function checkStep($property_id, $step){
        $data['step']    = $step;
        $data['result']  = Properties::where('host_id', Auth::id())->findOrFail($property_id);
        $data['details'] = PropertyDetails::pluck('value', 'field');
        $data['missed']  = PropertySteps::where('property_id',$property_id)->first(); 
        return $data;
    }

}
