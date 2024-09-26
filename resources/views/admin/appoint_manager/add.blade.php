@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pms Job
                <small>Add Pms Job</small>
            </h1>
            @include('admin.common.breadcrumb')
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <span class="text-danger showmessage" id="form_error" style="display: none;"></span>
                        <form class="form-horizontal" action="{{ url('admin/add-appoint-managers') }}" id="add_pms_job" method="post"
                            name="add_pms_job" accept-charset='UTF-8' enctype="multipart/form-data">
                              {{ csrf_field() }}
                            <div class="box-body">
                                <input type="hidden" name='city' id='city'>
                                <input type="hidden" name='state' id='state'>
                                <input type="hidden" name='country' id='country'>
                                <input type="hidden" name='latitude' id='latitude'>
                                <input type="hidden" name='longitude' id='longitude'>
                                  <div class="form-group row mt-3">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Site Manager list</label>
                                        <div class="col-sm-6">
                                            <select name="siteengineer_id" class="form-control f-14">
                                                <option value=""> Select Site Manager</option>
                                                @foreach ($siteengineer as $value)
                                                    <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                        {{ ucfirst($value->username) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                               
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Service <span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                       @foreach($department as $items)  
                                            <label class="checkbo">
                                                <input type="checkbox" name="service[]" value="{{$items->id}}">&nbsp;&nbsp; {{ $items->name }}
                                            </label>
                                       @endforeach 
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1" class="control-label col-sm-3 mt-2 fw-bold">City
                                        <span class="text-danger">*</span></label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control f-14" id="map_address" name="map_address"
                                            placeholder="">
                                        @if ($errors->has('map_address'))
                                            <p class="error-tag">{{ $errors->first('map_address') }}</p>
                                        @endif
                                    </div>
                                    <div id="us3"></div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Pin Code</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control f-14" id="pin_code" name="pin_code"
                                            placeholder="">
                                        @if ($errors->has('pin_code'))
                                            <p class="error-tag">{{ $errors->first('pin_code') }}</p>
                                        @endif
                                    </div>
                                </div>    
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info text-white f-14 me-2"
                                    id="submitBtn">Submit</button>
                                <a class="btn btn-danger f-14" href="{{ url('admin/pms_inventory') }}">Cancel</a>
                            </div>

                            <div id="dynamicForm"></div>
                            <div id="dynamicForm_service"></div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
                    <!-- /.box -->

                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
        </section>
    </div>
@endsection
@section('validate_script')
    <script src="{{ asset('public/backend/js/intl-tel-input-13.0.0/build/js/intlTelInput.js') }}" type="text/javascript">
    </script>
    <script src="{{ asset('public/backend/js/isValidPhoneNumber.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        let validEmailText = "Please enter a valid email address.";
        let checkUserURL = "{{ route('checkUser.check') }}";
        var token = "{{ csrf_token() }}";
        let validInternationalNumber = "Please enter a valid International Phone Number.";
    </script>
    <script src="{{ asset('public/backend/js/add_customer_for_properties.min.js') }}" type="text/javascript"></script>
   
    
@endsection
