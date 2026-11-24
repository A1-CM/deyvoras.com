@extends('layouts.marketing')
@section('title', 'Create a workspace')
@section('content')
<section class="auth-section"><div class="auth-aside"><div class="eyebrow">A CLEARER WAY TO WORK</div><h1>Make room<br>for <em>good decisions.</em></h1><p>Bring your organization’s agreements, review work, and responsibilities into one shared workspace.</p><div class="auth-aside-note"><span>01—03</span><p>Organize agreements. Review important details. Keep obligations moving.</p></div></div><div class="auth-card-wrap"><div class="auth-card"><span class="eyebrow">START YOUR WORKSPACE</span><h2>Create your account</h2><p class="auth-intro">Set up your organization’s private agreement desk.</p>
    @if ($errors->any())<div class="form-alert" role="alert">{{ $errors->first() }}</div>@endif
    <a class="google-auth-button" href="{{ route('auth.google.redirect') }}"><i class="fa-brands fa-google" aria-hidden="true"></i>Continue with Google</a>
    <div class="auth-divider"><span>or create an account with email</span></div>
    <form method="POST" action="{{ route('register.store') }}" class="form-stack">@csrf
        <label>Your name<input type="text" name="name" value="{{ old('name') }}" autocomplete="name" required autofocus placeholder="Alex Lee"></label>
        <label>Organization name<input type="text" name="organization" value="{{ old('organization') }}" autocomplete="organization" required placeholder="Your company"></label>
        <label>Work email<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required placeholder="you@company.com"></label>
        <label>Password<input type="password" name="password" autocomplete="new-password" required minlength="10" placeholder="At least 10 characters"></label>
        <label>Confirm password<input type="password" name="password_confirmation" autocomplete="new-password" required minlength="10" placeholder="Enter it again"></label>
        <button class="button button-full" type="submit">Create workspace <span aria-hidden="true">→</span></button>
    </form><p class="auth-switch">Already have a workspace? <a href="{{ route('login') }}">Sign in</a></p></div><p class="auth-legal">Creating an account starts a private organization workspace. Invite and team-management controls are coming later.</p></div></section>
@endsection
