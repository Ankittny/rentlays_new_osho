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
										{{ __('Add Service Request') }}
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
                                            <form method="POST" action="{{ url('users/store-service-request') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="issue">Issue</label>
                                                    <input type="text" class="form-control" id="issue" name="issue" maxlength="2000" required>
													@if ($errors->has('issue'))
														<span class="error-tag">
															<p>{{ $errors->first('issue') }}</p>
														</span>
													@endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
													@if ($errors->has('description'))
														<span class="error-tag">
															<p>{{ $errors->first('description') }}</p>
														</span>
													@endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">Image</label>
                                                    <input type="file" class="form-control" id="image" name="image">
													@if ($errors->has('image'))
														<span class="error-tag">
															<p>{{ $errors->first('image') }}</p>
														</span>
													@endif
                                                </div>
                                                <div class="form-group">
                                                    <label for="priority">Priority</label>
                                                    <select class="form-control" id="priority" name="priority" required>
                                                        <option value="low">Low</option>
                                                        <option value="medium">Medium</option>
                                                        <option value="high">High</option>
                                                    </select>
													@if ($errors->has('priority'))
														<span class="error-tag">
															<p>{{ $errors->first('priority') }}</p>
														</span>
													@endif
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


@section('validation_script')
<script type="text/javascript" src="{{ asset('public/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/daterangecustom.min.js') }}"></script>
@endsection


