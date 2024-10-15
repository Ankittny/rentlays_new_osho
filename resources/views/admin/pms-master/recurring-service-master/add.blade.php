@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
             Recurring  Service
                <small>Add Recurring</small>
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
                        <form class="form-horizontal" action="{{ url('admin/add-recurring-service-master') }}"
                            id="add_recurring_service_master" method="post" name="add_recurring_service_master" accept-charset='UTF-8'
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">


                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Service</label>
                                    <div class="col-sm-8">

                                      
                                        <select name="service_id" class="form-control f-14">
                                          <option value=""> Select Service </option>
                                          @foreach ($service as $key => $value)
                                              <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                  {{ $value->name  }}
                                              </option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="form-group row mt-3">
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
                                </div> --}}

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Price<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="price" id="price"
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
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Duration Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="duration_type" id="duration_type">
                                            <option value="1">Yearly</option>
                                            <option value="2">Quarterly</option>
                                            <option value="2">3 Months</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Duration Time<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="duration_time" id="duration" placeholder="Enter Duration">
                                        @if ($errors->has('duration_time'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('duration_time') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="status" id="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info text-white f-14 me-2"
                                    id="submitBtn">Submit</button>
                                <a class="btn btn-danger f-14" href="{{ url('admin/recurring-service-master') }}">Cancel</a>
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
