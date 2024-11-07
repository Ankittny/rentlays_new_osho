@extends('admin.template')

@section('main')



 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
   PMS Inventory
      <small>Edit  PMS Inventory</small>
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
            <form class="form-horizontal" action="{{ url('admin/edit-pms-inventory/' . $result->id) }}" id="edit_pms_inventory" method="post" name="edit_pms_inventory" accept-charset='UTF-8' enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">

                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">User</label>
                        <div class="col-sm-8">
                            <select name="user_id" class="form-control f-14">
                              <option value=""> Select User</option>
                              @foreach ($assign_to_sitemanager as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}"{{ $value->id == $result->user_id ? 'selected' : '' }} >
                                      {{ $value->username  }}
                                  </option>
                              @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Brand</label>
                        <div class="col-sm-8">
                            <select name="brand_id" class="form-control f-14">
                              <option value=""> Select Brand</option>
                              @foreach ($brands as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}" {{ $value->id == $result->brand_id ? 'selected' : '' }}}>
                                      {{ $value->name  }}
                                  </option>
                              @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Category</label>
                        <div class="col-sm-8">
                            <select name="category_id" class="form-control f-14">
                              <option value=""> Select Category</option>
                              @foreach ($category as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id}}" {{ $value->id == $result->category_id ? 'selected' : '' }}>
                                      {{ $value->name }}
                                  </option>
                              @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Sub Category</label>
                        <div class="col-sm-8">
                            <select name="sub_category_id" class="form-control f-14">
                              <option value=""> Select Sub Category</option>
                              @foreach ($sub_category as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}" {{ $value->id == $result->sub_category_id ? 'selected' : '' }}>
                                      {{ $value->name  }}
                                  </option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                   
                  
                 

                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2">Image<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="file" class="form-control f-14 error" name="image" id="image" placeholder="">
                        <img src="{{ url('/public/front/images/pms_inventory/' . $result->image) }}" height="80px;" width="80px;">
                     
                        @if ($errors->has('image'))
                            <span class="error-tag">
                                <p>{{ $errors->first('image') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2">Description<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <textarea name="description" id="description" class="form-control f-14 error" placeholder="Description..">{{$result->description}}</textarea>
                        @if ($errors->has('description'))
                            <span class="error-tag">
                                <p>{{ $errors->first('description') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>
                   

                 
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Price<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="price" id="price" value="{{$result->price}}" placeholder="Enter Reviewer Name..">
                        @if ($errors->has('price'))
                            <span class="error-tag">
                                <p>{{ $errors->first('price') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Sell Price<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="sellprice" id="sellprice" value="{{$result->sellprice}}" placeholder="Enter Reviewer Name..">
                        @if ($errors->has('sellprice'))
                            <span class="error-tag">
                                <p>{{ $errors->first('sellprice') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>

                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Sku<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="qty" id="qty" value="{{$result->qty}}" placeholder="Enter Reviewer Name..">
                        @if ($errors->has('qty'))
                            <span class="error-tag">
                                <p>{{ $errors->first('qty') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>


                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Qty<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="sku" id="sku" value="{{$result->sku}}" placeholder="Enter Reviewer Name..">
                        @if ($errors->has('sku'))
                            <span class="error-tag">
                                <p>{{ $errors->first('sku') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>

                 

                    <div class="form-group row mt-3">
                    <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                    <div class="col-sm-8">
                        <select class="form-control f-14" name="status" id="status">
                        <option value="Active" {{ ($result->status == 'Active') ? 'selected' : '' }} >Active</option>
                        <option value="Inactive" {{ ($result->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <button type="submit" class="btn btn-info f-14 text-white me-2" id="submitBtn">Submit</button>
                  <a class="btn btn-danger f-14" href="{{ url('admin/pms_inventory') }}">Cancel</a>
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
