
<li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-refresh"></i>
        <span class="label label-danger" id="count"><?php echo $notification->count(); ?></span>
    </a>
    <ul class="dropdown-menu" style="width:500px">
        
        <li class="header">You have <?php echo $notification->count(); ?> update(s).</li>

        <ul class="menu list-unstyled">
            <?php if($notification->count()>0): ?>
            <?php $__currentLoopData = $notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notify): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($notify->value): ?>

            <li>&nbsp;&nbsp;&nbsp;<?php echo ucfirst($notify->value); ?></li>
            <li class="clearfix"></li>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </ul>
        <!--<li class="footer no-border"><div class="col-md-5"></div><div class="col-md-2">
                <img src="<?php echo e(asset("lb-faveo/media/images/gifloader.gif")); ?>" style="display: none;" id="notification-loader">
            </div><div class="col-md-5"></div></li>
        <li class="footer"><a href="<?php echo e(url('notifications-list')); ?>">View all</a>
        </li>-->

    </ul>
</li>

<?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/update/notification.blade.php ENDPATH**/ ?>