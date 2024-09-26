@extends('admin.template')

@section('main')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <section class="content-header">
        <h1>Property Type Option Set</h1> 
    </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-3 col-12 settings_bar_gap">
                    @include('admin.common.settings_bar')
                </div>
                <div class="col-lg-9 col-12">

                    <div class="box box_info">
                        <div class="box-header">
                            <h3 class="box-title">Property Option Set Management</h3>
                            <div class="pull-right"><a class="btn btn-success f-14" href="{{ url('admin/settings/add-property-type-set-option') }}">Add Property Set Option</a></div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="parent-table filters-parent f-14">
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th>Ptoperty Type</th>
                                        <th>Property Option Type</th>
                                        <th>Status</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                     
                                     @if($result->count()>0)
                                      @foreach($result as $items)
                                        @php
                                            $PropertyType = App\Models\PropertyType::where('id',$items->property_type_id)->first();
                                            $PropertyTypeoption = App\Models\PropertyTypeoption::where('id',$items->property_option_type_id)->first();
                                        @endphp
                                        <tr>
                                            <td>{{$PropertyType->name ?? ""}}</td>
                                            <td>{{$PropertyTypeoption->name ?? ""}}</td>
                                            <td>
                                                <a href="{{url('admin/settings/edit-property-type-set-option')}}/{{$items->id}}" class="btn btn-xs btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                                <a href="{{url('admin/settings/delete-property-type-set-option')}}/{{$items->id}}" class="btn btn-xs btn-sm btn-danger delete-warning"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                      @endforeach
                                     @endif
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    {{-- <script src="{{ asset('public/backend/plugins/DataTables-1.10.18/js/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('public/backend/plugins/Responsive-2.2.2/js/dataTables.responsive.min.js') }}"></script>
    {{-- {!! $dataTable->scripts() !!} --}}
@endpush
