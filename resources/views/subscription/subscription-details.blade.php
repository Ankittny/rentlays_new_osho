@extends('template')

@section('main')
    <div class="container mt-5 mb-5">
        <h3 class="text-center mb-4">Recurring Package Details</h3>
        
        <div class="card w-75 m-auto ">
            <div class="card-body ">
                <dl class="row">
                    <dt class="col-sm-4">Package Name:</dt>
                    <dd class="col-sm-8 float-right">{{$data['result']['package_name'] ?? 'N/A'}}</dd>
                    
                    <dt class="col-sm-4">Price:</dt>
                    <dd class="col-sm-8">{{$data['result']['price'] ?? 'N/A'}}</dd>
                    
                    <dt class="col-sm-4">Offer Price:</dt>
                    <dd class="col-sm-8">{{$data['result']['offer_price'] ?? 'N/A'}}</dd>
                    
                    <dt class="col-sm-4">Recurring Service:</dt>
                    <dd class="col-sm-8">
                        @forelse ($data['recurring_service'] as $item)
                            <span class="badge badge-primary">{{$item}}</span>
                        @empty
                            No services available
                        @endforelse
                    </dd>
                </dl>
                <div class="text-center mt-4">
                    <a href="{{ url('subscription-payments') }}/{{ base64_encode($data['property_id']) }}/{{ base64_encode($data['subscription_type']) }}/{{ base64_encode($data['pms_recurring_packages_id']) }}" class="btn btn-primary">Pay Now</a>
                </div>
            </div>
        </div>
    </div>
@endsection
