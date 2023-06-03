<?php $__env->startSection('Tickets'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('tickets-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('auto-response'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.settings')); ?></h1>
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
<?php echo Form::model($responders,['url' => 'postresponder/'.$responders->id, 'method' => 'PATCH']); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(Lang::get('lang.auto_responce-settings')); ?></h3> 
    </div>
    <!-- New Ticket: CHECKBOX	 Ticket Owner   -->
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
            <b><?php echo lang::get('lang.alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('fails'); ?>

        </div>
        <?php endif; ?>
        <div class="form-group">
            <?php echo Form::checkbox('new_ticket',1); ?> &nbsp;
            <?php echo Form::label('new_ticket',Lang::get('lang.new_ticket')); ?>

        </div>
        <!-- New Ticket by Agent: CHECKBOX	 Ticket Owner   -->
        <div class="form-group">
            <?php echo Form::checkbox('agent_new_ticket',1); ?>&nbsp;
            <?php echo Form::label('agent_new_ticket',Lang::get('lang.new_ticket_by_agent')); ?>

        </div>
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary']); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/responder.blade.php ENDPATH**/ ?>