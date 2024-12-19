@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Add Task
                <small>Add Task</small>
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
                        <form class="form-horizontal" action="{{ url('admin/store-task-list') }}"
                            id="add_task_list" method="post" name="add_task_list" accept-charset='UTF-8'
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Property Name<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14 text-capitalize" name="property_id"
                                            id="property_name">
                                            <option value="">--Select Property--</option>
                                            @foreach ($property as $data)
                                                <option value="{{ $data->id }}" class="text-capitalize">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('property_name'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('property_name') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Date<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control f-14" name="date" id="date"
                                            value="{{ old('date') }}" placeholder="Enter Date..">
                                        @if ($errors->has('date'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('date') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Image<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="file" class="form-control f-14" name="image" id="image" accept=".jpg,.jpeg,.png" />
                                        @if ($errors->has('image'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('image') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Task<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control f-14" name="task" id="task"
                                            value="{{ old('task') }}" placeholder="Enter Task..">
                                        @if ($errors->has('task'))
                                            <span class="error-tag">
                                                <p>{{ $errors->first('task') }}</p>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <label for="exampleInputPassword1"
                                        class="control-label col-sm-3 fw-bold text-md-end mb-2">Status<span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control f-14" name="task_status" id="status">
                                            <option value="Complete">Complete</option>
                                            <option value="Incomplete">Incomplete</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-info text-white f-14 me-2"
                                    id="submitBtn">Submit</button>
                                <a class="btn btn-danger f-14" href="{{ url('admin/task-list') }}">Cancel</a>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                    </div>
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

