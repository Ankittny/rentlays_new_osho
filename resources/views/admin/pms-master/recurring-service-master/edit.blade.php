@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
             Recurring Service  Master
                <small>Edit Recurring Service</small>
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
                        <form class="form-horizontal" action="{{ url('admin/edit-recurring-service-master/' . $result->id) }}"
                            id="edit_recurring_service_master" method="post" name="edit_recurring_service_master" accept-charset='UTF-8'
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
                                              <option data-icon-class="icon-star-alt" value="{{ $value->id }}" {{ $value->id == $result->service_id ? 'selected' : '' }} >
                                                  {{ $value->name  }}
                                              </option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                               
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Price<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="price" id="price" placeholder="Enter  amount.." value="{{ $result->price }}">
                                        @if ($errors->has('price'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('price') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Duration Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="duration_type" id="duration_type"  value="{{ $result->duration_type }}">
                                            <option value="1" {{ $result->duration_type == 1 ? 'selected' : '' }}>Yearly</option>
                                            <option value="2" {{ $result->duration_type == 2 ? 'selected' : '' }}>Quarterly</option>
                                            <option value="2" {{ $result->duration_type == 3 ? 'selected' : '' }}>3 Months</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Duration Time<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="duration_time" id="duration" placeholder="Enter Duration" value="{{ $result->duration_time }}">
                                        @if ($errors->has('duration_time'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('duration_time') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="status" id="status">
                                            <option value="active" {{ $result->status == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ $result->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info f-14 text-white me-2"
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
