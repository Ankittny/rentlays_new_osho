@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
              Service
                <small>Add Service</small>
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
                        <form class="form-horizontal" action="{{ url('admin/add-service-master') }}"
                            id="add_service_master" method="post" name="add_service_master" accept-charset='UTF-8'
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">


                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Department</label>
                                    <div class="col-sm-8">

                                      
                                        <select name="department_id" class="form-control f-14">
                                          <option value=""> Select Department </option>
                                          @foreach ($department as $key => $value)
                                              <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                  {{ $value->name  }}
                                              </option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Name<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="name" id="name"
                                            value="{{ old('name') }}" placeholder="Enter  Name..">
                                        @if ($errors->has('name'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('name') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="amount" id="amount"
                                            value="{{ old('amount') }}" placeholder="Enter  amount..">
                                        @if ($errors->has('amount'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('amount') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Description<span
                                            class="text-danger">*</span></label>
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
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Service Provider</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="service_provider" id="service_provider">
                                            <option value="1">Inhouse</option>
                                            <option value="0">Vendor</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="status" id="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info text-white f-14 me-2"
                                    id="submitBtn">Submit</button>
                                <a class="btn btn-danger f-14" href="{{ url('admin/service-master') }}">Cancel</a>
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
@endsection
