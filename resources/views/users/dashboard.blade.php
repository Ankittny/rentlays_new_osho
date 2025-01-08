@extends('template')
@section('main')
<div class="margin-top-85">
	<div class="row m-0">
		{{-- sidebar start--}}
		@include('users.sidebar')
		{{--sidebar end--}}

        <style>
          
        </style>
		<div class="col-lg-10 p-0 dashboardbkground">
            <div class="flash-message">
                @if (Session::has('message'))
                    <div class="row">
                        <div class="col-md-12  alert {{ Session::get('alert-class') }} alert-dismissable fade in top-message-text opacity-1">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ Session::get('message') }}
                        </div>
                    </div>
                @endif
            </div>
			<div class="container-fluid min-height">
				<div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card card-default   boxs">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-3">
                                    <i class="far fa-list-alt    rounded-circle dashicon vbadge-success"></i>
                                   </div>
                                <div class="col-md-9  col-9 pl-0">
                                   <p class="grclor mb-0 " >  {{ __('My Lists') }} </p>
                                    <a href="{{ url('properties') }}">                                       
                                        <p class=" font-weight-bold m-0 fntsize ">{{ $list }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-default   boxs">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-3  col-3 ">
                                    <i class="fa fa-suitcase  rounded-circle dashicon vbadge-success" aria-hidden="true"></i>
                                </div>
                                <div class="col-md-9 col-9 pl-0">
                                    <p class="grclor mb-0">    {{ __('Trips') }} </p>
                                    <a href="{{ url('trips/active') }}">
                                      
                                        <p class=" font-weight-bold m-0 fntsize" >{{ $trip }}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-default   boxs">
                            <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-3">
                                    <i class="fas fa-wallet rounded-circle dashicon  vbadge-success"></i>
                                </div>
                                <div class="col-md-9  col-9 pl-0" >
                                    <p class="grclor mb-0">    {{ __('My Wallet') }} </p>
                                    <a href="{{ url('trips/active') }}">
                                       
                                        <p class=" font-weight-bold m-0 fntsize">{!! moneyFormat( $currentCurrency->symbol, number_format($wallet->total ?? 0, 2)) !!}</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

				<div class="row mb-5">
					<!-- Content Column -->
					<div class="col-lg-5 mb-4 mt-5">
						<!-- Project Card Example -->
						<div class="card card-default">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-700 text-18"><i class="fa fa-bookmark  mr-1" aria-hidden="true"></i> {{ __('Latest Bookings') }}</h6>
							</div>
							<div class="card-body">
								<div class="widget">
									<ul>
										@forelse ($bookings as $booking)
										@if ($loop->index < 4)
										<li>
											<div class="sidebar-thumb">
												<a href="{{ url('properties/' . optional($booking->properties)->slug) }}"><img class="animated rollIn" src="{{ optional($booking->properties)->cover_photo }} " alt="coverphoto" /></a>

											</div>

											<div>
												<h4 class="animated bounceInRight text-16 font-weight-700">
													<a href="{{ url('properties/' . optional($booking->properties)->slug) }}">{{ optional($booking->properties)->name }}
													</a><br/>

												</h4>
											</div>

											<div class="d-flex justify-content-between">
												<div>
													<div>
														<span class="text-14 font-weight-400">
															<i class="fa fa-calendar" aria-hidden="true"></i> {{ $booking->date_range }}</span>
														<div class="sidebar-meta">
															<a href="{{ url('users/show/' . $booking->user_id) }}" class="text-14 font-weight-400">{{ optional($booking->users)->full_name }}</a>
														</div>
													</div>

												</div>

												<div class="align-self-center pr-4">
													<span class="badge vbadge-success text-14 mt-3 p-2 {{ $booking->status }}">{{ __($booking->status) }}</span>
												</div>
											</div>
										</li>
										@endif
										@empty
										<div class="row jutify-content-center w-100  mt-4">
											<div class="text-center w-100">
											<p class="text-center">{{ __('You don’t have any Bookings yet—but when you do, you’ll find them here.') }}</p>
											</div>
										</div>
										@endforelse
									</ul>
								</div>

								@if ($bookings->count()>4)
									<div class="more-btn text-right">
										<a class="btn vbtn-outline-success text-14 font-weight-700 p-0 mt-2 pl-3 pr-3" href="{{ url('my-bookings') }}">
											<p class="p-2 mb-0">{{ __('More') }}</p>
										</a>
									</div>
								@endif
							</div>


						</div>
					</div>

					<div class="col-lg-7 mb-4 mt-5">
                        <!-- Illustrations -->
                        <div class="card card-default h-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-700 text-18"><i class="fas fa-exchange-alt mr-2"></i>{{ __('Latest Transactions') }}</h6>
                            </div>
                            <div class="card-body text-16 p-0">
                                <div class="panel-footer">
                                    <div class="panel">
                                        <div class="panel-body" class="p-0">
                                            <div class="row">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover table-header text-center">
                                                        @if ($transactions->count()>0)
                                                            <thead >
                                                                <tr class="bg-gr text-black">
                                                                    <th>{{ __('Type') }}</th>
                                                                    <th>{{ __('Payment Method') }}</th>
                                                                    <th>{{ __('Amount') }}</th>
                                                                    <th>{{ __('Date') }}</th>
                                                                </tr>
                                                            </thead>
                                                        @endif
                                                            <tbody id="transaction-table-body1">
                                                                @forelse ($transactions as $transaction)
                                                                    <tr>
                                                                        <td>{{ $transaction->type > 0 ?  __('Booking') : ($transaction->type < 0 ?  __('Trip') :  __('Withdrawn')) }}
                                                                        </td>
                                                                        <td>{{ __($transaction->p_method) }}   </td>
                                                                        <td class="{{ $transaction->type <= 0 ? 'text-danger' : 'text-success' }}">
                                                                            {{ $transaction->type <= 0 ? '- ' : '+ ' }}
                                                                          {!! Session::get('symbol') !!}{{ $transaction->type <> 0 ? currency_fix($transaction->amount, $transaction->currency_id) : currency_fix($transaction->amount, optional($transaction->currency)->code)  }}
                                                                        </td>
                                                                        <td>{{ onlyFormat($transaction->created_at) }}</td>
                                                                    </tr>
                                                                @empty
                                                                <div class="row jutify-content-center w-100 p-4 mt-4">
                                                                    <div class="text-center w-100">
                                                                    <p class="text-center">{{ __('No') }} {{ __('Transaction History') }}.</p>
                                                                    </div>
                                                                </div>
                                                                @endforelse
                                                            </tbody>
                                                    </table>
                                                    @if ( $transactions->count() >= 9 )
                                                        <div class="more-btn text-right mb-4 pr-4">
                                                            <a class="btn vbtn-outline-success text-14 font-weight-700 p-0 mt-2 pl-3 pr-3" href="{{ url('users/transaction-history') }}">
                                                                <p class="p-2 mb-0">{{ __('More') }}</p>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


				</div>
			</div>
		</div>
	</div>
</div>
@endsection
