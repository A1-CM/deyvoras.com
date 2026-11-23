<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)"><meta name="theme-color" content="#101010" media="(prefers-color-scheme: dark)"><title>@yield('title', 'Workspace') · Deyvoras</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="workspace-body">
<a class="skip-link" href="#main">Skip to content</a>
<aside class="workspace-sidebar">
    <a class="brand workspace-brand" href="{{ route('dashboard') }}"><span class="brand-mark">D</span><span>Deyvoras</span></a>
    <div class="workspace-org"><span class="org-avatar">{{ strtoupper(substr(auth()->user()->organization?->name ?? 'D', 0, 1)) }}</span><span><b>{{ auth()->user()->organization?->name ?? 'My workspace' }}</b><small>Team workspace</small></span><span class="org-chevron">⌄</span></div>
    <nav class="workspace-nav" id="workspace-nav" aria-label="Workspace navigation">
        <span class="nav-caption">WORKSPACE</span>
        <a class="{{ request()->routeIs('dashboard') ? 'current' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon">⌂</span>Overview</a>
        <a class="{{ request()->routeIs('contracts.*') ? 'current' : '' }}" href="{{ route('contracts.index') }}"><span class="nav-icon">▤</span>Contracts</a>
        <a href="{{ route('reports.index') }}#obligations"><span class="nav-icon">◷</span>Obligations</a>
        <a href="{{ route('contracts.index', ['review' => 'needs_review']) }}"><span class="nav-icon">◫</span>Reviews</a>
        <span class="nav-caption nav-caption-spaced">MANAGE</span>
        <a class="{{ request()->routeIs('activity.*') ? 'current' : '' }}" href="{{ route('activity.index') }}"><span class="nav-icon">⌁</span>Activity</a>
        <a class="{{ request()->routeIs('reports.*') ? 'current' : '' }}" href="{{ route('reports.index') }}"><span class="nav-icon">▥</span>Reports</a>
        @can('manage-team')<a class="{{ request()->routeIs('team.*') ? 'current' : '' }}" href="{{ route('team.index') }}"><span class="nav-icon">♙</span>Team</a>@endcan
    </nav>
    <div class="sidebar-bottom"><div class="sidebar-help"><span>?</span><div><b>Need a hand?</b><a href="tel:+94210170264">Contact the team</a></div><span aria-hidden="true">→</span></div><div class="sidebar-account"><span class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span class="account-info"><b>{{ auth()->user()->name }}</b><small>{{ str_replace('_', ' ', ucfirst(auth()->user()->role)) }}</small></span><form method="POST" action="{{ route('logout') }}">@csrf<button class="icon-button" type="submit" aria-label="Sign out">⇥</button></form></div></div>
</aside>
<div class="workspace-main">
    <header class="workspace-topbar"><button class="menu-toggle workspace-menu-toggle" aria-expanded="false" aria-controls="workspace-nav" aria-label="Open workspace navigation"><span></span><span></span></button><div class="breadcrumb"><a href="{{ route('dashboard') }}">Workspace</a>@hasSection('breadcrumb')<span>/</span><span>@yield('breadcrumb')</span>@endif</div><div class="topbar-actions"><span class="privacy-pill"><span>●</span> Private workspace</span><a class="avatar-link" href="#account" aria-label="Account">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</a></div></header>
    <main id="main" class="workspace-content">
        @if (session('status')) <div class="flash-message" role="status">{{ session('status') }}</div> @endif
        @yield('content')
    </main>
</div>
</body>
</html>
