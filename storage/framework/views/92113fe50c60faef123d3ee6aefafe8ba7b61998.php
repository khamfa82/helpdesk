<?php $__env->startSection('Settings'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('settings-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('languages'); ?>
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
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title"><?php echo e(Lang::get('lang.language-settings')); ?></h2><span class="pull-right"><a href="<?php echo e(route('download')); ?>" title="click here to download template file" class="btn btn-primary"><i class="fa fa-download"></i> <?php echo e(Lang::get('lang.download')); ?> </a> <a href="<?php echo e(route('add-language')); ?>" class="btn btn-primary "><i class="fa fa-plus"></i> <?php echo e(Lang::get('lang.add')); ?></a></span>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('success')); ?> <?php if(Session::has('link')): ?><a href="<?php echo e(url(Session::get('link'))); ?>"><?php echo e(Lang::get('lang.enable_lang')); ?></a> <?php endif; ?>
        </div>
        <?php endif; ?>
        <!-- failure message -->
        <?php if(Session::has('fails')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('fails')); ?>

        </div>
        <?php endif; ?>
        <?php echo Datatable::table()
        ->addColumn(Lang::get('lang.language'),Lang::get('lang.native-name'),Lang::get('lang.iso-code'),Lang::get('lang.system-language'),Lang::get('lang.Action'))       // these are the column headings to be shown
        ->setUrl(route('getAllLanguages'))   // this is the route where data will be retrieved
        ->render(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/language/index.blade.php ENDPATH**/ ?>