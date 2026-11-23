<?php $__env->startSection('title', 'Add contract'); ?>
<?php $__env->startSection('breadcrumb'); ?><a href="<?php echo e(route('contracts.index')); ?>">Contracts</a><span>/</span><span>New contract</span><?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<section class="page-heading"><div><div class="eyebrow">ADD TO YOUR REPOSITORY</div><h1>New contract</h1><p>Start with the details your team needs to find and follow this agreement.</p></div><a class="text-link" href="<?php echo e(route('contracts.index')); ?>">← Back to contracts</a></section>
<form method="POST" action="<?php echo e(route('contracts.store')); ?>" enctype="multipart/form-data" class="contract-form panel"><?php echo csrf_field(); ?> <?php echo $__env->make('workspace.contracts.form-fields', ['contract' => null, 'submitLabel' => 'Add contract'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/macm/projects/temp/deyvoras/resources/views/workspace/contracts/create.blade.php ENDPATH**/ ?>