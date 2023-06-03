<?php $__env->startSection('Staffs'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('staffs-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('departments'); ?>
class="active"
<?php $__env->stopSection(); ?>


<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.departments')); ?></h1>
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
<?php echo Form::open(array('action' => 'Admin\helpdesk\DepartmentController@store' , 'method' => 'post') ); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.create_a_department'); ?></h3>	
    </div>
    <div class="box-body">
        <?php if(Session::has('errors')): ?>
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            <?php if($errors->first('name')): ?>
            <li class="error-message-padding"><?php echo $errors->first('name', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('account_status')): ?>
            <li class="error-message-padding"><?php echo $errors->first('account_status', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('sla')): ?>
            <li class="error-message-padding"><?php echo $errors->first('sla', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('manager')): ?>
            <li class="error-message-padding"><?php echo $errors->first('manager', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('outgoing_email')): ?>
            <li class="error-message-padding"><?php echo $errors->first('outgoing_email', ':message'); ?></li>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="row">
            <!-- name -->
            <div class="col-xs-6 form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                <?php echo Form::label('name',Lang::get('lang.name')); ?>  <span class="text-red"> *</span>
                <?php echo Form::text('name',null,['class' => 'form-control']); ?>

            </div>
            <!-- account status -->
            <div class="col-xs-6 form-group <?php echo e($errors->has('account_status') ? 'has-error' : ''); ?>">
                <?php echo Form::label('type',Lang::get('lang.type')); ?>

                <div class="row">
                    <div class="col-xs-2">
                        <?php echo Form::radio('type','1',true); ?> <?php echo e(Lang::get('lang.public')); ?>

                    </div>
                    <div class="col-xs-3">
                        <?php echo Form::radio('type','0',null); ?> <?php echo e(Lang::get('lang.private')); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- slaplan -->
            <div class="col-xs-6 form-group <?php echo e($errors->has('sla') ? 'has-error' : ''); ?>">
                <?php echo Form::label('sla',Lang::get('lang.SLA_plan')); ?>

                <?php echo Form::select('sla', [''=>Lang::get('lang.select_a_sla'), Lang::get('lang.sla_plans')=>$slas->pluck('grace_period','id')->toArray()],null,['class' => 'form-control select']); ?>

            </div>
            <!-- manager -->
            <div class="col-xs-6 form-group <?php echo e($errors->has('manager') ? 'has-error' : ''); ?>">
                <?php echo Form::label('manager',Lang::get('lang.manager')); ?>

                <?php echo Form::select('manager',[''=>Lang::get('lang.select_a_manager'),Lang::get('lang.manager')=>$user->pluck('full_name','id')->toArray()],null,['class' => 'form-control select']); ?>

            </div>
        </div>
    </div>
    <div class="box-header with-border">
        <h4 class="box-title"><?php echo Lang::get('lang.outgoing_email_settings'); ?></h4>
    </div>
    <div class="box-body">
        <div class="row">
            <!-- sla -->
            <div class="col-xs-6 form-group <?php echo e($errors->has('outgoing_email') ? 'has-error' : ''); ?>">
                <?php echo Form::label('outgoing_email',Lang::get('lang.outgoing_email')); ?>

                <?php echo Form::select('outgoing_email', ['' => Lang::get('lang.system_default'), Lang::get('lang.emails')=>$emails->pluck('email_name','id')->toArray()],null,['class' => 'form-control select']); ?>

            </div>
        </div>
        <div class="form-group">
            <input type="checkbox" name="sys_department"> <?php echo e(Lang::get('lang.make-default-department')); ?>

        </div>
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary']); ?>    
    </div>
    <?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/agent/departments/create.blade.php ENDPATH**/ ?>