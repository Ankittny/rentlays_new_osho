@extends('admin.template')

@section('main')



 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Category
      <small>Add Category</small>
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
            <form class="form-horizontal" action="{{ url('admin/add-category-master') }}" id="add_category_master" method="post" name="add_category_master" accept-charset='UTF-8' enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Name<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="name" id="name" value="{{ old('name') }}" placeholder="Enter  Name..">
                        @if ($errors->has('name'))
                            <span class="error-tag">
                                <p>{{ $errors->first('name') }}</p>
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
                    <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2">Status</label>
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
                  <button type="submit" class="btn btn-info text-white f-14 me-2" id="submitBtn">Submit</button>
                  <a class="btn btn-danger f-14" href="{{ url('admin/category-master') }}">Cancel</a>
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


