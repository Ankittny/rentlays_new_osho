@extends('template')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/glyphicon.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/js/ninja/ninja-slider.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/single-property.min.css') }}">
    <style>
        /* Custom style for the info window */
        .info-window-content {
        font-family: Arial, sans-serif;
        max-width: 300px;
        }
        .info-window-header {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
        }
        .info-window-category {
        font-style: italic;
        color: #555;
        }
        .info-window-address {
        margin: 10px 0;
        }
        .info-window-photo {
        width: 100%;
        height: auto;
        margin-top: 10px;
        }
        .info-window-link {
        color: #1E90FF;
        text-decoration: none;
        font-size: 14px;
        margin-top: 10px;
        display: inline-block;
        }
    </style>
@endpush

@section('main')


<input type="hidden" id="front_date_format_type" value="{{ Session::get('front_date_format_type') }}">
<div class="main-panel mt-50 ">




{{--     
    <div class="container-fluid p-0  ">
        @if (count($property_photos) > 0)
                        <div class="row ">
                            <div class="col-md-12 col-sm-12  p-0 ">
                                <div class="row">
                                    @php $i=0 @endphp
                                    @foreach ($property_photos as $row_photos)
                                    @if ($i == 0)
                                    <div class="col-md-12 col-sm-12 mb-2 p-0 ">
                                        <div class="slider-image-container" onclick="lightbox({{ $i }})"
                                            style="background-image:url({{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }});">
                                        </div>
                                    </div>
                                    @elseif ($i <= 4) @if ($i==4) <div class="p-2 position-relative">
                                        <div class="view-all gal-img h-110px">
                                            <img src="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}"
                                                alt="property-photo" class="img-fluid h-110px rounded"
                                                onclick="lightbox({{ $i }})" />
                                            
                                        </div>
                                        <span class="btn btn-success"
                                                onclick="lightbox({{ $i }})">{{ __('View All') }}</span>
                                        </div>

                                @else
                                <div class="p-2">
                                    <div class="h-110px gal-img">
                                        <img src="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}"
                                            alt="property-photo" class="img-fluid h-110px rounded"
                                            onclick="lightbox({{ $i }})" />
                                    </div>
                                </div>
                                @endif
                                @else
                                @php break; @endphp
                                @endif
                                @php $i++ @endphp
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                <hr>
    </div> --}}


    @if (count($property_photos) > 0)
    <div class="grid-container OurLightgallery">
        @php $i=0 @endphp
        @foreach ($property_photos as $row_photos)
        @if ($i == 0)
        <div>
            <div class="lightbox_img_wrap">
                <img  data-toggle="modal" data-target=".bd-example-modal-lg" src="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}" data-imgsrc="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}">
            </div>
        </div>

        @elseif ($i <= 4) @if ($i==4)
        <div>
            <div class="lightbox_img_wrap">
                <img  data-toggle="modal" data-target=".bd-example-modal-lg" src="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}" data-imgsrc="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}">
                
            </div>
        </div>
        
        @else
        <div>
            <div class="lightbox_img_wrap">
                <img  src="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}" data-imgsrc="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}">
            </div>
        </div> 
        @endif
        @else
        @php break; @endphp
        @endif
        @php $i++ @endphp
        @endforeach
    </div>
    @endif

<section class="lightbox-container">
  <span class="material-symbols-outlined material-icons lightbox-btn left" id="left">
    <i class="fa fa-angle-left" aria-hidden="true"></i>
</span>
  <span class="material-symbols-outlined material-icons lightbox-btn right" id="right">
    <i class="fa fa-angle-right" aria-hidden="true"></i>
</span>
<span id="close" class="close material-icons material-symbols-outlined">
    <i class="fa fa-window-close" aria-hidden="true"></i>
</span>
  <div class="lightbox-image-wrapper">
  <img alt="lightboximage" class="lightbox-image">
  </div>
</section>

    </div>
</div>

