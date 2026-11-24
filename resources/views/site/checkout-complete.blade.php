@extends('layouts.marketing')

@section('title', 'Demo checkout complete')

@section('content')
<section class="checkout-page checkout-complete-page">
    <div class="container checkout-complete-card">
        <span class="checkout-success-mark" aria-hidden="true">✓</span>
        <p class="eyebrow">DEMO CHECKOUT COMPLETE</p>
        @if ($checkout)
            <h1>Thanks, {{ $checkout['name'] }}.</h1>
            <p>Your demo selection is <strong>{{ $checkout['plan'] }}</strong>, billed {{ $checkout['billing'] }} at <strong>${{ number_format($checkout['amount']) }} / {{ $checkout['billing'] === 'yearly' ? 'year' : 'month' }}</strong>.</p>
        @else
            <h1>That’s the demo.</h1>
            <p>This checkout preview does not create a subscription or take payment.</p>
        @endif
        <p class="checkout-disclaimer">No payment was processed and no subscription was created.</p>
        <a class="button" href="{{ route('home') }}#plans">Back to plans <span aria-hidden="true">→</span></a>
    </div>
</section>
@endsection
