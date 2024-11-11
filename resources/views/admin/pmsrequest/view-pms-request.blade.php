@extends('admin.template')

@section('main')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      {{-- <h1>
        PMS New Request Detail
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
              <h3 class="box-title">PMS New Request Detail</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
              {{-- history  --}}
              @php
                $pms_onboard_id =App\Models\PmsHistory::where('pms_onboard_id',$pms_request->id)->pluck('id')->first();
              @endphp
              @if($pms_onboard_id)
              <a href="{{url('admin/pms-request-history')}}/{{$pms_request->id}}">
                <button type="button"  class="btn btn-primary float-end"><i class="fa fa-user"></i> History</button>
              </a>
              @endif

              {{--end history  --}}
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row w-75 mx-auto">
                <div class="col-sm-12">
                  <form action="{{ url('admin/view-pms-request', $pms_request->id) }}" method="POST">
                    @csrf
                    @method('Post')
                    <table class="table table-bordered">
                      @php
                        $get_role=App\Http\Helpers\Common::get_roles(Auth::guard('admin')->user()->id);
                      @endphp
                      @if($get_role != 'sitemanager')
                      <tr>
                        <th>Area Site Engineer</th>
                        <td>
                          @php
                            $get_site_engineer=App\Http\Helpers\Common::getSiteEngineer($pms_request->getSupervisor->pincode ?? null);
                          @endphp
                          <select onchange="myFunction(this)" id="site_engineer" @if($get_role == 'helpdesk') disabled  @endif class="form-control" name="site_engineer">
                            <option value=""> -- Select Area Site Engineer --</option>
                              @foreach($get_site_engineer as $value)
                                <option value="{{ $value->id }}" {{ $pms_request->assign_to_sitemanager == $value->id ? 'selected' : ''}}>{{ ucfirst($value->username) }}</option>
                              @endforeach
                          </select>
                        </td>
                      </tr>
                      @endif
                      <tr>
                        <th>Property Owner Email</th>
                        <td><input type="email" name="owner_email" disabled class="form-control" value="{{ $user_property->email ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Property Owner Name</th>
                        <td><input type="text" name="owner_name" disabled class="form-control" value="{{ ucfirst($user_property->first_name) ?? '' }} {{ ucfirst($user_property->last_name) ?? '' }}"></td>
                        {{-- <td><input type="text" name="owner_phone" hidden class="form-control" value="{{ ucfirst($user_property->first_name) ?? '' }} {{ ucfirst($user_property->last_name) ?? '' }}"></td> --}}
                      </tr>
                      <tr>
                        <th>Property Owner Phone</th>
                        <td><input type="text" name="owner_phone" disabled class="form-control" value="{{ $user_property->phone ?? '' }}"></td>
                        {{-- <td><input type="text" name="owner_phone" hidden class="form-control" value="{{ $user_property->phone ?? '' }}"></td> --}}
                      </tr>
                      <tr>
                        <th>Property Owner Country</th>
                        <td><input type="text" name="owner_country" disabled class="form-control" value="{{ $user_property->country ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Property Name</th>
                        <input type="hidden" name="pms_onboard_id" value="{{$pms_request->id}}">
                        <td><input type="text" name="property_name" disabled class="form-control" value="{{ $pms_request->property_name->name ?? '' }}"></td>
                        <td><input type="text" name="property_id" hidden class="form-control" value="{{ $pms_request->property_name->id ?? '' }}"></td>
                        <td><input type="text" name="name" hidden class="form-control" value="{{ $pms_request->property_name->name ?? '' }}"></td>
                        <td><input type="text" name="property_type" hidden class="form-control" value="{{ $pms_request->property_name->property_type ?? '' }}"></td>
                        <td><input type="text" name="space_type" hidden class="form-control" value="{{ $pms_request->property_name->space_type ?? '' }}"></td>
                        <td><input type="text" name="accommodates" hidden class="form-control" value="{{ $pms_request->property_name->accommodates ?? '' }}"></td>
                        <td><input type="text" name="recomended" hidden class="form-control" value="{{ $pms_request->property_name->recomended ?? '' }}"></td>
                        <td><input type="text" name="is_verified" hidden class="form-control" value="{{ $pms_request->property_name->is_verified ?? '' }}"></td>
                        <td><input type="text" name="for_property" hidden class="form-control" value="{{ $pms_request->property_name->for_property ?? '' }}"></td>
                        <td><input type="text" name="booking_type" hidden class="form-control" value="{{ $pms_request->property_name->booking_type ?? '' }}"></td>
                        <td><input type="text" name="cancellation" hidden class="form-control" value="{{ $pms_request->property_name->cancellation ?? '' }}"></td>
                        <td><input type="text" name="floor" hidden class="form-control" value="{{ $pms_request->property_name->floor ?? '' }}"></td>
                        <td><input type="text" name="super_area" hidden class="form-control" value="{{ $pms_request->property_name->super_area ?? '' }}"></td>
                        <td><input type="text" name="property_age" hidden class="form-control" value="{{ $pms_request->property_name->property_age ?? '' }}"></td>
                        <td><input type="text" name="is_verified_pms" hidden class="form-control" value="{{ $pms_request->property_name->is_verified_pms ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Supervisor Name</th>
                        <td><input type="text" name="supervisor_name" disabled class="form-control" value="{{ $pms_request->getSupervisor->username ?? '' }}"></td>
                        <td><input type="text" name="assign_to_supervisor" hidden class="form-control" value="{{ $pms_request->getSupervisor->id ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Helpdesk User Name</th>
                        <td><input type="text" name="helpdesk_username" disabled class="form-control" value="{{ $pms_request->getHelpdesk->username ?? '' }}"></td>
                        <td><input type="text" name="helpdesk_user_id" hidden class="form-control" value="{{ $pms_request->getHelpdesk->id ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Description</th>
                        <td><textarea name="description" disabled class="form-control">{{ $pms_request->description ?? '' }}</textarea></td>
                      </tr>
                    
                      <tr>
                        <th>Date</th>
                        <td><input type="text" name="date_times" disabled class="form-control" value="{{ $pms_request->created_at ?? '' }}"></td>
                        <td><input type="text" name="date_times" hidden class="form-control" value="{{ $pms_request->created_at ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Priority</th>
                        <td><input type="text" name="priority" disabled class="form-control" value="{{ $pms_request->priority ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Status</th>
                        <td><input type="text" name="status" disabled class="form-control" value="{{ $pms_request->status ?? '' }}"></td>
                      </tr>
                      <tr>
                        <td>Status</td>
                        <td>
                          <select class="form-control f-14" id="status" @if($get_role != 'sitemanager') disabled  @endif name="status" aria-invalid="false">
                            <option value="active">Active</option>
                            <option value="onhold">OnHold</option>
                        </td>
                      </tr>
                      <tr>
                        <th>Bedrooms</th>
                        <td><input type="text" name="bedrooms" class="form-control" @if($get_role != 'sitemanager') disabled  @endif value="{{ $pms_request->property_name->bedrooms ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Beds</th>
                        <td><input type="text" name="beds" class="form-control" @if($get_role != 'sitemanager') disabled  @endif value="{{ $pms_request->property_name->beds ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Bathrooms</th>
                        <td><input type="text" name="bathrooms" class="form-control" @if($get_role != 'sitemanager') disabled  @endif value="{{ $pms_request->property_name->bathrooms ?? '' }}"></td>
                        <td><input type="text" name="bed_type" hidden class="form-control" value="{{ $pms_request->property_name->bed_type ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Property Square Feet</th>
                        <td><input type="text" name="property_square" class="form-control" @if($get_role != 'sitemanager') disabled  @endif value="{{ $pms_request->property_name->property_square ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Number Of Floor</th>
                        <td><input type="text" name="number_of_floor" class="form-control" @if($get_role != 'sitemanager') disabled  @endif value="{{ $pms_request->property_name->number_of_floor ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Number Of Rooms</th>
                        <td><input type="text" name="number_of_rooms" class="form-control" @if($get_role != 'sitemanager') disabled  @endif value="{{ $pms_request->property_name->number_of_rooms ?? '' }}"></td>
                      </tr>
                      <tr>
                        <th>Amenities</th>
                        <td>
                          @php
                            $amenities_data = explode(',', App\Models\Properties::find($pms_request->property_id)->amenities);
                            $amenities_type = App\Models\AmenityType::all();
                            $amenities = App\Models\Amenities::get();
                          @endphp
                          <ul class="list-group">
                            @foreach ($amenities_type as $row_type)
                            @if (count($amenities->where('type_id', $row_type->id)->whereIn('id', $amenities_data)) > 0)
                            <li class="list-group-item "> 
                                  <p class="text-bold text-decoration-underline">{{ $row_type->name }}</p>
                                  <ul class="list-group">
                                    @foreach ($amenities->where('type_id', $row_type->id) as $data)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $data->title }}
                                            <input type="checkbox" name="amenities[{{ $data->id }}]" 
                                                  @if($get_role != 'sitemanager') disabled @endif 
                                                  {{ in_array($data->id, $amenities_data) ? 'checked' : '' }} 
                                                  value="{{ $data->id }}"
                                                  {{ in_array($data->id, $amenities_data) ? '' : 'style=display:none;' }}>
                        
                                            <div class="form-check">
                                                <input class="form-check-input amenities_status_yes" 
                                                      type="radio" 
                                                      name="amenities_status[{{ $data->id }}]" 
                                                      value="yes" 
                                                      @if($get_role != 'sitemanager') disabled @endif 
                                                      onchange="showRemark(this, {{ $data->id }})" 
                                                      {{ in_array($data->id, $amenities_data) ? '' : 'style=display:none;' }}>
                                                <label class="form-check-label" for="is_working_{{ $data->id }}_yes" {{ in_array($data->id, $amenities_data) ? '' : 'style=display:none;' }}>Yes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input amenities_status_no" 
                                                      type="radio" 
                                                      name="amenities_status[{{ $data->id }}]" 
                                                      value="no" 
                                                      @if($get_role != 'sitemanager') disabled @endif 
                                                      onchange="showRemark(this, {{ $data->id }})"
                                                      {{ in_array($data->id, $amenities_data) ? '' : 'style=display:none;' }}>
                                                <label class="form-check-label" for="is_working_{{ $data->id }}_no" {{ in_array($data->id, $amenities_data) ? '' : 'style=display:none;' }}>No</label>
                                            </div>
                                          
                                        </li>
                        
                                        <!-- Remarks and Working Options -->
                                        <div id="remarks_{{ $data->id }}" style="display:none">
                                          <label>Remarks</label>
                                          <input type="text" name="remarks[{{ $data->id }}]" 
                                                @if($get_role != 'sitemanager') disabled @endif  
                                                class="form-control">
                                        </div>
                                  
                                        <div id="working_options_{{ $data->id }}"  class="working_options" style="display:none">
                                            {{-- working --}}
                                           <b>Working Options</b> 
                                            <div class="form-check">
                                              <input class="form-check-input" 
                                                    type="radio" 
                                                    name="working[{{ $data->id }}]"  
                                                    value="working" 
                                                    @if($get_role != 'sitemanager') disabled @endif 
                                                    id="is_repairing_{{ $data->id }}_working" 
                                                    onchange="showRepairing(this, {{ $data->id }})">
                                              <label class="form-check-label" for="is_repairing_{{ $data->id }}_working">
                                                  Working
                                              </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                      type="radio" 
                                                      name="working[{{ $data->id }}]" 
                                                      value="not_working" 
                                                      @if($get_role != 'sitemanager') disabled @endif 
                                                      id="is_repairing_{{ $data->id }}_not_working" 
                                                      onchange="showRepairing(this, {{ $data->id }})">
                                                <label class="form-check-label" for="is_repairing_{{ $data->id }}_not_working">
                                                    Not Working
                                                </label>
                                            </div>
                                        </div>
                                        <div id="repairing_options_{{ $data->id }}"  class="repairing_options" style="display:none">
                                          {{-- repairing --}}
                                          <b>Repairing Options</b> 
                                          <div class="form-check">
                                              <input class="form-check-input" 
                                                    type="radio" 
                                                    name="repairing[{{ $data->id }}]"  
                                                    value="in_repairing" 
                                                    @if($get_role != 'sitemanager') disabled @endif 
                                                    id="is_repairing_{{ $data->id }}_in_repairing" 
                                                    onchange="showEstimatedCost(this, {{ $data->id }})">
                                              <label class="form-check-label" for="is_repairing_{{ $data->id }}_in_repairing">
                                                  Can We Repair
                                              </label>
                                          </div>
                                          <div class="form-check">
                                            <input class="form-check-input" 
                                                  type="radio" 
                                                  name="repairing[{{ $data->id }}]"  
                                                  value="replace" 
                                                  @if($get_role != 'sitemanager') disabled @endif 
                                                  id="is_repairing_{{ $data->id }}_in_repairing" 
                                                  onchange="showEstimatedCost(this, {{ $data->id }})">
                                            <label class="form-check-label" for="is_repairing_{{ $data->id }}_in_repairing">
                                                Can We Replace
                                            </label>
                                        </div>
                                          <div class="form-check">
                                              <input class="form-check-input" 
                                                    type="radio" 
                                                    name="repairing[{{ $data->id }}]" 
                                                    value="out_repairing" 
                                                    @if($get_role != 'sitemanager') disabled @endif 
                                                    id="is_repairing_{{ $data->id }}_out_repairing" 
                                                    onchange="showEstimatedCost(this, {{ $data->id }})">
                                              <label class="form-check-label" for="is_repairing_{{ $data->id }}_out_repairing">
                                                  Out Repairing
                                              </label>
                                          </div>
                                          <div id="estimated_cost_{{ $data->id }}" style="display:none;">
                                              <label>Estimated Cost</label>
                                              <input type="text" name="estimated_cost[{{ $data->id }}]" 
                                                    @if($get_role != 'sitemanager') disabled @endif  
                                                    class="form-control">
                                          </div>
                                        </div>
                                   
                                    @endforeach
                                  </ul>
                                </li>
                              @endif
                            @endforeach
                          </ul>
                        
                        </td>
                      </tr>
                    </table>
                    @if($get_role == 'sitemanager') 
                     <button type="submit" class="btn btn-primary float-end ">Submit</button>
                    @endif
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

