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
              <h3 class="box-title">Pms New Request Detail</h3>
              <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row w-75 mx-auto">
                <div class="col-sm-12">
                  <table class="table table-bordered">
                      <tr>
                        <th>Area Site Engineer</th>
                        <td>
                          <select onchange="myFunction(this)" id="site_engineer" class="form-control">
                            <option value="">Area Site Engineer</option>
                              @foreach($site_engineer as $value)
                                <option value="{{ $value->id }}">{{ ucfirst($value->username) }}</option>
                              @endforeach
                          </select>
                        </td>
                      </tr>
                    <tr>
                        <th>Property Owner Email</th>
                        <td>{{ $user_property->email ?? '' }}</td>
                      </tr>
                    <tr>
                      <th >Property Owner Name</th>
                      <td>{{ ucfirst($user_property->first_name) ?? '' }} {{ ucfirst($user_property->last_name) ?? '' }}</td>
                    </tr>
                    <tr>
                      <th >Property Owner Email</th>
                      <td>{{ $user_property->email ?? '' }}</td>
                    </tr>
                    <tr>
                      <th >Property Owner Phone</th>
                      <td>{{ $user_property->phone ?? '' }}</td>
                    </tr>
                    <tr>
                      <th >Property Owner Country</th>
                      <td>{{ $user_property->country ?? '' }}</td>
                    </tr>
                    <tr>
                      <th >Property Name</th>
                      <td>{{ $pms_request->property_name->name ?? '' }}</td>
                    </tr>
                    <tr>
                      <th>Superviser Name</th>
                      <td>{{ $pms_request->getSupervisor->username ?? ''  }}</td>
                    </tr>
                    <tr>
                      <th>Helpdesk User Name</th>
                      <td>{{ $pms_request->getHelpdesk->username ?? ''  }}</td>
                    </tr>
                    <tr>
                      <th>Description</th>
                      <td>{{ $pms_request->description ?? ''  }}</td>
                    </tr>
                    <tr>
                      <th>Status</th>
                      <td>{{ $pms_request->status ?? ''  }}</td>
                    </tr>
                    <tr>
                      <th>Date</th>
                      <td>{{ $pms_request->created_at ?? ''  }}</td>
                    </tr>
                    <tr>
                      <th>Priority</th>
                      <td>{{ $pms_request->priority ?? ''  }}</td>
                    </tr>
                    <tr>
                      <th>Description</th>
                      <td>{{ $pms_request->description ?? ''  }}</td>
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
                                    <li class="list-group-item "> <p class="text-bold text-decoration-underline">{{ $row_type->name }}</p>
                                        <ul class="list-group">
                                            @foreach ($amenities->where('type_id', $row_type->id) as $data)
                                                @if (in_array($data->id, $amenities_data))
                                                    <li class="list-group-item">{{ $data->title }}</li>
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

