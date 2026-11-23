<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)"><meta name="theme-color" content="#101010" media="(prefers-color-scheme: dark)">
    <meta name="description" content="A clearer place for teams to organize agreements, review important terms, and keep commitments moving.">
    <link rel="canonical" href="https://deyvoras.com">
    <title><?php echo $__env->yieldContent('title', 'Contract intelligence, made clear'); ?> · Deyvoras</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'%3E%3Crect width='40' height='40' rx='12' fill='%23000'/%3E%3Cpath d='M12 9h8c8 0 13 4 13 11s-5 11-13 11h-8V9Zm7 17c4 0 7-2 7-6s-3-6-7-6h-1v12h1Z' fill='white'/%3E%3C/svg%3E">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="marketing-body">
    <a class="skip-link" href="#main">Skip to content</a>
    <header class="site-header">
        <div class="container header-inner">
            <a class="brand" href="<?php echo e(route('home')); ?>" aria-label="Deyvoras home"><span class="brand-mark">D</span><span>Deyvoras</span></a>
            <button class="menu-toggle" aria-expanded="false" aria-controls="site-nav" aria-label="Open navigation"><span></span><span></span></button>
            <nav class="site-nav" id="site-nav" aria-label="Main navigation">
                <a href="<?php echo e(route('home')); ?>#about">About</a>
                <a href="<?php echo e(route('home')); ?>#features">Features</a>
                <a href="<?php echo e(route('home')); ?>#plans">Plans</a>
                <a href="<?php echo e(route('home')); ?>#faq">FAQ</a>
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>">Workspace</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>">Sign in</a>
                    <a class="button button-small" href="<?php echo e(route('register')); ?>">Create workspace <span aria-hidden="true">→</span></a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <main id="main"><?php echo $__env->yieldContent('content'); ?></main>

    <footer class="site-footer">
        <div class="container footer-top">
            <div class="footer-brand"><a class="brand" href="<?php echo e(route('home')); ?>"><span class="brand-mark">D</span><span>Deyvoras</span></a><p>Make every agreement easier to find, review, and follow through.</p></div>
            <div class="footer-column"><span class="eyebrow">Explore</span><a href="<?php echo e(route('home')); ?>#about">About</a><a href="<?php echo e(route('home')); ?>#features">Features</a><a href="<?php echo e(route('home')); ?>#workflow">How it works</a><a href="<?php echo e(route('home')); ?>#plans">Plans</a><a href="<?php echo e(route('home')); ?>#faq">FAQ</a></div>
            <div class="footer-column"><span class="eyebrow">Get started</span><a href="<?php echo e(route('register')); ?>">Create a workspace</a><a href="<?php echo e(route('login')); ?>">Sign in</a><a href="tel:+94210170264">Contact us</a></div>
            <div class="footer-column footer-company"><span class="eyebrow">Deyvoras Digital Labs</span><span>Deyvoras Digital Labs (Pvt) Ltd</span><span>No. 37, Hospital Road<br>Jaffna 40000, Sri Lanka</span><a href="tel:+94210170264">+94 21 017 0264</a><span>Deyvoras Digital Labs Inc.</span><span>350 South Grand Avenue<br>Los Angeles, CA 90071, USA</span><a href="tel:+12130850264">+1 213 085 0264</a><small>Founded 24 July 2024<br>Founder: Dhilakshan Kirubakaran</small></div>
        </div>
        <div class="container footer-bottom"><span>© <?php echo e(date('Y')); ?> Deyvoras Digital Labs</span><span>Built for clarity. Reviewed by people.</span></div>
    </footer>
</body>
</html>
<?php /**PATH /home/macm/projects/temp/deyvoras/resources/views/layouts/marketing.blade.php ENDPATH**/ ?>