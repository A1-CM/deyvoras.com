<?php $__env->startSection('title', 'Sign in'); ?>
<?php $__env->startSection('content'); ?>
<section class="auth-section"><div class="auth-aside"><div class="eyebrow">YOUR AGREEMENT DESK</div><h1>Good work<br>starts with <em>clarity.</em></h1><p>Sign in to keep your contracts, reviews, and important dates in one place.</p><div class="auth-aside-note"><span>“</span><p>Every agreement should have a clear owner, a clear status, and a clear next step.</p></div></div><div class="auth-card-wrap"><div class="auth-card"><span class="eyebrow">WELCOME BACK</span><h2>Sign in to Deyvoras</h2><p class="auth-intro">Enter your details to continue to your workspace.</p>
    <?php if($errors->any()): ?><div class="form-alert" role="alert"><?php echo e($errors->first()); ?></div><?php endif; ?>
    <form method="POST" action="<?php echo e(route('login.store')); ?>" class="form-stack"><?php echo csrf_field(); ?>
        <label>Email address<input type="email" name="email" value="<?php echo e(old('email')); ?>" autocomplete="email" required autofocus placeholder="you@company.com"></label>
        <label>Password<input type="password" name="password" autocomplete="current-password" required placeholder="Your password"></label>
        <label class="remember-row"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
        <button class="button button-full" type="submit">Sign in <span aria-hidden="true">→</span></button>
    </form><p class="auth-switch">New to Deyvoras? <a href="<?php echo e(route('register')); ?>">Create a workspace</a></p></div><p class="auth-legal">Your workspace is for organizing agreement information. Review contract details against source documents.</p></div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/macm/projects/temp/deyvoras/resources/views/auth/login.blade.php ENDPATH**/ ?>