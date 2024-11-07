@extends('admin.template')

@section('main')



 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    PMS Inventory
      <small>Add  PMS Inventory</small>
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
            <form class="form-horizontal" action="{{ url('admin/add-pms-inventory') }}" id="add_pms_inventory" method="post" name="add_pms_inventory" accept-charset='UTF-8' enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="box-body">

                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">User</label>
                        <div class="col-sm-8">
                            <select name="user_id" class="form-control f-14">
                              <option value=""> Select User</option>
                              @foreach ($assign_to_sitemanager as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
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
                              @foreach ($brand as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
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
                            <select name="category_id" id="category" class="form-control f-14">
                              <option value=""> Select Category</option>
                              @foreach ($category as $key => $value)
                                  <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                      {{ $value->name  }}
                                  </option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <label for="exampleInputPassword1"
                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Sub Category</label>
                        <div class="col-sm-8">
                            <select name="sub_category_id" class="form-control f-14 sub-category" id="sub-category">
                              <option value=""> Select Sub Category</option>
                            
                            </select>
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
                        <label for="exampleInputPassword1" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Price<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control f-14" name="price" id="price" value="{{ old('price') }}" placeholder="Enter Reviewer Name..">
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
                        <input type="text" class="form-control f-14" name="sellprice" id="sellprice" value="{{ old('sellprice') }}" placeholder="Enter Reviewer Name..">
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
                        <input type="text" class="form-control f-14" name="qty" id="qty" value="{{ old('qty') }}" placeholder="Enter Reviewer Name..">
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
                        <input type="text" class="form-control f-14" name="sku" id="sku" value="{{ old('sku') }}" placeholder="Enter Reviewer Name..">
                        @if ($errors->has('sku'))
                            <span class="error-tag">
                                <p>{{ $errors->first('sku') }}</p>
                            </span>
                        @endif
                        </div>
                    </div>

                 

                  

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


<script>
$(document).ready(function(){
    $('#category').on('change',function(){
        var category_id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"get",
            url:"{{url('admin/subcategory-data')}}",
            data:{
                category_id:category_id
            },
            success:function(response){
                console.log(response.data);
                $('#sub-category').empty();
                $('#sub-category').append('<option value =""> Select Sub Category</option>');
                $.each(response.data,function(index,subcategory){
                    $('#sub-category').append('<option value="'+subcategory.id+'">'+subcategory.name+'</option>');
                });
            }
        })
    });
});
</script>
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>	
@endsection


