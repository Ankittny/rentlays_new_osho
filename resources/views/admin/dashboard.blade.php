@extends('admin.template')
@section('main')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <section class="content-header">
			<h1>Dashboard</h1>

</section>
    <section class="content">
      <div class="row g-4 mb-4">
        
        <div class="col-lg-4 col-md-4">
          <a class="color_box box_bg6" href="{{ url('admin/customers') }}">
            <h3>{{ $total_users_count }}</h3>
            <p>Total Users</p>
          </a>
        </div>
        <div class="col-lg-4 col-md-4">
          <a class="color_box box_bg1" href="{{ url('admin/properties') }}">
            <h3>{{ $total_property_count }}</h3>
            <p>Total Property</p>
          </a>
        </div>
        <div class="col-lg-4 col-md-4">
          <a class="color_box box_bg2" href="{{ url('admin/bookings') }}">
            <h3>{{ $total_reservations_count }}</h3>
            <p>Total Reservations</p>
          </a>
        </div>
        <div class="col-lg-4 col-md-4">
          <a class="color_box box_bg3" href="{{ url('admin/customers') }}">
            <h3>{{ $today_users_count }}</h3>
            <p>Today Users</p>
          </a>
        </div>
        <div class="col-lg-4 col-md-4">
          <a class="color_box box_bg4" href="{{ url('admin/properties') }}">
            <h3>{{ $today_property_count }}</h3>
            <p>Today Property</p>
          </a>
        </div>
        <div class="col-lg-4 col-md-4">
          <a class="color_box box_bg5" href="{{ url('admin/bookings') }}">
            <h3>{{ $today_reservations_count }}</h3>
            <p>Today Reservations</p>
          </a>
        </div>
      </div>


      <!-- /.content -->
      <div class="row">
        <div class="col-md-12">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Property</h3>
            </div>
            <div class="box-body">
           <div class="table-responsive f-14">
              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Host Name</th>
                      <th>Space type</th>
                      <th width="15%">Date</th>
                      <th width="5%">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (!empty($propertiesList))
                      @foreach ($propertiesList  as $property)
                        <tr>
                          <td><a href="{{ url('admin/listing/' . $property->properties_id) . '/basics' }}" >{{ $property->property_name }}</a></td>
                          <td><a href="{{ url('admin/edit-customer/' . $property->host_id) }}">{{ $property->first_name . ' ' . $property->last_name }}</a></td>
                          <td>{{ $property->property_name }}</td>
                          <td>{{ dateFormat($property->property_created_at) }}</td>
                          <td>{{ $property->property_status }}</td>
                        </tr>
                        @endforeach
                      @endif
                  </tbody>
                </table>
           </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

      <!-- /.content -->
      <div class="row">
        <div class="col-md-12">
          <!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Latest Bookings</h3>
            </div>
            <div class="box-body">
            <div class="table-responsive f-14">
              <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Host Name</th>
                      <th>Guest Name</th>
                      <th>Property Name</th>
                      <th>Total Amount</th>
                      <th>Date</th>
                      <th width="5%">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if (!empty($bookingList))
                      @foreach ($bookingList  as $booking)
                        <tr>
                          <td><a href="{{ url('admin/bookings/detail/' . $booking->id) }}" >{{ $booking->host_name }}</a></td>
                          <td><a href="{{ url('admin/edit-customer/' . $booking->user_id) }}">{{ $booking->guest_name }}</a></td>
                          <td><a href="{{ url('admin/listing/' . $booking->property_id) . '/basics' }}" >{{ $booking->property_name }}</a></td>
                          <td>{!! moneyFormat($booking->symbol, $booking->total_amount) !!}</td>
                          <td>{{ dateFormat($booking->created_at) }}</td>
                          <td>{{ $booking->status }}</td>
                        </tr>
                      @endforeach
                    @endif
                  </tbody>
                </table>
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@stop
