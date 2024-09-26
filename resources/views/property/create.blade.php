@extends('template')
@section('main')
<div class="mb-4 margin-top-85">
	<div class="row m-0">
		@include('users.sidebar')
		<div class="col-md-10  min-height dashboardbkground">
			<div class="main-panel m-4 list-background border rounded-3">
				<h3 class="text-center mt-5 text-24 font-weight-700">{{ __('List Your Space') }}</h3>
				<p class="text-center text-16 pl-4 pr-4">{{ __(':x Lets you make money renting out your place.', ['x' => siteName()]) }}</p>
				<form id="list_space" method="post" action="{{ url('property/create') }}" class="mt-4" id="lys_form" accept-charset='UTF-8'>
					{{ csrf_field() }}
					<input type="hidden" name='street_number' id='street_number'>
					<input type="hidden" name='route' id='route'>
					<input type="hidden" name='postal_code' id='postal_code'>
					<input type="hidden" name='city' id='city'>
					<input type="hidden" name='state' id='state'>
					<input type="hidden" name='country' id='country'>
					<input type="hidden" name='latitude' id='latitude'>
					<input type="hidden" name='longitude' id='longitude'>
					<div class="row p-4">
						<div class="col-md-6">
							<div class="form-group mt-4">
								<label for="exampleInputEmail1">{{ __('Property Type') }}</label>
								<select name="property_type_id" class="form-control text-16" id="toggleSelect">
									@foreach($property_type as $key => $value)
										<option data-icon-class="icon-star-alt"  value="{{ $key }}">
										{{ $value }}
										</option>
									@endforeach
								</select>
								@if ($errors->has('property_type_id')) <p class="error-tag">{{ $errors->first('property_type_id') }}</p> @endif
							</div>
						</div>
						 <div class="col-md-6 container">
							<div class="form-group mt-4">
								<label for="exampleInputEmail1">{{ __('Room Type') }}</label>
								<select name="space_type" class="form-control text-16">
									@foreach($space_type as $key => $value)
										<option data-icon-class="icon-star-alt" value="{{ $key }}">
										{{ $value }}
										</option>
									@endforeach
								</select>
								@if ($errors->has('space_type')) <p class="error-tag">{{ $errors->first('space_type') }}</p> @endif
							</div>
						</div>
{{-- 
						<div class="container">
							<!-- Divs will be added here -->
						  </div>
						{{-- <div class="col-md-6 toggleDiv">
							<div class="form-group mt-4">
								<label for="exampleInputEmail1">{{ __('Room Type') }}</label>
								<select name="space_type" class="form-control text-16">
									@foreach($space_type as $key => $value)
										<option data-icon-class="icon-star-alt" value="{{ $key }}">
										{{ $value }}
										</option>
									@endforeach
								</select>
								@if ($errors->has('space_type')) <p class="error-tag">{{ $errors->first('space_type') }}</p> @endif
							</div>
						</div>
						<div class="col-md-6 toggleDiv1">
							<div class="form-group mt-4">
								<label for="exampleInputEmail1">{{ __('Ware House Type') }}</label>
								<select name="space_type1" class="form-control text-16">
									@foreach($warehouse as $key => $value)
										<option data-icon-class="icon-star-alt" value="{{ $key }}">
										{{ $value }}
										</option>
									@endforeach
								</select>
								@if ($errors->has('space_type')) <p class="error-tag">{{ $errors->first('space_type') }}</p> @endif
							</div>
						</div> --}}

						<div class="col-md-6" id="accommodates">
							<div class="form-group mt-4">
								<label for="exampleInputEmail1">{{ __('Accommodates') }}</label>
								<select name="accommodates" class="form-control text-16">
									@for($i=1;$i<=16;$i++)
									<option class="accommodates" data-accommodates="{{ $i }}" value="{{ $i }}">
										{{ $i }}
									</option>
									@endfor
								</select>
								@if ($errors->has('accommodates')) <p class="error-tag">{{ $errors->first('accommodates') }}</p> @endif
							</div>
						</div>

						<div class="col-md-6" id="content">
							<div class="form-group mt-4">
								<label for="exampleInputPassword1">{{ __('City') }} <span class="text-danger">*</span></label>
								<input type="text" class="form-control text-16" id="map_address" name="map_address" placeholder="">
								@if ($errors->has('map_address')) <p class="error-tag">{{ $errors->first('map_address') }}</p> @endif
								<div id="us3"></div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="float-right">
								<button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3 mt-4 mb-4" id="btn_next"> <i class="spinner fa fa-spinner fa-spin d-none" ></i>
									<span id="btn_next-text">{{ __('Continue') }}</span>

								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('validation_script')
	<script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ config("vrent.google_map_key") }}&libraries=places'></script>
	<script type="text/javascript" src="{{ asset('public/js/jquery.validate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/js/locationpicker.jquery.min.js') }}"></script>

	<script type="text/javascript">
		'use strict'
		let continueText = "{{ __('Continue') }}..";
		let fieldRequiredText = "{{ __('This field is required.') }}";
		let page = 'create';
	</script>

	<script type="text/javascript" src="{{ asset('public/js/propertycreate.min.js') }}"></script>
	{{-- add by ankit 06/12/2024 --}}
	<script>
		$(document).ready(function(){
			// Function to add div based on selected value
			function addDiv(label, name, options) {
				var formGroup = $("<div>").addClass("form-group mt-4");
				formGroup.append("<label>" + label + "</label>");
				var select = $("<select>").attr("name", name).addClass("form-control text-16 valid");
				$.each(options, function(key, value) {
					select.append($("<option>").attr("value", key).text(value));
				});
				formGroup.append(select);
				$(".container").append(formGroup);
			}
		
			// Function to handle toggleSelect change
			function handleToggleSelectChange(selectedValue) {
				$(".container").empty(); // Clear existing content
				if (selectedValue == 29) {
					$("#accommodates").hide();
					$('#content').removeClass('col-md-6 col-md-12').addClass('col-md-12');
					addDiv("Ware House Type", "space_type", {!! json_encode($warehouse) !!});
				} else {
					$("#accommodates").show();
					$('#content').removeClass('col-md-12').addClass('col-md-6');
					addDiv("Room Type", "space_type", {!! json_encode($space_type) !!});
				}
			}
		
			// Check if there's a stored selectedValue in sessionStorage
			var storedSelectedValue = sessionStorage.getItem('selectedValue');
			if (storedSelectedValue) {
				// Set the value of #toggleSelect to the stored selectedValue
				$("#toggleSelect").val(storedSelectedValue);
				// Trigger change to populate .container based on stored selectedValue
				handleToggleSelectChange(storedSelectedValue);
			}
		
			// Event listener for #toggleSelect change
			$("#toggleSelect").change(function() {
				var selectedValue = $(this).val();
				// Store selectedValue in sessionStorage
				sessionStorage.setItem('selectedValue', selectedValue);
				// Handle change to populate .container based on selectedValue
				handleToggleSelectChange(selectedValue);
			});
		});
	</script>
		
		
@endsection

