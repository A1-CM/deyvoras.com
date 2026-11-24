@extends('layouts.marketing')

@section('title', 'Contact Deyvoras')

@section('content')
<section class="contact-page">
    <div class="container contact-layout"><div class="contact-intro"><p class="eyebrow">CONTACT THE DEYVORAS TEAM</p><h1>Tell us what’s<br>on your <em>mind.</em></h1><p>Ask about the workspace, share feedback, or start a conversation about bringing Deyvoras to your team.</p><div class="contact-address"><span class="eyebrow">EMAIL</span><a href="mailto:support@deyvoras.com">support@deyvoras.com</a><small>Messages from this form go to our support team. Replies are routed to the email address you provide.</small></div><div class="contact-side-note"><span>01</span><p>We’ll use your details only to respond to your enquiry.</p></div></div>
        <div class="contact-form-card"><div class="contact-form-heading"><span class="eyebrow">SEND A NOTE</span><span>01 — 05</span></div>
            @if (session('status'))<div class="form-alert form-success" role="status">{{ session('status') }}</div>@endif
            @if ($errors->any())<div class="form-alert" role="alert">{{ $errors->first() }}</div>@endif
            @if (! config('services.turnstile.site_key') && ! app()->environment(['local', 'testing']))<div class="form-alert" role="alert">Contact form verification is not configured yet. Email <a href="mailto:support@deyvoras.com">support@deyvoras.com</a>.</div>@endif
            <form method="POST" action="{{ route('contact.send') }}" class="contact-form">@csrf
                <label class="contact-honeypot" aria-hidden="true">Leave this field empty<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                <div class="contact-form-row"><label>Your name<input name="name" autocomplete="name" value="{{ old('name') }}" maxlength="100" required></label><label>Work email<input name="email" type="email" autocomplete="email" value="{{ old('email') }}" maxlength="254" required></label></div>
                <label>Organization <span class="field-hint">Optional</span><input name="organization" autocomplete="organization" value="{{ old('organization') }}" maxlength="150"></label>
                <label>Subject<input name="subject" value="{{ old('subject') }}" maxlength="140" required></label>
                <label>Your message<textarea name="message" rows="6" minlength="20" maxlength="6000" required>{{ old('message') }}</textarea><small>At least 20 characters.</small></label>
                @if (config('services.turnstile.site_key'))<div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>@endif
                <button class="button" type="submit">Send to support <span>→</span></button>
            </form><p class="contact-form-footnote">Sent from <strong>no-reply@deyvoras.com</strong> to support@deyvoras.com. The email includes your address as Reply-To.</p>
        </div></div>
</section>
@if (config('services.turnstile.site_key'))<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>@endif
@endsection
