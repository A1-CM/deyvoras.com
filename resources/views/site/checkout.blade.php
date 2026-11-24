@extends('layouts.marketing')

@section('title', 'Secure sandbox checkout')

@section('content')
<section class="checkout-page">
    <div class="container checkout-layout">
        <div class="checkout-copy">
            <p class="eyebrow">SANDBOX CHECKOUT · NO CHARGE</p>
            <h1>Review your<br><em>workspace plan.</em></h1>
            <p>Enter card details to try the checkout flow. This sandbox validates the card number in your browser only; it does not contact a bank or charge a card.</p>
            <a class="text-link" href="{{ route('home') }}#plans">← Back to plans</a>
        </div>
        <div class="checkout-card">
            <div class="checkout-card-heading"><span class="eyebrow">YOUR SELECTION</span><span class="checkout-sandbox-badge">NO CHARGE</span></div>
            <div class="checkout-plan-summary"><div><h2>{{ $plan['name'] }}</h2><p>{{ $billing === 'yearly' ? 'Annual workspace plan' : 'Monthly workspace plan' }}</p></div><strong>${{ number_format($amount) }}<small> / {{ $billing === 'yearly' ? 'year' : 'month' }}</small></strong></div>
            <div class="checkout-sandbox-note"><span class="eyebrow">SANDBOX PAYMENT</span><p>Use any card number that passes the standard Luhn check. Card details stay in this page and are cleared before submission.</p></div>
            <form method="POST" action="{{ route('checkout.confirm') }}" class="checkout-form" data-sandbox-checkout novalidate>
                @csrf
                <input type="hidden" name="plan" value="{{ $planKey }}">
                <input type="hidden" name="billing" value="{{ $billing }}">
                @if ($errors->any())<div class="form-alert" role="alert">{{ $errors->first() }}</div>@endif
                <label>Your name<input name="name" value="{{ old('name') }}" autocomplete="name" maxlength="100" required></label>
                <label>Email address<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="254" required></label>
                <label>Card number<input type="text" inputmode="numeric" autocomplete="cc-number" data-card-number aria-describedby="card-number-error" placeholder="1234 5678 9012 3456" maxlength="23" required><small class="field-error" id="card-number-error" data-card-number-error hidden></small></label>
                <div class="checkout-card-fields">
                    <label>Expiry date<input type="text" inputmode="numeric" autocomplete="cc-exp" data-card-expiry aria-describedby="card-expiry-error" placeholder="MM / YY" maxlength="7" required><small class="field-error" id="card-expiry-error" data-card-expiry-error hidden></small></label>
                    <label>Security code<input type="password" inputmode="numeric" autocomplete="cc-csc" data-card-cvc aria-describedby="card-cvc-error" placeholder="CVC" maxlength="4" required><small class="field-error" id="card-cvc-error" data-card-cvc-error hidden></small></label>
                </div>
                <button class="button button-full" type="submit">Complete sandbox checkout <span aria-hidden="true">→</span></button>
            </form>
            <p class="checkout-disclaimer">No payment is processed, subscription created, or card details saved. Do not enter a real card number.</p>
        </div>
    </div>
</section>
@endsection
