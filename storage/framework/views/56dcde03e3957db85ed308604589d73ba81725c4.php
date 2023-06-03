<?php $__env->startSection('Tickets'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('tickets-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('alert'); ?>
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
<?php echo Form::model($alerts,['url' => 'postalert/'.$alerts->id, 'method' => 'PATCH']); ?>

<div class="box box-primary">
    <div class="box-header">
        <h4 class="box-title"><?php echo e(Lang::get('lang.alert_notices_setitngs')); ?></h4> <?php echo Form::submit(Lang::get('lang.submit'),['class'=>' btn btn-primary pull-right']); ?>

    </div>

</div>
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
    <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <b><?php echo lang::get('lang.alert'); ?>!</b><br/>
    <?php echo Session::get('fails'); ?>

</div>
<?php endif; ?>
<div class="row">
    <!-- left column -->
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo e(Lang::get('lang.new_ticket_alert')); ?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-group">
                    <!-- Status:     Enable   Disable     -->
                    <?php echo Form::label('ticket_status',Lang::get('lang.status').":"); ?>&nbsp;&nbsp;
                    <?php echo Form::radio('ticket_status',1); ?> <?php echo Lang::get('lang.enable'); ?> &nbsp;&nbsp; <?php echo Form::radio('ticket_status',0); ?>  <?php echo Lang::get('lang.disable'); ?>

                </div>
                <div class="form-group">
                    <!-- Admin Email -->
                    <?php echo Form::checkbox('ticket_admin_email',1); ?>

                    <?php echo Form::label('ticket_admin_email',Lang::get('lang.admin_email_2')); ?>

                </div>
                <!-- Department Members -->
                <div class="form-group">
                    <?php echo Form::checkbox('ticket_department_member',1); ?>

                    <?php echo Form::label('ticket_department_member',Lang::get('lang.department_members')); ?>

                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
        <!-- /.box -->
    </div><!--/.col (left) -->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo e(Lang::get('lang.ticket_assignment_alert')); ?></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <!-- Status:     Enable      Disable      -->
                <div class="form-group">
                    <?php echo Form::label('assignment_status',Lang::get('lang.status').":"); ?>

                    <?php echo Form::radio('assignment_status',1); ?> <?php echo Lang::get('lang.enable'); ?> &nbsp;&nbsp; <?php echo Form::radio('assignment_status',0); ?>  <?php echo Lang::get('lang.disable'); ?>

                </div>
                <!-- Assigned Agent / Team -->
                <div class="form-group">
                    <?php echo Form::checkbox('assignment_assigned_agent',1); ?>

                    <?php echo Form::label('assignment_assigned_agent',Lang::get('lang.agent')); ?>

                </div>
                <!-- Team Members -->
                <div class="form-group">
                    <?php echo Form::checkbox('assignment_team_member',1); ?>

                    <?php echo Form::label('assignment_team_member',Lang::get('lang.team_members')); ?>

                </div>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!--/.col (left) -->
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/alert.blade.php ENDPATH**/ ?>