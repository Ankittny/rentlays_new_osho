@extends('admin.template') 
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
	<h1>
	Pms Inventory
	<small>Control panel</small>
	</h1>
@include('admin.common.breadcrumb')
</section>
<!-- Main content -->
<section class="content">
	<!--Filtering Box Start -->
	
	<!--Filtering Box End -->
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Pms Inventory</h3>
					@if (Helpers::has_permission(Auth::guard('admin')->user()->id, 'add_pms_inventory'))
						<div class="pull-right"><a class="btn btn-success f-14" href="{{ url('admin/add-pms-inventory') }}">Add Pms Inventory</a></div>
					@endif
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive parent-table filters-parent f-14">
						{!! $dataTable->table(['class' => 'table table-striped table-hover dt-responsive', 'width' => '100%', 'cellspacing' => '0']) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
@endsection
@push('scripts')
<script src="{{ asset('public/backend/plugins/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/backend/plugins/Responsive-2.2.2/js/dataTables.responsive.min.js') }}"></script>
{!! $dataTable->scripts() !!} 
@endpush 
