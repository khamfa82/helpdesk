<?php $__env->startSection('Settings'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('settings-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('notification'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo Lang::get('lang.settings'); ?></h1>
<?php $__env->stopSection(); ?>
<!-- /header -->
<!-- breadcrumbs -->
<?php $__env->startSection('breadcrumbs'); ?>
<ol class="breadcrumb">
</ol>
<?php $__env->stopSection(); ?>
<!-- /breadcrumbs -->
<!-- content -->
<?php $__env->startSection('content'); ?>
<!-- open a form -->
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo e(Lang::get('lang.notification_settings')); ?></h3>
            </div>
            <!-- check whether success or not -->
            <div class="box-body table-responsive"style="overflow:hidden;">
                <?php if(Session::has('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <i class="fa fa-check-circle"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo Session::get('success'); ?>

                </div>
                <?php endif; ?>
                <!-- failure message -->
                <?php if(Session::has('fails')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <i class="fa fa-ban"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <b> <?php echo Lang::get('lang.alert'); ?> ! </b>
                    <li class="error-message-padding"><?php echo Session::get('fails'); ?></li>
                </div>
                <?php endif; ?>
                <div class="row">
                    <!-- Default System Email:	DROPDOWN value from emails table : Required -->
                    <div class="col-md-12">
                        <div class="col-md-3 no-padding">
                            <div class="form-group">
                                <?php echo Form::label('del_noti', Lang::get('lang.delete_noti')); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <a href="<?php echo e(url('delete-read-notification')); ?>" class="btn btn-danger"><?php echo Lang::get('lang.del_all_read'); ?></a>
                        </div>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <div class="col-md-3 no-padding">
                            <div class="form-group">
                                <?php echo Form::label('del_noti', Lang::get('lang.noti_msg1')); ?><span class="text-red"> *</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form action="<?php echo e(url('delete-notification-log')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

                                <div class="callout callout-default" style="font-style: oblique;"><?php echo Lang::get('lang.noti_msg2'); ?></div>
                                <input type="number" class="form-control" name='no_of_days' placeholder="<?php echo lang::get('lang.enter_no_of_days'); ?>" min='1'>
                                <button type="submit" class="btn btn-primary"><?php echo Lang::get('lang.submit'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/notification.blade.php ENDPATH**/ ?>