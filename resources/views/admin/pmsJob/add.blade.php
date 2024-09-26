@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pms Job
                <small>Add Pms Job</small>
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
                        <span class="text-danger showmessage" id="form_error" style="display: none;"></span>
                        <form class="form-horizontal" action="{{ url('admin/add-pms-job') }}" id="add_pms_job" method="post"
                            name="add_pms_job" accept-charset='UTF-8' enctype="multipart/form-data">
                              {{ csrf_field() }}
                            <div class="box-body">
                                @if(App\Models\Roles::find($role->role_id)->name=='admin' || App\Models\Roles::find($role->role_id)->name=='Supervisor')
                                    <input type="hidden" value="{{ App\models\Roles::find($role->role_id)->name }}" name="role" id="role_id">    
                                    <div class="form-group row mt-3">
                                            <label for="exampleInputPassword1"
                                                class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Property </label>
                                            <div class="col-sm-8">
                                                <select name="property_id" class="form-control f-14" id="property_id">
                                                    <option value=""> Select property</option>
                                                    @foreach ($property as $key => $value)
                                                        <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                            {{ $value->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('property_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                        </div>
                            {{-- @if(App\Models\Roles::find($role->role_id)->name=='Supervisor')
                               <input type="hidden" name="user_id" value="{{App\models\Roles::find($role->role_id)->id}}">
                            @else 
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Supervisor</label>
                                    <div class="col-sm-8">
                                        <select name="user_id" class="form-control f-14">
                                            <option value="">Select Supervisor</option>
                                                @foreach ($assign_to_sitemanager as $key => $value)
                                                    <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                        {{ $value->username }}
                                                    </option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif --}}
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Helpdesk</label>
                                    <div class="col-sm-8">
                                        <select name="helpdesk_id" class="form-control f-14" id="helpdesk_id" readonly>
                                            <option value=""> Select helpdesk</option>
                                            @foreach ($pms_helpdesk as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                    {{ $value->issue }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('helpdesk_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Type</label>
                                    <div class="col-sm-8">
                                        <select name="type" class="form-control f-14" id="subscription_type" readonly>
                                            <option value=""> Select Type</option>

                                            <option data-icon-class="icon-star-alt" value="requrring">
                                                Recurring
                                            </option>
                                            <option data-icon-class="icon-star-alt" value="on-demand">
                                                Onetime
                                            </option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @else

                                  <div class="form-group row mt-3">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Property </label>
                                        <div class="col-sm-8">
                                            <select name="property_id" class="form-control f-14">
                                                <option value=""> Select property</option>
                                                @foreach ($property as $key => $value)
                                                    <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                        {{ $value->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">User</label>
                                    <div class="col-sm-8">
                                        <select name="user_id" class="form-control f-14">
                                            <option value=""> Select User</option>
                                            @foreach ($assign_to_sitemanager as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                    {{ $value->username }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Helpdesk</label>
                                    <div class="col-sm-8">
                                        <select name="helpdesk_id" class="form-control f-14">
                                            <option value=""> Select helpdesk</option>
                                            @foreach ($pms_helpdesk as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                    {{ $value->issue }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Type</label>
                                    <div class="col-sm-8">
                                        <select name="type" class="form-control f-14">
                                            <option value=""> Select Type</option>

                                            <option data-icon-class="icon-star-alt" value="Recurring">
                                                Recurring
                                            </option>
                                            <option data-icon-class="icon-star-alt" value="Onetime">
                                                Onetime
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Upload Before Image<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control f-14 error" name="upload_before_image"
                                            id="upload_before_image" placeholder="">
                                        @if ($errors->has('upload_before_image'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('upload_before_image') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Upload After Image<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control f-14 error" name="upload_after_image"
                                            id="upload_after_image" placeholder="">
                                        @if ($errors->has('upload_after_image'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('upload_after_image') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>





                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Start Time<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="time" class="form-control f-14" name="start_time" id="start_time"
                                            value="{{ old('start_time') }}" placeholder="Enter Reviewer Name..">
                                        @if ($errors->has('start_time'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('start_time') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">End Time<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="time" class="form-control f-14" name="end_time" id="end_time"
                                            value="{{ old('end_time') }}" placeholder="Enter Reviewer Name..">
                                        @if ($errors->has('end_time'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('end_time') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Start Time Otp<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="start_time_otp"
                                            id="start_time_otp" value="{{ old('start_time_otp') }}"
                                            placeholder="Enter Reviewer Name..">
                                        @if ($errors->has('start_time_otp'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('start_time_otp') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">End time otp<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="end_time_otp"
                                            id="end_time_otp" value="{{ old('end_time_otp') }}"
                                            placeholder="Enter Reviewer Name..">
                                        @if ($errors->has('end_time_otp'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('end_time_otp') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Service<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="service[]" class="form-control f-14" id="service">
                                            <option value=""> Select Service</option>
                                            @foreach ($pms_master_service as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('service'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('service') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Addon
                                        Inventory<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="addon[]" class="form-control f-14 addon_inventory" id="addon_inventory" disabled>
                                            <option value=""> -- Addon Inventory -- </option>
                                            @foreach ($addon_inventory as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}">
                                                    {{ $value->description }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('service'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('service') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-8">
                                        <table
                                            class="addon_price table-bordered showdata table table-striped table-hover dt-responsive"
                                            style="display: none">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Item</th>
                                                    <th>Price</th>
                                                    <th>Offer Price</th>
                                                    <th>Discount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Rows will be appended here -->
                                            </tbody>
                                        </table>
                                        <div id="subtotal" style="display: none" class="showdata">Subtotal: 0.00</div>


                                    </div>
                                </div>
                                <div class="row mt-0">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-10 sub_total">

                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Price<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="price" id="price"
                                            value="{{ old('price') }}" placeholder="price">
                                        @if ($errors->has('price'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('price') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Payable amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="payable_amount"
                                            id="payable_amount" value="{{ old('payable_amount') }}"
                                            placeholder="Enter Reviewer Name..">
                                        @if ($errors->has('start_time_otp'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('start_time_otp') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>



                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="status" id="status">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info text-white f-14 me-2"
                                    id="submitBtn">Submit</button>
                                <a class="btn btn-danger f-14" href="{{ url('admin/pms_inventory') }}">Cancel</a>
                            </div>

                            <div id="dynamicForm"></div>
                            <div id="dynamicForm_service"></div>
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
        var service_id = '';
        $(document).on('change', '#service', function() {
            service_id = $(this).val();
            if (service_id != "") {
                $('.addon_inventory').prop('disabled', false);
            } else {
                $('.addon_inventory').prop('disabled', true);
               
            }   
        });

        $(document).on('change', '#addon_inventory', function() {
            var addon_id = $(this).val();

            $.ajax({
                type: 'GET',
                url: '{{ url('admin/pms-inventory-getPrice') }}',
                data: {
                    addon_id: addon_id,
                    service_id: service_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                //    console.log(data);
                    if (data.success == true) {
                        var shortDesc = data.pms_inventory_data.description.substring(0, 20) + '...';
                        var price = data.pms_inventory_data.price;
                        var sellprice = data.pms_inventory_data.sellprice ? data.pms_inventory_data
                            .sellprice : price;
                        var discount = ((price - sellprice) / price * 100).toFixed(2);
                        var service = data.pms_service_data.name
                        var html = '<tr><td class="service">' +
                            service + '</td><td class="short-desc">' + shortDesc +
                            '</td><td class="price">' + price + '</td><td class="sellprice">' +
                            sellprice + '</td><td class="discount">' + discount +
                            '%</td><td><span class="cross-icon float-end" style="font-size:20px">&times;</span></td></tr>';

                        var existing = $('.addon_price tr').filter(function() {
                            var existingPrice = $(this).find('.price').text();
                            var existingSellPrice = $(this).find('.sellprice').text();
                            var existingService = $(this).find('.service').text();
                            var existingValues = $(this).find('.values'+service_id).text();
                            return existingPrice === price.toString() && existingSellPrice ===
                                sellprice.toString() && existingService === service;
                        });
                        if (existing.length === 0) {
                            if (addon_id != "" && service_id != "") {
                            var inputField = '<input type="hidden" name="addon_invertory[]" class="values" value="' + addon_id +
                                '">';
                            $('#dynamicForm').append(inputField);
                            
                            var inputField1 = '<input type="hidden" name="service[]" class="values" value="' + service_id +
                                '">';
                            $('#dynamicForm_service').append(inputField1);
                            
                        }
                            $(".showdata").show();
                            $('.addon_price tbody').append(html);
                            updateTotal();
                        } else {
                            console.log('Item with price ' + price + ' and sellprice ' + sellprice +
                                ' already exists.');
                        }
                    }
                }
            });
        });

 function updateTotal() {
    var total = 0;
    $('.addon_price .sellprice').each(function() {
        var sellpriceText = $(this).text().trim(); // Get text and remove any leading/trailing whitespace
        var sellpriceValue = parseFloat(sellpriceText); // Parse float from the text content

        if (!isNaN(sellpriceValue)) { // Check if the parsed value is not NaN
            total += sellpriceValue; // Add to total
        }
    });
    $('#subtotal').text('Subtotal: ' + total.toFixed(2)); // Update subtotal display
}

        $(function(){
            $("#property_id").change(function(){
                var Pms_id = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '{{ url('admin/pms-job-view') }}',
                    data: {
                         pms_id: Pms_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if(data.status == true){
                            $("#form_error").hide();
                            let issue = data.data.id;
                            let subscription_type = data.onboarddata.subscription_type;
                            $("#helpdesk_id").val(issue);
                            $("#subscription_type").val(subscription_type);
                        }else{
                            $("#form_error").show();
                            $(".showmessage").html("Data not Found");
                        }
                       
                    }
            });
          });
        });

        $(document).on('click', '.cross-icon', function() {
            $(this).closest('tr').remove();
            updateTotal();
        });
    </script>

@endsection
