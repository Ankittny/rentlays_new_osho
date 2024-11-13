@extends('admin.template')

@section('main')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Service Request
                <small>Edit Service Request</small>
            </h1>
            @include('admin.common.breadcrumb')
        </section>


        @php
            $roleName = \App\Models\Roles::find($role->role_id)->name;
        @endphp
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- right column -->
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" action="{{ url('admin/edit-service-request/' . $result->id) }}"
                            id="edit_service_request" method="post" name="edit_service_request" accept-charset='UTF-8'
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Property</label>
                                    <div class="col-sm-8">
                                        <select name="property_id" class="form-control f-14" id="property_id"
                                            OnChange="OnChangeFunction(this.value)" @if($result->status=="Completed") disabled @endif>
                                            <option value=""> Select Property</option>
                                            @foreach ($property as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}"
                                                    {{ $value->id == $result->property_id ? 'selected' : '' }}>
                                                    {{ $value->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Issue<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="issue" id="issue"
                                            value="{{ $result->issue }}" placeholder="Enter Reviewer Name.." @if($result->status=="Completed") disabled @endif>
                                        @if ($errors->has('issue'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('issue') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Description<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea name="description" id="description" class="form-control f-14 error"  @if($result->status=="Completed") disabled @endif placeholder="Description..">{{ $result->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Image<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control f-14 error" name="image" id="image"
                                            placeholder="">
                                        <img src="{{ url('/public/front/images/service_request/' . $result->image) }}"
                                            height="80px;" width="80px;">


                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                                <strong class="text-danger">{{ $errors->first('image') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Priority</label>
                                    <div class="col-sm-8">
                                        <select name="priority" class="form-control f-14"  @if($result->status=="Completed") disabled @endif>
                                            <option value=""> Select Priority</option>

                                            <option data-icon-class="icon-star-alt" value="Low"
                                                {{ $result->priority == 'Low' ? 'selected' : '' }}>
                                                Low
                                            </option>
                                            <option data-icon-class="icon-star-alt" value="Medium"
                                                {{ $result->priority == 'Medium' ? 'selected' : '' }}>
                                                Medium
                                            </option>
                                            <option data-icon-class="icon-star-alt" value="High"
                                                {{ $result->priority == 'High' ? 'selected' : '' }}>
                                                High
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Assign to
                                        supervisor</label>
                                    <div class="col-sm-8">
                                        @if ($roleName == 'Supervisor')
                                            <input type="hidden" value="{{ $result->assign_to_supervisor }}"
                                                name="assign_to_supervisor"  @if($result->status=="Completed") disabled @endif>
                                        @endif
                                        <select name="assign_to_supervisor" class="form-control f-14"
                                            @if ($roleName == 'Supervisor') disabled @endif>
                                            <option value=""> Select supervisor </option>
                                            @foreach ($assign_to_supervisor as $key => $value)
                                                <option data-icon-class="icon-star-alt" value="{{ $value->id }}"
                                                    {{ $value->id == $result->assign_to_supervisor ? 'selected' : '' }}>
                                                    {{ $value->username }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @php
                                    $user = Auth::guard('admin')->user();
                                @endphp
                                
                                @if ($user->username != 'admin')
                                    <div class="form-group row mt-3">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Select
                                            Department</label>
                                        <div class="col-sm-8">
                                            <select name="department" class="form-control f-14"
                                                OnChange="OnChangeDepartment(this.value)" @if($result->status=="Completed") disabled @endif>
                                                <option value="">Select Department</option>
                                                @foreach ($pms_department_master as $key => $value)
                                                    <option data-icon-class="icon-star-alt  " class="text-capitalize" value="{{ $value->id }}">
                                                        {{ $value->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Assign to site
                                            Manager</label>
                                        <div class="col-sm-8">
                                            <select name="assign_to_sitemanager" class="form-control f-14"
                                                id="assign_to_sitemanager" OnChange="OnChangeSiteManager(this.value)"  @if($result->status=="Completed") disabled @endif>
                                                <option value="">Select Site Manager</option>
                                                @foreach ($assign_to_sitemanager as $key => $value)
                                                    <option data-icon-class="icon-star-alt" value="{{ $value->id }}"
                                                        {{ $value->id == $result->assign_to_sitemanager ? 'selected' : '' }}>
                                                        {{ $value->username }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-3" style="display: none;" id="sitemanager">
                                        <label for="exampleInputPassword1"
                                            class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Assign to site
                                            Manager</label>
                                        <div class="col-sm-8">
                                            <div id="assign_to_service"></div>
                                        </div>
                                    </div>
                                @endif

                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Status</label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="status" id="status" @if($result->status=="Completed")  disabled @endif>
                                            <option value="Active" {{ $result->status == 'Active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="Inactive"
                                                {{ $result->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            @if($result->status!="Completed") 
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-info f-14 text-white me-2"
                                        id="submitBtn">Submit</button>
                                    <a class="btn btn-danger f-14" href="{{ url('admin/service_request') }}">Cancel</a>
                                </div>
                          @endif
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
        var id = "{{ $result->property_id }}";
        var assign_to_sitemanager = "{{ $result->assign_to_sitemanager }}";

        function OnChangeFunction(id) {
            $.ajax({
                url: "{{ url('admin/getsitemanager') }}" + "/" + id,
                type: "GET",
                success: function(data) {
                    // $('#assign_to_sitemanager').html(data);
                }
            });
        }
        OnChangeFunction(id);

        function OnChangeSiteManager(id) {
            $.ajax({
                url: "{{ url('admin/getsitemanagerservice') }}" + "/" + id,
                type: "GET",
                success: function(data) {
                    if (data.status == false) {
                        $("#sitemanager").hide();
                        $('#assign_to_service').html(data);
                    } else {
                        $("#sitemanager").show();
                        $('#assign_to_service').html(data);
                    }
                }
            });
        }
        OnChangeSiteManager(assign_to_sitemanager);
        function OnChangeDepartment(id) {
            $.ajax({
                url: "{{ url('admin/site_manager_department') }}" + "/" + id,
                type: "GET",
                success: function(data) {
                   $('#assign_to_sitemanager').html(data);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
@endsection
