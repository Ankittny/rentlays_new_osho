@extends('admin.template')
@section('main')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content-header">
            <h1>
                List Your Space
                <small>List Your Space</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            </ol>
        </section>

        <section class="content">
            <div class="row gap-2">
                <div class="col-md-3 settings_bar_gap">
                    @include('admin.common.property_bar')
                </div>
                <div class="col-md-9">
                    <form method="post" action="{{ url('admin/listing/' . $result->id . '/' . $step) }}"
                        class='signup-form login-form' accept-charset='UTF-8'>
                        {{ csrf_field() }}


                        <div class="box box-info">
                            <div class="box-body">

                                @if ($result->space_type == '7' || $result->space_type == '8')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="mb-0 f-18 mt-1">Area & Age</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Floor</label>
                                            <select name="floor" id="basics-select-bedrooms" data-saving="basics1"
                                                class="form-control f-14">
                                                    @foreach ($floor_type as $key => $value)
                                                        <option value="{{ $key }}"
                                                            {{ $key == $result->floor ? 'selected' : '' }}>{{ $value }}
                                                        </option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="exampleInputPassword1" class="label-large fw-bold">Super Area<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control f-14" name="super_area"
                                                id="super_area" placeholder="" value="{{$result->super_area}}" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="exampleInputPassword1" class="label-large fw-bold">Property Age<span
                                                    class="text-danger">*</span></label>
                                            <input type="number" class="form-control f-14" name="property_age"
                                                id="property_age" placeholder="" value="{{$result->property_age}}" required>
                                        </div>
                                    </div>
                                @else
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p class="mb-0 f-18 mt-1">Rooms and Beds</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Bedrooms</label>
                                            <select name="bedrooms" id="basics-select-bedrooms" data-saving="basics1"
                                                class="form-control f-14">
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $i == $result->bedrooms ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Beds</label>
                                            <select name="beds" id="basics-select-beds" data-saving="basics1"
                                                class="form-control f-14">
                                                @for ($i = 1; $i <= 16; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $i == $result->beds ? 'selected' : '' }}>
                                                        {{ $i == '16' ? $i . '+' : $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Bathrooms</label>
                                            <select name="bathrooms" id="basics-select-bathrooms" data-saving="basics1"
                                                class="form-control f-14">
                                                @for ($i = 1; $i <= 8; $i++)
                                                    <option class="bathrooms" value="{{ $i }}"
                                                        {{ $i == $result->bathrooms ? 'selected' : '' }}>
                                                        {{ $i == '8' ? $i . '+' : $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Bed Type</label>
                                            <select id="basics-select-bed_type" name="bed_type" data-saving="basics1"
                                                class="form-control f-14">
                                                @foreach ($bed_type as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ $key == $result->bed_type ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="mb-0 f-18 mt-1">Listings</p>
                                    </div>
                                </div>
                                <div class="row">

                                    @if ($result->property_type == 29)
                                        <input type="hidden" value="{{ $result->property_type }}" name="property_type">
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Property Type</label>
                                            <select name="" data-saving="basics1" class="form-control f-14"
                                                @if ($result->property_type == 29) {{ 'disabled' }} @endif>
                                                @foreach ($property_type as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ $key == $result->property_type ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Property Type</label>
                                            <select name="property_type" data-saving="basics1" class="form-control f-14">
                                                @foreach ($property_type as $key => $value)
                                                    @if ($key != 29)
                                                        <option value="{{ $key }}"
                                                            {{ $key == $result->property_type ? 'selected' : '' }}>
                                                            {{ $value }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if ($result->space_type == '7' || $result->space_type == '8')
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Ware House Type</label>
                                            <select name="space_type" data-saving="basics1" class="form-control f-14">
                                                @foreach ($warehouse_type as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ $key == $result->space_type ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Room Type</label>
                                            <select name="space_type" data-saving="basics1" class="form-control f-14">
                                                @foreach ($space_type as $key => $value)
                                                    <option value="{{ $key }}"
                                                        {{ $key == $result->space_type ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if ($result->property_type == 29)
                                        <input type="hidden" value="1" name="accommodates">
                                    @else
                                        <div class="col-md-4">
                                            <label class="label-large fw-bold">Accommodates</label>
                                            <select name="accommodates" id="basics-select-accommodates"
                                                class="form-control f-14">
                                                @for ($i = 1; $i <= 16; $i++)
                                                    <option class="accommodates" value="{{ $i }}"
                                                        {{ $i == $result->accommodates ? 'selected' : '' }}>
                                                        {{ $i == '16' ? $i . '+' : $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="label-large fw-bold">Recomended</label>
                                        <select name="recomended" id="basics-select-recomended"
                                            class="form-control f-14">
                                            <option value="1" {{ $result->recomended == 1 ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="0" {{ $result->recomended == 0 ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="label-large fw-bold">Verified</label>
                                        <select name="verified" class="form-control f-14">
                                            <option value="Pending"
                                                {{ $result->is_verified == 'Pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="Approved"
                                                {{ $result->is_verified == 'Approved' || $result->is_verified == '' ? 'selected' : '' }}>
                                                Approved</option>
                                        </select>
                                    </div>
                                    @if(App\Models\RoleAdmin::where('admin_id',Auth('admin')->user()->id)->first()->role_id == '3' || App\Models\RoleAdmin::where('admin_id',Auth('admin')->user()->id)->first()->role_id=='1')
                                    <div class="col-md-4">
                                        <label class="label-large fw-bold">Verified For PMS</label>
                                        <select name="verified" class="form-control f-14">
                                            <option value="Pending"
                                                {{ $result->is_verified_pms == 'Pending' ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="Approved"
                                                {{ $result->is_verified_pms == 'Approved' || $result->is_verified_pms == '' ? 'selected' : '' }}>
                                                Approved</option>
                                        </select>
                                    </div>
                                    @endif
                                </div>
                                <div class="row">
                                    <br>
                                    <div class="col-12 text-right mt-2">
                                        <button type="submit" class="btn btn-large btn-primary next-section-button f-14">
                                            Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- /.content -->
        <div class="clearfix"></div>
    </div>
@endsection
