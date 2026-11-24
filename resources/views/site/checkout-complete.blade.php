@extends('layouts.marketing')

@section('title', 'Sandbox checkout complete')

@section('content')
<section class="checkout-page checkout-complete-page">
    <div class="container checkout-complete-card">
        <span class="checkout-success-mark" aria-hidden="true">✓</span>
        <p class="eyebrow">SANDBOX CHECKOUT COMPLETE</p>
        @if ($checkout)
            <h1>Thanks, {{ $checkout['name'] }}.</h1>
            <p>Your selection is <strong>{{ $checkout['plan'] }}</strong>, billed {{ $checkout['billing'] }} at <strong>${{ number_format($checkout['amount']) }} / {{ $checkout['billing'] === 'yearly' ? 'year' : 'month' }}</strong>.</p>
        @else
            <h1>Sandbox complete.</h1>
            <p>This checkout flow does not create a subscription or take payment.</p>
        @endif
        <p class="checkout-disclaimer">No payment was processed, no subscription was created, and no card details were sent or saved.</p>
        <a class="button" href="{{ route('home') }}#plans">Back to plans <span aria-hidden="true">→</span></a>
    </div>
</section>
@endsection
