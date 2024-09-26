@extends('admin.template')

@section('main')


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pms Job
                <small>Edit Pms Job</small>
            </h1>
            <!-- @include('admin.common.breadcrumb') -->
        </section>
        <!-- Main content -->
        <section class="content">
           
                       
                    @php
                        $roleName = \App\Models\Roles::find($role->role_id)->name;
                    @endphp

                        <form class="form-horizontal" action="{{ url('admin/edit-pms-job/' . $result->id) }}"
                            id="edit_pms_job" method="post" name="edit_pms_job" accept-charset='UTF-8'
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="">
                                @php
                                    $user = \Auth::guard('admin')->user();

                                    $owner = App\Models\User::find(App\Models\Properties::find($result->property_id)->host_id);
                                @endphp
                                @if ($user->username != 'admin')

                                <div class="row g-3">

                                    <div class="col-md-4 col-lg-4">
                                        <div class="card">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Jobs Details</h3>
                                            </div>
                                            <div class="card-body">
                                                <ul class="list-group box_bg5">
                                                    <li class="list-group-item">Property :- <span>{{App\Models\Properties::find($result->property_id)->name ?? ""}}</span></li>
                                                    <li class="list-group-item">Owner :- <span>{{ucfirst($owner->first_name." ".$owner->last_name)}}</li>
                                                    <li class="list-group-item">Contect:- <span>{{$owner->phone}}</span></li>
                                                    <li class="list-group-item">Location:- {{App\Models\PropertyAddress::where('property_id',$result->property_id)->first()->city}}</li>
                                                    <li class="list-group-item">Issu List:- {{App\Models\PmsHelpdesk::find($result->helpdesk_id)->issue}}</li>
                                                    <li class="list-group-item">Priority:- {{App\Models\PmsHelpdesk::find($result->helpdesk_id)->priority}}</li>
                                                    <li class="list-group-item">User :- <span>{{App\Models\Admin::find($result->user_id)->username}}</span></li>
                                                    <li class="list-group-item">Subscription Type :- <span>{{ App\Models\PmsRecurringPackage::where('id', App\Models\PmsSubscriptionIds::where('property_id', $result->property_id)->value('package_id'))->value('package_name') ?? "No Subscription" }}</span></li>
                                                 </ul> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $user = App\Models\User::find(App\Models\Properties::find($result->property_id)->host_id ?? "");
                                                $pmsOnboard = App\Models\PmsOnboard::where('property_id',$result->property_id)->first();
                                            @endphp

                                            {{-- <div class="form-group row mt-3">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Property
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="property_id" class="form-control f-14" disabled>
                                                <option value=""> Select property</option>
                                                @foreach ($property as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == $result->property_id ? 'selected' : '' }}>
                                                        {{ $value->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-group row mt-3">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">User</label>
                                        <div class="col-sm-8">
                                            <select name="user_id" class="form-control f-14" disabled>
                                                <option value=""> Select User</option>
                                                @foreach ($assign_to_sitemanager as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == $result->user_id ? 'selected' : '' }}>
                                                        {{ $value->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                    {{-- <div class="form-group row mt-3">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Helpdesk</label>
                                        <div class="col-sm-8">
                                            <select name="helpdesk_id" class="form-control f-14" disabled>
                                                <option value=""> Select helpdesk</option>
                                                @foreach ($pms_helpdesk as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == $result->helpdesk_id ? 'selected' : '' }}>
                                                        {{ $value->issue }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
                                @else
                                    <div class="form-group row mt-3">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Property
                                        </label>
                                        <div class="col-sm-8">
                                            <select name="property_id" class="form-control f-14"  @if($roleName == 'admin') disabled @endif>
                                                <option value=""> Select property</option>
                                                @foreach ($property as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == $result->property_id ? 'selected' : '' }}>
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
                                            <select name="user_id" class="form-control f-14" @if($roleName == 'admin') disabled @endif>
                                                <option value=""> Select User</option>
                                                @foreach ($assign_to_sitemanager as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == $result->user_id ? 'selected' : '' }}>
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
                                            <select name="helpdesk_id" class="form-control f-14" @if($roleName == 'admin') disabled @endif>
                                                <option value=""> Select helpdesk</option>
                                                @foreach ($pms_helpdesk as $key => $value)
                                                    <option value="{{ $value->id }}"
                                                        {{ $value->id == $result->helpdesk_id ? 'selected' : '' }}>
                                                        {{ $value->issue }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                            @if($roleName != 'Supervisor' && $roleName != 'Site Manager')
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Type</label>
                                    <div class="col-sm-8">
                                        <select name="type" class="form-control f-14" @if($roleName == 'admin') disabled @endif>
                                            <option value=""> Select Type</option>

                                            <option data-icon-class="icon-star-alt" value="Recurring"
                                                {{ $result->type == 'Recurring' ? 'selected' : '' }}>
                                                Recurring
                                            </option>
                                            <option data-icon-class="icon-star-alt" value="Onetime"
                                                {{ $result->type == 'Onetime' ? 'selected' : '' }}>
                                                Onetime
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            @endif

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Upload Before Image<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control f-14 error" name="upload_before_image"
                                            id="upload_before_image" placeholder="" @if($roleName == 'admin') disabled @endif>
                                        <img src="{{ url('/public/front/images/upload_before_image/' . $result->upload_before_image) }}"
                                          class="upload_before_img">

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
                                            id="upload_after_image" placeholder="" @if($roleName == 'admin') disabled @endif>
                                        <img src="{{ url('/public/front/images/upload_after_image/' . $result->upload_after_image) }}"
                                        class="upload_before_img" @if($roleName == 'admin') disabled @endif>

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
                                        <input type="time" class="form-control f-14" name="start_time"
                                            id="start_time" value="{{ $result->start_time }}"
                                            placeholder="Enter Reviewer Name.." @if($roleName == 'admin') disabled @endif>
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
                                            value="{{ $result->end_time }}" placeholder="Enter Reviewer Name.." @if($roleName == 'admin') disabled @endif>
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
                                            id="start_time_otp" value="{{ $result->start_time_otp }}"
                                            placeholder="Enter Start Time Otp.." @if($roleName == 'admin') disabled @endif>
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
                                            id="end_time_otp" value="{{ $result->end_time_otp }}"
                                            placeholder="Enter End time otp.." @if($roleName == 'admin') disabled @endif>
                                        @if ($errors->has('end_time_otp'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('end_time_otp') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @php
                                    $service_selected = explode(',', $result->service);
                                @endphp
                                   @if($result->status!="Completed")   
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Service<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select name="service[]" class="form-control f-14" id="service"
                                            onchange="saveServiceSelection()" @if($roleName == 'admin') disabled @endif>
                                            <option value=""> Select Service</option>
                                            @foreach ($pms_master_service as $key => $value)
                                               @dump($value->name)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}"
                                                    @if (in_array($value->id, $service_selected)) selected @endif>
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
                                @endif
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Addon
                                        Inventory<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        @php
                                            $addon_inventorys = explode(',', $result->addon_inventory);
                                        @endphp
                                        <select name="addon[]" class="form-control f-14 addon_inventory" disabled
                                            id="addon_inventory" onchange="saveInvertory()" @if($roleName == 'admin') disabled @endif>
                                            <option value=""> -- Addon Inventory -- </option>
                                            @foreach ($addon_inventory as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}"
                                                    @if (in_array($value->id, $addon_inventorys)) selected @endif>
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
                                            class="addon_price showmytable table-bordered showdata table table-striped table-hover dt-responsive"
                                            style="display: none">
                                            <thead>
                                                <tr>
                                                    {{-- <th>Service</th> --}}
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
                                        <div id="subtotal" style="font-weight: 600;" class="showdata text-end text-success"><strong>Subtotal: 0.00</strong></div>
                                    </div>
                                </div>
                                <div class="row mt-0">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-10 ">

                                    </div>
                                </div>
                                {{-- <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Price<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="price" id="price"
                                            value="{{ $result->price }}" placeholder="Enter Reviewer Name..">
                                        @if ($errors->has('price'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('price') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div> --}}
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Payable amount<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="payable_amount"
                                            id="payableamount" value="{{ $result->payable_amount }}"
                                            placeholder="Payable amount" @if($roleName == 'admin') disabled @endif readonly>
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
                                        <select class="form-control f-14" name="status" id="status" @if($roleName == 'admin') disabled @endif>
                                            <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                             <!-- /.box-body -->
                             @if($result->status!="Completed")  
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info f-14 text-white me-2"
                                        id="submitBtn">Submit</button>
                                    <a class="btn btn-danger f-14" href="{{ url('admin/pms_job') }}">Cancel</a>
                                </div>
                            @endif
                            <!-- /.box-footer -->
                                        </div>
                                    </div>
                                    </div>
        
                                   
                                </div>
                                   
                           
                            <div id="dynamicForm"></div>
                            <div id="subtotal"></div>
                        </form>
                   
        </section>
    </div>
@endsection
@section('validate_script')
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>
    <script>
        var service_id = '';
        var property_id = '{{ $result->property_id }}';
        $(document).on('change', '#service', function() {
            service_id = $(this).val();
            if (service_id != "") {
                $('.addon_inventory').prop('disabled', false);
            } else {
                $('.addon_inventory').prop('disabled', true);
            }
            var addon_id = "0";
            $.ajax({
                type: 'GET',
                url: '{{ url('admin/pms-inventory-getPrice') }}',
                data: {
                    addon_id: addon_id,
                    service_id: service_id,
                    pms_job_id: "{{ $result->id }}",
                    type: "service",
                    property_id:property_id,
                    package_id:'{{ App\Models\PmsSubscriptionIds::where('property_id', $result->property_id)->value('package_id') }}',
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    // Check for success
                    console.log(data);
                    if (data.success == true) {
                        var pms_job_id = "{{ $result->id }}";
                        var package_id ='{{ App\Models\PmsSubscriptionIds::where('property_id', $result->property_id)->value('package_id') }}';
                        ShowTableData(pms_job_id, service_id, addon_id,package_id);
                        var shortDesc = data.pms_inventory_data.description.substring(0, 20) + '...';
                        var price = data.pms_inventory_data.price;
                        var sellprice = data.pms_inventory_data.sellprice ? data.pms_inventory_data
                            .sellprice : price;
                        var discount = ((price - sellprice) / price * 100).toFixed(2);
                        var service = data.pms_service_data.name;


                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(xhr.responseText);
                }
            });
        });

        $(document).on('change', '#addon_inventory', function() {
            var addon_id = $(this).val();
            var package_id = '{{ App\Models\PmsSubscriptionIds::where('property_id', $result->property_id)->value('package_id') }}';
            $.ajax({
                type: 'GET',
                url: '{{ url('admin/pms-inventory-getPrice') }}',
                data: {
                    addon_id: addon_id,
                    service_id: service_id,
                    pms_job_id: "{{ $result->id }}",
                    type: "edit",
                    package_id: package_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success == true) {
                        var pms_job_id = "{{ $result->id }}";
                        ShowTableData(pms_job_id, service_id, addon_id, package_id);
                    }
                }
            });
        });

        $(document).on('click', '.cross-icon', function() {
            $(this).closest('tr').remove();
            updateTotal();
        });

        function ShowTableData(pms_job_id, service_id, addon_id,package_id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/admin/pms-inventory-job-item/') }}" + '/' + (pms_job_id ?? "0") + "/" + (
                    service_id ?? "0") + "/" + (addon_id ?? "0") + "/" + (package_id ?? "0"),
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        var data = response.data;
                        console.log(data);
                        var total = 0;
                        //console.log("ankit test======================>",data);
                        $('.addon_price tbody').empty();
                        $.each(data, function(index, item) {
                            var html = '<tr>';
                            // html += '<td class="service">' + item.service + '</td>';
                            html += '<td class="service">' + item.description + "</br>"+item.service+'</td>';
                            html += '<td class="sellprice">' + item.price + '</td>';
                            html += '<td class="sellprice">' + item.sellprice + '</td>';
                            html += '<td class="quantity">' + item.discount + '</td>';
                            html +=
                                '<td class="width-100px text-center"><a onclick="myDeleteFunction(' +
                                item.id +
                                ')" class="cross-icon"><i class="fa fa-times-circle"></i></a></td>';
                            html += '</tr>';
                            $('.addon_price tbody').append(html);

                            total += item.sellprice ? parseFloat(item.sellprice) : parseFloat(item
                                .price);
                        });

                        $('#subtotal').text('Subtotal: ' + total.toFixed(2));
                        $('#payableamount').val(total.toFixed(2));
                        $(".showmytable").show();
                    } else {
                        console.log("Error: No data found.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                }
            });
        }


        function myDeleteFunction(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/admin/pms-inventory-job-item-delete/') }}" + "/" + id,
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        $('.addon_price tbody').empty();
                        ShowTableData({{ $result->id }});
                    } else {

                    }
                }

            });
        }
        ShowTableData({{ $result->id }} ,);
    </script>
@endsection
