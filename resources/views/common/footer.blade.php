{{--Footer Section Start --}}
<footer class="main-panel footer-bg" id="footer">
    <div class="footer-top-style">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    <div class="mb-4">
                        <a href="{{ url('/') }}">{!! getLogo('img-130x32') !!}</a>
                    </div>
                    <p>Corem ipsum dolor sit amet consecte turad pisicing elit, sed do eiusmod tempor inci didunt ut labore et dolor.pisicing elit, sed do eiusmod tempor inci </p>
                    <div class="item-social">
                        <ul>
                        <li>
                            <a href="#" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                            <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                            <i class="fab fa-vimeo-v"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                            <i class="fab fa-pinterest-p"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            </a>
                        </li>
                        </ul>
                    </div>
                
                </div>

                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-title">
                        <h3>{{ __('Company') }}</h3>
                    </div>
                    <ul class="footer-link">
                        @foreach (top_destinations() as $pc)
                            <li>
                                <a href="{{ url('search?location=' .  $pc->name . '&checkin=' . date('d-m-Y') . '&checkout=' . date('d-m-Y') . '&guest=1">') }}">{{ $pc->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-title">
                        <h3>Instagram</h3>
                    </div>
                    <div class="footer-insta">
                        <div class="insta-link">
                            <ul>
                            <li>
                                <div class="item-img">
                                <a href="#" class="insta-pic">
                                    <img src="{{ asset('public/front/images/insta4.jpg') }}"width="86" height="73" alt="instagram">
                                </a>
                                <div class="item-overlay">
                                    <a href="#" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-img">
                                <a href="#" class="insta-pic">
                                    <img src="{{ asset('public/front/images/insta4.jpg') }}"width="86" height="73" alt="instagram">
                                </a>
                                <div class="item-overlay">
                                    <a href="#" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-img">
                                <a href="#" class="insta-pic">
                                    <img src="{{ asset('public/front/images/insta4.jpg') }}"width="86" height="73" alt="instagram">
                                </a>
                                <div class="item-overlay">
                                    <a href="#" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-img">
                                <a href="#" class="insta-pic">
                                    <img src="{{ asset('public/front/images/insta4.jpg') }}" width="86" height="73" alt="instagram">
                                </a>
                                <div class="item-overlay">
                                    <a href="#" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-img">
                                <a href="#" class="insta-pic">
                                    <img src="{{ asset('public/front/images/insta4.jpg') }}"width="86" height="73" alt="instagram">
                                </a>
                                <div class="item-overlay">
                                    <a href="#" target="_blank">
                                    <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                </div>
                            </li>
                            <li>
                                <div class="item-img">
                                <a href="#" class="insta-pic">
                                    <img src="{{ asset('public/front/images/insta4.jpg') }}"width="86" height="73" alt="instagram">
                                </a>
                                <div class="item-overlay">
                                    <a href="#" target="_blank"><i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                                </div>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-title">
                        <h3>Contact</h3>
                    </div>
                    <div class="footer-location">
                        <ul>
                        <li class="item-map">
                            <i class="fas fa-map-marker-alt"></i>4th Floor, MTML Square, 63 Cybercity,  72201 Ebene, Mauritius
                        </li>
                        <li>
                            <a href="mailto:info@example.com">
                            <i class="fas fa-envelope"></i>info@rentalys.com </a>
                        </li>
                        <li>
                            <a href="tel:+123596000">
                            <i class="fa fa-phone"></i>(230) 467 7914 </a>
                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="copy_section pt-5 pb-5 mt-3">
		<div class="container-fluid">

        <div class="row justify-content-center">
              <div class="col-lg-6 col-md-6">
                <div class="copyright-area1">
                  <ul class="Privacy_policy_list">
                    @if (isset($footer_second))
                        @foreach ($footer_second as $fs)
                        <li>
                            <a href="{{ url($fs->url) }}">{{ $fs->name }}</a>
                        </li>
                        @endforeach
                    @endif
                  </ul>
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="copyright-area2">
                  <p>© 2024-{{ date('Y') }} {{ siteName() }}. {{ __('All Rights Reserved') }}</p>
                </div>
              </div>
            </div>

		</div>
	</div>
</footer>

<div class="row">
    {{--Language Modal --}}
    <div class="modal fade mt-5 z-index-high" id="languageModalCenter" tabindex="-1" role="dialog" aria-labelledby="languageModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="w-100 pt-3">
                        <h5 class="modal-title text-20 text-center font-weight-700" id="languageModalLongTitle">{{ __('Choose Your Language') }}</h5>
                    </div>

                    <div>
                        <button type="button" class="close text-28 mr-2 filter-cancel" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="modal-body pb-5">
                    <div class="row">
                        @if(isset($language) && !empty($language))
                        @foreach ($language as $key => $value)
							<div class="col-md-6 mt-4">
								<a href="javascript:void(0)" class="language_footer {{ (Session::get('language') == $key) ? 'text-success' : '' }}" data-lang="{{ $key }}">{{ $value }}</a>
							</div>
						@endforeach
                        @endif
					</div>
				</div>
			</div>
		</div>
	</div>

    {{--Currency Modal --}}
    <div class="modal fade mt-5 z-index-high" id="currencyModalCenter" tabindex="-1" role="dialog" aria-labelledby="languageModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="w-100 pt-3">
						<h5 class="modal-title text-20 text-center font-weight-700" id="languageModalLongTitle">{{ __('Choose a Currency') }}</h5>
					</div>

					<div>
						<button type="button" class="close text-28 mr-2 filter-cancel font-weight-500" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
				</div>

				<div class="modal-body pb-5">
					<div class="row">
                        @if(isset($currencies) && !empty($currencies))
						@foreach ($currencies as $key => $value)
						<div class="col-6 col-sm-3 p-3">
							<div class="currency pl-3 pr-3 text-16 {{ (Session::get('currency') == $value->code) ? 'border border-success rounded-5 currency-active' : '' }}">
								<a href="javascript:void(0)" class="currency_footer " data-curr="{{ $value->code }}">
									<p class="m-0 mt-2  text-16">{{ $value->name }}</p>
									<p class="m-0 text-muted text-16">{{ $value->code }} - {!! $value->org_symbol !!} </p>
								</a>
							</div>
						</div>
						@endforeach
                        @endif

					</div>
				</div>
			</div>
        </div>
    </div>
</div>
