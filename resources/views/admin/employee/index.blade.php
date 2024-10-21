@extends('admin.template')

@section('main')
<div class="content-wrapper">
<section class="content-header">
        <h1>Employee</h1> 
    </section>
    <section class="content">
        <div class="row">
                {{-- <div class="col-lg-3 col-12 settings_bar_gap">
                    @include('admin.common.settings_bar')
                </div> --}}
                <div class="col-lg-12 col-12">

                        <div class="box box_info">
                            <div class="box-header">
                                <h3 class="box-title">Employee Management</h3>
                                <div class="pull-right"><a class="btn btn-success f-14" href="{{ url('admin/add-employee') }}">Add Employee</a></div>
                            </div>
                            @if (Session::has('success'))
                            <div class="success_email_settings">
                                <div class="alert alert-success fade in alert-dismissable">
                                    <strong>Success!</strong> {{ Session::get('success') }}
                                    <a class="close" href="#" data-dismiss="alert" aria-label="close"
                                        title="close">×</a>
                                </div>
                            </div>
                            @endif
                            <div class="box-body">
                                <div class="parent-table filters-parent f-14">
                                    {!! $dataTable->table(['class' => 'table table-striped dt-responsive', 'width' => '100%', 'cellspacing' => '0']) !!}
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
