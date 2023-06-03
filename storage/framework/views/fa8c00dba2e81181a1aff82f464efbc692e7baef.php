<?php $__env->startSection('Settings'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('security'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo Lang::get('lang.settings'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.security_settings'); ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('success'); ?>

        </div>
        <?php endif; ?>
        <?php if(Session::has('failed')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang/alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p><?php echo e(Session::get('failed')); ?></p>                
        </div>
        <?php endif; ?>
        <?php if(Session::has('errors')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            <?php if($errors->first('lockout_message')): ?>
            <li class="error-message-padding"><?php echo $errors->first('lockout_message', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('backlist_threshold')): ?>
            <li class="error-message-padding"><?php echo $errors->first('backlist_threshold', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('lockout_period')): ?>
            <li class="error-message-padding"><?php echo $errors->first('lockout_period', ':message'); ?></li>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php echo Form::model($security,['route'=>['securitys.update', $security->id],'method'=>'PATCH','files' => true]); ?>

        <div class="form-group <?php echo e($errors->has('lockout_message') ? 'has-error' : ''); ?>">
            <div class="row">
                <div class="col-md-3">
                    <label for="title">Lockout Message: <span class="text-red"> *</span></label>
                </div>
                <div  class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;"><?php echo Lang::get('lang.security_msg1'); ?></div>
                    <?php echo Form::textarea('lockout_message',null,['class'=>'form-control']); ?>

                </div>
            </div>
        </div>
        <div class="form-group <?php echo e($errors->has('backlist_threshold') ? 'has-error' : ''); ?>">
            <div class="row">
                <div class="col-md-3">
                    <label for="title"><?php echo Lang::get('lang.max_attempt'); ?>: <span class="text-red"> *</span></label>
                </div>
                <div class="col-md-9">
                    <div class="callout callout-default" style="font-style: oblique;"><?php echo Lang::get('lang.security_msg2'); ?></div>
                    <span><?php echo Form::text('backlist_threshold',null,['class'=>'form-control']); ?> <?php echo Lang::get('lang.lockouts'); ?></span>
                </div>     
            </div>
        </div>
        <div class="form-group <?php echo e($errors->has('lockout_period') ? 'has-error' : ''); ?>"> 
            <div class="row">
                <div class="col-md-3">
                    <label for="title">Lockout Period: <span class="text-red"> *</span></label>
                </div>
                <div class="col-md-8">
                    <div class="callout callout-default" style="font-style: oblique;"><?php echo Lang::get('lang.security_msg3'); ?></div>
                    <span> <?php echo Form::text('lockout_period',null,['class'=>'form-control']); ?> <?php echo Lang::get('lang.minutes'); ?></span>
                </div>
            </div>
        </div>
    </div><!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-primary"><?php echo lang::get('lang.submit'); ?></button>
    </div>
    <?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/security/index.blade.php ENDPATH**/ ?>