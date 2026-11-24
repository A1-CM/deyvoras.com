@extends('layouts.marketing')
@section('title', 'Sign in')
@section('content')
<section class="auth-section"><div class="auth-aside"><div class="eyebrow">YOUR AGREEMENT DESK</div><h1>Good work<br>starts with <em>clarity.</em></h1><p>Sign in to keep your contracts, reviews, and important dates in one place.</p><div class="auth-aside-note"><span>“</span><p>Every agreement should have a clear owner, a clear status, and a clear next step.</p></div></div><div class="auth-card-wrap"><div class="auth-card"><span class="eyebrow">WELCOME BACK</span><h2>Sign in to Deyvoras</h2><p class="auth-intro">Enter your details to continue to your workspace.</p>
    @if ($errors->any())<div class="form-alert" role="alert">{{ $errors->first() }}</div>@endif
    <a class="google-auth-button" href="{{ route('auth.google.redirect') }}"><i class="fa-brands fa-google" aria-hidden="true"></i>Continue with Google</a>
    <div class="auth-divider"><span>or sign in with email</span></div>
    <form method="POST" action="{{ route('login.store') }}" class="form-stack">@csrf
        <label>Email address<input type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="you@company.com"></label>
        <label>Password<input type="password" name="password" autocomplete="current-password" required placeholder="Your password"></label>
        <label class="remember-row"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
        <button class="button button-full" type="submit">Sign in <span aria-hidden="true">→</span></button>
    </form><p class="auth-switch">New to Deyvoras? <a href="{{ route('register') }}">Create a workspace</a></p></div><p class="auth-legal">Your workspace is for organizing agreement information. Review contract details against source documents.</p></div></section>
@endsection
