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
								@php
									$property_id = \App\Models\Bookings::where('user_id', Auth::id())
												->where('status', 'Accepted')
												->select('property_id')
												->first();
									$property = $property_id ? \App\Models\Properties::where('id', $property_id->property_id)
												->whereIn('for_property', ['pms', 'pmsandrentlays'])
												->first() : null;

									$hasRequest = $property && \App\Models\PmsHelpdesk::where('property_id', $property->id)
												->where('user_id', Auth::id())
												->exists();
								@endphp
								@if($property && !$hasRequest)
									<a href="{{ url('users/add-service-request') }}" class="btn btn-primary float-right">Add Request</a>
								@endif
							</nav>
						</div>
					</div>

					<div class="row mt-4 p-4 bkwhite">
						<div class="col-md-12">
							<div class="panel-footer">
								<div class="panel">
									<div class="panel-body">
										<div class="box mb-5">
											<div class="card-body p-0">
												<div class="table-responsive">
													{!! $dataTable->table(['class' => 'table table-striped table-hover dt-responsive pt-4 text-center', 'width' => '100%', 'cellspacing' => '0']) !!}
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
	</div>
</div>
@endsection


@section('validation_script')
<script type="text/javascript" src="{{ asset('public/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/dataTables.responsive.min.js') }}"></script>
{!! $dataTable->scripts() !!}
<script type="text/javascript" src="{{ asset('public/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/daterangepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/daterangecustom.min.js') }}"></script>
@endsection


