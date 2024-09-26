@extends('template')
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		<!-- sidebar start-->
		@include('users.sidebar')
		<!--sidebar end-->
		<div class="col-md-10 dashboardbkground">
			<div class="main-panel min-height mt-4 bkwhite">
				<div class="row">
					<div class="col-md-3 pl-4 pr-4">
						@include('listing.sidebar')
					</div>
					<div class="col-md-9  mt-4 mt-sm-0 pl-4 pr-4 bkwhite">
						<form method="post" action="{{ url('listing/' . $result->id . '/' . $step) }}"  accept-charset='UTF-8' id="listing_bes">
							{{ csrf_field() }}
							
							@if($result->space_type=="7" || $result->space_type=="8")

								<div class="form-row mt-4 border rounded pb-4">
									<nav aria-label="breadcrumb "  class="w-100">
										<ol class="breadcrumb">
										  <li class="breadcrumb-item"><a href="#">Property Type</a></li>
										  <li class="breadcrumb-item">
											<a href="#">
												{{ App\Models\PropertyType::where('id', $result->property_type)->value('name') }}
											</a>
											</li>
											<li class="breadcrumb-item">
												<a href="{{url('property/create')}}" class="btn btn-danger">Edit</a>
											</li>
										</ol>
									  </nav>
									<div class="form-group col-md-12 main-panelbg pb-3 pt-3">
										<h4 class="text-18 font-weight-700 pl-3">{{ __('Area & Age') }}</h4>
									</div>

							  @if($ProperTypeOptionset->count() > 0)
								  @foreach($ProperTypeOptionset as $item)
									@php
										$option = App\Models\PropertyTypeoption::find($item->property_option_type_id);
										$name = str_replace(' ', '_', strtolower($option->name));
									@endphp
										@if($option->name=="Floor")
												<div class="form-group col-md-6 pl-5 pr-5">
													<label for="inputState">{{ $option->name }}</label>
													<select name="{{$name}}" id="basics-select-bedrooms"  class="form-control text-16 mt-2">
														@foreach ($floor_type as $key => $value)
														<option value="{{ $key }}" {{ ($key == $result->floor) ? 'selected' : '' }}>{{ $value }}</option>
														@endforeach
													</select>
												</div>
										@else

										<div class="form-group col-md-6 pl-5 pr-5">
											<label for="inputState">{{ $option->name }}</label>
											<input type="number" class="form-control text-16" name="{{$name}}" placeholder="" required value="{{$result->property_age ?? ''}}"> 
										</div>
										@endif
								@endforeach
							   @endif  
									{{-- <div class="form-group col-md-6 pl-5 pr-5">
										<label for="inputState">{{ __('Super Area') }}</label>
										<input type="number" class="form-control text-16" name="super_area" placeholder="" required value="{{$result->super_area ?? ''}}"> 
									</div>

									<div class="form-group col-md-6 pl-5 pr-5">
										<label for="inputState">{{ __('Property Age') }}</label>
										<input type="number" class="form-control text-16" name="property_age" placeholder="" required value="{{$result->property_age ?? ''}}"> 
									</div> --}}
								</div>
							@else 
							<div class="form-row mt-4 border rounded pb-4">
								<nav aria-label="breadcrumb "  class="w-100">
									<ol class="breadcrumb">
									  <li class="breadcrumb-item"><a href="#">Property Type</a></li>
									  <li class="breadcrumb-item">
										<a href="#">
											{{ App\Models\PropertyType::where('id', $result->property_type)->value('name') }}
										</a>
										</li>
										<li class="breadcrumb-item">
											<a href="{{url('property/create')}}" class="btn btn-danger">Edit</a>
										</li>
									</ol>
								  </nav>
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3">
									<h4 class="text-18 font-weight-700 pl-3">{{ __('Rooms and Beds') }}</h4>
								</div>

							@if($ProperTypeOptionset->count() > 0)
								@foreach($ProperTypeOptionset as $item)
									@php
										$option = App\Models\PropertyTypeoption::find($item->property_option_type_id);
										$name = str_replace(' ', '_', strtolower($option->name));
									@endphp
									@if($option->name=="Bed Type")
										<div class="form-group col-md-6 pl-5 pr-5">
											<label for="inputState">{{ $option->name }}</label>
											<select  name="{{$name}}"  class="form-control text-16 mt-2">
												@foreach ($bed_type as $key => $value)
													<option value="{{ $key }}" {{ ($key == $result->bed_type) ? 'selected' : '' }}>{{ $value }}</option>
												@endforeach
											</select>
										</div>
									@else 
										<div class="form-group col-md-6 pl-5 pr-5">
											<label for="inputState">{{ $option->name }}</label>
											<select name="{{$name}}" id="basics-select-beds"  class="form-control text-16 mt-2">
												@for ($i=1;$i<=16;$i++)
													<option value="{{ $i }}" {{ ($i == $result->beds) ? 'selected' : '' }}>
														{{ ($i == '16') ? $i . '+' : $i }}
													</option>
												@endfor
											</select>
										</div>
									@endif
								@endforeach
							@endif


								{{-- <div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Bedrooms') }}</label>
									<select name="bedrooms" id="basics-select-bedrooms"  class="form-control text-16 mt-2">
										@for ($i=1;$i<=10;$i++)
											<option value="{{ $i }}" {{ ($i == $result->bedrooms) ? 'selected' : '' }}>
												{{ $i }}
											</option>
										@endfor
									</select>
								</div> --}}

								{{-- <div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Beds') }}</label>
									<select name="beds" id="basics-select-beds"  class="form-control text-16 mt-2">
										@for ($i=1;$i<=16;$i++)
											<option value="{{ $i }}" {{ ($i == $result->beds) ? 'selected' : '' }}>
												{{ ($i == '16') ? $i . '+' : $i }}
											</option>
										@endfor
									</select>
								</div> --}}
								{{-- <div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Bathrooms') }}</label>
									<select name="bathrooms" id="basics-select-bathrooms"  class="form-control text-16 mt-2">
										@for ($i=1;$i<=8;$i+=1)
											<option class="bathrooms" value="{{ $i }}" {{ ($i == $result->bathrooms) ? 'selected' : '' }}>
												{{ ($i == '8') ? $i . '+' : $i }}
											</option>
										@endfor
									</select>
								</div> --}}

								{{-- <div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Bed Type') }}</label>
									<select  name="bed_type"  class="form-control text-16 mt-2">
										@foreach ($bed_type as $key => $value)
											<option value="{{ $key }}" {{ ($key == $result->bed_type) ? 'selected' : '' }}>{{ $value }}</option>
										@endforeach
									</select>
								</div> --}}
							</div>


							<div class="form-row mt-4 border rounded pb-4">
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3">
									<h4 class="text-18 font-weight-700 pl-3">{{ __('Listings ') }}</h4>
								</div>
								<div class="form-group col-md-12 pl-5 pr-5 d-flex">
										<div class="form-check">
											<input class="form-check-input checkBoxSmall" type="checkbox" id="toggleField1" name="other[]" value="airbnb">
											<label class="form-check-label mr-3 ml-4">Air BnB</label>
										</div>
										<div class="form-check">
											<input class="form-check-input checkBoxSmall" type="checkbox" id="toggleField" name="other[]" value="booking.com">
											<label class="form-check-label mr-3 ml-4">Booking.com</label>
										</div>
								</div>
								<div class="ml-5 mt-4">
									<div id="textFieldContainer1" class="mb-3"></div>
									<div id="textFieldContainer"></div>
								</div>
							</div>
							@endif
							
							
							
							<div class="form-row mt-4 border rounded pb-4" style="display: none;">
								<div class="form-group col-md-12 main-panelbg pb-3 pt-3" >
									<h4 class="text-18 font-weight-700 pl-3">{{ __('Listings') }}</h4>
								</div>

								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Property Type') }}</label>
									@if($result->property_type==29)
									<input type="hidden" value="{{$result->property_type}}" name="property_type">
									<select name=""  class="form-control text-16 mt-2" @if($result->property_type==29){{"disabled"}}@endif>
										@foreach ($property_type as $key => $value)
											<option value="{{ $key }}" {{ ($key == $result->property_type) ? 'selected' : '' }}>{{ $value }}</option>
										@endforeach
									</select>
									@else
										<select name="property_type"  class="form-control text-16 mt-2" @if($result->property_type==29){{"disabled"}}@endif>
											@foreach ($property_type as $key => $value)
											@if ($key != 29) 
												<option value="{{ $key }}" {{ ($key == $result->property_type) ? 'selected' : '' }}>{{ $value }}</option>
												@endif
											@endforeach
										</select>
								   @endif
								</div>
								@if($result->space_type=="7" || $result->space_type=="8")
									<div class="form-group col-md-6 pl-5 pr-5">
										<label for="inputState">{{ __('Ware House Type') }}</label>
										<select name="space_type" class="form-control text-16 mt-2">
											@foreach ($warehouse_type as $key => $value)
												<option value="{{ $key }}" {{ ($key == $result->space_type) ? 'selected' : '' }}>{{ $value }}</option>
											@endforeach
										</select>
									</div>
								@else 
									<div class="form-group col-md-6 pl-5 pr-5">
										<label for="inputState">{{ __('Room Type') }}</label>
										<select name="space_type" class="form-control text-16 mt-2">
											@foreach ($space_type as $key => $value)
												<option value="{{ $key }}" {{ ($key == $result->space_type) ? 'selected' : '' }}>{{ $value }}</option>
											@endforeach
										</select>
									</div>
								@endif
								@if($result->property_type==29)
									<input type="hidden" value="1" name="accommodates">
								@else
								<div class="form-group col-md-6 pl-5 pr-5">
									<label for="inputState">{{ __('Accommodates') }}</label>
									<select name="accommodates" id="basics-select-accommodates" class="form-control text-16 mt-2">
										@for ($i=1;$i<=16;$i++)
											<option class="accommodates" value="{{ $i }}" {{ ($i == $result->accommodates) ? 'selected' : '' }}>
												{{ ($i == '16') ? $i . '+' : $i }}
											</option>
										@endfor
									</select>
								</div>
								@endif
							</div>

							<div class="form-row float-right mt-5 mb-5">
								<div class="col-md-12 pr-0">
									<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-4 pr-4 pt-3 pb-3" id="btn_next"><i class="spinner fa fa-spinner fa-spin d-none" ></i>
										<span id="btn_next-text">{{ __('Next') }}</span>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('validation_script')
<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">

	'use strict'
	let nextText = "{{ __('Next') }}.."; 
	let page = 'basics';

</script>
<script type="text/javascript" src="{{ asset('public/js/listings.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#toggleField1, #toggleField').change(function() {
            var container;
            if ($(this).attr('id') === 'toggleField1') {
                container = $('#textFieldContainer1');
            } else {
                container = $('#textFieldContainer');
            }

            if ($(this).is(':checked')) {
                container.append('<input class="form-control" type="text" name="platform[]" placeholder="' + ($(this).val() === 'airbnb' ? 'AirBnb registration id' : 'booking.com registration id') + '">');
            } else {
                container.empty();
            }
        });
    });
</script>
@endsection

