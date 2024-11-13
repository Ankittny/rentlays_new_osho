@extends('template')
@push('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/daterangepicker.min.css') }}" />
<link rel="stylesheet" href="{{ asset('public/css/dataTables.bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/css/responsive.dataTables.min.css') }}">
@endpush
@section('main')
<div class="margin-top-85">
    <div class="row m-0">
        @include('users.sidebar')
        <div class="col-lg-10 p-0 dashboardbkground">
            <div class="container-fluid min-height">
                <div class="main-panel">
                    <div class="row justify-content-center mt-5 mb-4 ">
                        <div class="col-md-12">
                            <nav class="navbar navbar-expand-lg navbar-light list-bacground border rounded-3 p-4" style="justify-content: space-between">
                                <ul class="navbar-nav">
                                    <li class="nav-item pl-4 pr-4">
                                        {{ __('Edit Service Request') }}
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <div class="row mt-4 p-4 bkwhite">
                        <div class="col-md-12">
                            <div class="panel-footer">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="box mb-5">
                                            <form method="POST" action="{{ url('users/update-service-request/' . $data['serviceRequest']->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('post')
                                                <div class="form-group">
                                                    <label for="issue">Issue</label>
                                                    <input type="text" class="form-control" id="issue" name="issue" value="{{ $data['serviceRequest']->issue }}" maxlength="2000" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ $data['serviceRequest']->description }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Image</label>
                                                    <input type="file" class="form-control" id="image" name="image">
                                                </div>
                                                <div class="form-group">
                                                    <label for="priority">Priority</label>
                                                    <select class="form-control" id="priority" name="priority" required>
                                                        <option value="low" {{ $data['serviceRequest']->priority == 'low' ? 'selected' : '' }}>Low</option>
                                                        <option value="medium" {{ $data['serviceRequest']->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                                        <option value="high" {{ $data['serviceRequest']->priority == 'high' ? 'selected' : '' }}>High</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary px-5 py-3 float-right">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

