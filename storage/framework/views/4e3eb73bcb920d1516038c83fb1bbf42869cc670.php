<?php $__env->startSection('Users'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('user-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('organizations'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo Lang::get('lang.organization'); ?></h1>
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
<?php echo Form::open(['action'=>'Agent\helpdesk\OrganizationController@store','method'=>'post']); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(Lang::get('lang.create')); ?></h4>
    </div>
    <div class="box-body">
        <?php if(Session::has('errors')): ?>
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            <?php if($errors->first('name')): ?>
            <li class="error-message-padding"><?php echo $errors->first('name', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('phone')): ?>
            <li class="error-message-padding"><?php echo $errors->first('phone', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('website')): ?>
            <li class="error-message-padding"><?php echo $errors->first('website', ':message'); ?></li>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <!-- name : text : Required -->
        <div class="row">
            <div class="col-xs-4 form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                <?php echo Form::label('name',Lang::get('lang.name')); ?> <span class="text-red"> *</span>
                <?php echo Form::text('name',null,['class' => 'form-control']); ?>

            </div>
            <!-- phone : Text : -->
            <div class="col-xs-4 form-group <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
                <?php echo Form::label('phone',Lang::get('lang.phone')); ?>

                <?php echo Form::text('phone',null,['class' => 'form-control']); ?>

            </div>
            <!-- website : Text :  -->
            <div class="col-xs-4 form-group <?php echo e($errors->has('website') ? 'has-error' : ''); ?>">
                <?php echo Form::label('website',Lang::get('lang.website')); ?>

                <?php echo Form::text('website',null,['class' => 'form-control']); ?>

            </div>
        </div>
        <!-- Internal Notes : Textarea -->
        <div class="row">
            <div class="col-xs-6 form-group">
                <?php echo Form::label('address',Lang::get('lang.address')); ?>

                <?php echo Form::textarea('address',null,['class' => 'form-control']); ?>

            </div>
            <div class="col-xs-6 form-group">
                <?php echo Form::label('internal_notes',Lang::get('lang.internal_notes')); ?>

                <?php echo Form::textarea('internal_notes',null,['class' => 'form-control']); ?>

            </div>
        </div>
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary']); ?>

    </div>
</div>
<script type="text/javascript">
    $(function() {
        $("textarea").wysihtml5();
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.agent.layout.agent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/agent/helpdesk/organization/create.blade.php ENDPATH**/ ?>