@extends('template')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/daterangepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/user-front.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/slick.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/slick-theme.min.css') }}" />

    <script type="text/javascript" src="{{ asset('public/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/slick.min.js') }}"></script>
	<script>
		$(function(){
			$('.activerImageUseCls').click(function(){
				$('.activerImageUseCls').removeClass('active');
				$(this).addClass('active');                
			})
		})
//         $(function(){
//         $('.activerImageUseCls').click(function(){
//         // Toggle the 'active' class for the clicked element
//         $(this).toggleClass('active');
//         // Remove the 'active' class from all other elements except the clicked one
//         $('.activerImageUseCls').not(this).removeClass('active');
//         });
//         });
	</script>  
@endpush
@section('main')
    <input type="hidden"  id="front_date_format_type" value="{{ Session::get('front_date_format_type') }}">
    <section class="hero-banner magic-ball">
        <div class="main-banner" style="background-image: url('{{ getBanner() }}');">
            <div class="container">
                <div class="main-banner-box1">
                    <h1 class="text-center"> Find the perfect place to Live with your family</h1>
                </div>
                <ul class="banner_list">
                    <li>
                        <span><i class="fa fa-building"></i></span>
                        <p> Online bookings & reservation management</p>
                    </li>
                    <li>
                        <span><i class="fa fa-home"></i></span>
                        <p> Marketing & advertising of units</p>
                    </li>
                    <li>
                        <span><i class="fa fa-briefcase"></i></span>
                        <p> Tenant screening & placement </p>
                    </li>
                </ul>
                <section class="slider-area slider">
				@if($property_type->count() > 0)
					@foreach($property_type as $itemsType)
						<div>
							<a onclick="handleClickWithParam({{$itemsType->id}});" ><img src="{{asset("public/front/images/icons/".$itemsType->image)}}" class="mx-auto text-center activerImageUseCls"></a>
							<a onclick="handleClickWithParam({{$itemsType->id}});"><p class="text-12 mb-0 properttypetext"> {{$itemsType->name}} </p></a>
						</div>
					@endforeach
                @endif
                </section>
                <script>
                    $(".slider-area").slick({
                        dots: false,
                        infinite: true,
                        slidesToShow: 10,
                        slidesToScroll: 1,
                        responsive: [{
                        breakpoint: 1024,
                        settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                            }
                        }]
                    });
                </script>
                <div class="banner_form_box">
                    <form id="front-search-form" method="post" action="{{ url('search') }}">
                        {{ csrf_field() }}
						<input type="hidden" name="property_type" id="getvalueprotype">
                        <div class="g-field-search">
                            <div class="row">
                                <div class="col-md-4 border-right">
                                    <div class="banner_form_icon">
                                        <img class="banner_form_icon_img"
                                            src={{ asset('/public/front/images/address.png') }} alt="">
                                        <div class="input-group">
                                            <input class="form-control p-3 text-14" id="front-search-field"
                                                placeholder="{{ __('Where do you want to go?') }}" autocomplete="off"
                                                name="location" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 border-right">
                                    <div class="banner_form_icon">
                                        <img class="banner_form_icon_img" src={{ asset('/public/front/images/clock.png') }}
                                            alt="">
                                        <div class="d-flex pt-2" id="daterange-btn">
                                            <div class="input-group">
                                            <label class="form-chec-label pt-2">Check In</label>
                                                <input class="form-control cnt-frm p-3 border-right-0 border text-14 checkinout"
                                                    name="checkin" id="startDate" type="text"
                                                    placeholder="{{ __('') }}" autocomplete="off"
                                                    readonly="readonly" required>
                                                <span class="input-group-append append-slip">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar success-text text-14"></i>
                                                    </div>
                                                </span>
                                            </div>
                                            <div class="input-group">
                                            <label class="form-chec-label pt-2">Check Out</label>
                                                <input class="form-control cnt-frms  p-3 border-right-0 border text-14 checkinout"
                                                    name="checkout" id="endDate" placeholder="{{ __('') }}"
                                                    type="text" readonly="readonly" required>
                                                <span class="input-group-append append-slip">
                                                    <div class="input-group-text">
                                                        <i class="fa fa-calendar success-text text-14"></i>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 border-right">
                                    <div class="banner_form_icon">
                                        <img class="banner_form_icon_img"
                                            src={{ asset('/public/front/images/traveler-man.png') }} alt="">
                                        <div class="input-group">
                                            <select id="front-search-guests" name="guest"
                                                class="form-control  text-14">
                                                <option class="p-4 text-14" value="1">1 {{ __('Guest') }}</option>
                                                @for ($i = 2; $i <= 16; $i++)
                                                    <option class="p-4 text-14" value="{{ $i }}">
                                                        {{ $i == '16' ? $i . '+ ' . __('Guest') : $i . ' ' . __('Guests') }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="g-button-submit">
                            <button type="submit" class="btn vbtn-default btn-block p-3 text-16"><i
                                    class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @if (!$starting_cities->isEmpty())
        <section class="bg-gray pt-5 pb-5">
            <div class="container-fluid container-fluid-90">
                <div class="row">
                    <div class="section-intro text-center mb-4">
                        <p class="item animated fadeIn text-30 font-weight-700 m-0 text-capitalize">
                            {{ __('Top Destination') }}</p>
                        <p>{{ __('Best places where to live in the world and enjoy your trip') }} </p>
                    </div>
                </div>
                <div class="row mt-2">
                    @foreach ($starting_cities as $city)
                        <div class="col-md-4">
                            <div class="top-Destination">
                                <div class="card-image">
                                    <a href="{{ url('search?location=' . $city->name . '&checkin=&checkout=&guest=1') }}">
                                        <img src="{{ $city->image_url }}" alt="">
                                    </a>
                                </div>
                                <div class="card-info">
                                    <a class="card-title topheading"
                                        href="{{ url('search?location=' . $city->name . '&checkin=&checkout=&guest=1') }}">
                                        {{ $city->name }}
                                    </a>
                                    
                                        <div class="card-meta">
                                        {{-- <div class="meta-links">356 Tours, 248 Activities</div> --}}
                                        <div class="card-button"> 
                                            <a href="{{ url('search?location=' . $city->name . '&checkin=&checkout=&guest=1') }}">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.00011 9.08347L9.08347 5.00011L5.00011 0.916748M9.08347 5.00011L0.916748 5.00011"
                                                        stroke="" stroke-linecap="round" stroke-linejoin="round">
                                                    </path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @if (!$properties->isEmpty())
        <section class="recommandedbg bg-gray magic-ball magic-ball-about pt-5 pb-5">
            <div class="container-fluid container-fluid-90">
                <div class="row">
                    <div class="recommandedhead section-intro text-center">
                        <p class="item animated fadeIn text-30 font-weight-700 m-0 text-capitalize">
                            {{ __('Recommended Property') }}</p>
                        <p>{{ __('Alluring home where you can stay and enjoy a comfortable life.') }}</p>
                    </div>
                </div>
                <div class="row">
                    @foreach ($properties as $property)
                        <div class="col-12 col-md-3">
                            <div class="top-Destination topdestination">
                                <div class="card-image mb-0">
                                    <a href="properties/{{ $property->slug }}" aria-label="{{ $property->name }}">
                                        <img src="{{ $property->cover_photo }}" class="room-image-container200"
                                            alt="{{ $property->name }}" class="topdestinationimg">
                                    </a>
                                </div>
                                <div class="card-info p-3">
                                    {{-- <p class="text-14 font-weight-700 text mb-0"> {{ $property->name }}</p> --}}
									<div class="card-meta" >
                                        <div class="d-flex justify-content-between w-100">
                                            <div class="d-flex justify-content-between  w-100">
                                                <div class="text-color text-color-hover d-flex align-items-center">
                                                    
                                                <span class="text-14 font-weight-700 w-100 ">{{ App\Models\PropertyType::getAll()->where('id',$property->property_type)->first()->name ?? "" }},</span>
                                                <span class="text-14 font-weight-700 text-nowrap  mb-0 ">{{ $property->property_address->city }}</span>    
                                                </div>
                                               
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex justify-content-betweeb w-100">
                                        <div>
                                        <a href="" class="text-color text-color-hover d-flex align-items-center">
                                            <div>
                                                <span class="text-14 font-weight-700  w-100">{{ App\Models\PropertyType::getAll()->where('id',$property->property_type)->first()->name }},</span>
                                                
                                                
                                                <span class="text-14 font-weight-700 text mb-0">{{ $property->property_address->city }}</span>
                                                </div>    
                                        </a>
                                    </div>
                                        <p class="text-12 mb-0 text cc"  ><span><i class="fa fa-star text-14 secondary-text-color"></i>
                                            @if ( $property->guest_review)
                                                {{ $property->avg_rating }}
                                            @else
                                                0
                                            @endif
                                            ({{ $property->guest_review }})</span> </p>

                                        </div> --}}
									<div class="card-button imagebutton">
                                              @auth
                                                    <a class="btn btn-sm book_mark_change"
                                                       data-status="{{ $property->book_mark }}" data-id="{{ $property->id }}"
                                                       style="color:{{ ($property->book_mark == true) ? '#1DBF73':'' }}; ">
                                                    <span style="font-size: 20px;">
                                                        <i class="fas fa-heart "></i>
                                                    </span>
                                                    </a>
                                                @else
                                                    <a class="btn btn-sm book_mark_change" data-id="{{ $property->id }}"
                                                        style="color:#1dbf73 }}; ">
                                                        <span style="font-size: 20px;">
                                                            <i class="fas fa-heart hrtmt"></i>
                                                        </span>
                                                    </a>
                                                @endauth
                                        {{-- <a href="{{ url('search?location=' . $city->name . '&checkin=&checkout=&guest=1') }}">
                                            <i class="fas fa-heart hrtmt"></i>
                                        </a>                                         --}}
                                    </div>
										</div>
                                    <div class="review-0 ">
                                        <div class="d-flex justify-content-between ">
                                            {{-- <div class="d-flex">
                                                <div class="d-flex align-items-center">
                                                    <span><i class="fa fa-star text-14 secondary-text-color"></i>
                                                        @if ($property->guest_review)
                                                            {{ $property->avg_rating }}
                                                        @else
                                                            0
                                                        @endif
                                                        ({{ $property->guest_review }})
                                                    </span>
                                                </div>
                                            </div> --}}
                                            <div  class="pricenightfont">
                                                <span class="font-weight-700 " >{!! moneyFormat($property->property_price->default_symbol, $property->property_price->price) !!}</span> @if($property->property_type!=29) /{{ __('Night') }}@endif
                                            </div>
                                            <div class="text-12 mb-0  cc"  ><span><i class="fa fa-star text-14 secondary-text-color"></i>
                                                    @if ( $property->guest_review)
                                                        {{ $property->avg_rating }}
                                                    @else
                                                        0
                                                    @endif
                                                    ({{ $property->guest_review }})</span> 
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                {{-- <div class="row mt-3">
					@foreach ($properties as $property)
					<div class="col-md-6 col-lg-4 col-xl-4 pl-3 pr-3 pb-3 mt-4">
						<div class="card h-100 card-shadow card-1 overflow-hidden">
							<div class="">
								<a href="properties/{{ $property->slug }}" aria-label="{{ $property->name }}">
									<figure class="effect-milo">
										<img src="{{ $property->cover_photo }}" class="room-image-container200" alt="{{ $property->name }}"/>
										<figcaption>
										</figcaption>
									</figure>
								</a>
							</div>
							<div class="card-body">
								<div class="d-flex">
									<div>
										<div class="profile-img pl-2">
											<a href="{{ url('users/show/' . $property->host_id) }}"><img src="{{ $property->users->profile_src }}" alt="{{ $property->name }}"></a>
										</div>
									</div>

									<div class="p-2 text">
										<a class="text-color text-color-hover" href="properties/{{ $property->slug }}">
											<p class="text-14 font-weight-700 text mb-0"> {{ $property->name }}</p>
										</a>
										<p class="text-12 mb-0 text"><i class="fas fa-map-marker-alt"></i> {{ $property->property_address->city }}</p>
									</div>
								</div>
								<div class="review-0 p-3">
									<div class="d-flex justify-content-between">

										<div class="d-flex">
                                            <div class="d-flex align-items-center">
											<span><i class="fa fa-star text-14 secondary-text-color"></i>
												@if ($property->guest_review)
                                                    {{ $property->avg_rating }}
                                                @else
                                                    0
                                                @endif
                                                ({{ $property->guest_review }})</span>
                                            </div>

                                            <div class="">
                                                @auth
                                                    <a class="btn btn-sm book_mark_change"
                                                       data-status="{{ $property->book_mark }}" data-id="{{ $property->id }}"
                                                       style="color:{{ ($property->book_mark == true) ? '#1dbf73':'' }}; ">
                                                    <span style="font-size: 22px;">
                                                        <i class="fas fa-heart pl-2"></i>
                                                    </span>
                                                    </a>
												@else
													<a class="btn btn-sm book_mark_change" data-id="{{ $property->id }}"
														style="color:#1dbf73 }}; ">
														<span style="font-size: 22px;">	
															<i class="fas fa-heart pl-2"></i>
														</span>
													</a>
                                                @endauth
                                            </div>
                                        </div>
										<div>
											<span class="font-weight-700">{!! moneyFormat( $property->property_price->default_symbol, $property->property_price->price) !!}</span> / {{ __('night') }}
										</div>
									</div>
								</div>

								 <div class="card-footer text-muted p-0 border-0">
									<div class="d-flex bg-white justify-content-between pl-2 pr-2 pt-2 mb-3">
										<div>
											<ul class="list-inline">
												<li class="list-inline-item  pl-4 pr-4 border rounded-3 mt-2 bg-light text-dark">
														<div class="vtooltip"> <i class="fas fa-user-friends"></i> {{ $property->accommodates }}
														<span class="vtooltiptext text-14">{{ $property->accommodates }} {{ __('Guests') }}</span>
													</div>
												</li>

												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-2 bg-light">
													<div class="vtooltip"> <i class="fas fa-bed"></i> {{ $property->bedrooms }}
														<span class="vtooltiptext  text-14">{{ $property->bedrooms }} {{ __('Bedrooms') }}</span>
													</div>
												</li>

												<li class="list-inline-item pl-4 pr-4 border rounded-3 mt-2 bg-light">
													<div class="vtooltip"> <i class="fas fa-bath"></i> {{ $property->bathrooms }}
														<span class="vtooltiptext  text-14 p-2">{{ $property->bathrooms }} {{ __('Bathrooms') }}</span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div> 
							</div>
						</div>
					</div>
					@endforeach
				</div> --}}
            </div>
        </section>
    @endif

    <section class="pt-5 pb-5">
        <div class="container">
            <div class="Luxury_Travel_box">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-30">
                        <div class="box-left-payment">
                            <p class="text-30 font-weight-700">Luxury Travel Redefined: Your Passport to Global Glamour</p>
                            <p class="text-18">Discover how you can offset your adventure's carbon emissions and support
                                the sustainable initiatives practiced by our operators worldwide.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="box-image-payment-2">
                            <div class="row align-items-center">
                                <div class="col-sm-4 mb-30">
                                    <img class="bdrd8 w-100" src="public/front/images/payment.png" alt="Travila">
                                </div>
                                <div class="col-sm-4 mb-30">
                                    <img class="bdrd8 w-100 mb-15" src="public/front/images/payment2.png" alt="Travila">
                                    <img class="bdrd8 w-100 mb-15" src="public/front/images/payment3.png" alt="Travila">
                                </div>
                                <div class="col-sm-4 mb-30">
                                    <img class="bdrd8 w-100" src="public/front/images/payment4.png" alt="Travila">
                                    <img class="bdrd8 w-100" src="public/front/images/payment5.png" alt="Travila">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (!$testimonials->isEmpty())
        <section class="testimonialbg pt-5 pb-5">
            <div class="testimonials">
                <div class="container">
                    <div class="row">
                        <div class="recommandedhead section-intro text-center">
                            <p class="animated fadeIn text-30 font-weight-700 m-0 bkclr">{{ __('Say about Us') }}</p>
                            <p>{{ __('People Say The Nicest Things') }}</p>
                        </div>
                    </div>

                    <div class="row mt-5">
                        @foreach ($testimonials as $testimonial)
                            <?php $i = 0; ?>
                            <div class="col-md-4 mt-4">
                                <div class="item h-100 card-1">
                                    <img src="{{ $testimonial->image_url }}" alt="{{ $testimonial->name }}">
                                    <div class="name">{{ $testimonial->name }}</div>
                                    <small class="desig">{{ $testimonial->designation }}</small>
                                    <p class="details">{{ substr($testimonial->description, 0, 200) }} </p>
                                    <ul>
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($testimonial->review > $i)
                                                <li><i class="fa fa-star secondary-text-color" aria-hidden="true"></i>
                                                </li>
                                            @else
                                                <li><i class="fa fa-star rating" aria-hidden="true"></i></li>
                                            @endif
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
@stop

@section('validation_script')


    <script type="text/javascript"
        src='https://maps.google.com/maps/api/js?key={{ config('vrent.google_map_key') }}&libraries=places'></script>
    <script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>

    <script src="{{ asset('public/js/sweetalert.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/daterangecustom.js') }}"></script>
    <script type="text/javascript">
        'use strict'
        var success = "{{ __('Success') }}";
        var yes = "{{ __('Yes') }}";
        var no = "{{ __('No') }}";
        var user_id = "{{ Auth::id() }}";
        var token = "{{ csrf_token() }}";
        var add = "{{ __('Add to Favourite List ?') }}";
        var remove = "{{ __('Remove from Favourite List ?') }}";
        var added = "{{ __('Added to favourite list.') }}";
        var removed = "{{ __('Removed from favourite list.') }}";
        var dateFormat = '{{ $date_format }}';
        const BaseURL = '{{ url('/') }}';
    </script>
    <script src="{{ asset('public/js/front.min.js') }}"></script>
	<script>
		function handleClickWithParam(id){
			
			$("#getvalueprotype").val(id);
		}
	</script>
@endsection
