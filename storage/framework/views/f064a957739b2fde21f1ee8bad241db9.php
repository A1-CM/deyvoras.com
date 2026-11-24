<?php $__env->startSection('title', 'Create a workspace'); ?>
<?php $__env->startSection('content'); ?>
<section class="auth-section"><div class="auth-aside"><div class="eyebrow">A CLEARER WAY TO WORK</div><h1>Make room<br>for <em>good decisions.</em></h1><p>Bring your organization’s agreements, review work, and responsibilities into one shared workspace.</p><div class="auth-aside-note"><span>01—03</span><p>Organize agreements. Review important details. Keep obligations moving.</p></div></div><div class="auth-card-wrap"><div class="auth-card"><span class="eyebrow">START YOUR WORKSPACE</span><h2>Create your account</h2><p class="auth-intro">Set up your organization’s private agreement desk.</p>
    <?php if($errors->any()): ?><div class="form-alert" role="alert"><?php echo e($errors->first()); ?></div><?php endif; ?>
    <form method="POST" action="<?php echo e(route('register.store')); ?>" class="form-stack"><?php echo csrf_field(); ?>
        <label>Your name<input type="text" name="name" value="<?php echo e(old('name')); ?>" autocomplete="name" required autofocus placeholder="Alex Lee"></label>
        <label>Organization name<input type="text" name="organization" value="<?php echo e(old('organization')); ?>" autocomplete="organization" required placeholder="Your company"></label>
        <label>Work email<input type="email" name="email" value="<?php echo e(old('email')); ?>" autocomplete="email" required placeholder="you@company.com"></label>
        <label>Password<input type="password" name="password" autocomplete="new-password" required minlength="10" placeholder="At least 10 characters"></label>
        <label>Confirm password<input type="password" name="password_confirmation" autocomplete="new-password" required minlength="10" placeholder="Enter it again"></label>
        <button class="button button-full" type="submit">Create workspace <span aria-hidden="true">→</span></button>
    </form><p class="auth-switch">Already have a workspace? <a href="<?php echo e(route('login')); ?>">Sign in</a></p></div><p class="auth-legal">Creating an account starts a private organization workspace. Invite and team-management controls are coming later.</p></div></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.marketing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/macm/projects/temp/deyvoras/resources/views/auth/register.blade.php ENDPATH**/ ?>