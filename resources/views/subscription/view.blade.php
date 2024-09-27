@extends('template')
@section('main')
    <section class="p-5 sbs">
        <div class="">
            <div class="container ">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-3">
                        <form action="{{ url('subcribe') . '/' . $properties->id }}" method="post">
                            @csrf
                            <input type="hidden" name="subscription_type" value="on-demand">
                            <input type="hidden" name="property_id" value="{{ $properties->id }}">
                            <input type="hidden" name="pms_recurring_packages_id" value="0">
                            <input type="hidden" name="package_id" value="0">
                            <div class="offers active">
                                {{-- <img src="{{asset('public/images/s1.png')}}" style="height: 170px"/>
                        <br> --}}
                                <h2>OnDemand</h2>
                                {{-- <h3 class="price">$80</h3>                    --}}
                                <button class="btn vbtn-outline-success text-14 font-weight-700 p-0 mt-2 pl-4 pr-4">
                                    <p class="p-3 mb-0">Subscribe Now</p>
                                </button>
                            </div>
                        </form>
                    </div>
                    @foreach ($package as $items)
                        <div class="col-md-3">
                            <form action="{{ url('subcribe') . '/' . $properties->id }}" method="post">
                                @csrf
                                <input type="hidden" name="subscription_type" value="requrring">
                                <input type="hidden" name="property_id" value="{{ $properties->id }}">
                                <input type="hidden" name="pms_recurring_packages_id" value="{{ $items->pms_recurring_service_ids }}">
                                <input type="hidden" name="package_id" value="{{ $items->id }}">
                                <div class="offers">
                                    {{-- <img src="{{asset('public/images/s2.png')}}" style="height: 170px"/>
                            <br> --}}
                                    <h2>{{ ucfirst($items->package_name) }}</h2>
                                    <h3 class="price">€ {{ $items->price }}</h3>
                                    <button class="btn vbtn-outline-success text-14 font-weight-700 p-0 mt-2 pl-4 pr-4">
                                        <p class="p-3 mb-0 ">Subscribe Now</p>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const offers = document.querySelectorAll('.offers');
                            offers.forEach(offer => {
                                offer.addEventListener('click', function() {
                                    // Remove 'active' class from all offers
                                    offers.forEach(otherOffer => otherOffer.classList.remove('active'));
                                    // Add 'active' class to the clicked offer
                                    offer.classList.add('active');
                                });
                            });
                        });
                    </script>

                </div>
    </section>
@endsection
@section('validation_script')
@endsection
