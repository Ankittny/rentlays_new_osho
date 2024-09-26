@extends('admin.template')

@section('main')



 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Service Request
      <small>Add Service Request</small>
    </h1>
  @include('admin.common.breadcrumb')
  </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box">
            <!-- /.box-header -->
            <!-- form start -->
           



              <table style="table">
                <tr>
                  <th>Id :</th>
                  <td>{{$pms_service->id}}</td>
                </tr>
                <tr>
                  <th>Property Name:</th>
                  <td>{{$pms_service->issue}}</td>
                </tr>

                <tr>
                    <th>Image:</th>
                    <td>
                        <img src="{{ url('/public/front/images/service_request/' . $pms_service->image) }}" height="80px;" width="80px;">
                        
                  </tr>
                <tr>
                  <th>Issue:</th>
                  <td>{{$pms_service->issue}}</td>
                </tr>

                <tr>
                    <th>Description:</th>
                    <td>{{$pms_service->description}}</td>
                  </tr>


                  <tr>
                    <th>Priority:</th>
                    <td>{{$pms_service->priority}}</td>
                  </tr>


                  <tr>
                    <th>Assign to Supervisor:</th>
                    <td>{{$pms_service->assign_to_supervisor}}</td>
                  </tr>

                  <tr>
                    <th>Assign to Site Manager:</th>
                    <td>{{$pms_service->assign_to_sitemanager}}</td>
                  </tr>
                  <tr>
                    <th>Status:</th>
                    <td>{{$pms_service->status}}</td>
                  </tr>
                  <tr>
                    <th>Created_at:</th>
                    <td>{{$pms_service->created_at}}</td>
                  </tr>
              </table>
          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
    </section>
    </div>
@endsection

@section('validate_script')
    <script type="text/javascript" src="{{ asset('public/backend/dist/js/validate.min.js') }}"></script>	
@endsection


