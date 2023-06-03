<?php $__env->startSection('Themes'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('theme-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('socail'); ?>
class="active"
<?php $__env->stopSection(); ?>
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo Lang::get('lang.widgets'); ?></h1>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h4 class="box-title"><?php echo Lang::get('lang.social-widget-settings'); ?> </h4>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('success')); ?>

        </div>
        <?php endif; ?>
        <!-- failure message -->
        <?php if(Session::has('fails')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?> !</b> 
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('fails')); ?>

        </div>
        <?php endif; ?>
        <?php echo Datatable::table()
        ->addColumn(Lang::get('lang.name'),
        Lang::get('lang.link'),
        Lang::get('lang.action'))  // these are the column headings to be shown
        ->setUrl('list-social-buttons')  // this is the route where data will be retrieved
        ->render(); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/theme/social.blade.php ENDPATH**/ ?>