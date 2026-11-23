<?php $__env->startSection('title', 'Overview'); ?>
<?php $__env->startSection('content'); ?>
<section class="page-heading dashboard-heading"><div><div class="eyebrow"><?php echo e(now()->format('l · j F Y')); ?></div><h1>Good <?php echo e(now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening')); ?>, <?php echo e(Str::before(auth()->user()->name, ' ')); ?>.</h1><p>Here is the current picture of your agreements.</p></div><?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-contracts')): ?><a class="button" href="<?php echo e(route('contracts.create')); ?>"><span>＋</span> New contract</a><?php endif; ?></section>
<section class="metric-grid" aria-label="Workspace summary">
    <article class="metric-card"><div class="metric-label"><span>ACTIVE AGREEMENTS</span><span class="metric-icon">▤</span></div><strong><?php echo e(str_pad($contractCount, 2, '0', STR_PAD_LEFT)); ?></strong><p>In your organization workspace</p><a href="<?php echo e(route('contracts.index')); ?>">View contracts <span>→</span></a></article>
    <article class="metric-card"><div class="metric-label"><span>NEEDS REVIEW</span><span class="metric-icon">⌕</span></div><strong><?php echo e(str_pad($reviewCount, 2, '0', STR_PAD_LEFT)); ?></strong><p>Records awaiting human review</p><a href="<?php echo e(route('contracts.index', ['review' => 'needs_review'])); ?>">Review records <span>→</span></a></article>
    <article class="metric-card"><div class="metric-label"><span>OPEN OBLIGATIONS</span><span class="metric-icon">◷</span></div><strong><?php echo e(str_pad($obligationCount, 2, '0', STR_PAD_LEFT)); ?></strong><p>Commitments still in progress</p><a href="#obligations">See upcoming <span>→</span></a></article>
</section>
<div class="dashboard-columns">
    <section class="panel recent-panel" id="reviews"><div class="panel-heading"><div><span class="eyebrow">YOUR REPOSITORY</span><h2>Recent contracts</h2></div><a class="text-link" href="<?php echo e(route('contracts.index')); ?>">All contracts <span>→</span></a></div>
        <?php $__empty_1 = true; $__currentLoopData = $recent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a class="contract-row" href="<?php echo e(route('contracts.show', $contract)); ?>"><span class="doc-icon"><?php echo e(strtoupper(substr($contract->document_type, 0, 1))); ?></span><span class="contract-row-main"><strong><?php echo e($contract->title); ?></strong><small><?php echo e($contract->counterparty ?: $contract->document_type); ?> · Added <?php echo e($contract->created_at->diffForHumans()); ?></small></span><span class="tag <?php echo e($contract->review_status === 'needs_review' ? 'tag-review' : ''); ?>"><?php echo e($contract->review_status === 'needs_review' ? 'Needs review' : ucfirst($contract->status)); ?></span><span class="row-arrow">→</span></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state"><div class="empty-illustration">▤</div><h3>Your repository starts here.</h3><p>Add an agreement to keep its source file, key details, and review work together.</p><a class="button button-outline" href="<?php echo e(route('contracts.create')); ?>">Add your first contract <span>→</span></a></div>
        <?php endif; ?>
    </section>
    <aside class="panel due-panel" id="obligations"><div class="panel-heading"><div><span class="eyebrow">LOOKING AHEAD</span><h2>Renewal dates</h2></div><span class="panel-count">90 DAYS</span></div>
        <?php $__empty_1 = true; $__currentLoopData = $upcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a class="date-row" href="<?php echo e(route('contracts.show', $contract)); ?>"><span class="date-badge"><small><?php echo e($contract->expiry_date->format('M')); ?></small><b><?php echo e($contract->expiry_date->format('d')); ?></b></span><span><strong><?php echo e($contract->title); ?></strong><small><?php echo e($contract->counterparty ?: 'Counterparty not recorded'); ?></small></span><span class="date-arrow">→</span></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-compact"><span>◷</span><p>No renewal dates in the next 90 days. Add an expiry date when you create a contract to see it here.</p></div>
        <?php endif; ?>
        <div class="dashboard-note"><span>i</span><p>Deyvoras helps organize contract information. Always confirm important dates against the signed agreement.</p></div>
    </aside>
</div>
<section class="workspace-principle" id="activity"><span class="principle-mark">D</span><div><span class="eyebrow">REVIEW WITH CONFIDENCE</span><p>Keep the original agreement close to every summary, clause, and follow-up. Information in Deyvoras should be checked by your team before you rely on it.</p></div><a href="<?php echo e(route('home')); ?>#workflow">Our workflow <span>→</span></a></section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.workspace', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/macm/projects/temp/deyvoras/resources/views/workspace/dashboard.blade.php ENDPATH**/ ?>