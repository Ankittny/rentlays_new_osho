@extends('template')
@push('css')
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

<div class="margin-top-85">
    <div class="row m-0">
        <!-- sidebar start-->
        @include('users.sidebar')
        <!--sidebar end-->
        <div class="col-md-10 dashboardbkground">
            <div class="main-panel min-height mt-4 bkwhite">
                <div class="row justify-content-center">
                    <div class="col-md-3 pl-4 pr-4 ">
                        @include('listing.sidebar')
                    </div>
                    <div class="col-md-9 mt-4 mt-sm-0 pl-4 pr-4 ">
                        <form id="amenities_id" method="post" action="{{ url('listing/' . $result->id . '/' . $step) }}" accept-charset='UTF-8'>
                            {{ csrf_field() }}
                            @if($result->property_type == 29)
                                @foreach ($amenities_type as $row_type)
                                    @if($row_type->id == 3)
                                        <div class="col-md-12 p-0 mt-4 border rounded-3 ">
                                            <div class="row">
                                                <div class="col-md-12 pl-4 main-panelbg mb-4">
                                                    <h4 class="text-18 font-weight-700 pl-0 pr-0 pt-4 pb-4">{{ $row_type->name }}
                                                        <input type="hidden" id="amenity_type_id" value="{{ $row_type->id }}">
                                                        <span class="text-danger">*</span>
                                                    </h4>
                                                    @if ($row_type->description != '')
                                                        <p class="text-muted">{{ $row_type->description }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-12 pl-4 pr-4 pt-0 pb-4">
                                                    <div class="row">
                                                        @foreach ($amenities as $amenity)
                                                            @if ($amenity->type_id == $row_type->id)
                                                                <div class="col-md-6">
                                                                    <label class="label-large label-inline amenity-label mt-4 checkboxmrgn">
                                                                        <input type="checkbox" value="{{ $amenity->id }}" name="amenities[]" data-saving="{{ $row_type->id }}" {{ in_array($amenity->id, $property_amenities) ? 'checked' : '' }}>
                                                                        <span>{{ $amenity->title }}</span>
                                                                    </label>
                                                                    <span>&nbsp;</span>
                                                                    @if ($amenity->description != '')
                                                                        <span data-toggle="tooltip" class="icon" title="{{ $amenity->description }}"></span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        <span class="ml-4" id="at_least_one"><br></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                @foreach ($amenities_type as $row_type)
                                    @if($row_type->id == 1 || $row_type->id == 2 || $row_type->id == 3 || $row_type->id == 4 || $row_type->id == 5) 
                                        @if($row_type->id == 3)
                                            @continue
                                        @endif
                                        <div class="col-md-12 p-0 mt-4 border rounded-3 ">
                                                <div class="row">
                                                    <div class="col-md-12 pl-4 main-panelbg mb-4">
                                                        <h4 class="text-18 font-weight-700 pl-0 pr-0 pt-4 pb-4">{{ $row_type->name }}
                                                            @if ($row_type->name == 'Common Amenities')
                                                                <input type="hidden" id="amenity_type_id" value="{{ $row_type->id }}">
                                                                <span class="text-danger">*</span>
                                                            @endif
                                                           
                                                        </h4>
                                                        @if ($row_type->description != '')
                                                            <p class="text-muted">{{ $row_type->description }}</p>
                                                        @endif
                                                    </div>
                                                    @if(!($row_type->id == 5))
                                                    <div class="col-md-12 pl-4 pr-4 pt-0 pb-4">
                                                        <div class="row">
                                                            @foreach ($amenities as $amenity)
                                                                @if ($amenity->type_id == $row_type->id)
                                                                    <div class="col-md-6">
                                                                        <label class="label-large label-inline amenity-label mt-4 checkboxmrgn">
                                                                            @if($row_type->name == 'Property Nearest')
                                                                                <!-- Checkbox Input -->
                                                                                <!-- Accordion start -->
                                                                                <input type="checkbox" value="{{ $amenity->id }}" name="amenities[]" data-saving="{{ $row_type->id }}" 
                                                                                    {{ in_array($amenity->id, $property_amenities) ? 'checked' : '' }}>
                                                                                <span>{{ $amenity->title }}</span>
                                                                          
                                                                                <!-- Accordion End -->
                                                                            @else
                                                                                <!-- Just the Checkbox without Accordion for other Row Types -->
                                                                                <input type="checkbox" value="{{ $amenity->id }}" name="amenities[]" data-saving="{{ $row_type->id }}" 
                                                                                    {{ in_array($amenity->id, $property_amenities) ? 'checked' : '' }}>
                                                                                <span>{{ $amenity->title }}</span>
                                                                            @endif
                                                                        </label>
                                                                        <span>&nbsp;</span>
                                                                        @if ($amenity->description != '')
                                                                            <span data-toggle="tooltip" class="icon" title="{{ $amenity->description }}"></span>
                                                                        @endif
                                                                    </div>
                                                                    @endif
                                                                    @endforeach
                                                            <span class="ml-4" id="at_least_one"><br></span>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="col-md-12 pl-4 pr-4 pt-0 pb-4">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="label-large label-inline">{{ __('Property Area(meter)') }}</label>
                                                                    <input type="number" class="form-control" name="property_square" required value="{{ $result->property_square ?? '' }}" data-saving="">
                                                                    <span class="text-danger">{{ $errors->first('property_square') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="label-large label-inline">{{ __('No Of Floors') }}</label>
                                                                    <input type="number" class="form-control" name="number_of_floor" required value="{{ $result->number_of_floor ?? '' }}" data-saving="">
                                                                    <span class="text-danger">{{ $errors->first('number_of_floor') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="label-large label-inline">{{ __('No Of Rooms') }}</label>
                                                                    <input type="number" class="form-control" name="number_of_rooms" required value="{{ $result->number_of_rooms ?? '' }}" data-saving="">
                                                                    <span class="text-danger">{{ $errors->first('number_of_rooms') }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($loop->last)
                                                        <div class="col-md-12 pl-4 main-panelbg mb-4">
                                                            <h4 class="text-18 font-weight-700 pl-0 pr-0 pt-4 pb-4">
                                                                {{ __('Property Nearest') }}
                                                            </h4>
                                                            <div id="map" style="height: 500px; width: 100%;"></div>
                                                            <div id="property-list" style="margin-top: 20px;"></div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                    @endif
                                @endforeach
                            @endif
                            <div class="col-md-12 p-0 mt-4 mb-5 mm">
                                <div class="row justify-content-between mt-4">
                                    <div class="mt-4">
                                        <a data-prevent-default="" href="{{ url('listing/' . $result->id . '/location') }}" class="btn btn-outline-danger secondary-text-color-hover text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3">
                                            {{ __('Back') }}
                                        </a>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-5 pr-5 pt-3 pb-3" id="btn_next">
                                            <i class="spinner fa fa-spinner fa-spin d-none"></i>
                                            <span id="btn_next-text">{{ __('Next') }}</span>
                                        </button>
                                    </div>
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
<script type="text/javascript">
    'use strict'
    let nextText = "{{ __('Next') }}..";
    let mendatoryAmenitiesText = "{{ __('Choose at least one item from the Common Amenities.') }}";
    let next = "{{ __('Next') }}";
    let page = 'amenities';
</script>
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
