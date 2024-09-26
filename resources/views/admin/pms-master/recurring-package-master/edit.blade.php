@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
             Recurring Package  Master
                <small>Edit Recurring Package</small>
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
                        <form class="form-horizontal" action="{{ url('admin/edit-recurring-package-master/' . $result->id) }}"
                            id="edit_recurring_package_master" method="post" name="edit_recurring_package_master" accept-charset='UTF-8'
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Recurring Package</label>
                                    <div class="col-sm-8">
                                        <select name="pms_recurring_service_ids[]" multiple class="form-control f-14">
                                          <option value=""> Select Package </option>
                                            @foreach ($recurring_service as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->service_id }}" {{ in_array($value->id, explode(',', $result->pms_recurring_service_ids)) ? 'selected' : '' }} >
                                                    {{ $value->name  }}
                                                </option>
                                          @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Package Name<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="package_name" id="package_name"
                                            value="{{ $result->package_name }}" placeholder="Enter  amount..">
                                        @if ($errors->has('package_name'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('package_name') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Price<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="price" id="price"
                                            value="{{ $result->price }}" placeholder="Enter  amount..">
                                        @if ($errors->has('price'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('price') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                              
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Offer Price<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="offer_price" id="offer_price"
                                            value="{{ $result->offer_price }}" placeholder="Enter  amount..">
                                        @if ($errors->has('offer_price'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('offer_price') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                              
                                
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="status" id="status">
                                            <option value="1" {{ $result->status == 1 ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0"
                                                {{ $result->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info f-14 text-white me-2"
                                    id="submitBtn">Submit</button>
                                <a class="btn btn-danger f-14" href="{{ url('admin/recurring-packages-master') }}">Cancel</a>
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
