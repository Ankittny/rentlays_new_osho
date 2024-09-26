@extends('template')

@section('main')
<style>
    .myimage{
        width: 40% !important;
        height: auto;
    }   
</style>
    <div class="margin-top-85 ">
        <div class="row m-0">
            @include('users.sidebar')
            <div class="col-lg-10 dashboardbkground">
                <div class="main-panel">
                    <div class="container-fluid min-height">
                        <div class="row">
                            <div class="col-md-12 p-0 mb-3">
                                <div class="list-bacground mt-4 rounded-3 pl-3 pr-3 pt-4 pb-4 border">
                                    <span class="text-18 pt-4 pb-4 font-weight-700">{{ __('Job Approval') }}</span>
                                    <div class="float-right">
                                        <div class="d-flex">
                                            <div class="pr-4">
                                                {{-- <span class="text-14 pt-2 pb-2 font-weight-700">{{ __('Sort By') }}</span> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row border border p-2  rounded-3 mt-4">
                            @forelse($pmsJobApproval as $ApprovalData)
                                <div class="col-md-3 col-xl-4 p-2">
                                    <div class="img-event myimage">
                                        <a href="{{ asset('public/front/images/upload_before_image/') . '/' . $ApprovalData->upload_before_image }}" download="{{ asset('public/front/images/upload_before_image/') . '/' . $ApprovalData->upload_before_image }}" title="click here to download"><img class="room-image-container200 rounded"
                                            src="{{ asset('public/front/images/upload_before_image/') . '/' . $ApprovalData->upload_before_image }}"
                                            alt="cover_photo"></a>
                                        <a href="{{ asset('public/front/images/upload_after_image/') . '/' . $ApprovalData->upload_after_image }}" download="{{ asset('public/front/images/upload_after_image/') . '/' . $ApprovalData->upload_after_image }}" title="click here to download"><img class="room-image-container200 rounded"
                                            src="{{ asset('public/front/images/upload_after_image/') . '/' . $ApprovalData->upload_after_image }}"
                                            alt="cover_photo"></a>
                                    </div>
                                </div>

                                <div class="col-md-9 col-xl-8 pl-2">
                                    <div class="row m-0 pr-4">
                                        <div class="col-10 col-sm-9 p-0">
                                            <p class="mb-0 text-18 text-color font-weight-700 text-color-hover pr-2">Site
                                                Engineer - {{ ucfirst($ApprovalData->username) }}</p>
                                        </div>
                                      
                                        <div class="col-2 col-sm-3">
                                           @if($ApprovalData->ApprovalStatus == 'pending') 
                                                <span class="btn btn-outline-success text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3 mr-2">{{ Str::ucfirst($ApprovalData->ApprovalStatus) }}</span></br>
                                                <button type="button" class="btn btn-info btn-lg"
                                                    onclick="MyModel({{ $ApprovalData->job_id }})">Approv</button>
                                           @elseif($ApprovalData->ApprovalStatus == 'approved')
                                            <span class="btn btn-outline-success text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3 mr-2">{{ $ApprovalData->payable_amount ?? '' }}</span></br>
                                            <form action="{{ url('users/paynow') }}" method="POST">
                                               @csrf
                                               <input type="hidden" name="job_id" id="job_id" value="{{ $ApprovalData->job_id }}">
                                               <input type="hidden" name="payable_amount" id="payable_amount" value="{{ $ApprovalData->payable_amount ?? '' }}">
                                               <input type="hidden" name="subtotal" id="payable_amount" value="{{ $ApprovalData->payable_amount ?? '' }}">
                                               <input type="hidden" name="user_id" id="" value="{{ Auth::user()->id }}">
                                               <input type="hidden" name="payment_method_id" value="4">
                                               <input type="hidden" name="uuid" value="{{ Str::uuid() }}">
                                               <input type="hidden" name="property_id" value="{{ $ApprovalData->property_id }}">
                                               <input type="hidden" name="status" value="Success">
                                               <input type="submit" class="btn btn-success btn-lg" name="submit" value="Paynow">
                                            </form>
                                           @elseif($ApprovalData->ApprovalStatus == 'rejected')
                                            <span class="btn btn-outline-success text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3 mr-2">{{ $ApprovalData->payable_amount ?? '' }}</span></br>
                                            <span class="btn btn-outline-danger text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3 mr-2">{{ $ApprovalData->ApprovalStatus ?? '' }}</span></br>
                                            <span><span class="text-14">{{ $ApprovalData->remark ?? '' }}</span></br></span>
                                            @elseif($ApprovalData->ApprovalStatus == 'completed')
                                            <span class="btn btn-outline-success text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3 mr-2">{{ $ApprovalData->payable_amount ?? '' }}</span></br>
                                            <span class="btn btn-outline-success text-14 font-weight-700 pl-4 pr-4 pt-3 pb-3 mr-2">{{ $ApprovalData->ApprovalStatus ?? '' }}</span></br>
                                            <a class="btn btn-success btn-lg" href="{{url('users/invoice').'/'.$ApprovalData->job_id}}">Download</a>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="d-flex justify-content-between ">
                                        <div>
                                            <p class="text-14 mb-0">
                                                <span>Payable Amount: {{ $ApprovalData->payable_amount ?? '' }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    @php
                                        $PmsJobsItems = App\Models\PmsJobsItems::where(
                                            'pms_job_id',
                                            $ApprovalData->job_id,
                                        )->get();
                                    @endphp
                                    @foreach ($PmsJobsItems as $itemsData)
                                        @php
                                            $ServiceName = App\Models\PmsServiceMaster::where(
                                                'id',
                                                $itemsData->service_id,
                                            )->first();
                                            $pms_inventory_product = App\Models\PmsInventoryProducts::where(
                                                'id',
                                                $itemsData->pms_inventory_product_id,
                                            )->first();
                                        @endphp
                                        <div class="d-flex justify-content-between ">
                                            <div>
                                                @if (!empty($ServiceName->name))
                                                    <p class="text-14 mb-0">
                                                        <span>Service: {{ $ServiceName->name ?? '' }}</span>
                                                        {{ $pms_inventory_product->description ?? '' }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <p class="text-14 mt-3">
                                        <i class="fas fa-calendar"></i> Start Time:- {{ $ApprovalData->start_time }} End
                                        Time- {{ $ApprovalData->end_time }}
                                    </p>

                                </div>
                            @empty
                                <div class="row jutify-content-center w-100 position-center p-4 mt-4">
                                    <div class="text-center w-100">
                                        <img src="{{ asset('public/img/unnamed.png') }}" alt="notfound" class="img-fluid">
                                        <p class="text-center">
                                            {{ __('You don’t have any Bookings yet—but when you do, you’ll find them here.') }}.
                                        </p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('users/update-job-approval') }}" method="POST" id="myForm">
                            @csrf
                            <input type="hidden" name="job_id" id="job_id_data">
                            <div class="form-group">
                                <select class="form-control" name="status">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" name="remark" class="form-control" placeholder="Remark">
                            </div>
                            <input type="submit" class="btn vbtn-outline-success text-16 font-weight-700 pl-4 pr-4 pt-3 pb-3" name="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('validation_script')
    <script src="{{ asset('public/js/my-booking.min.js') }}"></script>

    <script>
        function MyModel(id) {
            $("#job_id_data").val(id);
            $('#myModal').modal('show');
        }
    </script>
@endsection
