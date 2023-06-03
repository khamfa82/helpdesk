<?php $__env->startSection('Manage'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('manage-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('url'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo Lang::get('lang.url'); ?></h1>
<?php $__env->stopSection(); ?>
<!-- /header -->
<!-- breadcrumbs -->
<?php $__env->startSection('breadcrumbs'); ?>
<ol class="breadcrumb">
</ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo Form::open(['url' => 'url/settings', 'method' => 'PATCH']); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">URL Settings</h3>
    </div>

    <div class="box-body table-responsive">
        <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
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
            <b><?php echo Lang::get('lang.alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('fails'); ?>

        </div>
        <?php endif; ?>
        
        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                <?php echo Form::label('www','WWW/non-WWW'); ?>

                </div>
                <div class="col-md-4 ">
                    <p> <?php echo Form::radio('www','yes',$www['www'],['class'=>'option']); ?> WWW</p>
                </div>
                <div class="col-md-4">
                    <p> <?php echo Form::radio('www','no',$www['nonwww'],['class'=>'option']); ?> Non WWW</p>
                </div>
            </div>
 

            <div class="col-md-6 form-group">
                <div class="form-group">
                <?php echo Form::label('option','SSl'); ?>

                </div>
                <div class="col-md-4">
                    <p> <?php echo Form::radio('ssl','yes',$https['https'],['class'=>'option']); ?> HTTPS</p>
                </div>
                <div class="col-md-4">
                    <p> <?php echo Form::radio('ssl','no',$https['http'],['class'=>'option']); ?> HTTP</p>
                </div>
            </div>
        </div>
       
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary']); ?>

    </div>
</div>
<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/url/settings.blade.php ENDPATH**/ ?>