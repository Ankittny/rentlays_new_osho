@extends('admin.template')

@section('main')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      {{-- <h1>
        Pms New Request Detail
        <small>Control panel</small>
      </h1> --}}
     {{-- // @include('admin.common.breadcrumb') --}}
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Pms  Request Detail</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row w-75 mx-auto">
                <div class="col-sm-12">
                    <table class="table table-bordered">
                      @php
                        $get_role=App\Http\Helpers\Common::get_roles(Auth::guard('admin')->user()->id);
                      @endphp
                      @if($get_role != 'sitemanager' || $get_role != 'helpdesk')
                      <tr>
                        <th>Area Site Engineer</th>
                        <td>
                          @php
                            $get_site_engineer=App\Http\Helpers\Common::getSiteEngineer($pms_history->getSupervisor->pincode);
                          @endphp
                          <select onchange="myFunction(this)" id="site_engineer" @if($get_role == 'helpdesk') disabled  @endif class="form-control" name="site_engineer">
                            <option value=""> -- Select Area Site Engineer --</option>
                              @foreach($get_site_engineer as $value)
                                <option value="{{ $value->id }}" {{ $pms_history->assign_to_sitemanager == $value->id ? 'selected' : ''}}>{{ ucfirst($value->username) }}</option>
                              @endforeach
                          </select>
                        </td>
                      </tr>
                      @endif
                      <tr>
                        <th>Property Owner Email</th>
                        <td>{{ $user_property->email ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Property Owner Name</th>
                        <td>{{ ucfirst($user_property->first_name) ?? '' }} {{ ucfirst($user_property->last_name) ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Property Owner Phone</th>
                        <td>{{ $user_property->phone ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Property Owner Country</th>
                        <td>{{ $user_property->country ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Property Name</th>
                        <td>{{ $pms_history->property_name->name ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Supervisor Name</th>
                        <td>{{ $pms_history->getSupervisor->username ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Helpdesk User Name</th>
                        <td>{{ $pms_history->getHelpdesk->username ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Description</th>
                        <td>{{ $pms_history->description ?? '' }}</td>
                      </tr>
                    
                      <tr>
                        <th>Date</th>
                        <td>{{ $pms_history->created_at ?? '' }}</td>
                      </tr>
                      {{-- <tr>
                        <th>Priority</th>
                        <td>{{ $pms_history->priority ?? '' }}</td>
                      </tr> --}}
                      <tr>
                        <th>Status</th>
                        <td>{{ $pms_history->status ?? '' }}</td>
                      </tr>
                      {{-- <tr>
                        <td>Status</td>
                        <td>
                          <select class="form-control f-14" id="status" @if($get_role != 'sitemanager') disabled  @endif name="status" aria-invalid="false">
                            <option value="active">Active</option>
                            <option value="onhold">OnHold</option>
                        </td>
                      </tr> --}}
                      <tr>
                        <th>Bedrooms</th>
                        <td>{{ $pms_history->property_name->bedrooms ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Beds</th>
                        <td>{{ $pms_history->property_name->beds ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Bathrooms</th>
                        <td>{{ $pms_history->property_name->bathrooms ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Property Square Feet</th>
                        <td>{{ $pms_history->property_name->property_square ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Number Of Floor</th>
                        <td>{{ $pms_history->property_name->number_of_floor ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Number Of Rooms</th>
                        <td>{{ $pms_history->property_name->number_of_rooms ?? '' }}</td>
                      </tr>
                      <tr>
                        <th>Amenities</th>
                        <td>
                            @php
                                $amenities_type = App\Models\AmenityType::all();
                                $amenities_data = explode(',', $pms_history->amenities);
                                $amenities = App\Models\Amenities::whereIn('id', $amenities_data)->get();
                            @endphp
                            <ul class="list-group">
                                @foreach ($amenities_type as $row_type)
                                    @if (count($amenities->where('type_id', $row_type->id)->whereIn('id', $amenities_data)) > 0)
                                        <li class="list-group-item">
                                            <p class="mb-2 text-bold text-decoration-underline">{{ $row_type->name }}</p>
                                            <ul class="list-group mb-0">
                                                @foreach ($amenities->where('type_id', $row_type->id) as $data)
                                                    @if (in_array($data->id, $amenities_data))
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <span>{{ $data->title }}</span>
                                                            <div class="d-flex align-items-center">
                                                                <!-- Amenity Status Radios -->
                                                                <div class="form-check form-check-inline me-2">
                                                                    <input class="form-check-input amenities_status_yes" 
                                                                           type="radio"  disabled
                                                                           name="amenities_status[{{ $data->id }}]" 
                                                                           value="yes"
                                                                           @if(isset($pms_history->amenities_status[$data->id]) && $pms_history->amenities_status[$data->id] == 'yes') checked @endif
                                                                           @if($get_role != 'sitemanager') disabled @endif 
                                                                           onchange="showRemark(this, {{ $data->id }})">
                                                                    <label class="form-check-label" for="is_working_{{ $data->id }}_yes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline me-2">
                                                                    <input class="form-check-input amenities_status_no"  disabled
                                                                           type="radio" 
                                                                           name="amenities_status[{{ $data->id }}]" 
                                                                           value="no"
                                                                           @if(isset($pms_history->amenities_status[$data->id]) && $pms_history->amenities_status[$data->id] == 'no') checked @endif
                                                                           @if($get_role != 'sitemanager') disabled @endif 
                                                                           onchange="showRemark(this, {{ $data->id }})">
                                                                    <label class="form-check-label" for="is_working_{{ $data->id }}_no">No</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <!-- Remarks Field -->
                                                        <div id="remarks_{{ $data->id }}" style="display:{{ isset($pms_history->remarks[$data->id]) && $pms_history->amenities_status[$data->id] == 'no' ? 'block' : 'none' }}" class="ms-4">
                                                            <label for="remarks[{{ $data->id }}]">Remarks</label>
                                                            <input type="text" name="remarks[{{ $data->id }}]" disabled
                                                                   class="form-control mb-2"
                                                                   value="{{ $pms_history->remarks[$data->id] ?? '' }}"
                                                                   @if($get_role != 'sitemanager') disabled @endif>
                                                        </div>
                                                        
                                                        <div id="working_options_{{ $data->id }}"  class="working_options" style="display:{{ isset($pms_history->amenities_status[$data->id]) && $pms_history->amenities_status[$data->id] == 'yes' ? 'block' : 'none'}}">
                                                            {{-- working --}}
                                                          <b>Working Options</b> 
                                                          <br>
                                                            <div class="form-check form-check-inline">
                                                              <input class="form-check-input" 
                                                                    type="radio" 
                                                                    name="working[{{ $data->id }}]"  
                                                                    value="working"  disabled
                                                                    @if($get_role != 'sitemanager') disabled @endif 
                                                                    id="is_repairing_{{ $data->id }}_working" 
                                                                    @if(isset($pms_history->working[$data->id]) && $pms_history->working[$data->id] == 'working') checked @endif
                                                                    onchange="showRepairing(this, {{ $data->id }})">
                                                              <label class="form-check-label" for="is_repairing_{{ $data->id }}_working">
                                                                  Working
                                                              </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" 
                                                                      type="radio" 
                                                                      name="working[{{ $data->id }}]" 
                                                                      value="not_working"  disabled
                                                                      @if($get_role != 'sitemanager') disabled @endif 
                                                                      @if(isset($pms_history->working[$data->id]) && $pms_history->working[$data->id] == 'not_working') checked @endif
                                                                      id="is_repairing_{{ $data->id }}_not_working" 
                                                                      onchange="showRepairing(this, {{ $data->id }})">
                                                                <label class="form-check-label" for="is_repairing_{{ $data->id }}_not_working">
                                                                    Not Working
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <!-- Repairing Options -->
                                                        <div id="repairing_options_{{ $data->id }}"  class="repairing_options" style="display:{{ isset($pms_history->working[$data->id]) && $pms_history->working[$data->id] == 'not_working' ? 'block' : 'none'}}">
                                                          <b>Repairing Options</b> 
                                                          <br>  
                                                          <div class="form-check form-check-inline">
                                                                <input class="form-check-input" disabled
                                                                       type="radio" 
                                                                       name="repairing[{{ $data->id }}]" 
                                                                       value="in_repairing"
                                                                       @if(isset($pms_history->repairing[$data->id]) && $pms_history->repairing[$data->id] == 'in_repairing') checked @endif
                                                                       @if($get_role != 'sitemanager') disabled @endif 
                                                                       onchange="showEstimatedCost(this, {{ $data->id }})">
                                                                <label class="form-check-label" for="is_repairing_{{ $data->id }}_in_repairing">In Repairing</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" disabled
                                                                       type="radio" 
                                                                       name="repairing[{{ $data->id }}]" 
                                                                       value="out_repairing"
                                                                       @if(isset($pms_history->repairing[$data->id]) && $pms_history->repairing[$data->id] == 'out_repairing') checked @endif
                                                                       @if($get_role != 'sitemanager') disabled @endif 
                                                                       onchange="showEstimatedCost(this, {{ $data->id }})">
                                                                <label class="form-check-label" for="is_repairing_{{ $data->id }}_out_repairing">Out Repairing</label>
                                                            </div>
                                                            <div id="estimated_cost_{{ $data->id }}" style="display:{{ isset($pms_history->repairing[$data->id]) && $pms_history->repairing[$data->id] == 'in_repairing' ? 'block' : 'none' }}" class="mt-2">
                                                                <label for="estimated_cost[{{ $data->id }}]">Estimated Cost</label>
                                                                <input type="text" name="estimated_cost[{{ $data->id }}]" disabled
                                                                       class="form-control"
                                                                       value="{{ $pms_history->estimated_cost[$data->id] ?? '' }}"
                                                                       @if($get_role != 'sitemanager') disabled @endif>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                    
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

