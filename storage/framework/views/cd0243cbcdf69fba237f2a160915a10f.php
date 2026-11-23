<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)"><meta name="theme-color" content="#101010" media="(prefers-color-scheme: dark)"><title><?php echo $__env->yieldContent('title', 'Workspace'); ?> · Deyvoras</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="workspace-body">
<a class="skip-link" href="#main">Skip to content</a>
<aside class="workspace-sidebar">
    <a class="brand workspace-brand" href="<?php echo e(route('dashboard')); ?>"><span class="brand-mark">D</span><span>Deyvoras</span></a>
    <div class="workspace-org"><span class="org-avatar"><?php echo e(strtoupper(substr(auth()->user()->organization?->name ?? 'D', 0, 1))); ?></span><span><b><?php echo e(auth()->user()->organization?->name ?? 'My workspace'); ?></b><small>Team workspace</small></span><span class="org-chevron">⌄</span></div>
    <nav class="workspace-nav" id="workspace-nav" aria-label="Workspace navigation">
        <span class="nav-caption">WORKSPACE</span>
        <a class="<?php echo e(request()->routeIs('dashboard') ? 'current' : ''); ?>" href="<?php echo e(route('dashboard')); ?>"><span class="nav-icon">⌂</span>Overview</a>
        <a class="<?php echo e(request()->routeIs('contracts.*') ? 'current' : ''); ?>" href="<?php echo e(route('contracts.index')); ?>"><span class="nav-icon">▤</span>Contracts</a>
        <a href="<?php echo e(route('reports.index')); ?>#obligations"><span class="nav-icon">◷</span>Obligations</a>
        <a href="<?php echo e(route('contracts.index', ['review' => 'needs_review'])); ?>"><span class="nav-icon">◫</span>Reviews</a>
        <span class="nav-caption nav-caption-spaced">MANAGE</span>
        <a class="<?php echo e(request()->routeIs('activity.*') ? 'current' : ''); ?>" href="<?php echo e(route('activity.index')); ?>"><span class="nav-icon">⌁</span>Activity</a>
        <a class="<?php echo e(request()->routeIs('reports.*') ? 'current' : ''); ?>" href="<?php echo e(route('reports.index')); ?>"><span class="nav-icon">▥</span>Reports</a>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-team')): ?><a class="<?php echo e(request()->routeIs('team.*') ? 'current' : ''); ?>" href="<?php echo e(route('team.index')); ?>"><span class="nav-icon">♙</span>Team</a><?php endif; ?>
    </nav>
    <div class="sidebar-bottom"><div class="sidebar-help"><span>?</span><div><b>Need a hand?</b><a href="tel:+94210170264">Contact the team</a></div><span aria-hidden="true">→</span></div><div class="sidebar-account"><span class="user-avatar"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></span><span class="account-info"><b><?php echo e(auth()->user()->name); ?></b><small><?php echo e(str_replace('_', ' ', ucfirst(auth()->user()->role))); ?></small></span><form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="icon-button" type="submit" aria-label="Sign out">⇥</button></form></div></div>
</aside>
<div class="workspace-main">
    <header class="workspace-topbar"><button class="menu-toggle workspace-menu-toggle" aria-expanded="false" aria-controls="workspace-nav" aria-label="Open workspace navigation"><span></span><span></span></button><div class="breadcrumb"><a href="<?php echo e(route('dashboard')); ?>">Workspace</a><?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?><span>/</span><span><?php echo $__env->yieldContent('breadcrumb'); ?></span><?php endif; ?></div><div class="topbar-actions"><span class="privacy-pill"><span>●</span> Private workspace</span><a class="avatar-link" href="#account" aria-label="Account"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></a></div></header>
    <main id="main" class="workspace-content">
        <?php if(session('status')): ?> <div class="flash-message" role="status"><?php echo e(session('status')); ?></div> <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>
</body>
</html>
<?php /**PATH /home/macm/projects/temp/deyvoras/resources/views/layouts/workspace.blade.php ENDPATH**/ ?>