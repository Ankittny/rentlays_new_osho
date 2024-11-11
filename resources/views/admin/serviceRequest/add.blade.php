@extends('admin.template')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrql/4R3yP9QqiTm6+6K9e7g2e5Tz1e9mr3v1+PjVt1uX2rrGZPjB7g5IP5Vd+qf5A5J3u3j2HU1YA==" crossorigin="anonymous" />
<!-- Include jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-tHtwcwUz1pD1UnWZn2kTEZg3OoR/BE04nND1q3zB3lsOWShy3f6Gtye5Yl9xZHt9pJ+Qq/uwZ8AO7zFt8G8mXw==" crossorigin="anonymous"></script>
@endpush
@section('main')



 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Service Request
      <small>Add Service Request</small>
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
            <form class="form-horizontal" action="{{ url('admin/add-service-request') }}" id="add_service_request" method="post" name="add_service_request" accept-charset='UTF-8' enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">

                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Property</label>
                        <div class="col-sm-8">
                      
                            <select name="property_id" class="form-control f-14 select2" required>
                                <option value="">Select Property</option>
                                @foreach ($property as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                    {{ $value->name }}
                                  </option>
                                @endforeach
                            </select>
                          
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Issue<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="issue" id="issue" value="{{ old('issue') }}" placeholder="Enter Reviewer Name..">
                        @if ($errors->has('issue'))
                            <span class="error-tag">
                                <p>{{ $errors->first('issue') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>
                  
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2">Description<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <textarea name="description" id="description" class="form-control f-14 error" placeholder="Description..">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="error-tag">
                                <p>{{ $errors->first('description') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2">Image<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="file" class="form-control f-14 error" name="image" id="image" placeholder="">
                        @if ($errors->has('image'))
                            <span class="error-tag">
                                <p>{{ $errors->first('image') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Priority</label>
                        <div class="col-sm-8">
                            <select name="priority" class="form-control f-14">
                              <option value=""> Select Priority</option>
                            
                                  <option data-icon-class="icon-star-alt" value="1" >
                                    Low
                                  </option>
                                  <option data-icon-class="icon-star-alt" value="2">
                                    Medium
                                  </option>
                                  <option data-icon-class="icon-star-alt" value="3">
                                    High
                                  </option>
                          
                            </select>
                        </div>
                    </div>

                 


                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Assign to supervisor</label>
                        <div class="col-sm-8">
                            <select name="assign_to_supervisor" class="form-control f-14">
                              <option value=""> Select supervisor </option>
                              @foreach ($assign_to_supervisor as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                      {{ $value->username  }}
                                  </option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    @php
                        $user = Auth::guard('admin')->user();
                    @endphp
                    @if($user->username != 'admin')
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Assign to site Manager</label>
                        <div class="col-sm-8">
                            <select name="assign_to_sitemanager" class="form-control f-14">
                              <option value=""> Select  Site Manager</option>
                              @foreach ($assign_to_sitemanager as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                      {{ $value->username  }}
                                  </option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row mt-3">
                    <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2">Status</label>
                    <div class="col-sm-8">
                        <select class="form-control f-14" name="status" id="status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-info text-white f-14 me-2" id="submitBtn">Submit</button>
                  <a class="btn btn-danger f-14" href="{{ url('admin/service_request') }}">Cancel</a>
                </div>
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
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>	
    <script>
        $(document).ready(function() {
          $('.select2').select2({
            placeholder: 'Select Property',
            allowClear: true
          });
        });
      </script>
@endsection


