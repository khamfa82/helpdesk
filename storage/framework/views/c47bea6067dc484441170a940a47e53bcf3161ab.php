<?php $__env->startSection('Emails'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('settings-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('email'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.emails')); ?></h1>
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
<?php echo Form::model($emails,['url' => 'postemail/'.$emails->id, 'method' => 'PATCH']); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(Lang::get('lang.email-settings')); ?></h3>             
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('success'); ?>

        </div>
        <?php endif; ?>
        <!-- failure message -->
        <?php if(Session::has('fails')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo lang::get('lang.success'); ?> !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('fails'); ?>

        </div>
        <?php endif; ?>
        <?php if(Session::has('errors')): ?>
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            <?php if($errors->first('sys_email')): ?>
            <li class="error-message-padding"><?php echo $errors->first('sys_email', ':message'); ?></li>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="row">
        </div>
        <!-- Accept All Emails:	CHECKBOX: Accept email from unknown Users  -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?php echo Form::checkbox('all_emails',1,true); ?>&nbsp;<?php echo e(Lang::get('lang.accept_all_email')); ?>

                </div>
            </div>
        </div>
        <!-- Admin's Email Address:	  Text : Required  -->
        <div class="row">
        </div>
        <!-- Accept Email Collaborators: CHECKBOX : Automatically add collaborators from email fields   -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo Form::checkbox('email_collaborator',1); ?>&nbsp;<?php echo e(Lang::get('lang.accept_email_collab')); ?>

                </div>
            </div>
        </div>
        <!-- Attachments: CHECKBOX	: Email attachments to the user  -->
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo Form::checkbox('attachment',1); ?>&nbsp;<?php echo e(Lang::get('lang.attachments')); ?>

                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary']); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/email.blade.php ENDPATH**/ ?>