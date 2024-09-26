@extends('emails.template')
@section('emails.main')
<div class="mt-20 text-left">
  <p>
    <?=$content?>
  </p>
  <p class="mt-20 text-center">
      <a href="{{ $url . ('users/payment_') . 'verification?secret=' . $token }}" target="_blank">
        <button type="button" class="learn-more">{{ __('Payment Request Approve') }}</button>
      </a>
  </p>
</div>
@endsection

