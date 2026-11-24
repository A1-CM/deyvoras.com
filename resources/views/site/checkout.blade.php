@extends('layouts.marketing')

@section('title', 'Demo checkout')

@section('content')
<section class="checkout-page">
    <div class="container checkout-layout">
        <div class="checkout-copy">
            <p class="eyebrow">DEMO CHECKOUT · NO PAYMENT WILL BE TAKEN</p>
            <h1>Review your<br><em>workspace plan.</em></h1>
            <p>This is a walkthrough of a future subscription checkout. It does not create a subscription or collect payment details.</p>
            <a class="text-link" href="{{ route('home') }}#plans">← Back to plans</a>
        </div>
        <div class="checkout-card">
            <div class="checkout-card-heading"><span class="eyebrow">YOUR SELECTION</span><span class="checkout-demo-badge">DEMO ONLY</span></div>
            <div class="checkout-plan-summary"><div><h2>{{ $plan['name'] }}</h2><p>{{ $billing === 'yearly' ? 'Annual workspace plan' : 'Monthly workspace plan' }}</p></div><strong>${{ number_format($amount) }}<small> / {{ $billing === 'yearly' ? 'year' : 'month' }}</small></strong></div>
            <div class="checkout-demo-payment"><span class="eyebrow">PAYMENT STEP PREVIEW</span><div><span aria-hidden="true">▰</span><strong>Demo card</strong><small>•••• 4242 · no card details needed</small></div><p>No payment provider is connected. Submitting below only displays a confirmation screen.</p></div>
            <form method="POST" action="{{ route('checkout.confirm') }}" class="checkout-form">
                @csrf
                <input type="hidden" name="plan" value="{{ $planKey }}">
                <input type="hidden" name="billing" value="{{ $billing }}">
                @if ($errors->any())<div class="form-alert" role="alert">{{ $errors->first() }}</div>@endif
                <label>Your name<input name="name" value="{{ old('name') }}" autocomplete="name" maxlength="100" required></label>
                <label>Email address<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" maxlength="254" required></label>
                <button class="button button-full" type="submit">Simulate checkout <span aria-hidden="true">→</span></button>
            </form>
            <p class="checkout-disclaimer">Demo only: no charge, subscription, payment processing, or saved customer record.</p>
        </div>
    </div>
</section>
@endsection
