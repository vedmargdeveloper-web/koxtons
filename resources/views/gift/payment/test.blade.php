<form method="POST" name="redirect" action="https://api.razorpay.com/v1/checkout/embedded">
  <input type="hidden" name="key_id" value="{{ $key }}">
  <input type="hidden" name="order_id" value="{{ $order->id }}">
  <input type="hidden" name="name" value="Clothing Mantra">
  <input type="hidden" name="description" value="Clothing Mantra">
  <input type="hidden" name="image" value="{{ asset('public/assets/images/lgoo.png' ) }}">
  <input type="hidden" name="prefill[name]" value="{{ $request->first_name.' '.$request->last_name }}">
  <input type="hidden" name="prefill[contact]" value="{{ $request->mobile }}">
  <input type="hidden" name="prefill[email]" value="{{ $request->email }}">
  <input type="hidden" name="notes[shipping address]" value="{{ implode(', ', $request->address) . ', ' . $request->city . ' ' . $state . ' ' . $country.' - '.$request->pincode }}">
  <input type="hidden" name="callback_url" value="{{ route('payment.success') }}">
  <input type="hidden" name="cancel_url" value="{{ route('payment.cancel') }}">
</form>

{{-- <script language='javascript'>document.redirect.submit();</script> --}}