<div class="container-fluid ">
    <div class="row" id="mainDiv">
        <div class="col-lg-8 col-xl-9">
            <div id="sideDiv">
                <div class="d-flex border rounded-4 p-4 mt-4">
                    <div class="text-center">
                        <a href="{{ url('users/show/' . $result?->host_id) }}">
                            <img alt="User Profile Image" class="img-fluid rounded-circle mr-4 img-90x90"
                                src="{{ $result?->users?->profile_src }}" title="{{ $result?->users?->first_name }}">
                        </a>
                    </div>

                    <div class="ml-2">
                        <h3 class="text-20 mt-4"><strong class="singlestrong">{{ $result?->name }}</strong></h3>
                        <span class="text-14 gray-text"><i class="fas fa-map-marker-alt"></i> 
                            {{ $result->property_address->city }} @if ($result->property_address->city !=''),@endif 
                            {{ $result->property_address->state }} @if ($result->property_address->state !=''),@endif 
                            {{ $result->property_address->countries->name ?? null }}
                        </span>
                        @if ($result->avg_rating)
                            <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf("%.1f",$result->avg_rating ) }} ({{ $result->guest_review }})</p>
                        @endif
                    </div>
                    <div class="ml-auto">
                        @auth
                            <a class="btn btn-sm book_mark_change" data-status="{{ $result->book_mark }}"
                                data-id="{{ $result->id }}" style="color:{{ ($result->book_mark == true) ? '#1dbf73' : '' }}; ">
                                <span style="font-size: 22px;">
                                    <i class="fas fa-heart pl-5"></i>
                                </span>
                            </a>
                        @else
                            <a class="btn btn-sm book_mark_change" data-id="{{ $result->id }}"
                                style="color:#1dbf73 }}; ">
                                <span style="font-size: 22px;">	
                                    <i class="fas fa-heart pl-2"></i>
                                </span>
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="row justify-content-between mt-4 ">
                    <div class="col text-center border p-4 rounded mt-3 mr-2 mr-sm-5 bg-light text-dark">
                        <i class="fa fa-home fa-2x" aria-hidden="true"></i>
                        <div>{{ $result->space_type_name }}</div>
                    </div>
                    @if($result->property_type!=29)
                        <div class="col text-center border p-4 rounded mt-3 bg-light text-dark">
                            <i class="fa fa-users fa-2x" aria-hidden="true"></i>
                            <div> {{ $result->accommodates }} {{ __('Guests') }} </div>
                        </div>
                    @else
                        <div class="col text-center border p-4 rounded mt-3 bg-light text-dark">
                             <i class="fa fa-building fa-2x" aria-hidden="true"></i>
                            <div> {{ $result->floor }} {{ __('Floor') }} </div>
                        </div>

                    @endif
                    @if($result->property_type!=29)
                    <div class="col text-center border p-4 rounded mt-3 ml-2 ml-sm-5 bg-light text-dark">
                        <i class="fa fa-bed fa-2x" aria-hidden="true"></i>
                        <div>
                            {{ $result->beds }} {{ __('Beds') }}
                        </div>
                    </div>
                    @else 
                    <div class="col text-center border p-4 rounded mt-3 ml-2 ml-sm-5 bg-light text-dark">
                        <i class="fa fa-square fa-2x" aria-hidden="true"></i>
                        <div>
                            {{ $result->super_area }} {{ __('Sq fit') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="row justify-content-center border rounded pb-5 mt-5 desktop" id="listMargin">
                <div class="col-md-12 mt-3 pl-4 pr-4">
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <h2><strong class="singlestrong">{{ __('About this listing') }}</strong> </h2>
                                <p class="mt-4 text-justify">{{ $result->property_description->summary }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="d-flex h-100">
                                    <div class="align-self-center">
                                        <h2 class="font-weight-700 text-18 singlestrong">
                                            {{ __('The Space') }}</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-sm-9">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        @if ($result?->bed_types?->name != NULL)
                                            <div>
                                                <span class="font-weight-600">{{ __('Bed type') }}:</span>
                                                {{ $result?->bed_types?->name }}
                                            </div>
                                        @endif

                                        <div>
                                            <strong class="singlestrong">{{ __('Property type') }}:</strong> {{ $result?->property_type_name }}
                                        </div>
                                        @if($result->property_type!=29)
                                        <div>
                                            <strong class="singlestrong">{{ __('Accommodates') }}:</strong> {{ $result?->accommodates }}
                                        </div>
                                        @endif
                                    </div>
                                   
                                @if($result->property_type==29)
                                    <div class="col-md-6 col-sm-6">
                                        <div>
                                            <strong class="singlestrong">{{ __('Floor') }}:</strong> {{ $result?->floor }}
                                        </div>

                                        <div>
                                            <strong class="singlestrong">{{ __('Super Area') }}:</strong> {{ $result?->super_area }}
                                        </div>

                                        <div>
                                            <strong class="singlestrong">{{ __('Property Age') }}:</strong> {{ $result?->property_age }}
                                        </div>
                                    </div>
                                 
                                @else 
                                    <div class="col-md-6 col-sm-6">
                                        <div>
                                            <strong class="singlestrong">{{ __('Bedrooms') }}:</strong> {{ $result?->bedrooms }}
                                        </div>

                                        <div>
                                            <strong class="singlestrong">{{ __('Bathrooms') }}:</strong> {{ $result?->bathrooms }}
                                        </div>

                                        <div>
                                            <strong class="singlestrong">{{ __('Beds') }}:</strong> {{ $result?->beds }}
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                   
                        @if($result->property_type!=29) <hr> @endif
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                @if($result->property_type!=29)
                                <div class="d-flex h-100">
                                    <div class="align-self-center">
                                        <h2 class="font-weight-700 text-18 singlestrong">
                                            {{ __('Amenities') }}</h2>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if (count($amenities) != 0)
                                  <div class="col-md-9 col-sm-9">
                                    @if($result->property_type!=29)
                                     <div class="row">
                                        @php $i = 1 @endphp
                                        @php $count = round(count($amenities)/2) @endphp
                                        @foreach ($amenities as $all_amenities)
                                            @if ($i < 6)
                                                <div class="col-md-6 col-sm-6">
                                                    <div>
                                                        <i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i>
                                                        @if ($all_amenities->status == null)
                                                            <del>
                                                                {{ $all_amenities->title }}
                                                            </del>
                                                        @else
                                                            {{ $all_amenities->title }}
                                                        @endif
                                                    </div>
                                         </div>
                                            @endif
                                            @php $i++ @endphp
                                        @endforeach
                                        @if ($i > 6)
                                            <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                                <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2" data-toggle="modal" data-target="#exampleModalCenter">
                                                    + {{ __('More') }}
                                                </button>
                                            </div>
                                        @endif
                                </div>
                                @endif
                            @else
                                <div class="col-md-9 col-sm-9">
                                     {{-- <b style="font-weight: bold">{{ __('There is no Amenities') }}</b> --}}
                                 </div>
                            @endif
                        </div>
                    
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18 singlestrong">{{ __('Prices') }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div> <i class="fa fa-users text-13 mr-2" style="color: #5d717fa2"></i> {{ __('Extra people') }}:
                                        <strong>
                                            @if ($result->property_price->guest_fee !=0)
                                            <span>
                                                {!! __(':x / night after the', ['x' => moneyFormat($symbol, $result->property_price->guest_fee)]) !!}
                                                {{ __(':x guest', ['x' => $result->property_price->guest_after] ) }}</span>
                                            @else
                                            <span>{{ __('No Charge') }}</span>
                                            @endif
                                        </strong>
                                    </div>

                                    <div>
                                        <i class="fa fa-arrow-down mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i> {{ __('Weekly discount') }} (%):
                                        @if ($result->property_price->weekly_discount != 0)
                                        <strong> <span id="weekly_price_string">{!! moneyFormat($symbol,
                                                $result->property_price->weekly_discount) !!}</span>
                                            /{{ __('week') }}</strong>
                                        @else
                                        <strong><span id="weekly_price_string">{!! moneyFormat($symbol,
                                                $result->property_price->weekly_discount) !!}</span>
                                            /{{ __('week') }}</strong>
                                        @endif
                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div>
                                        <i class="fa fa-arrow-down mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                        {{ __('Monthly discount') }} (%):
                                        @if ($result->property_price->monthly_discount != 0)
                                        <strong>
                                            <span id="weekly_price_string">{!! moneyFormat($symbol,
                                                $result->property_price->monthly_discount) !!}</span>
                                            /{{ __('month') }}
                                        </strong>
                                        @else
                                        <strong><span id="weekly_price_string">{!! moneyFormat($symbol,
                                                $result->property_price->monthly_discount) !!}</span>
                                            /{{ __('month') }}</strong>
                                        @endif
                                    </div>

                                    <!-- weekend price -->
                                    @if ($result->property_price->weekend_price > 0)
                                        <div>
                                            <i class="fa fa-calendar-minus mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                            {{ ('Weekend pricing') }}:
                                            <strong>
                                                <span id="weekly_price_string">{!! $symbol !!} {{ $result->property_price->weekend_price }}</span> /
                                                {{ __('Weekend Night') }}
                                            </strong>
                                        </div>
                                    @endif
                                    <!-- end weekend price -->
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (count($safety_amenities) !=0)
                    @if($result->property_type!=29)
                     <hr>
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="d-flex h-100">
                                    <div class="align-self-center">
                                        <h2 class="font-weight-700 text-18 singlestrong">
                                            {{ __('Safety Features') }}
                                        </h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-sm-9">
                                <div class="row">
                                    @php $i = 1 @endphp
                                    @foreach ($safety_amenities as $row_safety)
                                        @if ($i < 6)
                                        <div class="col-md-6 col-sm-6">
                                            <i class="fa h3 fa-{{ $row_safety->symbol }}" aria-hidden="true"></i>
                                            @if ($row_safety->status == null)
                                                <del>
                                                    {{ $row_safety->title }}
                                                </del>
                                            @else
                                                {{ $row_safety->title }}
                                            @endif
                                        </div>
                                        @endif
                                        @php $i++ @endphp
                                    @endforeach

                                    @if ($i>6)
                                        <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                            <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2" data-toggle="modal" data-target="#safetyModal">
                                                + {{ __('More') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif   
                    @endif
                    @if($result->property_type==29)
                            @if (count($all_new_amenities) != 0)
                                @foreach ($all_new_amenities as $key => $new_amenities)
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-3 col-sm-3">
                                            <div class="d-flex h-100">
                                                <div class="align-self-center">
                                                    <h2 class="font-weight-700 text-18 singlestrong"> {{ $key }}</h2>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-9 col-sm-9">
                                            <div class="row">
                                                @php $i = 1 @endphp
                                                @foreach ($new_amenities as $row_safety)
                                                    @if ($i < 6)
                                                        <div class="col-md-6 col-sm-6">
                                                            <i class="fa h3 fa-{{ $row_safety->symbol }}" aria-hidden="true"></i>
                                                            @if ($row_safety->status == null)
                                                                <del>
                                                                    {{ $row_safety->title }}
                                                                </del>
                                                            @else
                                                                {{ $row_safety->title }}
                                                            @endif
                                                        </div>
                                                    @endif
                                                    @php $i++ @endphp
                                                @endforeach
                                                @if ($i>6)
                                                    <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                                        <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2"
                                                            data-toggle="modal" data-target="#exampleModalCenter_{{ str_replace(" ","-",$key) }}">
                                                            + {{ __('More') }}
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                    @endif       
                    @if ($result?->property_description->about_place !='' ||
                    $result->property_description->place_is_great_for !='' ||
                    $result->property_description->guest_can_access !='' ||
                    $result->property_description->interaction_guests !='' || $result->property_description->other ||
                    $result->property_description->about_neighborhood || $result->property_description->get_around)
                    <hr>
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18 singlestrong">
                                        {{ __('Description') }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-9 col-sm-9">
                            @if ($result->property_description->about_place)
                                <strong class="font-weight-700">{{ __('About Place') }}</strong>
                                <p class="text-justify">{{ $result->property_description->about_place }}</p>
                            @endif

                            @if ($result->property_description->place_is_great_for)
                                <strong
                                    class="font-weight-700">{{ __('Place is Greate For') }}</strong>
                                <p class="text-justify">{{ $result->property_description->place_is_great_for }} </p>
                            @endif

                            <a href="javascript:void(0)" id="description_trigger_mobile" data-rel="description"
                                class="more-btn-mobile"><strong>+ {{ __('More') }}</strong></a>
                            <div class="d-none" id='description_after_mobile'>
                                @if ($result->property_description->interaction_guests)
                                    <strong
                                        class="font-weight-700">{{ __('Interaction with Guests') }}</strong>
                                    <p class="text-justify"> {{ $result->property_description->interaction_guests }}</p>
                                @endif

                                @if ($result->property_description->about_neighborhood)
                                    <strong
                                        class="font-weight-700">{{ __('About Neighborhood') }}</strong>
                                    <p class="text-justify"> {{ $result->property_description->about_neighborhood }}</p>
                                @endif

                                @if ($result->property_description->guest_can_access)
                                    <strong
                                        class="font-weight-700">{{ __('Guest can Access') }}</strong>
                                    <p class="text-justify">{{ $result->property_description->guest_can_access }}</p>
                                @endif

                                @if ($result->property_description->get_around)
                                    <strong
                                        class="font-weight-700">{{ __('Get Around') }}</strong>
                                    <p class="text-justify">{{ $result->property_description->get_around }}</p>
                                @endif

                                @if ($result->property_description->other)
                                    <strong class="font-weight-700">{{ __('Other') }}</strong>
                                    <p class="text-justify">{{ $result->property_description->other }}</p>
                                @endif
                                <a href="javascript:void(0)" id="description_less" data-rel="description"
                                    class="less-btn-mobile"><strong>{{ __('- less') }}</strong></a>

                            </div>
                        </div>
                    </div>
                    @endif
                    <hr>
                    <!--popup slider end-->
                   
                
            </div>

            <!--Start Reviews-->
            @if (!$result->reviews->count())
            <div class="mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <h2 ><strong>{{ __('No Reviews Yet') }}</strong></h2>
                    </div>

                    @if ($result->users->reviews->count())
                    <div class="col-md-12">
                        <p>{{ __('This host has :count review for other properties.',['count'=>$result->users->guest_review]) }}</p>
                        <p class="text-center mt-5 mb-4">
                            <a href="{{ url('users/show/' . $result->users->id) }}" class="btn btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                            {{  __('View Other Reviews') }}</a>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @else
            <div class="mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex">
                            <div>
                                <h2 class="text-20"><strong> {{ __('Review') }}</strong></h2>
                            </div>

                            <div class="ml-4">
                                <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf("%.1f",$result->avg_rating) }} ({{ $result->guest_review }})</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="font-weight-700 text-16">{{ __('Summary') }}</h3>
                    </div>

                    <div class="col-md-12">
                        <div class="mt-3 p-4 pt-3 pb-3 border rounded">
                            <div class="row justify-content-between">
                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Accuracy') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->accuracy_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->accuracy_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Location') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->location_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->location_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4 class="text-truncate">{{ __('Communication') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->communication_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->communication_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Check In') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->checkin_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->checkin_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Cleanliness') }}</h4>
                                        </div>

                                        <div>
                                            <progress max="5" value="{{ $result->cleanliness_avg_rating }}">
                                                <div class="progress-bar">
                                                    <span></span>
                                                </div>
                                            </progress>
                                            <span> {{ sprintf("%.1f",$result->cleanliness_avg_rating) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xl-5">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ __('Value') }}</h4>
                                        </div>

                                        <div>
                                            <ul>
                                                <li>
                                                    <progress max="5" value="{{ $result->value_avg_rating }}">
                                                        <div class="progress-bar">
                                                            <span></span>
                                                        </div>
                                                    </progress>
                                                    <span> {{ sprintf("%.1f",$result->value_avg_rating) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <div class="row">
                    @foreach ($result->reviews as $row_review)
                    @if ($row_review->reviewer == 'guest')
                    <div class="col-12 mt-4 mb-2">
                        <div class="d-flex">
                            <div class="">
                                <div class="media-photo-badge text-center">
                                    <a href="{{ url('users/show/' . $row_review->users->id) }}"><img
                                            alt="{{ $row_review->users->first_name }}" class=""
                                            src="{{ $row_review->users->profile_src }}"
                                            title="{{ $row_review->users->first_name }}"></a>
                                </div>
                            </div>

                            <div class="ml-2 pt-2">
                                <a href="{{ url('users/show/' . $row_review->users->id) }}">
                                    <h2 class="text-16 font-weight-700 ">{{ $row_review->users->full_name }}</h2>
                                </a>
                                <p class="text-14 text-muted"><i class="far fa-clock"></i> {{ dateFormat($row_review->date_fy) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <div class="background text-15">
                            @for($i=1; $i <=5 ; $i++) @if ($row_review->rating >= $i)
                                <i class="fa fa-star secondary-text-color"></i>
                                @else
                                <i class="fa fa-star"></i>
                                @endif
                                @endfor
                        </div>
                        <p class="mt-2 text-justify pr-4">{{ $row_review->message }}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>

            <div class="mt-4">
                @if ($result->users->reviews->count() - $result->reviews->count())
                <div class="row">

                    <div class="col-md-12">
                        <p class="text-center mt-2 ">
                            <a target="blank"
                                class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5"
                                href="{{ url('users/show/' . $result->users->id) }}">
                                <span>{{ __('View Other Reviews') }}</span>
                            </a>
                        </p>
                    </div>
                </div>
                @endif
            </div>
            @endif
            <hr>
            <!--End Reviews-->
            <div class="mt-5">
                <div class="col-md-12">
                    <div class="clearfix"></div>
                    <h2><strong>{{ __('About the Host') }}</strong></h2>
                    <div class="d-flex mt-4">
                        <div class="">
                            <div class="media-photo-badge text-center">
                                <a href="{{ url('users/show/' . $result->host_id) }}"><img
                                        alt="{{ $result->users->first_name }}" class=""
                                        src="{{ $result->users->profile_src }}"
                                        title="{{ $result->users->first_name }}"></a>
                            </div>
                        </div>

                        <div class="ml-2 pt-3">
                            <a href="{{ url('users/show/' . $result->host_id) }}">
                                <h2 class="text-16 font-weight-700">{{ $result->users->full_name }}</h2>
                            </a>
                            <p>{{ __('Member since') }} {{ date('F Y',
                                strtotime($result->users->created_at)) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-4 col-xl-3 mb-4 mt-4">
    <div id="sticky-anchor" class="d-none d-md-block"></div>
    <div class="card p-4" style="position: sticky;  top: 96px;  height:auto">
        <div id="booking-price" class="panel panel-default">
            <div class="" id="booking-banner" class="">
                <div class="secondary-bg rounded">
                    <div class="col-lg-12">
                        <div class="row justify-content-between p-3">
                            <div class="text-white">
                                {!! moneyFormat($symbol, numberFormat($result->property_price->price,2)) !!}
                            </div>

                            <div class="text-white text-14">
                                <div id="per_night" class="per-night">
                                  @if($result->property_type!=29)  {{ __('Per Night') }}@endif
                                </div>
                                <div id="per_month" class="per-month display-off">
                                    {{ __('Per Month') }}
                                    <i id="price-info-tooltip" class="fa fa-question hide" data-behavior="tooltip"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <form accept-charset="UTF-8" method="post" action="{{ url('payments/book/' . $property_id) }}"
                    id="booking_form">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12  p-4 single-border border-r-10 ">
                            <div class="row p-2" id="daterange-btn">
                                <div class="col-6 p-0">
                                    <label>{{ __('Check In') }}</label>
                                    <div class="mr-2">
                                        <input class="form-control" id="startDate" name="checkin"
                                            value="{{ $checkin ? $checkin : onlyFormat(date('d-m-Y', time() + 86400)) }}"
                                            placeholder="dd-mm-yyyy" type="text" required>
                                    </div>
                                </div>
                                <input type="hidden" id="property_id" value="{{ $property_id }}">
                                <input type="hidden" id="room_blocked_dates" value="">
                                <input type="hidden" id="calendar_available_price" value="">
                                <input type="hidden" id="room_available_price" value="">
                                <input type="hidden" id="price_tooltip" value="">
                                <input type="hidden" id="url_checkin" value="{{ $checkin }}">
                                <input type="hidden" id="url_checkout" value="{{ $checkout }}">
                                <input type="hidden" id="url_guests" value="{{ $guests }}">
                                <input type="hidden" name="booking_type" id="booking_type"
                                    value="{{ $result->booking_type }}">

                                <div class="col-6 p-0">
                                    <label>{{ __('Check Out') }}</label>
                                    <div class="ml-2">
                                        <input class="form-control" id="endDate" name="checkout"
                                            value="{{ $checkout ? $checkout : onlyFormat(date('d-m-Y', time() + 86400)) }}"
                                            placeholder="dd-mm-yyyy" type="text" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 p-0">
                                @if($result->property_type!=29)
                                    <div class=" ml-2 mr-2 ">
                                        <label>{{ __('guest') }}</label>
                                        <div class="">
                                            <select id="number_of_guests" class="form-control" name="number_of_guests">
                                                @for($i=1; $i<= $result->accommodates; $i++)
                                                    <option value="{{ $i }}" <?= $guests == $i ? 'selected' : '' ?>>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="book_it" class="mt-4">
                        <div class="js-subtotal-container booking-subtotal panel-padding-fit">
                            <div id="loader" class="display-off single-load">
                                <img src="{{ asset('public/front/img/green-loader.gif') }}" alt="loader">
                            </div>
                            <div class="table-responsive price-table-scroll">
                                <table class="table table-bordered price_table" id="booking_table">
                                    <tbody>
                                        <div id="append_date">

                                        </div>
                                       @if($result->property_type!=29)
                                        <tr>
                                            <td class="pl-4 w-50">
                                                <span id="total_night_count" value="">0</span>
                                                {{ __('Nights') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="total_night_price" value=""> 0 </span>
                                                <span id="custom_price" class="fa fa-info-circle secondary-text-color"
                                                    data-html="true" data-toggle="tooltip" data-placement="top"
                                                    title=""></span></td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td class="pl-4">
                                                {{ __('Service Fee') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="service_fee" value=""> 0 </span></td>
                                        </tr>
                                      
                                            <tr class="additional_price">
                                                <td class="pl-4">
                                                    {{ __('Additional Guest fee') }}
                                                </td>
                                                <td class="pl-4 text-right"><span id="additional_guest" value=""> 0 </span>
                                                </td>
                                            </tr>
                                    
                                        <tr class="security_price">
                                            <td class="pl-4">
                                                {{ __('Security Fee') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="security_fee" value=""> 0 </span></td>
                                        </tr>

                                        <tr class="cleaning_price">
                                            <td class="pl-4">
                                                {{ __('Cleaning Fee') }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="cleaning_fee" value=""> 0 </span></td>
                                        </tr>

                                        <tr class="iva_tax">
                                            <td class="pl-4">
                                                {{ __('I.V.A Tax') }}
                                            </td>
                                            <td class="pl-4 text-right"> <span id="iva_tax" value=""> 0 </span></td>
                                        </tr>

                                        <tr class="accomodation_tax">
                                            <td class="pl-4">
                                                {{ __('Accommodation Tax') }}
                                            </td>
                                            <td class="pl-4 text-right"> <span id="accomodation_tax" value=""> 0 </span>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="pl-4">
                                                {{ __("Discount") }}
                                            </td>
                                            <td class="pl-4 text-right"><span id="discount" value="">0 </span></td>
                                        </tr>

                                        <tr>
                                            <td class="pl-4">{{ __('Total') }}</td>
                                            <td class="pl-4 text-right"><span id="total" value=""> 0 </span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div id="book_it_disabled" class="text-center d-none">
                            <p id="book_it_disabled_message" class="icon-rausch">
                                {{ __('Dates Not Available') }}
                            </p>
                            <a href="{{ url('search?location=' . $result->property_address->city) }}"
                                class="btn btn-large btn-block text-14" id="view_other_listings_button">
                                {{ __('View Other Listing') }}
                            </a>
                        </div>

                        <div id="minimum_disabled" class="text-center d-none">
                            <p class="icon-rausch text-danger">
                                {{ __('You have to book minimum') }} <span
                                    id="minimum_disabled_message"></span>
                                {{ __('night\'s on this date') }}
                            </p>
                            <a href="{{ url('search?location=' . $result->property_address->city) }}"
                                class="btn btn-large btn-block text-14" id="view_other_listings_button">
                                {{ __('View Other Listing') }}
                            </a>
                        </div>
                        <div class="book_btn col-md-12 text-center {{ ($result->host_id == Auth()->user()?->id || $result->status == 'Unlisted') ? 'display-off' : '' }}">
                            @if ( ($adminPropertyApproval == 'Yes' && $result->is_verified != 'Pending') ||  $adminPropertyApproval == 'No')
                                <button type="submit"
                                    class="btn vbtn-outline-success text-14 font-weight-700 mt-3 pl-5 pr-5 pt-3 pb-3"
                                    id="save_btn">
                                    <i class="spinner fa fa-spinner fa-spin d-none"></i>
                                    <span class="{{ ($result->booking_type != 'instant') ? '' : 'display-off' }}">
                                        {{ __('Request to Book') }}
                                    </span>
                                    <span class="{{ ($result->booking_type == 'instant') ? '' : 'display-off' }}">
                                        <i class="icon icon-bolt text-beach h4"></i>
                                        {{ __('Instant Book') }}
                                    </span>
                                </button>
                            @endif
                        </div>

                        <p class="col-md-12 text-center mt-3">{{ __('You’ll be able to review before paying.') }}</p>

                        <ul class="list-inline text-center d-flex align-items-center justify-content-center">
                            <li class="list-inline-item">
                                @php
                                echo '<iframe
                                    src="https://www.facebook.com/plugins/share_button.php?href=' . $shareLink . '&layout=button&size=large&mobile_iframe=true&width=73&height=28&appId"
                                    width="76" height="28" class="overflow-hidden border-0" scrolling="no"
                                    frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>';
                                @endphp
                            </li>

                            <li class="list-inline-item">
                                <a class="twitter-share-button" href="https://twitter.com/intent/tweet?text=" . $title
                                    data-size="large" aria-label="tweet">Tweet</a>
                            </li>

                            <li class="list-inline-item">
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $shareLink }}&title={{ $title }}&summary={{ $result->property_description->summary }}"
                                    aria-label="linkedin"
                                    onclick="window.open(this.href, 'mywin','left=20,top=20,width=500,height=500,toolbar=1,resizable=0'); return false;"
                                    class="shareButton">
                                    <i class="fab fa-linkedin-in"></i> Share
                                </a>
                            </li>
                        </ul>
                    </div>
                    <input id="hosting_id" name="hosting_id" type="hidden" value="{{ $result->id }}">
                </form>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

</div>
{{-- erorr check here --}}
<div class="row mt-4 mt-sm-0 mobile">
    <div class="col-lg-8 col-xl-9 col-sm-12">
        <div class="row  justify-content-center border rounded pb-5" id="listMargin">
            <div class="col-md-12 mt-3 pl-4 pr-4">
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-12">
                            <h2><strong>{{ __('About this listing') }}</strong> </h2>
                            <p class="mt-4 text-justify">{{ $result->property_description->summary }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18"> {{ __('The Space') }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        
                      @if(!empty($result->bedrooms) && !empty($result->beds) && !empty($result->bed_type) && !empty($result->bathrooms))  
                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    @if ($result?->bed_types->name != NULL)
                                        <div>
                                            <span class="font-weight-600">{{ __('Bed type') }}:</span>
                                            {{ $result?->bed_types?->name }}
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ __('Property type') }}:</strong> 
                                        {{ $result?->property_type_name }}
                                    </div>
                                    <div>
                                        <strong>{{ __('Accommodates') }}:</strong> 
                                        {{ $result?->accommodates }}
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div>
                                        <strong>{{ __('Bedrooms') }}:</strong> 
                                        {{ $result?->bedrooms }}
                                    </div>

                                    <div>
                                        <strong>{{ __('Bathrooms') }}:</strong> 
                                        {{ $result?->bathrooms }}
                                    </div>

                                    <div>
                                        <strong>{{ __('Beds') }}:</strong> 
                                        {{ $result?->beds }}
                                    </div>
                                </div>
                            </div>
                        </div>
                      @endif 
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="d-flex h-100">
                                <div class="align-self-center">
                                    <h2 class="font-weight-700 text-18"> {{ __('Amenities') }}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9">
                            <div class="row">
                                @php $i = 1 @endphp

                                @php $count = round(count($amenities)/2) @endphp
                                @foreach ($amenities as $all_amenities)
                                    @if ($i < 6)
                                        <div class="col-md-6 col-sm-6">
                                            <div>
                                                <i class="icon h3 icon-{{ $all_amenities->symbol }}" aria-hidden="true"></i>
                                                @if ($all_amenities->status == null)
                                                    <del>
                                                        {{ $all_amenities->title }}
                                                    </del>
                                                @else
                                                    {{ $all_amenities->title }}
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    @php $i++ @endphp
                                @endforeach

                                <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                    <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2" data-toggle="modal" data-target="#exampleModalCenter">
                                        + {{ __('More') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="d-flex h-100">
                            <div class="align-self-center">
                                <h2 class="font-weight-700 text-18">{{ __('Prices') }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-sm-9">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div>
                                    <i class="fa fa-minus-circle mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                    {{ __('Extra people') }}:
                                    <strong>
                                        @if ($result->property_price->guest_fee !=0)
                                        <span> {!! moneyFormat($symbol, $result->property_price->guest_fee) !!} /
                                            {{ __('night after the') }}
                                            {{ $result->property_price->guest_after }}
                                            {{ __('guest') }}</span>
                                        @else
                                        <span>{{ __('No Charge') }}</span>
                                        @endif
                                    </strong>
                                </div>

                                <div>
                                    <i class="fa fa-arrow-down mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                    {{ __('Weekly discount') }} (%):
                                    @if ($result->property_price->weekly_discount != 0)
                                    <strong> <span id="weekly_price_string">{!! moneyFormat($symbol,
                                            $result->property_price->weekly_discount) !!}</span>
                                        /{{ __('week') }}</strong>
                                    @else
                                    <strong><span id="weekly_price_string">{!! moneyFormat($symbol,
                                            $result->property_price->weekly_discount) !!}</span>
                                        /{{ __('week') }}</strong>
                                    @endif
                                </div>

                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div>
                                    <i class="fa fa-arrow-down mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                    {{ __('Monthly discount') }} (%):
                                    @if ($result->property_price->monthly_discount != 0)
                                    <strong>
                                        <span id="weekly_price_string">{!! moneyFormat($symbol,
                                            $result->property_price->monthly_discount) !!}</span>
                                        /{{ __('month') }}
                                    </strong>
                                    @else
                                    <strong><span id="weekly_price_string">{!! moneyFormat($symbol,
                                            $result->property_price->monthly_discount) !!}</span>
                                        /{{ __('month') }}</strong>
                                    @endif
                                </div>

                                <!-- weekend price -->
                                @if ($result->property_price->weekend_price > 0)
                                <div>
                                    <i class="fa fa-calendar-minus mr-2 text-13" style="color: #5d717fa2" aria-hidden="true"></i>
                                    {{ __('Weekend pricing') }}:
                                    <strong>
                                        <span id="weekly_price_string">{!! $symbol !!} {{ $result->property_price->weekend_price }}</span> 
                                        / {{ __('Weekend Night') }}
                                    </strong>
                                </div>
                                @endif
                                <!-- end weekend price -->
                            </div>
                        </div>
                    </div>
                </div>
                
                @if (count($safety_amenities) !=0)
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="d-flex h-100">
                            <div class="align-self-center">
                                <h2 class="font-weight-700 text-18">{{ __('Safety Features') }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-sm-9">
                        <div class="row">
                            @php $i = 1 @endphp
                            @foreach ($safety_amenities as $row_safety)
                                @if ($i < 6)
                                <div class="col-md-6 col-sm-6">
                                    <div>
                                        <i class="icon h3 icon-{{  $row_safety->symbol }}" aria-hidden="true"></i>
                                        @if ( $row_safety->status == null)
                                            <del>
                                                {{ $row_safety->title }}
                                            </del>
                                        @else
                                            {{ $row_safety->title }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @php $i++ @endphp
                            @endforeach

                            <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2" data-toggle="modal" data-target="#safetyModal">
                                    + {{ __('More') }}
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
                @endif
                
                @if (count($all_new_amenities) != 0)
                    @foreach ($all_new_amenities as $key => $new_amenities)
                        <hr>
                        <div class="row">
                            <div class="col-md-3 col-sm-3">
                                <div class="d-flex h-100">
                                    <div class="align-self-center">
                                        <h2 class="font-weight-700 text-18"> {{ $key }}</h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9 col-sm-9">
                                <div class="row">
                                    @php $i = 1 @endphp
                                    @foreach ($new_amenities as $row_safety)
                                        @if ($i < 6)
                                            <div class="col-md-6 col-sm-6">
                                                <i class="fa h3 fa-{{ $row_safety->symbol }}" aria-hidden="true"></i>
                                                @if ($row_safety->status == null)
                                                    <del>
                                                        {{ $row_safety->title }}
                                                    </del>
                                                @else
                                                    {{ $row_safety->title }}
                                                @endif
                                            </div>
                                        @endif
                                        @php $i++ @endphp
                                    @endforeach
                                    @if ($i>6)
                                        <div class="col-md-6 col-sm-6" id="amenities_trigger">
                                            <button type="button" class="btn btn-outline-dark btn-lg text-16 mt-4 mr-2"
                                                data-toggle="modal" data-target="#exampleModalCenter_{{ $key }}">
                                                + {{ __('More') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                @if ($result?->property_description?->about_place !='' ||
                $result->property_description->place_is_great_for !='' ||
                $result->property_description->guest_can_access !='' ||
                $result->property_description->interaction_guests !='' || $result->property_description->other ||
                $result->property_description->about_neighborhood || $result->property_description->get_around)
                <hr>
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <div class="d-flex h-100">
                            <div class="align-self-center">
                                <h2 class="font-weight-700 text-18">{{ __('Description') }}
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-sm-9">
                        @if ($result->property_description->about_place)
                        <strong class="font-weight-700">{{ __('About Place') }}</strong>
                        <p class="text-justify">{{ $result->property_description->about_place }}</p>
                        @endif

                        @if ($result->property_description->place_is_great_for)
                        <strong class="font-weight-700">{{ __('Place is Greate For') }}</strong>
                        <p class="text-justify">{{ $result->property_description->place_is_great_for }} </p>
                        @endif

                        <a href="javascript:void(0)" id="description_trigger" data-rel="description"
                            class="more-btn"><strong>+ {{ __('More') }}</strong></a>
                        <div class="d-none" id='description_after'>
                            @if ($result->property_description->interaction_guests)
                            <strong
                                class="font-weight-700">{{ __('Interaction with Guests') }}</strong>
                            <p class="text-justify"> {{ $result->property_description->interaction_guests }}</p>
                            @endif

                            @if ($result->property_description->about_neighborhood)
                            <strong
                                class="font-weight-700">{{ __('About Neighborhood') }}</strong>
                            <p class="text-justify"> {{ $result->property_description->about_neighborhood }}</p>
                            @endif

                            @if ($result->property_description->guest_can_access)
                            <strong class="font-weight-700">{{ __('Guest can Access') }}</strong>
                            <p class="text-justify">{{ $result->property_description->guest_can_access }}</p>
                            @endif

                            @if ($result->property_description->get_around)
                            <strong class="font-weight-700">{{ __('Get Around') }}</strong>
                            <p class="text-justify">{{ $result->property_description->get_around }}</p>
                            @endif

                            @if ($result->property_description->other)
                            <strong class="font-weight-700">{{ __('Other') }}</strong>
                            <p class="text-justify">{{ $result->property_description->other }}</p>
                            @endif
                            <a href="javascript:void(0)" id="description_less" data-rel="description"
                                class="less-btn"><strong> {{ __('- less') }}</strong></a>

                        </div>
                    </div>
                </div>
                @endif
                <hr>

                <!--popup slider-->
                <div class="d-none" id="showSlider-mobile">
                    <div id="ninja-slider-mobile">
                        <div class="slider-inner">
                            <ul>
                                @foreach ($property_photos as $row_photos)
                                <li>
                                    <a class="ns-img"
                                        href="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}"
                                        aria-label="photo">
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
                        </div>
                    </div>
                </div>
            {{-- @if (count($property_photos) > 0)
                     <div class="row mt-4">
                    <div class="col-md-12 col-sm-12 pl-3 pr-3">
                        <div class="row">
                            @php $i=0 @endphp

                            @foreach ($property_photos as $row_photos)
                            @if ($i == 0)
                            <div class="col-md-12 col-sm-12 mb-2 mt-2 p-2">
                                <div class="slider-image-container" onclick="lightbox({{ $i }})"
                                    style="background-image:url({{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }});">
                                </div>
                            </div>
                            @elseif ($i <= 4) @if ($i==4) <div class="p-2 position-relative">
                                <div class="view-all gal-img h-110px">
                                    <img src="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}"
                                        alt="property-photo" class="img-fluid h-110px rounded"
                                        onclick="lightbox({{ $i }})" />
                                    <span class="position-center cursor-pointer"
                                        onclick="lightbox({{ $i }})">{{ __('View All') }}</span>
                                </div>
                        </div>

                        @else
                        <div class="p-2">
                            <div class="h-110px gal-img">
                                <img src="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}"
                                    alt="property-photo" class="img-fluid h-110px rounded" onclick="lightbox({{ $i }})" />
                            </div>
                        </div>
                        @endif
                        @else
                        @php break; @endphp
                        @endif
                        @php $i++ @endphp
                        @endforeach
                    </div>
                    </div>
                    </div>
                    <hr>
            @endif --}}            
        </div>
        <!--Start Reviews-->
        @if (!$result->reviews->count())
        <div class="mt-5">
            <div class="row">
                <div class="col-md-12">
                    <h2><strong>{{ __('No Reviews Yet') }}</strong></h2>
                </div>
                @if ($result->users->reviews->count())
                <div class="col-md-12">
                    <p>{{ __(' This host has :count review for other properties.',['count'=>$result->users->guest_review]) }}</p>
                    <p class="text-center mt-5 mb-4">
                        <a href="{{ url('users/show/' . $result->users->id) }}" class="btn btn vbtn-outline-success text-14 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                        {{ __('View Other Reviews') }}
                        </a>
                    </p>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex">
                        <div>
                            <h2 class="text-20 "><strong> {{ __('Review') }}</strong></h2>
                        </div>
                        <div class="ml-4">
                            <p> <i class="fa fa-star secondary-text-color"></i> {{ sprintf("%.1f",$result->avg_rating ) }}
                                ({{ $result->guest_review }})</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="font-weight-700 text-16 singlestrong">{{ __('Summary') }}</h3>
                </div>
                <div class="col-md-12">
                    <div class="mt-3 p-4 pt-3 pb-3 border rounded">
                        <div class="row justify-content-between">
                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Accuracy') }}</h4>
                                    </div>
                                    <div>
                                        <progress max="5" value="{{ $result->accuracy_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->accuracy_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Location') }}</h4>
                                    </div>
                                    <div>
                                        <progress max="5" value="{{ $result->location_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->location_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 class="text-truncate">{{ __('Communication') }}</h4>
                                    </div>

                                    <div>
                                        <progress max="5" value="{{ $result->communication_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->communication_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Check In') }}</h4>
                                    </div>

                                    <div>
                                        <progress max="5" value="{{ $result->checkin_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->checkin_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Cleanliness') }}</h4>
                                    </div>

                                    <div>
                                        <progress max="5" value="{{ $result->cleanliness_avg_rating }}">
                                            <div class="progress-bar">
                                                <span></span>
                                            </div>
                                        </progress>
                                        <span> {{ sprintf("%.1f",$result->cleanliness_avg_rating) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xl-5">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4>{{ __('Value') }}</h4>
                                    </div>

                                    <div>
                                        <ul>
                                            <li>
                                                <progress max="5" value="{{ $result->value_avg_rating }}">
                                                    <div class="progress-bar">
                                                        <span></span>
                                                    </div>
                                                </progress>
                                                <span> {{ sprintf("%.1f",$result->value_avg_rating) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <div class="row">
                @foreach ($result->reviews as $row_review)
                    @if ($row_review->reviewer == 'guest')
                        <div class="col-12 mt-4 mb-2">
                            <div class="d-flex">
                                <div class="">
                                    <div class="media-photo-badge text-center">
                                        <a href="{{ url('users/show/' . $row_review->users->id) }}"><img
                                                alt="{{ $row_review->users->first_name }}" class=""
                                                src="{{ $row_review->users->profile_src }}"
                                                title="{{ $row_review->users->first_name }}"></a>
                                    </div>
                                </div>

                                <div class="ml-2 pt-2">
                                    <a href="{{ url('users/show/' . $row_review->users->id) }}">
                                        <h2 class="text-16 font-weight-700">{{ $row_review->users->full_name }}</h2>
                                    </a>
                                    <p class="text-14 text-muted"><i class="far fa-clock"></i> {{ dateFormat($row_review->date_fy) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="background text-15">
                                @for($i=1; $i <=5 ; $i++) @if ($row_review->rating >= $i)
                                    <i class="fa fa-star secondary-text-color"></i>
                                    @else
                                    <i class="fa fa-star"></i>
                                    @endif
                                    @endfor
                            </div>
                            <p class="mt-2 text-justify pr-4">{{ $row_review->message }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="mt-4">
            @if ($result->users->reviews->count() - $result->reviews->count())
            <div class="row">

                <div class="col-md-12">
                    <p class="text-center mt-2">
                        <a target="blank"
                            class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 pl-5 pr-5"
                            href="{{ url('users/show/' . $result->users->id) }}">
                            <span>{{ __('View Other Reviews') }}</span>
                        </a>
                    </p>
                </div>
            </div>
            @endif
        </div>
        @endif
        <hr>
        <!--End Reviews-->
        <div class="mt-5">
            <div class="col-md-12">
                <div class="clearfix"></div>
                <h2><strong>{{ __('About the Host') }}</strong></h2>
                <div class="d-flex mt-4">
                    <div class="">
                        <div class="media-photo-badge text-center">
                            <a href="{{ url('users/show/' . $result->host_id) }}"><img
                                    alt="{{ $result->users->first_name }}" class=""
                                    src="{{ $result->users->profile_src }}"
                                    title="{{ $result->users->first_name }}"></a>
                        </div>
                    </div>

                    <div class="ml-2 pt-3">
                        <a href="{{ url('users/show/' . $result->host_id) }}">
                            <h2 class="text-16 font-weight-700">{{ $result->users->full_name }}</h2>
                        </a>
                        <p>{{ __('Member since') }} {{ date('F Y', strtotime($result->users->created_at)) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<div class="container-fluid container-fluid-90 mt-70">
    <div class="row mt-5">
        <div class="col-md-12">
            <div id="map" style="height: 500px; width: 100%;"></div>
            <div id="property-list" style="margin-top: 20px;"></div>
        </div>
    </div>
</div>

<div class="container-fluid container-fluid-90 mt-70 mb-5">
    @if (count($similar)!= 0)
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center-sm text-20 font-weight-700">{{ __('Similar Listings') }}</h2>
        </div>
    </div>

    <div class="row m-0 mt-5 mb-5">
        @foreach ($similar->slice(0, 8) as $row_similar)
        <div class="col-md-6 col-lg-4 col-xl-3 p-2 mt-4 pl-4 pr-4">
            <div class="card h-100 border card-1 noShadowborder">
                <div class="grid">
                    <a href="{{ $row_similar->slug }}">
                        <figure class="effect-milo">
                            <img src="{{ $row_similar->cover_photo }}" class="room-image-container200" alt="img11" />
                            <figcaption>
                            </figcaption>
                        </figure>
                    </a>
                </div>

                <div class="card-body p-0 pl-1 pr-1">
                    <div class="d-flex">
                        {{-- <div>
                            <div class="profile-img pl-2 pr-1">
                                <a href="{{ url('users/show/' . $row_similar->host_id) }}">
                                    <img src="{{ $row_similar->users->profile_src }}" alt="profile-photo"></a>
                            </div>
                        </div> --}}

                        <div class="px-3 text">
                            <a class="text-color text-color-hover d-flex align-items-center" href="{{ url('properties/' . $row_similar->slug) }}">
                                <p class="mb-0">
                                <span class="text-14 font-weight-700 w-100">{{ App\Models\PropertyType::getAll()->where('id',$row_similar->property_type)->first()->name }},</span>
								<span class="text-14 font-weight-700 text mb-0">{{ $row_similar->property_address->city ?? null }}</span>
                                </p>
                                <p class="text-12 mb-0 text cc"  ><span><i class="fa fa-star text-14 secondary-text-color"></i>
                                    @if ( $row_similar->guest_review)
                                        {{ $row_similar->avg_rating }}
                                    @else
                                        0
                                    @endif
                                    ({{ $row_similar->guest_review }})</span> </p>
                                {{-- <h4 class="text-16 font-weight-700 text"> {{ $row_similar->name }}</h4> --}}
                            </a>
                            {{-- <p class="text-14 mt-2 mb-0 text"><i class="fas fa-map-marker-alt"></i>
                                {{ $row_similar->property_address->city }}</p> --}}
                        </div>

                        <div class="card-button imagebutton">
                            @auth
                                  <a class="btn btn-sm book_mark_change"
                                     data-status="{{ $row_similar->book_mark }}" data-id="{{ $row_similar->id }}"
                                     style="color:{{ ($row_similar->book_mark == true) ? '#1DBF73':'' }}; ">
                                  <span style="font-size: 20px;">
                                      <i class="fas fa-heart "></i>
                                  </span>
                                  </a>
                              @else
                                  <a class="btn btn-sm book_mark_change" data-id="{{ $row_similar->id }}"
                                      style="color:#1dbf73 }}; ">
                                      <span style="font-size: 20px;">
                                          <i class="fas fa-heart hrtmt"></i>
                                      </span>
                                  </a>
                              @endauth
                                    {{-- <a href="{{ url('search?location=' . $city->name . '&checkin=&checkout=&guest=1') }}">
                                        <i class="fas fa-heart hrtmt"></i>
                                    </a>--}}
                  </div>                
                </div>
                    <div class="review-0 px-3 pb-3">
                        <div class="d-flex justify-content-between">
                            {{-- <div>
                                <span><i class="fa fa-star text-14 secondary-text-color"></i>
                                    @if ( $row_similar->reviews_count)
                                        {{ $row_similar->avg_rating }}
                                    @else
                                        0
                                    @endif
                                    ({{ $row_similar->reviews_count }})</span>
                            </div> --}}
                            <div class="pricenightfont">
                                <span class="font-weight-700">{!! moneyFormat(
                                    $row_similar->property_price->default_symbol, $row_similar->property_price->price)
                                    !!}
                                </span> / {{ __('Weekend Night') }}
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card-footer text-muted p-0 border-0">
                        <div class="d-flex bg-white justify-content-between pl-2 pr-2 pt-2 mb-3">
                            <div>
                                <ul class="list-inline">
                                    <li class="list-inline-item  pl-4 pr-4 border rounded-3 mt-4 bg-light text-dark">
                                        <div class="vtooltip"> 
                                            <i class="fas fa-user-friends"></i> {{ $row_similar->accommodates }}
                                            <span class="vtooltiptext text-14">{{ $row_similar->accommodates }}
                                                {{ __('Guest') }}</span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item pl-4 pr-4 border rounded-3 mt-4 bg-light text-dark">
                                        <div class="vtooltip"> <i class="fas fa-bed"></i> {{ $row_similar->bedrooms }}
                                            <span class="vtooltiptext  text-14">{{ $row_similar->bedrooms }}
                                                {{ __('Bedrooms') }}</span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item pl-4 pr-4 border rounded-3 mt-4 bg-light text-dark">
                                        <div class="vtooltip"> <i class="fas fa-bath"></i> {{ $row_similar->bathrooms }}
                                            <span class="vtooltiptext  text-14 p-2">{{ $row_similar->bathrooms }}
                                                {{ __('Bathrooms') }}</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
<div class="row">
    <!-- Modal -->    
    <div class="modal fade mt-5 z-index-high" id="exampleModalCenter" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 pt-3">
                       <h5 class="modal-title text-20 text-center font-weight-700"
                            id="exampleModalLongTitle">{{ __('Amenities') }}
                       </h5>
                    </div>
                    <div>
                        <button type="button" class="close text-28 mr-2 filter-cancel"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body pb-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                @php $i = 1 @endphp
                                @foreach ($amenities as $all_amenities)
                                @if ($i >= 6)
                                <div class="col-md-6 col-sm-6 mt-3">
                                    <div>
                                        <i class="icon h3 icon-{{ $all_amenities->symbol }}"
                                            aria-hidden="true"></i>
                                        @if ($all_amenities->status == null)
                                            <del>
                                                {{ $all_amenities->title }}
                                            </del>
                                        @else
                                            {{ $all_amenities->title }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @php $i++ @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade mt-5 z-index-high" id="safetyModal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 pt-3">
                        <h5 class="modal-title text-20 text-center font-weight-700" id="exampleModalLongTitle">
                            {{ __('Safety Features') }}
                        </h5>
                    </div>
                    <div>
                        <button type="button" class="close text-28 mr-2 filter-cancel"
                            data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body pb-5">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                @php $i = 1 @endphp
                                @foreach ($safety_amenities as $row_safety)
                                @if ($i >= 6)
                                <div class="col-md-6 col-sm-6 mt-3">
                                    <div>
                                        <i class="icon h3 icon-{{ $row_safety->symbol }}"
                                            aria-hidden="true"></i>
                                        @if ($row_safety->status == null)
                                            <del>
                                                {{ $row_safety->title }}
                                            </del>
                                        @else
                                            {{ $row_safety->title }}
                                        @endif
                                    </div>
                                </div>
                                @endif
                                @php $i++ @endphp
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="grid-container OurLightgallery">
            @foreach ($property_photos as $row_photos)
              <div>
                  <div class="lightbox_img_wrap">
                      <img class="lightbox-enabled" src="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}" data-imgsrc="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}">
                  </div>
              </div>
            @endforeach               
              </div>
          </div>      
      <section class="lightbox-container">
        <span class="material-symbols-outlined material-icons lightbox-btn left" id="left">
          <i class="fa fa-angle-left" aria-hidden="true"></i>
      </span>
        <span class="material-symbols-outlined material-icons lightbox-btn right" id="right">
          <i class="fa fa-angle-right" aria-hidden="true"></i>
      </span>
      <span id="close" class="close material-icons material-symbols-outlined">
          <i class="fa fa-window-close" aria-hidden="true"></i>
      </span>
        <div class="lightbox-image-wrapper">
        <img alt="lightboximage" class="lightbox-image">
        </div>
      </section>
      </div>
    </div>
  </div>
      <!-- EndLarge modal -->
  
  

    @foreach ($all_new_amenities as $key => $new_amenities)
        <div class="modal fade mt-5 z-index-high" id="exampleModalCenter_{{ str_replace(" ","-",$key) }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="w-100 pt-3">
                            <h5 class="modal-title text-20 text-center font-weight-700" id="exampleModalLongTitle">{{ $key }}</h5>
                        </div>

                        <div>
                            <button type="button" class="close text-28 mr-2 filter-cancel" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    @php $a = 1 @endphp
                                    @foreach ($new_amenities as $row_safety)
                                        @if ($a >= 6)
                                            <div class="col-md-6 col-sm-6">
                                                <i class="fa h3 fa-{{ $row_safety->symbol }}" aria-hidden="true"></i>
                                                @if ($row_safety->status == null)
                                                    <del>
                                                        {{ $row_safety->title }}
                                                    </del>
                                                @else
                                                    {{ $row_safety->title }}
                                                @endif
                                            </div>
                                        @endif
                                        @php $a++ @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- <div class="d-none" id="showSlider">
    <div id="ninja-slider">
        <div class="slider-inner">
            <ul>
                @foreach ($property_photos as $row_photos)
                <li>
                    <a class="ns-img"
                        href="{{ url('public/images/property/' . $property_id . '/' . $row_photos->photo) }}"
                        aria-label="photo"></a>
                </li>
                @endforeach
            </ul>
            <div id="fsBtn" class="fs-icon" title="Expand/Close"></div>
        </div>
    </div>
</div> --}}
@endsection

@section('validation_script')

<script>
    // Lightbox Gallery
// query selectors
const lightboxEnabled = document.querySelectorAll('.lightbox-enabled');
const lightboxArray = Array.from(lightboxEnabled);
const lastImage = lightboxArray.length-1;
const lightboxContainer = document.querySelector('.lightbox-container');
const lightboxImage = document.querySelector('.lightbox-image');
const lightboxBtns = document.querySelectorAll('.lightbox-btn');
const lightboxBtnRight = document.querySelector('#right');
const lightboxBtnLeft = document.querySelector('#left');
const close = document.querySelector('#close');
let activeImage;
// Functions
const showLightBox = () => {lightboxContainer.classList.add('active')}
const hideLightBox = () => {lightboxContainer.classList.remove('active')}
const setActiveImage = (image) => {
lightboxImage.src = image.dataset.imgsrc;
activeImage= lightboxArray.indexOf(image);
}
const transitionSlidesLeft = () => {
  lightboxBtnLeft.focus();
  $('.lightbox-image').addClass('slideright');
   setTimeout(function() {
  activeImage === 0 ? setActiveImage(lightboxArray[lastImage]) : setActiveImage(lightboxArray[activeImage-1]);
}, 250);
  setTimeout(function() {
    $('.lightbox-image').removeClass('slideright');
}, 500);
}
const transitionSlidesRight = () => {
 lightboxBtnRight.focus();
$('.lightbox-image').addClass('slideleft');
  setTimeout(function() {
   activeImage === lastImage ? setActiveImage(lightboxArray[0]) : setActiveImage(lightboxArray[activeImage+1]);
}, 250);
  setTimeout(function() {
    $('.lightbox-image').removeClass('slideleft');
}, 500);
}
const transitionSlideHandler = (moveItem) => {
  moveItem.includes('left') ? transitionSlidesLeft() : transitionSlidesRight();
}
// Event Listeners
lightboxEnabled.forEach(image => {
   image.addEventListener('click', (e) => {
    showLightBox();
    setActiveImage(image);
    })
    })
lightboxContainer.addEventListener('click', () => {hideLightBox()})
close.addEventListener('click', () => {hideLightBox()})
lightboxBtns.forEach(btn => {
btn.addEventListener('click', (e) => {
e.stopPropagation();
  transitionSlideHandler(e.currentTarget.id);
})
})
lightboxImage.addEventListener('click', (e) => {
e.stopPropagation();
})
    </script>
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ config("vrent.google_map_key") }}&libraries=places'></script>
    @auth
    <script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
    @endauth
    <script type="text/javascript" src="{{ asset('public/js/locationpicker.jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/ninja/ninja-slider.js') }}"></script>
    <!-- daterangepicker -->
    <script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/daterangecustom.js') }}"></script>
    <script type="text/javascript">
        'use strict'
        let back = 0;
        let dateFormat = '{{ $date_format }}';
        let getPriceURL = '{{ url("property/get-price") }}';
        var token = "{{ csrf_token() }}";
        let customPriceText = "{{ __('Custom Price') }}";
        let dateText = "{{ __('Date') }}";
        let priceText = "{{ __('Price') }}";
        let symbolText = "{{ $symbol }}";
		let host = "{{ ($result->host_id == Auth()->user()?->id) ? '1' : '' }}";
        let latitude = {{ $result->property_address->latitude }};
		let longitude = {{ $result->property_address->longitude }};
        let user_id = "{{ Auth::id() }}";
        let success = "{{ __('Success') }}";
        let yes = "{{ __('Yes') }}";
        let no = "{{ __('No') }}";
        let add = "{{ __('Add to Favourite List ?') }}";
        let remove = "{{ __('Remove from Favourite List ?') }}";
        let added = "{{ __('Added to favourite list.') }}";
        let removed = "{{ __('Removed from favourite list.') }}";
        const BaseURL = "{{ url('/') }}";

    </script>

    <script type="text/javascript" src="{{ asset('public/js/single-property.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/front.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ config("vrent.google_map_key") }}&libraries=places'></script>
    <script type="text/javascript">
    'use strict';
    function initMap() {
    let latitude = "{{ $result->property_address->latitude != '' ? $result->property_address->latitude : 0 }}";
    let longitude = "{{ $result->property_address->longitude != '' ? $result->property_address->longitude : 0 }}";

    if (latitude == 0 || longitude == 0) {
        alert('Invalid latitude or longitude.');
        return;
    }

    const map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
        zoom: 15,
    });

    const marker = new google.maps.Marker({
        position: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
        map: map,
        title: "Property Location",
    });

    const circle = new google.maps.Circle({
        map: map,
        radius: 1000, // 1 km radius
        center: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
        strokeColor: '#FF0000',
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: '#FF0000',
        fillOpacity: 0.2,
    });

    const service = new google.maps.places.PlacesService(map);
    const radius = 1000; // 1 km radius
    const categories = [
        { name: 'School/College', keywords: 'school OR college' },
        { name: 'Hospital/Clinic', keywords: 'hospital OR clinic' },
        { name: 'Public Transport', keywords: 'bus stop OR metro station' },
        { name: 'Restaurants/Cafes', keywords: 'restaurant OR cafe' },
        { name: 'Supermarket', keywords: 'supermarket' },
        { name: 'Playground', keywords: 'playground' },
        { name: 'Walking/Jogging Track', keywords: 'walking track OR jogging track' },
        { name: 'Sports Complex', keywords: 'sports complex' },
        { name: 'Parking Facility', keywords: 'parking' },
    ];

    const propertyList = []; // Array to store the properties for listing

    categories.forEach(category => {
        service.textSearch(
        {
            location: { lat: parseFloat(latitude), lng: parseFloat(longitude) },
            radius: radius,
            query: category.keywords,
        },
        (results, status) => {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
            results.forEach(place => {
                const placeLocation = place.geometry.location;
                const userLocation = new google.maps.LatLng(latitude, longitude);
                const distance = google.maps.geometry.spherical.computeDistanceBetween(userLocation, placeLocation);
                const distanceText = (distance / 1000).toFixed(2) + ' km';
                if (distance <= radius) {
                const placeMarker = new google.maps.Marker({
                    position: placeLocation,
                    map: map,
                    title: place.name,
                });

                const photoUrl = place.photos && place.photos.length > 0 ? place.photos[0].getUrl({ maxWidth: 200, maxHeight: 200 }) : null;

                propertyList.push({
                    name: place.name,
                    category: category.name,
                    address: place.formatted_address,
                    photoUrl: photoUrl,
                    distance: distanceText,
                });

                // Update the property list HTML
                updatePropertyList(propertyList);
                }
            });
            }
        }
        );
    });
    }

    function updatePropertyList(propertyList) {
    const propertyListDiv = document.getElementById('property-list');
    propertyListDiv.innerHTML = ''; // Clear the existing list

    if (propertyList.length === 0) {
        propertyListDiv.innerHTML = '<p>No properties found in the selected area.</p>';
        return;
    }

    const listHtml = propertyList
        .map(property => `
        <div class="property-item row" style="margin-bottom: 10px; padding: 10px; border: 1px solid #ccc;">
            <div class="col-6"> 
                <h4><strong>Name:</strong>${property.name}</h4>
                <p><strong>Type:</strong> ${property.category}</p>
                <p><strong>Address:</strong> ${property.address}</p>
                <p><strong>Distance:</strong> ${property.distance}</p>
            </div>
            <div class="col-6 float-right">
                ${
                    property.photoUrl
                    ? `<img src="${property.photoUrl}" alt="${property.name}" style="max-width: 100%; height: auto;"  class="float-right"/>`
                    : ''
                }
            </div>
        </div>
        `)
        .join('');

    propertyListDiv.innerHTML = listHtml;
    }

    window.onload = function () {
    initMap();
    };
   </script>
@endsection



@extends('admin.include.app')
@section('style')
    <style>
        .octicon.octicon-light-bulb {
            position: absolute;
            left: 31px;
            top: 43px;
            font-size: 12px;
            width: 99%;
            text-align: center;
        }
        .dropdown-menu{
        min-width: 900px !important;
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.css') }}">
@endsection
@section('main-content')
    <div class="row">
        <!-- Lightbox -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Student Profile</h4>
                </div>
                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        <h4 class="text-center">{{ session('message') }}</h4>
                    </div>
                @endif

                <div class="card-body">
                    <div class="wizard">
                        <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                data-bs-placement="top" title=" General Information ">
                                <a class="nav-link active rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                    href="#step1" id="step1-tab"   data-bs-toggle="tab" role="tab" aria-controls="step1"
                                    aria-selected="true"> 1 </a>
                                <br>
                                <span class="octicon octicon-light-bulb">General Information </span>
                            </li>
                            <li class="nav-item flex-fill education_data" role="presentation" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Educaton History">
                                <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                    href="#step2" id="step2-tab"   data-bs-toggle="tab" role="tab" aria-controls="step2"
                                    aria-selected="false"> 2 </a>
                                <br>
                                <span class="octicon octicon-light-bulb">Educaton History</span>
                            </li>
                            <li class="nav-item flex-fill experience" role="presentation" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Work Experience">
                                <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                    href="#step3" id="step3-tab"   data-bs-toggle="tab" role="tab" aria-controls="step3"
                                    aria-selected="false"> 3 </a>
                                <br>
                                <span class="octicon octicon-light-bulb">Work Experience</span>
                            </li>
                            <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Test Score">
                                <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                    href="#step4" id="step4-tab"    data-bs-toggle="tab" role="tab" aria-controls="step4"
                                    aria-selected="false"> 4 </a>
                                <br>
                                <span class="octicon octicon-light-bulb">Test Score</span>
                            </li>
                            <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="BackGround Information">
                                <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                    href="#step5" id="step5-tab"   data-bs-toggle="tab" role="tab" aria-controls="step5"
                                    aria-selected="false"> 5 </a>
                                <br>
                                <span class="octicon octicon-light-bulb">BackGround Information</span>
                            </li>
                            <li class="nav-item flex-fill" role="presentation" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Document">
                                <a class="nav-link rounded-circle mx-auto d-flex align-items-center justify-content-center"
                                    href="#step6" id="step6-tab"   data-bs-toggle="tab" role="tab" aria-controls="step6"
                                    aria-selected="false"> 6
                                </a>
                                <br>
                                <span class="octicon octicon-light-bulb">Document</span>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="tab-pane fade show active" role="tabpanel" id="step1"
                                aria-labelledby="step1-tab">
                                <div class="mb-4">
                                    <h5>General Information</h5>
                                </div>
                                <form>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <input
                                                    value="{{ $about_student->first_name ?? old('first_name') }}"
                                                    name="first_name" type="text" class="form-control"
                                                    placeholder="Name" autocomplete="first_name">
                                                <label for="lead-first_name" class="form-label text-danger">First Name *</label>
                                                <span class="text-danger first_name"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <input type="hidden" name="tab1" value="tab1">
                                                <input  name="middle_name" type="text"
                                                    class="form-control"
                                                    value="{{ $about_student->middle_name ?? old('middle_name') }}"
                                                    placeholder="Middle Name" autocomplete="middle_name">
                                                <label for="lead-middle_name" class="form-label">Middle Name</label>
                                                <span class="text-danger middle_name"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <input  name="last_name" type="text"
                                                    class="form-control"
                                                    value="{{ $about_student->last_name ?? old('last_name') }}"
                                                    placeholder="Last Name" autocomplete="last_name">
                                                <label for="lead-last_name" class="form-label">Last Name*</label>
                                                <span class="text-danger last_name"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <input  name="email" type="text"
                                                    class="form-control"
                                                    value="{{ $about_student->email ?? old('email') }}"
                                                    placeholder="Email" autocomplete="Email">
                                                <label for="lead-last_name" class="form-label text-danger">Email*</label>
                                                <span class="text-danger email-error"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <select class="form-control" name="gender" >
                                                    <option value="">-- Select Gender --</option>
                                                    <option value="Male"
                                                        {{ ($about_student->gender ?? old('gender')) == 'Male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="Female"
                                                        {{ ($about_student->gender ?? old('gender')) == 'Female' ? 'selected' : '' }}>
                                                        Female</option>
                                                    <option value="Other"
                                                    {{ ($about_student->gender ?? old('gender')) == 'Other' ? 'selected' : '' }}>
                                                    Other</option>
                                                </select>
                                                <span class="text-danger gender"></span>
                                                <label for="lead-source" class="form-label text-danger">Gender *</label>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <select class="form-control" name="maritial_status" >
                                                    <option value="">-- Maritial Status --</option>
                                                    <option value="Single"
                                                        {{ ($about_student->maritial_status ?? old('maritial_status')) == 'Single' ? 'selected' : '' }}>
                                                        Single</option>
                                                    <option value="Married"
                                                        {{ ($about_student->maritial_status ?? old('maritial_status')) == 'Married' ? 'selected' : '' }}>
                                                        Married</option>
                                                    <option value="Widowed"
                                                        {{ ($about_student->maritial_status ?? old('maritial_status')) == 'Widowed' ? 'selected' : '' }}>
                                                        Widowed</option>
                                                    <option value="Divorced"
                                                        {{ ($about_student->maritial_status ?? old('maritial_status')) == 'Divorced' ? 'selected' : '' }}>
                                                        Divorced</option>
                                                </select>
                                                <label for="lead-source" class="form-label">Maritial Status</label>
                                                <span class="text-danger maritial_status"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4 mt-3">
                                            <div class="form-floating">
                                                <select class="form-control" name="passport_status" id="passport_status"
                                                    placeholder="Passport Status">
                                                    <option value="">-- Select --</option>
                                                    <option value="I have"
                                                        {{ ($about_student->passport_status ?? old('passport_status')) == 'I have' ? 'selected' : '' }}>
                                                        I have</option>
                                                    <option value="I do not have"
                                                        {{ ($about_student->passport_status ?? old('passport_status')) == 'I do not have' ? 'selected' : '' }}>
                                                        I do not have</option>
                                                    <option value="I have applied"
                                                        {{ ($about_student->passport_status ?? old('passport_status')) == 'I have applied' ? 'selected' : '' }}>
                                                        I have applied</option>
                                                </select>
                                                <label for="lead-source" class="form-label">Passport Status</label>
                                                <span class="text-danger passport_status"></span>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3" style="display: none" id="passport_number">
                                            <div class="form-floating">
                                                <input  name="passport_number"
                                                    value="{{ $about_student->passport_number ?? old('passport_number') }}"
                                                    type="text" class="form-control" placeholder="Middle Name"
                                                    autocomplete="passport-number" pattern="[A-Za-z0-9]" title="Only letters and numbers are allowed">
                                                <label for="lead-passport-number" class="form-label">Passport
                                                    Number</label>
                                                <span class="text-danger passport_number"></span>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3" style="display: none" id="passport_document">
                                            <div class="form-floating">
                                                <input  name="passport_document"
                                                    value="{{ $about_student->passport_document ?? old('passport_document') }}"
                                                    type="file" class="form-control"
                                                    >
                                                <label for="lead-passport-number" class="form-label">Passport
                                                    Document</label>
                                                <span class="text-danger passport_document"></span>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3" style="display: none" id="passport_expiry">
                                            <div class="form-floating">
                                                <input  name="passport_expiry"
                                                    value="{{ $about_student->passport_expiry ?? old('passport_expiry') }}"
                                                    type="date" class="form-control" placeholder="Passport Expiry Date"
                                                    autocomplete="off" min="{{ now()->toDateString() }}">
                                                <label for="passport_expiry" class="form-label">Passport Expiry Date</label>
                                                <span class="text-danger">{{ $errors->first('passport_expiry') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <div class="form-floating">
                                                <input name="dob" type="date" class="form-control"
                                                    value="{{ $about_student->dob ?? old('dob') }}" >
                                                <label for="lead-passport-number" class="form-label text-danger">Date of Birth *</label>
                                                <span class="text-danger dob"></span>
                                            </div>
                                        </div>
                                        <div class="col-4 mt-3">
                                            <div class="form-floating">
                                                <input name="first_language" type="text"
                                                    value="{{ $about_student->first_language ?? old('first_language') }}"
                                                    class="form-control" >
                                                <label for="lead-passport-number" class="form-label">First
                                                    Language</label>
                                                <span class="text-danger first_language "></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 mt-3">
                                        <h5>Address Details</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <select class="form-control country" name="country_id" >
                                                    <option value="">-- Select Country --</option>
                                                    @foreach ($countries as $item)
                                                        <option value="{{ $item->id }}"
                                                            {{ ($about_student->country_id ?? old('country_id')) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="lead-source" class="form-label">Country</label>
                                                <span class="text-danger country_id "></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating">
                                                @php
                                                    $state = DB::table('province')
                                                        ->where('id', $about_student->province_id)
                                                        ->first();
                                                @endphp
                                                <select name="province_id"
                                                    class="form-control province_id" required>
                                                    @if (!empty($about_student->province_id))
                                                        <option value="{{ $about_student->province_id }}"
                                                            {{ ($about_student->province_id ?? old('province_id')) == $state->id ? 'selected' : '' }}>
                                                            {{ $state->name }}</option>
                                                    @endif
                                                </select>
                                                <label for="lead-source" class="form-label">State/Provision </label>
                                            </div>
                                            <span class="text-danger province_id_error"></span>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <input name="city" type="text"
                                                    value="{{ $about_student->city ?? old('city') }}"
                                                    class="form-control" >
                                                <label for="lead-city" class="form-label">City</label>
                                                <span class="text-danger city"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <input name="address" type="text"
                                                    value="{{ $about_student->address ?? old('address') }}"
                                                    class="form-control" >
                                                <label for="lead-address" class="form-label">Address</label>
                                                <span class="text-danger address"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-floating">
                                                <input name="zip" type="text" class="form-control"
                                                    value="{{ $about_student->zip ?? old('zip') }}" >
                                                <label for="lead-address" class="form-label">Pincode</label>
                                                <span class="text-danger zip"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="d-flex">
                                    <a class="btn btn btn-primary next ">Continue<span
                                            class="spinner-grow spinner-grow-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane fade " role="tabpanel" id="step2" aria-labelledby="step2-tab">
                                <div class="mb-4">
                                    <h5>Education History</h5>
                                </div>
                                <form>
                                    <div class="row">
                                        <div class="col-3 mt-2">
                                            <div class="form-floating">
                                                <select class="form-control selected-country" name="pref_countries">
                                                    <option value="">-- Select Country --</option>
                                                    @foreach ($countries as $item)
                                                        <option value="{{ $item->id }}"
                                                        {{ (isset($about_student->pref_countries) &&  $about_student->pref_countries == $item->id) || (old('pref_countries') == $item->id) ? 'selected' : '' }}>
                                                        {{ $item->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <label for="lead-source text-danger" class="form-label">Country*</label>
                                                <span class="text-danger pref_countries"></span>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-2">
                                            <div class="form-floating">
                                                <select class="form-control education_level_id" name="education_level_id"
                                                    >
                                                    <option value="">-- Education Level --</option>
                                                    @foreach ($progLabel as $item)
                                                        <option value="{{ $item->id }}" {{ (isset($education_history->education_level_id) && $education_history->education_level_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="lead-source" class="form-label text-danger">Education Level*</label>
                                                <span class="text-danger education_level_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-2">
                                            <div class="form-floating">
                                                @php
                                                $grading_scheme = DB::table('grading_scheme')
                                                        ->where('id', $education_history->grading_scheme_id ?? null)
                                                        ->first();
                                                @endphp
                                            <select name="grading_scheme_id" id="grading_scheme_id"
                                                class="form-control grading_scheme_id grading-scheme" >
                                                    <option value="0-100" {{ (isset($education_history->grading_scheme_id) && $education_history->grading_scheme_id == '0-100') ? 'selected' : '' }} grading-data= "0-100">0 - 100 out of</option>
                                                    <option value="0-45" {{ (isset($education_history->grading_scheme_id) && $education_history->grading_scheme_id == '0-45') ? 'selected' : '' }} grading-data= "0-45">0 - 45 out of</option>
                                                    <option value="0-10" {{ (isset($education_history->grading_scheme_id) && $education_history->grading_scheme_id == '0-10') ? 'selected' : '' }} grading-data="0-10">0 - 10 out of</option>
                                                    <option value="other" {{ (isset($education_history->grading_scheme_id) && $education_history->grading_scheme_id == 'other') ? 'selected' : '' }} grading-data="other">Other</option>
                                            </select>
                                                 <label for="lead-source" class="form-label text-danger">Grading Scheme*</label>
                                                <span class="text-danger grading_scheme_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-2" style="display: none" id="max_score" >
                                            <div class="form-floating">
                                                <input name="max_score"  value="{{ $education_history->max_score ?? null }}" type="number" class="form-control">
                                                <label for="lead-address" class="form-label">Max Score </label>
                                                <span class="text-danger max_score"></span>
                                            </div>
                                        </div>
                                        <div class="col-3 mt-2">
                                            <div class="form-floating">
                                                <input name="grading_average" id="lead-grading_number" value="{{ $education_history->grading_average ?? null }}" type="number" class="form-control">
                                                <input type="hidden" name="tab2" value="tab2">
                                                <label for="lead-address" class="form-label">Grading Score</label>
                                                <span class="text-danger grading_average"></span>
                                                <div id="grading_input_error" class="text-danger"  style="display: none;">Invalid grade. Please enter a value within the selected grading scheme.</div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-12 m-2"><label>
                                            <input type="checkbox" name="graduated_recently" value="Yes">Graduated
                                            from most recent school</label>
                                    </div>
                                </form>
                                <div class="school-attended">

                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="card-stretch-full">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h4>Schools Attended</h4>
                                                </div>
                                                <div class="col-md-6 ">
                                                     {{-- class="last_attended" --}}
                                                    <div data-tour="search"
                                                        data-bs-toggle="offcanvas" data-bs-target="#viewlead"
                                                        aria-controls="viewlead"
                                                        student-id="{{ $about_student->user_id ?? null }}">
                                                        <button type="button" class="btn btn-primary float-end last_attended_school"
                                                            aria-controls="exampleOffcanvas">
                                                            Last Attended School <i
                                                                class="las la-hands-helping"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-modern table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="1"> SNo</th>
                                                        <th>Documents</th>
                                                        <th> Name</th>
                                                        <th> Language</th>
                                                        <th> AttendedFrom</th>
                                                        <th> AttendedTo</th>
                                                        <th> Degree</th>
                                                        <th> DegreeOn</th>
                                                        <th> Country</th>
                                                        <th> Province</th>
                                                        <th> City/Town</th>
                                                        <th> Address</th>
                                                        <th> Postal/Zip</th>
                                                        <th> Edit </th>
                                                        <th>Delete</th>

                                                    </tr>
                                                </thead>
                                                @php
                                                    $i = 1;
                                                @endphp
                                                <tbody class="last-attended-school">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a class="btn btn btn-warning previous me-2 "> Back</a>
                                    <a class="btn btn btn-primary next school">Continue
                                        <span class="spinner-grow spinner-grow-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane fade " role="tabpanel" id="step3" aria-labelledby="step3-tab">
                                <div class="mb-4">
                                    <h5>Work Experience</h5>
                                </div>
                                <form>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input " type="radio" name="work_experience" id="work_experience_1" value="1"  @if ($about_student->work_experience == 1) checked @endif>
                                                <label class="form-check-label" for="work_experience_1">Yes, I have work experience</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="work_experience" id="work_experience_0" value="0" @if ($about_student->work_experience == 0) checked @endif >
                                                <label class="form-check-label" for="work_experience_0">No, I have not any work experience</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 experience_details" style="display: none">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input
                                                    value="{{ $about_student->organization_name ?? old('organization_name') }}"
                                                    name="organization_name" type="text" class="form-control"
                                                    placeholder="Name of Organization" autocomplete="organization_name">
                                                <label for="organization_name" class="form-label">Name of Organization</label>
                                                <span class="text-danger organization_name"></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input type="hidden" name="tab3" value="tab3">
                                                <input  name="position" type="text"
                                                    class="form-control"
                                                    value="{{ $about_student->position ?? old('position') }}"
                                                    placeholder="Position" autocomplete="position">
                                                <label for="position" class="form-label">Position</label>
                                                <span class="text-danger position"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 experience_details"  style="display: none">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input
                                                    value="{{ $about_student->job_profile ?? old('job_profile') }}"
                                                    name="job_profile" type="text" class="form-control"
                                                    placeholder="Job Profile" autocomplete="job_profile">
                                                <label for="job_profile" class="form-label">Job Profile</label>
                                                <span class="text-danger job_profile"></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input  name="working_from" type="date"
                                                    class="form-control"
                                                    value="{{ $about_student->working_from ?? old('working_from') }}"
                                                    placeholder="Working From" autocomplete="working_from">
                                                <label for="working_from" class="form-label">Working From</label>
                                                <span class="text-danger working_from"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 experience_details"  style="display: none">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input
                                                    value="{{ $about_student->working_upto ?? old('working_upto') }}"
                                                    name="working_upto" type="date" class="form-control"
                                                    placeholder="Working Upto" autocomplete="working_upto">
                                                <label for="lead-working_upto" class="form-label">Working Upto</label>
                                                <span class="text-danger working_upto"></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input  name="mode_of_selary" type="text"
                                                    class="form-control"
                                                    value="{{ $about_student->mode_of_selary ?? old('mode_of_selary') }}"
                                                    placeholder="Middle Name" autocomplete="mode_of_selary">
                                                <label for="mode_of_selary" class="form-label">Mode Of Salary</label>
                                                <span class="text-danger mode_of_selary"></span>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-3">
                                            <div class="form-floating">
                                                <input  name="working_experience_document" type="file"
                                                    class="form-control"
                                                    value="{{ $about_student->working_experience_document ?? old('working_experience_document') }}"
                                                    >
                                                <label for="working_experience_document" class="form-label">Working Experience Document</label>
                                                <span class="text-danger working_experience_document"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 experience_details"  style="display: none">
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="working_status" id="working_status1" value="1" {{ isset($about_student->working_status) && $about_student->working_status == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="working_status1">
                                                  I am working here
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="working_status" id="working_status2" value="2" {{ isset($about_student->working_status) && $about_student->working_status == 2 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="working_status2">
                                                  I am not working here
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="d-flex">
                                    <a class="btn btn btn-warning previous me-2 "> Back</a>
                                    <a class="btn btn btn-primary next">Continue
                                        <span class="spinner-grow spinner-grow-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="step4" aria-labelledby="step4-tab">
                                <div class="mb-4">
                                    <h5>Test Score</h5>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <div class="card-stretch-full">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h4>Test Score</h4>
                                                </div>
                                                <div class="col-md-8 ">
                                                    <div class="d-flex float-end">
                                                        <a href="" class="btn btn-primary btn-sm mx-1" class="last_attended" data-tour="search"
                                                        data-bs-toggle="offcanvas" data-bs-target="#gre_exam"
                                                        aria-controls="gre_exam">GRE exam scores</a>
                                                        <a href="" class="btn btn-primary btn-sm mx-1"  data-tour="search"
                                                        data-bs-toggle="offcanvas" data-bs-target="#gmat"
                                                        aria-controls="gmat">GMAT exam scores</a>
                                                        <a href="" class="btn btn-primary btn-sm mx-1"
                                                        data-tour="search"  data-bs-toggle="offcanvas" data-bs-target="#testscrores"
                                                        aria-controls="testscrores">Add Test Score</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-modern table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>S.NO</th>
                                                        <th>Exam Type</th>
                                                        <th>Date of Exam</th>
                                                        <th>Listening/Verbal</th>
                                                        <th>Writing</th>
                                                        <th>Reading/Quantitative</th>
                                                        <th>Speaking</th>
                                                        <th>Average</th>
                                                        <th>Document</th>
                                                        <th>Edit</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="test-score">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a class="btn btn-warning previous me-2 ">Previous</a>
                                    <a class="btn btn-primary skipform" data-bs-toggle="modal"
                                        data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                            role="status" aria-hidden="true"></span> continue</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="step5" aria-labelledby="step5-tab">
                                <div class="mb-4">
                                    <h5>Background Information</h5>
                                </div>
                                <div class="alert-image-error"> </div>
                            <form>
                                <div class="col-12">
                                    <label>
                                        <b>Have you been refused a visa from Canada, the USA, the United Kingdom, New Zealand or Australia?</b>
                                    </label>
                                        <div class="col-12">
                                            <label>
                                                <input type="radio" name="ever_refused_visa" value="Yes"  {{ $about_student->ever_refused_visa === "Yes" ? 'checked' : '' }} onclick="showVisaDetails(this.value)">
                                                &nbsp; Yes &nbsp;&nbsp;&nbsp;</label><label>
                                                <input type="radio" name="ever_refused_visa" value="No" {{ $about_student->ever_refused_visa === "No" ? 'checked' : '' }} onclick="showVisaDetails(this.value)">&nbsp; No</label>
                                                <span class="text-danger ever_refused_visa"></span>
                                        </div>
                                        <div class="col-12 visa_details_info" style="display: {{ $about_student->ever_refused_visa === "Yes" ? 'block' : 'none' }};">
                                            <div class="form-floating">
                                                <input name="visa_details" value="{{ $about_student->visa_details ?? null }}"  type="text" class="form-control" >
                                                <label for="lead-address" class="form-label">Visa Details</label>
                                                <span class="text-danger visa_details"></span>
                                            </div>
                                        </div>
                                        <div class="col-12 visa_details_info mt-2" style="display: {{ $about_student->ever_refused_visa === "Yes" ? 'block' : 'none' }};" >
                                            <div class="form-floating">
                                                <input name="visa_documents" value="{{ $about_student->visa_documents ?? null }}"  type="file" class="form-control" >
                                                <label for="lead-address" class="form-label">Upload Documents</label>
                                                <span class="text-danger visa_details"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-12 mt-2">
                                        <input type="hidden" name="tab5" value="tab5" >
                                        <label><b>Do you have a valid Study Permit / Visa?</b></label>
                                        <label>
                                        <input type="radio" name="has_visa" value="1" {{ $about_student->has_visa == "1" ? 'checked' : '' }} onclick="studypermit(this.value)">&nbsp; Yes &nbsp;&nbsp;&nbsp;</label><label>
                                        <input type="radio" name="has_visa" value="0" {{ $about_student->has_visa == "0" ? 'checked' : '' }} onclick="studypermit(this.value)">&nbsp; No</label>
                                        <span class="text-danger has_visa"></span>
                                    </div>
                                    <br>
                                    <div class="col-12 study_permit" style="display: {{ $about_student->has_visa == "1" ? 'block' : 'none' }};">
                                        <div class="form-floating">
                                            <input name="study_permit" value="{{ $about_student->study_permit ?? null }}"  type="text" class="form-control" >
                                            <label for="lead-address" class="form-label">Study Permit  Details</label>
                                            <span class="text-danger study_permit"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 study_permit mt-2" style="display: {{ $about_student->has_visa == "1" ? 'block' : 'none' }};">
                                        <div class="form-floating">
                                            <input name="study_permit_documents" value="{{ $about_student->study_permit_documents ?? null }}"  type="file" class="form-control" >
                                            <label for="lead-address" class="form-label">Upload Documents</label>
                                            <span class="text-danger visa_details"></span>
                                        </div>
                                    </div>
                                    <br>
                                    {{-- <div class="col-12 mb-3">
                                        <div class="form-floating">
                                            <select class="form-control  selectpicker" name="subject_input"
                                                id="lead-subject_input" multiple placeholder="Education Level">
                                                @foreach ($all_subject as $item)
                                                    @php
                                                        $selected = '';
                                                        if ($about_student->pref_subjects !== null && $about_student->pref_subjects !== '') {
                                                            $selected = in_array($item->id, explode(',', $about_student->pref_subjects)) ? 'selected' : '';
                                                        }
                                                    @endphp
                                                    <option value="{{ $item->id }}" {{ $selected }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="lead_documents_id" class="form-label">Subject</label>
                                            <span class="text-danger subject_input"></span>
                                        </div>
                                    </div> --}}
                                </form>
                                <div class="d-flex">
                                    <a class="btn btn-warning previous me-2 ">Previous</a>
                                    <a class="btn btn-primary next" data-bs-toggle="modal"
                                        data-bs-target="#save_modal"><span class="spinner-grow spinner-grow-sm d-none"
                                            role="status" aria-hidden="true"></span>Continue</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" role="tabpanel" id="step6" aria-labelledby="step6-tab">
                                <div class="mb-4">
                                    <h5>Documents</h5>
                                </div>

                                <form id="document">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <select class="form-control " name="visa_document_type" id="lead-visa_document_type" placeholder="Document Type">
                                                    <option value="">--Select--</option>
                                                 </select>
                                                <label for="lead-source" class="form-label">Document Type</label>
                                                <span class="text-danger visa_document_type"></span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating">
                                                <input type="file"  class="form-control " name ="document[]" id="lead-document" multiple placeholder="Document">
                                                <input type="hidden" name="tab6" value="tab6">
                                                <label for="lead-address" class="form-label">Document</label>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-md-12 mt-2">
                                    <div class="card-stretch-full">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <h4>Document List</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="responseMessage"></div>
                                        <div class="card-body table-responsive">
                                            <table class="table table-modern table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Student Id</th>
                                                        <th>Type</th>
                                                        <th>Image Name</th>
                                                        <th>Image</th>
                                                        <th>Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="documents-data">
                                                    @foreach ($student_document as $item)

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a class="btn btn-warning previous me-2 ">Previous</a>
                                    <a class="btn btn-primary documentForm"><span class="spinner-grow spinner-grow-sm d-none"
                                            role="status" aria-hidden="true"></span>Save</a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="viewlead">
        <div class="sidebar-headerset" style="  box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
            <div class="sidebar-headersets">
                <h5>Last Attended School</h5>
            </div>
            <div class="sidebar-headerclose">
                <a data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="{{ url('assets/img/close.png') }}" alt="Close Icon">
                </a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div id="responseMessage"></div>
                <div class="card-stretch-full">
                    <div class="row g-4">
                        <form id="myForm">
                            <div class="col-12 ">
                                <div class="form-floating">
                                    <select class="form-control lead_documents_id" name="lead_documents_id"
                                        id="lead_documents_id" placeholder="Education Level">
                                        <option> --Select Document--</option>
                                    </select>
                                    <label for="lead_documents_id" class="form-label"> Select Documents</label>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating">
                                    <input name="name" type="text" id="institue_name"
                                        class="form-control " placeholder="Institute Name" autocomplete="name"
                                        value=""><label for="lead-name" class="form-label">Institute Name</label>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating">
                                    <input name="primary_language" type="text"
                                        class="form-control " id="primary_language" placeholder="Primary Language for Instruction"
                                        autocomplete="primary_language" value=""><label for="lead-primary_language"
                                        class="form-label">Primary Language for Instruction</label></div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating"><input name="attended_from" type="date"
                                        class="form-control " id="attended_from" placeholder="Attended Institute From"
                                        autocomplete="attended_from" value="">
                                        <label for="lead-attended_from"
                                        class="form-label">Attended Institute From</label></div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating">
                                    <input name="attended_to" type="date"
                                        class="form-control" id="attended_to" placeholder="Attendend Instutute To"
                                        autocomplete="attended_to" value=""><label for="lead-attended_to"
                                        class="form-label">Attendend Instutute To</label></div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating"><input name="degree_awarded" type="text"
                                        class="form-control " id="degree_awarded" placeholder="Degree Awarded"
                                        autocomplete="degree_awarded" value=""><label for="lead-degree_awarded"
                                        class="form-label">Degree Awarded</label></div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating"><input name="degree_awarded_on" type="date"
                                        class="form-control " id="degree_awarded_on" placeholder="Degree Awareded On"
                                        autocomplete="degree_awarded_on" value=""><label
                                        for="lead-degree_awarded_on" class="form-label">Degree Awareded On</label></div>
                            </div>
                            <h4 class="m-2">School Address</h4>
                            <div class="col-12 mt-2">
                                <div class="form-floating">
                                    <select class="form-control country " name="country_id" id="country_id">
                                        <option value="">-- Select Country --</option>
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}"
                                                {{ (old('country_id')) == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="lead-country" class="form-label">Country Name</label>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <select name="province_id" class="form-control province_id" id="province_id">
                                    <option value="">-State/Provision -</option>
                                </select>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating"><input name="city" type="text" id="city"
                                        class="form-control " placeholder="City/Town" autocomplete="city"
                                        value=""><label for="lead-city" class="form-label">City/Town</label></div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating"><input name="address" id="address" type="text"
                                        class="form-control " placeholder="Address" autocomplete="address"
                                        value=""><label for="lead-address" class="form-label">Address</label></div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating"><input name="postal_zip" id="postal_zip" type="text"
                                        class="form-control " placeholder="Postal Code/Zip"
                                        autocomplete="postal_zip" value=""><label for="lead-postal_zip"
                                        class="form-label">Postal Code/Zip</label></div>
                            </div>
                        </form>
                        <div class="col-md-12"><button type="button"
                        class="btn btn-info  py-6 last_attendence">Submit<span
                                    class="spinner-grow spinner-grow-sm d-none" role="status"
                                    aria-hidden="true"></button>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- gre exam score  --}}
    <div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="gre_exam">
        <div class="sidebar-headerset" style="  box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
            <div class="sidebar-headersets">
                <h5>GRE exam scores</h5>
               <div class="responseMessage"></div>
            </div>
            <div class="sidebar-headerclose">
                <a data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="{{ url('assets/img/close.png') }}" alt="Close Icon">
                </a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="card-stretch-full">
                    <div class="row g-4">
                        <form id="greExam">
                            <label class="form-check-label" for="result_receive">Result Receive</label><br>
                            <div class="col-lg-12">
                                <div class="form-check ">
                                    <input class="form-check-input " id="result_receive1" type="radio" name="result_receive"  value="1"  @if (isset($additional_qualification) && $additional_qualification->result_receive == 1) checked @endif>
                                    <label class="form-check-label" for="result_receive1">Yes</label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="result_receive"  value="0" @if (isset($additional_qualification) && $additional_qualification->result_receive  == 0) checked @endif >
                                    <label class="form-check-label" for="result_receive">No</label>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating">
                                    <input name="date_of_exam" type="date" value="{{ $additional_qualification->date_of_exam ?? \Carbon\Carbon::now()->toDateString() }}" class="form-control ">
                                    <label for="lead-name" class="form-label">Exam Date</label>
                                </div>
                            </div>
                            <div class="row result_receive_details" style="display: none">
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input type="hidden" name="type" value="GRE">
                                        <input name="verbal_score" type="number"  class="form-control gre_score"  value="{{$additional_qualification->verbal_score  ?? null}}">
                                        <label for="lead-name" class="form-label">Verbal Score</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="verbal_rank" type="number"  class="form-control gre_score" value="{{$additional_qualification->verbal_rank  ?? null}}">
                                        <label for="lead-name" class="form-label">Verbal Rank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row result_receive_details" style="display:none">
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="quantitative_score" type="number"  class="form-control gre_score" value="{{$additional_qualification->quantitative_score  ?? null}}">
                                        <label for="lead-name" class="form-label">Quantitative Score</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="quantitative_rank" type="number"  class="form-control gre_score" value="{{$additional_qualification->quantitative_rank  ?? null}}">
                                        <label for="lead-name" class="form-label">Quantitative Rank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row result_receive_details" style="display: none">
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="writing_score" type="number"  class="form-control gre_score"  value="{{$additional_qualification->writing_score  ?? null}}">
                                        <label for="lead-name" class="form-label">Writing Score</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="writing_rank" type="number"  class="form-control gre_score" value="{{$additional_qualification->writing_rank  ?? null}}">
                                        <label for="lead-name" class="form-label">Writing Rank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row result_receive_details" style="display: none">
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="total_score" type="number"  class="form-control gre_score" value="{{$additional_qualification->total_score  ?? null}}">
                                        <label for="lead-name" class="form-label">Total Score</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="total_rank" type="number"  class="form-control gre_score" value="{{$additional_qualification->total_rank  ?? null}}">
                                        <label for="lead-name" class="form-label">Total Rank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row result_receive_details" style="display: none">
                                <div class="col-12 mt-2">
                                    <div class="form-floating">
                                        <input name="exam_document" type="file"  class="form-control gre_score" value="{{$additional_qualification->exam_document  ?? null}}">
                                        <label for="lead-name" class="form-label">Gre Exam Document</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12"><button type="button"
                            class="btn btn-info  py-6 greExam">Submit</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- gmat score  --}}
    <div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="gmat">
        <div class="sidebar-headerset" style="  box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
            <div class="sidebar-headersets">
                <h5>GMAT exam scores</h5>
               <div class="responseMessage"></div>
            </div>
            <div class="sidebar-headerclose">
                <a data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="{{ url('assets/img/close.png') }}" alt="Close Icon">
                </a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="card-stretch-full">
                    <div class="row g-4">
                        <form id="gmatform">
                            <label class="form-check-label" for="gmat_result_receive">Result Receive</label><br>
                            <div class="col-lg-12">
                                <div class="form-check ">
                                    <input class="form-check-input " id="gmat_result_receive1" type="radio" name="gmat_result_receive"  value="1"  @if ($gmat && $gmat->result_receive == 1) checked @endif>
                                    <label class="form-check-label" for="gmat_result_receive1">Yes</label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="gmat_result_receive"  value="0" @if ($gmat && $gmat->result_receive == 0) checked @endif >
                                    <label class="form-check-label" for="gmat_result_receive">No</label>
                                </div>
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-floating">
                                    <input name="date_of_exam" type="date" value="{{ $gmat->date_of_exam ?? \Carbon\Carbon::now()->toDateString() }}" class="form-control ">
                                    <label for="lead-name" class="form-label">Exam Date</label>
                                </div>
                            </div>
                            <div class="row gmat_details" style="display: none">
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input type="hidden" name="type" value="GMAT">
                                        <input name="verbal_score" type="number"  class="form-control gmat_score" value="{{$gmat->verbal_score ?? null}}">
                                        <label for="lead-name" class="form-label">Verbal Score</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="verbal_rank" type="number"  class="form-control gmat_score" value="{{$gmat->verbal_rank  ?? null}}">
                                        <label for="lead-name" class="form-label">Verbal Rank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row gmat_details" style="display: none">
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="quantitative_score" type="number"  class="form-control gmat_score" value="{{$gmat->quantitative_score  ?? null}}">
                                        <label for="lead-name" class="form-label">Quantitative Score</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="quantitative_rank" type="number"  class="form-control gmat_score" value="{{$gmat->quantitative_rank  ?? null}}">
                                        <label for="lead-name" class="form-label">Quantitative Rank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row gmat_details" style="display: none">
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="writing_score" type="number"  class="form-control gmat_score"  value="{{$gmat->writing_score  ?? null}}">
                                        <label for="lead-name" class="form-label">Writing Score</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="writing_rank" type="number"  class="form-control gmat_score" value="{{$gmat->writing_rank  ?? null}}">
                                        <label for="lead-name" class="form-label">Writing Rank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row gmat_details" style="display: none">
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="total_score" type="number"  class="form-control gmat_score" value="{{$gmat->total_score  ?? null}}">
                                        <label for="lead-name" class="form-label">Total Score</label>
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-floating">
                                        <input name="total_rank" type="number"  class="form-control gmat_score" value="{{$gmat->total_rank  ?? null}}">
                                        <label for="lead-name" class="form-label">Total Rank</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row gmat_details" style="display: none">
                                <div class="col-12 mt-2">
                                    <div class="form-floating">
                                        <input name="exam_document" type="file"  class="form-control gmat_score" value="{{$gmat->exam_document  ?? null}}">
                                        <label for="lead-name" class="form-label">Exam Document</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12"><button type="button"
                            class="btn btn-info  py-6 gmat">Submit</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     {{-- test Score --}}
     <div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="testscrores">
        <div class="sidebar-headerset" style="  box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
            <div class="sidebar-headersets">
                <h5>Add Test Score</h5>
                <div class="responseMessage"></div>
            </div>
            <div class="sidebar-headerclose">
                <a data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="{{ url('assets/img/close.png') }}" alt="Close Icon">
                </a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="card-stretch-full">
                    <div class="row g-4">
                        <form id="testscore">
                            <label class="form-check-label" for="eng_prof_level_result">Result Receive</label><br>
                            <div class="col-lg-12">
                                <div class="form-check ">
                                    <input class="form-check-input " id="eng_prof_level_result1" type="radio" name="eng_prof_level_result"  value="1"  >
                                    <label class="form-check-label" for="eng_prof_level_result1">Yes</label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="eng_prof_level_result"  value="0"  >
                                    <label class="form-check-label" for="eng_prof_level_result">No</label>
                                </div>
                            </div>
                            <div class="row " >
                                <div class="col-12 mt-2">
                                    <div class="form-floating">
                                        <select class="form-control eng_prof_level" name="type" id="lead-type" placeholder="Exam Type">
                                            <option value="">--Select--</option>
                                            @foreach ($eng_prof_level as $item)
                                              <option value="{{$item->name}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="lead-name" class="form-label">Exam Type</label>
                                        <span class="text-danger type"></span>
                                    </div>
                                </div>
                                <input type="hidden" name="eng_prof_level_score" value="" id="eng_prof_level_score">
                                <div class="col-12 mt-2">
                                    <div class="form-floating">
                                        <input id="lead-exam_date" name="exam_date" type="date" class="form-control " placeholder="Date of Exam" autocomplete="exam_date" value="">
                                        <label for="lead-name" class="form-label">Exam Date</label>
                                        <span class="text-danger exam_date"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead-listening_score" name="listening_score" type="number" class="form-control eng_prof_score" placeholder="Listening" autocomplete="listening_score" value="">
                                        <label for="lead-name" class="form-label">Listening</label>
                                        <span class="text-danger listening_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead-writing_score" name="writing_score" type="number" class="form-control eng_prof_score" placeholder="Writing" autocomplete="writing_score" value="">
                                        <label for="lead-name" class="form-label">Writing</label>
                                        <span class="text-danger writing_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead-reading_score" name="reading_score" type="number" class="form-control eng_prof_score" placeholder="Reading" autocomplete="reading_score" value="">
                                        <label for="lead-name" class="form-label">Reading</label>
                                        <span class="text-danger reading_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead-speaking_score" name="speaking_score" type="number" class="form-control eng_prof_score" placeholder="Speaking" autocomplete="speaking_score" value="">
                                        <label for="lead-name" class="form-label">Speaking</label>
                                        <span class="text-danger speaking_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead-average_score" name="average_score" type="number" class="form-control eng_prof_score" placeholder="Average" autocomplete="average_score" value="">
                                        <label for="lead-name" class="form-label">Average</label>
                                        <span class="text-danger average_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead-exam_document" name="exam_document" type="file" class="form-control eng_prof_score" placeholder="Average" autocomplete="exam_document" value="">
                                        <label for="lead-name" class="form-label">Exam Document</label>
                                        <span class="text-danger exam_document"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12"><button type="button"
                            class="btn btn-info  py-6 testscore">Submit</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- edit test score  --}}
      <div class="offcanvas offcanvas-end border-0 " tabindex="-1" id="testscroresedit">
        <div class="sidebar-headerset" style="  box-shadow: 0 1.6rem 3rem rgba(0,0,0,.1);">
            <div class="sidebar-headersets">
                <h5>Edit Test Score</h5>
                <div class="responseMessage"></div>
            </div>
            <div class="sidebar-headerclose">
                <a data-bs-dismiss="offcanvas" aria-label="Close">
                    <img src="{{ url('assets/img/close.png') }}" alt="Close Icon">
                </a>
            </div>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="card-stretch-full">
                    <div class="row g-4">
                        <form id="testscoreedit">
                            <label class="form-check-label" for="eng_prof_level_result">Result Receive</label><br>
                            <div class="col-lg-12">
                                <div class="form-check ">
                                    <input class="form-check-input " id="eng_prof_level_result1_edit" type="radio" name="eng_prof_level_result_edit"  value="1"  @if ($about_student && $about_student->eng_prof_level_result == 1) checked @endif>
                                    <label class="form-check-label" for="eng_prof_level_result1_edit">Yes</label>
                                </div>
                                <div class="form-check ">
                                    <input class="form-check-input" type="radio" name="eng_prof_level_result_edit"  value="0" @if ($about_student && $about_student->eng_prof_level_result == 0) checked @endif >
                                    <label class="form-check-label" for="eng_prof_level_result">No</label>
                                </div>
                            </div>
                            <div class="row " >
                                <div class="col-12 mt-2">
                                    <div class="form-floating">
                                        <select class="form-control eng_prof_level" name="type_edit" id="lead_type_edit" placeholder="Exam Type">

                                        </select>
                                        <label for="lead-name" class="form-label">Exam Type</label>
                                        <span class="text-danger type"></span>
                                    </div>
                                </div>
                                <input type="hidden" name="eng_prof_level_score_edit" value="" id="eng_prof_level_score_edit">
                                <input type="hidden" name="update_test_score" value="update_test_score" >
                                <input type="hidden" name="test_score_id" id="test_score_id" >
                                <div class="col-12 mt-2">
                                    <div class="form-floating">
                                        <input id="lead_exam_date_edit" name="exam_date_edit" type="date" class="form-control" placeholder="Date of Exam" autocomplete="exam_date" value="">
                                        <label for="lead-name" class="form-label">Exam Date</label>
                                        <span class="text-danger exam_date"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details_edit" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead_listening_score_edit" name="listening_score_edit" type="number" class="form-control eng_prof_score_edit" placeholder="Listening" autocomplete="listening_score" value="">
                                        <label for="lead-name" class="form-label">Listening</label>
                                        <span class="text-danger listening_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details_edit" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead_writing_score_edit" name="writing_score_edit" type="number" class="form-control eng_prof_score_edit" placeholder="Writing" autocomplete="writing_score" value="">
                                        <label for="lead-name" class="form-label">Writing</label>
                                        <span class="text-danger writing_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details_edit" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead-reading_score_edit" name="reading_score_edit" type="number" class="form-control eng_prof_score_edit" placeholder="Reading" autocomplete="reading_score" value="">
                                        <label for="lead-name" class="form-label">Reading</label>
                                        <span class="text-danger reading_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details_edit" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead_speaking_score_edit" name="speaking_score_edit" type="number" class="form-control eng_prof_score_edit" placeholder="Speaking" autocomplete="speaking_score" value="">
                                        <label for="lead-name" class="form-label">Speaking</label>
                                        <span class="text-danger speaking_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details_edit" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead_average_score_edit" name="average_score_edit" type="number" class="form-control eng_prof_score_edit" placeholder="Average" autocomplete="average_score" value="">
                                        <label for="lead-name" class="form-label">Average</label>
                                        <span class="text-danger average_score"></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-2 eng_prof_level_details_edit" style="display: none">
                                    <div class="form-floating">
                                        <input id="lead_exam_document_edit" name="exam_document_edit" type="file" class="form-control eng_prof_score_edit" placeholder="Average" autocomplete="exam_document" value="">
                                        <label for="lead-name" class="form-label">Exam Document</label>
                                        <span class="text-danger exam_document"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-12"><button type="button"
                            class="btn btn-info  py-6 testscore_edit">Submit</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.2/dist/sweetalert2.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
          const gradingSchemeSelect = document.getElementById('grading_scheme_id');
          const gradingInput = document.getElementById('lead-grading_number');

          gradingSchemeSelect.addEventListener('change', function () {
              validateInput();
          });
          gradingInput.addEventListener('input', function () {
              validateInput();
          });
          function extractMaxGrade(value) {
              const match = value.match(/(\d+)$/);
              return match ? parseInt(match[0], 10) : null;
          }

          function validateInput() {
              const selectedOption = gradingSchemeSelect.options[gradingSchemeSelect.selectedIndex];
              const selectedScheme = selectedOption.getAttribute('grading-data');
              if(selectedScheme == 'other'){
                $('#max_score').show();
              }else{
                $('#max_score').hide();
              }
              const inputValue = gradingInput.value;
              if (selectedScheme && inputValue !== '') {
                  const maxGrade = extractMaxGrade(selectedScheme);
                  if (maxGrade && inputValue > maxGrade) {
                      gradingInput.classList.add('is-invalid');
                      $('#grading_input_error').show();
                  } else {
                      gradingInput.classList.remove('is-invalid');
                      $('#grading_input_error').hide();
                  }
              } else {
                  gradingInput.classList.remove('is-invalid');
                  $('#grading_input_error').hide();
              }
          }
          validateInput();
    });
    function showVisaDetails(value) {
        var visaDetails = document.getElementsByClassName('visa_details_info');
        if (value == 'Yes') {
            for (var i = 0; i < visaDetails.length; i++) {
                visaDetails[i].style.display = 'block';
            }
        } else {
            for (var i = 0; i < visaDetails.length; i++) {
                visaDetails[i].style.display = 'none';
            }
        }
    }
    function studypermit(value) {
        var visaDetails = document.getElementsByClassName('study_permit');
        if (value == '1') {
            for (var i = 0; i < visaDetails.length; i++) {
                visaDetails[i].style.display = 'block';
            }
        } else {
            for (var i = 0; i < visaDetails.length; i++) {
                visaDetails[i].style.display = 'none';
            }
        }
    }

    $(document).ready(function() {
        var passport_status = $('#passport_status').val();
        if(passport_status == 'I have') {
            $('#passport_number').show();
            $('#passport_expiry').show();
            $('#passport_document').show();
        }
    });
    $('#passport_status').change(function() {
        var passport_stauts=$(this).val();
        if($(this).val() == 'I have') {
            $('#passport_number').show();
            $('#passport_expiry').show();
            $('#passport_document').show();
        } else {
            $('#passport_number').hide();
            $('#passport_expiry').hide();
            $('#passport_document').hide();
        }
    });
</script>
    <script src="{{ asset('assets/js/jquery-3.7.1.js') }}"></script>
    <script>
        $(document).ready(function() {
            function setupCSRF() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            }
            function fetchStates(country_id) {
                $('.province_id').empty();
                setupCSRF();
                $.ajax({
                    url: "{{ route('states.get') }}",
                    method: 'get',
                    data: {
                        country_id: country_id
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data)) {
                            $('.province_id').append('<option value="">No records found</option>');
                        } else {
                            $.each(data, function(key, value) {
                                $('.province_id').append('<option value="' + key + '">' +
                                    value + '</option>');
                            });
                        }
                    }
                });
            }
            // fetchStates($('.country').val());
            $('.country').change(function() {
                var country_id = $(this).val();
                fetchStates(country_id);
            });
            function student_test_score(){
                var student_id = $('.last_attended').attr('student-id');
                setupCSRF();
                $.ajax({
                    url: '{{ route('get-student-test-score') }}',
                    type: 'POST',
                    data: { student_id: student_id },
                    success: function(response) {
                        var test_score_data = response.test_score;
                        var tableRow = '';
                        var assetBaseUrl = "{{ asset('') }}/";
                        test_score_data.forEach(function(item,index) {
                            var key = index + 1;
                            tableRow += '<tr>';
                            tableRow += '<td>' + key + '</td>';
                            tableRow += '<td>' + item.type + '</td>';
                            tableRow += '<td>' + (item.exam_date ? item.exam_date : item.date_of_exam) + '</td>';
                            tableRow += '<td>' +(item.listening_score ? item.listening_score : item.verbal_score)+ '</td>';
                            tableRow += '<td>' + item.writing_score + '</td>';
                            tableRow += '<td>' +(item.reading_score ? item.reading_score : item.quantitative_score)+ '</td>';
                            tableRow += '<td>' + item.speaking_score + '</td>';
                            tableRow += '<td>' + item.average_score + '</td>';
                            if (item.exam_document) {
                                tableRow += `<td><a target="_blank" href="${assetBaseUrl}${item.exam_document ?? ''}"><img src="${assetBaseUrl}${item.exam_document ?? ''}" alt="${item.type}" width="100" height="100"></a></td>`;
                            } else {
                                tableRow += '<td></td>';
                            }
                            if(item.type == 'GRE'){
                                tableRow += `<td><a href="javascript:void(0)" class="btn btn-primary btn-sm mx-1"  data-bs-toggle="offcanvas" data-bs-target="#gre_exam" aria-controls="gre_exam"><i class="las la-pen"></i></a></td>`;
                            }else if(item.type == 'GMAT'){
                                tableRow += `<td><a href="javascript:void(0)" class="btn btn-primary btn-sm mx-1"  data-bs-toggle="offcanvas" data-bs-target="#gmat" aria-controls="gmat"><i class="las la-pen"></i></a></td>`;
                            }else{
                                tableRow += `<td><a href="javascript:void(0)" class="btn btn-primary btn-sm mx-1 test-score-edit"  data-bs-toggle="offcanvas" data-bs-target="#testscroresedit" aria-controls="testscroresedit" data-id="${item.id}" data><i class="fa-solid fa-pen"></i></a></td>`;
                                tableRow += `<td><a href="javascript:void(0)" class="btn btn-primary btn-sm mx-1 test-score-delete"  data-id="${item.id}" data><i class="fa-solid fa-trash"></i></a></td>`;
                            }
                            tableRow += '</tr>';
                        });
                        $('.test-score').html(tableRow);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
            $(document).on('click', '.test-score-delete', function(){
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        setupCSRF();
                        $.ajax({
                            url: '{{ url('student/delete-student-test-score')}}/'+id,
                            type: 'GET',
                            success: function(response){
                                Swal.fire(
                                    'Deleted!',
                                    'Test Score has been deleted.',
                                    'success'
                                );
                                student_test_score();
                            }
                        });
                    }
                })
            });
            student_test_score();
            $('.education_level_id').change(function() {
                var program_level_id = $(this).val();
                var student_id = $('.last_attended').attr('student-id');
                setupCSRF();
                $.ajax({
                    url: '{{ route('fetch-documents')}}',
                    method: 'get',
                    data: {
                        program_level_id: program_level_id,
                        student_id: student_id,
                    },
                    success: function(data) {
                        $('.school-attended').empty();
                        $('#lead-visa_document_type').empty();
                        var documents = data.documents;
                        var school_attended = data.school_attended;
                        $('#lead-visa_document_type').append('<option value="">--Select Document--</option>');
                        $('#lead-visa_document_type').append('<option value="0">Other Documents</option>');
                        $.each(documents, function(key, value) {
                            $('#lead-visa_document_type').append(`<option value="${value.id}">${value.name}</option>`);
                            var isChecked = school_attended ? (school_attended.includes(String(value.id)) ? 'checked' : '') : '';
                            $('.school-attended').append(`
                            <div class="form-check">
                                <input class="form-check-input already_filled_data" ${isChecked} name="education_level_id[]" disabled type="checkbox" id="education_level_id_${value.id}" value="${value.id}">
                                <label class="form-check-label" for="education_level_id_${value.id}">${value.name}</label>
                            </div>`);
                        });
                    }
                });
            });
            function school_data(){
                var program_level_id = $('.education_level_id').val();
                var student_id = $('.last_attended').attr('student-id');
                if(program_level_id){
                    setupCSRF();
                    $.ajax({
                        url: '{{ route('fetch-documents') }}',
                        method: 'get',
                        data: {
                            program_level_id: program_level_id,
                            student_id: student_id,
                        },
                        success: function(data) {
                            $('.school-attended').empty();
                            $('#lead-visa_document_type').empty();
                            var documents = data.documents;
                            var school_attended = data.school_attended;
                            $('#lead-visa_document_type').append('<option value="">--Select Document--</option>');
                            $('#lead-visa_document_type').append('<option value="0">Other Documents</option>');
                            $.each(documents, function(key, value) {
                                $('#lead-visa_document_type').append(`<option value="${value.id}">${value.name}</option>`);
                                var isChecked = school_attended ? (school_attended.includes(String(value.id)) ? 'checked' : '') : '';
                                $('.school-attended').append(`
                                <div class="form-check">
                                    <input class="form-check-input already_filled_data" ${isChecked} name="education_level_id[]" disabled type="checkbox" id="education_level_id_${value.id}" value="${value.id}">
                                    <label class="form-check-label" for="education_level_id_${value.id}">${value.name}</label>
                                </div>`);
                            });
                        }
                    });
                }
            }
            function checkEducationAttended(){
                school_data();
                let checkedCount = $('.school-attended input[type="checkbox"]:checked').length;
                var program_level_id = $('.education_level_id').val();
                setupCSRF();
                $.ajax({
                    url: '{{ route('check-education-attended') }}',
                    method: 'get',
                    data: {
                        program_level_id: program_level_id,
                        checkedCount: checkedCount
                    },
                    success: function(response) {
                        if(response.document == 0){
                            $('.school').addClass('disabled');
                        }else{
                            if(response.status == true){
                                $('.school').removeClass('disabled');
                            }else{
                                $('.school').addClass('disabled');
                            }
                        }
                    }
                });
            }
            $('.education_data').on('click',function(){
                checkEducationAttended();
            });
            function lead_education_level_id(){
                var program_level_id = $('.education_level_id').val();
                setupCSRF();
                $.ajax({
                    url: '{{ route('fetch-documents') }}',
                    method: 'get',
                    data: {
                        program_level_id: program_level_id
                    },
                    success: function(data) {
                        var optionsHtml =`<option >--Select Document--</option>`;
                        $.each(data.documents, function(key, value) {
                            var disabled = data.disabled_education_history.includes(String(value.id)) ? 'disabled' : '';
                            optionsHtml += '<option value="' + value.id + '">' + value.name +
                                '</option>';
                        });
                        $('.lead_documents_id').html(optionsHtml);
                    }
                });
            }
            $('.last_attended_school').on('click',function() {
                $('#myForm')[0].reset();
                lead_education_level_id();
            });
            // $('.selected-country, .education_level_id').change(function() {
            //     var country_id = $('.selected-country').val();
            //     var education_level_id = $('.education_level_id').val();
            //     fetchData(country_id, education_level_id);
            // });
            // function fetchData(country_id, education_level_id) {
            //     setupCSRF();
            //     $.ajax({
            //         url: '{{ route('grading-scheme-list') }}',
            //         method: 'Post',
            //         data: {
            //             country_id: country_id,
            //             education_level_id: education_level_id
            //         },
            //         success: function(response) {
            //             var optionsHtml = '<option value="">-- Select --</option>';
            //             $.each(response.data, function(index, item) {
            //                 optionsHtml += '<option value="' + item.id + '">' + item.name +
            //                     '</option>';
            //             });
            //             $('.grading-scheme').html(optionsHtml);
            //         },
            //         error: function(xhr, status, error) {
            //             console.error(error);
            //         }
            //     });
            // }
            function handleNext() {
                const activeTab = $('.tab-pane.active');
                const nextTab = activeTab.next('.tab-pane');
                if (nextTab.length) {
                    activeTab.removeClass('active');
                    activeTab.removeClass('show');
                    nextTab.addClass('active show');
                    const nextTabLink = nextTab.attr('id') + '-tab';
                    $('#' + nextTabLink).tab('show');
                }
            }
            function handlePrevious() {
                const activeTab = $('.tab-pane.active');
                const previousTab = activeTab.prev('.tab-pane');
                if (previousTab.length) {
                    activeTab.removeClass('active');
                    activeTab.removeClass('show');
                    previousTab.addClass('active show');
                    const previousTabLink = previousTab.attr('id') + '-tab';
                    $('#' + previousTabLink).tab('show');
                }
            }
            $('.previous').on('click', handlePrevious);
            $('.skipform').on('click', function(event) {
                handleNext();
            });
            function deleteDocument(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        setupCSRF();
                        $.ajax({
                            url: "{{ route('delete-student-document') }}",
                            type: "get",
                            data: {
                                id: id
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Deleted!',
                                    'Document has been deleted.',
                                    'success'
                                );
                                documents_list();
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                })
            }
            function documents_list(){
                var student_id = $('.last_attended').attr('student-id');
                setupCSRF();
                $.ajax({
                    url: "{{ route('get-student-document') }}",
                    type: "GET",
                    data: {
                        student_id: student_id
                    },
                    success: function(response) {
                        var tableBody = $('.documents-data');
                        tableBody.empty();
                        var assetBaseUrl = "{{ asset('') }}/";
                        $.each(response.student_documents_data, function(index, item) {
                            var tr = $('<tr>');
                            tr.append($('<td>').text(item.student_id ?? null));
                            tr.append($('<td>').text('Other Documents'));
                            tr.append($('<td>').text(item?.image_name?.toUpperCase() ?? ''));
                            if (item.image_url && item.image_url.endsWith('.pdf')) {
                                tr.append($('<td>').html(`<a href="${assetBaseUrl}${item.image_url}" target="_blank" class="badge badge-success">View PDF</a>`));
                            } else {
                                tr.append($('<td>').html(`<img src="${assetBaseUrl}${item.image_url ?? ''}" style="width:150px;height:150px">`));
                            }
                            tr.append($('<td>').html(`<a href="#" class="btn btn-warning delete-document" data-id="${item.id}"><i class="fa-solid fa-trash"></i></a>`));
                            tableBody.append(tr);
                        });
                        $.each(response.documents, function(index, item) {
                            var tr = $('<tr>');
                            tr.append($('<td>').text(item.student_id ?? null));
                            tr.append($('<td>').text(item.name ?? null));
                            tr.append($('<td>').text(item?.image_name?.toUpperCase() ?? ''));
                            if (item.image_url && item.image_url.endsWith('.pdf')) {
                                tr.append($('<td>').html(`<a href="${assetBaseUrl}${item.image_url}" target="_blank" class="badge badge-success">View PDF</a>`));
                            } else {
                                tr.append($('<td>').html(`<img src="${assetBaseUrl}${item.image_url ?? ''}" style="width:150px;height:150px">`));
                            }
                            tr.append($('<td>').html(`<a href="#" class="btn btn-warning delete-document" data-id="${item.id}"><i class="fa-solid fa-trash"></i></a>`));
                            tableBody.append(tr);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            $(document).on('click', '.delete-document', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                deleteDocument(id);
            });
            documents_list();
            $('.next').on('click', function(event) {
                event.preventDefault();
                var spinner = this.querySelector('.spinner-grow');
                spinner.classList.remove('d-none');
                $('.next').addClass('disabled');
                var activeTab = document.querySelector('.tab-pane.fade.show.active');
                var activeForm = activeTab.querySelector('form');
                var formData = new FormData(activeForm);
                var subject_input = $('#lead-subject_input').val();
                formData.append('subject_input',subject_input);
                setupCSRF();
                $.ajax({
                    url: '{{route('student/student-store')}}',
                    type: 'post',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status) {
                            Swal.fire({
                                title: 'Success',
                                text: response.success,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                        spinner.classList.add('d-none');
                        $('.next').removeClass('disabled');
                        checkEducationAttended();
                        handleNext();
                    },
                    error: function(xhr) {
                        spinner.classList.add('d-none');
                        $('.next').removeClass('disabled');
                        var response = JSON.parse(xhr.responseText);
                        if(response.errors.email){
                            $('.email-error').html(response.errors.email);
                        }else{
                            $('.email-error').html('');
                        }
                        if(response.errors.middle_name){
                            $('.middle_name').html(response.errors.middle_name);
                        }else{
                            $('.middle_name').html('');
                        }
                        if(response.errors.passport_number){
                            $('.passport_number').html(response.errors.passport_number);
                        }else{
                            $('.passport_number').html('');
                        }
                        if(response.errors.last_name){
                            $('.last_name').html(response.errors.last_name);
                        }else{
                            $('.last_name').html('');
                        }
                        if(response.errors.zip){
                            $('.zip').html(response.errors.zip);
                        }else{
                            $('.zip').html('');
                        }
                        if(response.errors.gender){
                            $('.gender').html(response.errors.gender);
                        }else{
                            $('.gender').html('');
                        }
                        if(response.errors.maritial_status){
                            $('.maritial_status').html(response.errors.maritial_status);
                        }else{
                            $('.maritial_status').html('');
                        }
                        if(response.errors.first_language){
                            $('.first_language').html(response.errors.first_language);
                        }else{
                            $('.first_language').html('');
                        }
                        if(response.errors.passport_status){
                            $('.passport_status').html(response.errors.passport_status);
                        }else{
                            $('.passport_status').html('');
                        }
                        if(response.errors.dob){
                            $('.dob').html(response.errors.dob);
                        }else{
                            $('.dob').html('');
                        }
                        if(response.errors.country_id){
                            $('.country_id').html(response.errors.country_id);
                        }else{
                            $('.country_id').html('');
                        }
                        if(response.errors.province_id){
                            $('.province_id_error').html(response.errors.province_id);
                        }else{
                            $('.province_id_error').html('');
                        }
                        if(response.errors.city){
                            $('.city').html(response.errors.city);
                        }else{
                            $('.city').html('');
                        }
                        if(response.errors.address){
                            $('.address').html(response.errors.address);
                        }else{
                            $('.address').html('');
                        }
                        if(response.errors.pref_countries){
                            $('.pref_countries').html(response.errors.pref_countries);
                        }else{
                            $('.pref_countries').html('');
                        }
                        if(response.errors.education_level_id){
                            $('.education_level_id_error').html(response.errors.education_level_id);
                        }else{
                            $('.education_level_id_error').html('');
                        }
                        if(response.errors.grading_average){
                            $('.grading_average').html(response.errors.grading_average);
                        }else{
                            $('.grading_average').html('');
                        }
                        if(response.errors.grading_scheme_id){
                            $('.grading_scheme_id_error').html(response.errors.grading_scheme_id);
                        }else{
                            $('.grading_scheme_id_error').html('');
                        }
                        if(response.errors.ever_refused_visa){
                            $('.ever_refused_visa').html(response.errors.ever_refused_visa);
                        }else{
                            $('.ever_refused_visa').html('');
                        }
                        if(response.errors.has_visa){
                            $('.has_visa').html(response.errors.has_visa);
                        }else{
                            $('.has_visa').html('');
                        }
                        if(response.errors.visa_details){
                            $('.visa_details').html(response.errors.visa_details);
                        }else{
                            $('.visa_details').html('');
                        }
                        if(response.errors.pref_subjects){
                            $('.pref_subjects').html(response.errors.pref_subjects);
                        }else{
                            $('.pref_subjects').html('');
                        }
                        if(response.errors.job_profile){
                            $('.job_profile').html(response.errors.job_profile);
                        }else{
                            $('.job_profile').html('');
                        }
                        if(response.errors.organization_name){
                            $('.organization_name').html(response.errors.organization_name);
                        }else{
                            $('.organization_name').html('');
                        }
                        if(response.errors.mode_of_selary){
                            $('.mode_of_selary').html(response.errors.mode_of_selary);
                        }else{
                            $('.mode_of_selary').html('');
                        }
                        if(response.errors.position){
                            $('.position').html(response.errors.position);
                        }else{
                            $('.position').html('');
                        }
                        if(response.errors.working_from){
                            $('.working_from').html(response.errors.working_from);
                        }else{
                            $('.working_from').html('');
                        }
                        if(response.errors.working_upto){
                            $('.working_upto').html(response.errors.working_upto);
                        }else{
                            $('.working_upto').html('');
                        }
                    }
                });
            });
            function get_school_attendend(){
                var student_id = $('.last_attended').attr('student-id');
                setupCSRF();
                $.ajax({
                    url: '{{ route('get-school-attendaned') }}',
                    type: 'get',
                    data: {
                        student_id: student_id
                    },
                    success: function(response){
                        $('.last-attended-school').html('');
                        $.each(response.school_attendend, function(i, data){
                            $('.last-attended-school').append(`
                                    <tr>
                                        <td>${i+1}</td>
                                        <td>${data.documents?.name ?? null}</td>
                                        <td>${data.student?.first_name ?? null}</td>
                                        <td>${data.primary_language ?? null}</td>
                                        <td>${data.attended_from ?? null}</td>
                                        <td>${data.attended_to ?? null}</td>
                                        <td>${data.degree_awarded ?? null}</td>
                                        <td>${data.degree_awarded_on ?? null}</td>
                                        <td>${data.country?.name ?? null}</td>
                                        <td>${data.province?.name ?? null}</td>
                                        <td>${data.city ?? null}</td>
                                        <td>${data.address ?? null}</td>
                                        <td>${data.postal_zip ?? null}</td>
                                        <td>
                                            <div class="last_attended" data-tour="search"
                                                data-bs-toggle="offcanvas" data-bs-target="#viewlead"
                                                aria-controls="viewlead"
                                                student-id="${data.id}">
                                                    <i class="las la-pen"></i>
                                            </div>
                                        </td>
                                        <td><a href="javascript:void(0)" class="text-danger delete-attendance" data-id="${data.id}"><i class="fa-solid fa-trash"></i></a></td>
                                    </tr>
                            `);
                            checkEducationAttended();
                        });
                    }
                });
            }
            get_school_attendend();
            $('.education_level_id').change(function() {
                var program_level_id = $('.education_level_id').val();
                var student_id = $('.last_attended').attr('student-id');
                setupCSRF();
                $.ajax({
                    url: '{{ url('admin/check-student-attendend')}}',
                    type: 'POST',
                    data: {
                        'program_level_id': program_level_id,'student_id':student_id,
                    },
                    success: function(response){
                        if(response.success){
                            get_school_attendend();
                        }else{
                            $('.last-attended-school').empty();
                        }
                    }
                });
            });
            $(document).on('click', '.last_attended', function(){
                lead_education_level_id();
                var student_id = $(this).attr('student-id');
                setupCSRF();
                $.ajax({
                    url: '{{ url('student/get-student-attendence')}}/'+student_id,
                    type: 'GET',
                    success: function(response){
                        var selectedValues = response.school_attended?.documents;
                        if (!Array.isArray(selectedValues)) {
                            selectedValues = selectedValues ? [selectedValues] : [];
                        }
                        selectedValues.forEach(function(value) {
                            $('.lead_documents_id option[value="' + value + '"]').prop('disabled', false);
                        });
                        $('.lead_documents_id').val(selectedValues);
                        $('#institue_name').val(response.school_attended?.name);
                        $('#primary_language').val(response.school_attended?.primary_language);
                        $('#attended_from').val(response.school_attended?.attended_from);
                        $('#attended_to').val(response.school_attended?.attended_to);
                        $('#degree_awarded').val(response.school_attended?.degree_awarded);
                        $('#degree_awarded_on').val(response.school_attended?.degree_awarded_on);
                        $('#country_id').val(response.school_attended?.country_id);
                        fetchStates(response.school_attended?.country_id);
                        $('#province_id').val(response.school_attended?.province_id);
                        $('#city').val(response.school_attended?.city);
                        $('#address').val(response.school_attended?.address);
                        $('#postal_zip').val(response.school_attended?.postal_zip);
                    }
                });
            });
            $(document).on('click', '.delete-attendance', function(){
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        school_data();
                        setupCSRF();
                        $.ajax({
                            url: '{{ url('student/delete-student-attendence')}}/'+id,
                            type: 'GET',
                            success: function(response){
                                Swal.fire(
                                    'Deleted!',
                                    'Schools Attended deleted successfully.',
                                    'success'
                                );
                                get_school_attendend();
                                lead_education_level_id();
                                checkEducationAttended();
                            }
                        });
                    }
                })
            });
            $('.last_attendence').on('click', function(event) {
                var document_id =$('.lead_documents_id').val();
                var program_level_id = $('.education_level_id').val();
                if(!document_id){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please Select Document  level'
                    });
                    return false;
                }
                var spinner = this.querySelector('.spinner-grow');
                spinner.classList.remove('d-none');
                var student_id = $('.last_attended').attr('student-id');
                var formData = $('#myForm').serialize();
                formData += '&student_id=' + student_id + '&program_level_id=' + program_level_id;
                setupCSRF();
                $('.last_attendence').addClass('disabled');
                $.ajax({
                    url: '{{ route('update-attended-school') }}',
                    type: 'post',
                    data: formData,
                    success: function(response) {
                        spinner.classList.add('d-none');
                        school_data();
                        if (response.status) {
                            Swal.fire(
                                'Updated!',
                                response.success,
                                'success'
                            );
                            // setTimeout(() => {
                            //     location.reload();
                            // }, 1000);
                        }
                        get_school_attendend();
                        lead_education_level_id();
                        $('.last_attendence').removeClass('disabled');
                        $('#myForm')[0].reset();
                    },
                    error: function(xhr) {
                        $('.last_attendence').removeClass('disabled');
                        spinner.classList.add('d-none');
                        lead_education_level_id();
                        var response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message
                        });
                    }
                });
            });
            $('.gre_score').on('input', function(){
                var gre_score =$(this).val();
                if(gre_score < 0){
                    $(this).val(0);
                }
                if(gre_score > 340){
                    $(this).val(340);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Sorry! You cannot enter greater than 340'
                    });
                }
            });
            $('.greExam').on('click', function(event) {
                $('.greExam').addClass('disabled');
                var student_id = $('.last_attended').attr('student-id');
                var formData = new FormData($('#greExam')[0]);
                formData.append('student_id', student_id);
                setupCSRF();
                $.ajax({
                    url: '{{ route('update-gre-exam-data') }}',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.greExam').removeClass('disabled');
                        $('#greExam')[0].reset();
                        student_test_score();
                        if (response.status) {
                            Swal.fire(
                                'Updated!',
                                response.success,
                                'success'
                            );
                            setTimeout(() => {
                                // location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        $('.greExam').removeClass('disabled');
                        var response = JSON.parse(xhr.responseText);
                    }
                });
            });
            $('.eng_prof_level').on('change', function(){
                var eng_prof_level =$(this).val();
                $.ajax({
                    url: '{{ route('fetch-eng-prof-level-score') }}',
                    type: 'post',
                    data: {eng_prof_level: eng_prof_level},
                    success: function(response) {
                        $('#eng_prof_level_score').val(response.score.number);
                        $('#eng_prof_level_score_edit').val(response.score.number);
                    },
                    error: function(xhr) {
                        var response = JSON.parse(xhr.responseText);
                    }
                });
            });
            $('.eng_prof_score, .eng_prof_score_edit').on('input', function(e) {
                var eng_prof_level = $('#lead-type').val() || $('#lead_type_edit').val();
                var currentThis = $(e.currentTarget);
                if (eng_prof_level) {
                    var eng_prof_score = parseFloat(currentThis.val());
                    var eng_score = parseFloat($('#eng_prof_level_score').val() || $('#eng_prof_level_score_edit').val());
                    console.log(eng_prof_score, eng_score);
                    if (eng_prof_score < 0) {
                        currentThis.val(0);
                    }
                    if (eng_prof_score > eng_score) {
                        currentThis.val(eng_score);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Sorry! You cannot enter greater than ' + eng_score
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please Select English Proficiency Level'
                    });
                    return false;
                }
            });
            $('.gmat_score').on('input', function() {
                var gmat_score = $(this).val();
                if (gmat_score < 0) {
                    $(this).val(0);
                }
                if (gmat_score > 805) {
                    $(this).val(805);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Sorry! You cannot enter greater than 805'
                    });
                }
            });
            $('.gmat').on('click', function(event) {
                $('.gmat').addClass('disabled');
                var student_id = $('.last_attended').attr('student-id');
                var formData = new FormData($('#gmatform')[0]);
                formData.append('student_id', student_id);
                setupCSRF();
                $.ajax({
                    url: '{{ route('update-gmat-exam-data') }}',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.gmat').removeClass('disabled');
                        student_test_score();
                        if (response.status) {
                            Swal.fire(
                                'Updated!',
                                response.success,
                                'success'
                            );
                            setTimeout(() => {
                                // location.reload();
                            }, 1000);
                        }
                    },
                    error: function(response) {
                        $('.gmat').removeClass('disabled');
                    }
                });
            });
            $('.testscore').on('click', function(event) {
                $('.testscore').addClass('disabled');
                var student_id = $('.last_attended').attr('student-id');
                var formData = new FormData($('#testscore')[0]);
                formData.append('student_id', student_id);
                setupCSRF();
                $.ajax({
                    url: '{{ route('update-test-score') }}',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.testscore').removeClass('disabled');
                        student_test_score();
                        $('#testscore')[0].reset();
                        if (response.status) {
                            Swal.fire(
                                'Updated!',
                                response.success,
                                'success'
                            );
                        }
                    },
                    error: function(xhr) {
                        $('.testscore').removeClass('disabled');
                        var response = JSON.parse(xhr.responseText);
                        if(response.errors.exam_date){
                            $('.exam_date').html(response.errors.exam_date);
                        }else{
                            $('.exam_date').html('');
                        }
                        if(response.errors.listening_score){
                            $('.listening_score').html(response.errors.listening_score);
                        }else{
                            $('.listening_score').html('');
                        }
                        if(response.errors.speaking_score){
                            $('.speaking_score').html(response.errors.speaking_score);
                        }else{
                            $('.speaking_score').html('');
                        }
                        if(response.errors.reading_score){
                            $('.reading_score').html(response.errors.reading_score);
                        }else{
                            $('.reading_score').html('');
                        }
                        if(response.errors.type){
                            $('.type').html(response.errors.type);
                        }else{
                            $('.type').html('');
                        }
                        if(response.errors.writing_score){
                            $('.writing_score').html(response.errors.writing_score);
                        }else{
                            $('.writing_score').html('');
                        }
                    }
                });
            });
            $('.testscore_edit').on('click', function(event) {
                $('.testscore_edit').addClass('disabled');
                var id = $('.test-score-edit').data('id');
                var student_id = $('.last_attended').attr('student-id');
                var formData = new FormData($('#testscoreedit')[0]);
                formData.append('student_id', student_id);
                formData.append('id', id);
                setupCSRF();
                $.ajax({
                    url: '{{ route('update-test-score') }}',
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('.testscore_edit').removeClass('disabled');
                        student_test_score();
                        $('#testscoreedit')[0].reset();
                        if (response.status) {
                            Swal.fire(
                                'Updated!',
                                response.success,
                                'success'
                            );
                        }
                    },
                    error: function(xhr) {
                        $('.testscore_edit').removeClass('disabled');
                        var response = JSON.parse(xhr.responseText);
                        if(response.errors.exam_date){
                            $('.exam_date_edit').html(response.errors.exam_date);
                        }else{
                            $('.exam_date_edit').html('');
                        }
                        if(response.errors.listening_score){
                            $('.listening_score_edit').html(response.errors.listening_score);
                        }else{
                            $('.listening_score_edit').html('');
                        }
                        if(response.errors.speaking_score){
                            $('.speaking_score_edit').html(response.errors.speaking_score);
                        }else{
                            $('.speaking_score_edit').html('');
                        }
                        if(response.errors.reading_score){
                            $('.reading_score_edit').html(response.errors.reading_score);
                        }else{
                            $('.reading_score_edit').html('');
                        }
                        if(response.errors.type){
                            $('.type_edit').html(response.errors.type);
                        }else{
                            $('.type_edit').html('');
                        }
                        if(response.errors.writing_score){
                            $('.writing_score_edit').html(response.errors.writing_score);
                        }else{
                            $('.writing_score_edit').html('');
                        }
                    }
                });
            });
            $(document).on('click', '.test-score-edit', function(){
                var id = $(this).data('id');
                $.ajax({
                    url: '{{ url('student/edit-test-score')}}/'+id,
                    type: 'GET',
                    success: function(response){
                        console.log(response);
                        $('#eng_prof_level_result1_edit').val(response.eng_prof_level_result);
                        $('#lead_type_edit').html('<option value="'+response.type+'">'+response.type+'</option>');
                        $('#lead_exam_date_edit').val(response.exam_date);
                        $('#lead_listening_score_edit').val(response.listening_score);
                        $('#lead_writing_score_edit').val(response.writing_score);
                        $('#lead-reading_score_edit').val(response.reading_score);
                        $('#lead_speaking_score_edit').val(response.speaking_score);
                        $('#lead_average_score_edit').val(response.average_score);
                        $('#lead_exam_document_edit').val(response.exam_document);
                        $('#test_score_id').val(response.id);
                    }
                });
            });

            $('.documentForm').on('click', function(event) {
                event.preventDefault();
                $('.documentForm').addClass('disabled');
                var student_id = $('.last_attended').attr('student-id');
                var formData = new FormData($('#document')[0]);
                formData.append('student_id', student_id);
                setupCSRF();
                $.ajax({
                    url: '{{ route('student/student-store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#document')[0].reset();
                        documents_list();
                        if (response.status) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.success,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            }).then(function() {
                                if(response.redirect){
                                    setTimeout(() => {
                                        window.location.href = "{{ route('student-profile') }}";
                                    }, 2000);
                                }
                            });
                        }
                        $('.documentForm').removeClass('disabled');
                    },
                    error: function(xhr) {
                        $('.documentForm').removeClass('disabled');
                        var response = JSON.parse(xhr.responseText);
                    }
                });
            });
            function toggleDetails(inputName, inputId, detailClass) {
                $(`input[name="${inputName}"]`).on('change', function() {
                    if ($(`#${inputId}`).is(':checked')) {
                        $(`.${detailClass}`).show();
                    } else {
                        $(`.${detailClass}`).hide();
                    }
                }).trigger('change');
            }
            toggleDetails('work_experience', 'work_experience_1', 'experience_details');
            toggleDetails('result_receive', 'result_receive1', 'result_receive_details');
            toggleDetails('gmat_result_receive', 'gmat_result_receive1', 'gmat_details');
            toggleDetails('eng_prof_level_result', 'eng_prof_level_result1', 'eng_prof_level_details');
            toggleDetails('eng_prof_level_result_edit', 'eng_prof_level_result1_edit', 'eng_prof_level_details_edit');
        });
    </script>
@endsection
