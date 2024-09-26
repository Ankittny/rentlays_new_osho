@extends('admin.template')
	@push('css')
	<link href="{{ asset('public/backend/css/setting.min.css') }}" rel="stylesheet" type="text/css" />
	@endpush
	@section('main')
	<div class="content-wrapper">
    <section class="content-header">
        <h1>Edit Property Type Option Set</h1>
    </section>
		<section class="content">
			<div class="row">
				<div class="col-lg-3 col-12 settings_bar_gap">
					@include('admin.common.settings_bar')
				</div>

				<div class="col-lg-9 col-12">
					<div class="box box-info">
                        @if (Session::has('error'))
                            <div class="error_email_settings">
                                <div class="alert alert-warning fade in alert-dismissable">
                                    <strong>Warning!</strong> Whoops there was an error. Please verify your below
                                    information. <a class="close" href="#" data-dismiss="alert" aria-label="close"
                                                    title="close">×</a>
                                </div>
                            </div>
                        @endif

						<div class="box-header with-border">
							<h3 class="box-title">Add Property Option Type set Form</h3><span class="email_status" >(<span class="text-green"><i class="fa fa-check" aria-hidden="true"></i>Verified</span>)</span>
						</div>

						<form id="add_property" method="post" action="{{ url('admin/settings/edit-property-type-set-option').'/'.$result->id }}" class="form-horizontal" enctype=multipart/form-data >
							{{ csrf_field() }}
							<div class="box-body">
                                <div class="form-group row mt-3 status">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Property Type</label>
                                    <div class="col-sm-6">
                                    <select class="form-control f-14 validate_field" id="property_type_id" name="property_type_id" aria-invalid="false">
                                        @if($PropertyType->count()>0)
                                            @foreach($PropertyType as $items)
                                             <option value="{{$items->id}}" {{ $result->property_type_id == $items->id ? 'selected' : '' }}   >{{$items->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                        <span class="text-danger">{{ $errors->first('status') }}</span>
                                    </div>
                                </div>
                                <div class="form-group row mt-3 status">
                                    <label for="inputEmail3" class="control-label col-sm-3 fw-bold text-md-end mb-2 mb-md-0">Property Type</label>
                                    <div class="col-sm-6">
                                       @if($PropertyOption->count()>0) 
                                         @foreach($PropertyOption as $ItemsData)
                                           <input name="options[]" {{ $result->property_option_type_id == $ItemsData->id ? 'checked' : '' }} type="radio" value="{{$ItemsData->id ?? ""}}">{{$ItemsData->name ?? ""}} &nbsp;
                                        @endforeach
                                       @endif
                                    </div>
                                </div>
							</div>

							<div class="box-footer">

								<button type="submit" class="btn btn-info btn-space f-14 text-white me-2">Submit</button>

								<a class="btn btn-danger f-14" href="{{ url('admin/settings/property-type') }}">Cancel</a>
								
							</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
	@endsection

@section('validate_script')
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>	
@endsection

