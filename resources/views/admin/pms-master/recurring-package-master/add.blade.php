@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Recurring Package
                <small>Add Recurring Package </small>
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
                        <form class="form-horizontal" action="{{ url('admin/add-recurring-package-master') }}"
                            id="add_recurring_package_master" method="post" name="add_recurring_package_master" accept-charset='UTF-8'
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">


                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Recurriung Service</label>
                                    <div class="col-sm-8">
                                        <select name="pms_recurring_service_ids[]" multiple  id="multiple-select" style="height: 50px" class="form-control select2" style="width: 100%;">
                                          <option value=""> Select Recurring Service </option>
                                          @foreach ($recurring_service as $key => $value)
                                              <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
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
                                            value="{{ old('package_name') }}" placeholder="Enter  Name..">
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
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Offer Price<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="offer_price" id="offer_price"
                                            value="{{ old('offer_price') }}" placeholder="Enter  offer price..">
                                        @if ($errors->has('offer_price'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('offer_price') }}</p>
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

<script>

$('#multiple-select').mobiscroll().select({
    inputElement: document.getElementById('my-input'),
    touchUi: false
});
</script>


    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
@endsection
