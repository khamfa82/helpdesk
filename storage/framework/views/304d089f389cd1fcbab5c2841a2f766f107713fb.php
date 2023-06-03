<?php if(isset($breadcrumbs)): ?>
<ol class="breadcrumb breadcrumb-custom">
    <li class="text"> <?php echo Lang::get('lang.you_are_here'); ?> :</li>

    <?php //dd(count($breadcrumbs)); ?>

    <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($key < count($breadcrumbs) - 1): ?>
    <li><a href="<?php echo e($breadcrumb->url); ?>"><?php echo e($breadcrumb->title); ?></a></li>
    <?php else: ?>
    <li class="text"><?php echo e($breadcrumb->title); ?></li>
    <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ol>
<?php endif; ?>
<?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/_partials/breadcrumbs.blade.php ENDPATH**/ ?>