<script>
  var id = "{{ $pms_request->id }}";
  function myFunction(x) {
    $.Ajax({
      type: "POST",
      url: "sdfsdfsdf",
      data: {
        _token: "{{ csrf_token() }}",
        id: id,
        id: x.value
      },
      success: function(data) {
        console.log(data);
      }
    })
  }
</script>
<script>
  function myFunction(event) {
    var site_engineer_id = event.value;
    $.ajax({
      url: "{{ url('admin/area-site-engineer') }}",
      type: "POST",
      data: {
        "_token": "{{ csrf_token() }}",
        "site_engineer_id": site_engineer_id,
        "pms_request_id": "{{ $pms_request->id }}",
      },
      success: function (response) {
        if (response.success) {
          alert(response.message);  
          window.location.reload();
        } else {
          alert(response.message);
          window.location.reload();
        }
      }
    });
  }
</script>
<script>
  function showRepairing(el, id){
      if(el.value == 'working'){
          document.getElementById("repairing_options_"+id).style.display="none";
      }else if(el.value == 'not_working'){
          document.getElementById("repairing_options_"+id).style.display="block";
      }
  }
  function showRemark(el, id){
      if(el.value == 'no'){
          document.getElementById("remarks_"+id).style.display="block";
          document.getElementById("working_options_"+id).style.display="none";
      }else if(el.value == 'yes'){
          document.getElementById("remarks_"+id).style.display="none";
          document.getElementById("working_options_"+id).style.display="block";
      }
  }

  function showEstimatedCost(el, id){
      if(el.value == 'in_repairing' || el.value == 'replace'){
          document.getElementById("estimated_cost_"+id).style.display="block";
      }else if(el.value == 'out_repairing'){
          document.getElementById("estimated_cost_"+id).style.display="none";
      }
  }
</script>

