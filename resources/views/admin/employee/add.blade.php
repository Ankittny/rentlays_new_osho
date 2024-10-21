@extends('admin.template')
@push('css')
<link href="{{ asset('public/backend/css/setting.min.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('main')
<div class="content-wrapper">
    <section class="content-header">
        <h1>Add Empoloyee</h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="box box-info">
                    @if (Session::has('error'))
                    <div class="error_email_settings">
                        <div class="alert alert-warning fade in alert-dismissable">
                            <strong>Warning!</strong> Whoops there was an error. Please verify your below
                            information. <a class="close" href="#" data-dismiss="alert" aria-label="close"
                                title="close">×</a>
                        </div>
                    </div>
                    @endif
                    @if (Session::has('success'))
                    <div class="success_email_settings">
                        <div class="alert alert-success fade in alert-dismissable">
                            <strong>Success!</strong> {{ Session::get('success') }}
                            <a class="close" href="#" data-dismiss="alert" aria-label="close"
                                title="close">×</a>
                        </div>
                    </div>
                    @endif
                    <div class="box-header with-border">
                        <h3 class="box-title">Add Employee Form</h3>
                        <span class="email_status">
                            (<span class="text-green">
                                <i class="fa fa-check" aria-hidden="true"></i>Verified</span>)
                        </span>
                    </div>

                    <form id="add_designation" method="post" action="{{ url('admin/add-employee') }}" class="form-horizontal" enctype=multipart/form-data>
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group row mt-3 name">
                                <label for="name" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Name
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control f-14 validate_field" id="name" placeholder="Name">
                                    <span class="text-danger">{{ $errors->first("name") }}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-3 email">
                                <label for="email" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Email</label>
                                <div class="col-sm-6">
                                    <input type="email" name="email" class="form-control f-14" id="email" placeholder="Email">
                                    <span class="text-danger">{{ $errors->first("email") }}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-3 designation_id">
                                <label for="designation_id" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Department
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <select class="form-control f-14 validate_field" name="designation_id" id="designation_id">
                                        <option value="">--Select Department--</option>
                                        @foreach($deparment_list as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first("designation_id") }}</span>
                                </div>
                            </div>
                            @php
                                $get_role = App\Http\Helpers\Common::get_roles(Auth::guard('admin')->user()->id);
                                $get_all_superviser = App\Http\Helpers\Common::get_all_superviser();
                            @endphp
                            @if ($get_role == 'admin')
                            <div class="form-group row mt-3">
                                <label for="supervisor_id" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Select Super viser
                                    <span class="text-danger">*</span>
                                </label>
                                
                                <div class="col-sm-6">
                                    <select class="form-control f-14 validate_field" name="supervisor_id" id="supervisor_id">
                                        <option value="">--Select Super viser--</option>
                                            @foreach ($get_all_superviser as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                    </select>
                                    <span class="text-danger">{{ $errors->first("supervisor_id") }}</span>
                                </div>
                            </div>
                            @else
                            <input type="hidden" name="supervisor_id" id="supervisor_id" value="{{ Auth::guard('admin')->user()->id }}">
                            @endif
                            <div class="form-group row mt-3 mobile">
                                <label for="mobile" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Mobile
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="mobile" class="form-control f-14 validate_field" id="mobile" placeholder="Mobile">
                                    <span class="text-danger">{{ $errors->first("mobile") }}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-3 address">
                                <label for="address" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Address
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <textarea name="address" class="form-control f-14 validate_field" id="address" placeholder="Address"></textarea>
                                    <span class="text-danger">{{ $errors->first("address") }}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-3 pan_photo">
                                <label for="pan_photo" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">PAN Photo
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="file" name="pan_photo" class="form-control f-14 validate_field" id="pan_photo">
                                    <span class="text-danger">{{ $errors->first("pan_photo") }}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-3 pincode">
                                <label for="pincode" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Pincode
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="text" name="pincode" class="form-control f-14 validate_field" id="pincode" placeholder="Pincode">
                                    <span class="text-danger">{{ $errors->first("pincode") }}</span>
                                </div>
                            </div>
                            
                            <div class="form-group row mt-3 aadhaar_front">
                                <label for="aadhaar_front" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Aadhaar Front
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="file" name="aadhaar_front" class="form-control f-14 validate_field" id="aadhaar_front">
                                    <span class="text-danger">{{ $errors->first("aadhaar_front") }}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-3 aadhaar_back">
                                <label for="aadhaar_back" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Aadhaar Back
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="file" name="aadhaar_back" class="form-control f-14 validate_field" id="aadhaar_back">
                                    <span class="text-danger">{{ $errors->first("aadhaar_back") }}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-3 date_of_joining">
                                <label for="date_of_joining" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Date of Joining
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-6">
                                    <input type="date" name="date_of_joining" class="form-control f-14 validate_field" id="date_of_joining">
                                    <span class="text-danger">{{ $errors->first("date_of_joining") }}</span>
                                </div>
                            </div>
                            <div class="form-group row mt-3 date_of_end">
                                <label for="date_of_end" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Date of End</label>
                                <div class="col-sm-6">
                                    <input type="date" name="date_of_end" class="form-control f-14" id="date_of_end">
                                    <span class="text-danger">{{ $errors->first("date_of_end") }}</span>
                                </div>
                            </div>

                            <div class="form-group row mt-3 date_of_end">
                                <label for="date_of_end" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Password</label>
                                <div class="col-sm-6">
                                    <input type="password" name="password" class="form-control f-14" id="password">
                                   
                                </div>
                            </div>
                            <div class="form-group row mt-3 status">
                                <label for="status" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                                <div class="col-sm-6">
                                    <select class="form-control f-14" id="status" name="status" aria-invalid="false">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                        <option value="on-leave">On Leave</option>
                                    </select>
                                    <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>
                            <a class="btn btn-danger f-14" href="{{ url('admin/designation') }}">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('validate_script')
<script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
@endsection

