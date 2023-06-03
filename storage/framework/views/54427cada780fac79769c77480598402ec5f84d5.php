<?php $__env->startSection('Tickets'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('status'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo Lang::get('lang.settings'); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumbs'); ?>
<ol class="breadcrumb">
</ol>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.list_of_status'); ?></h3>
    </div><!-- /.box-header -->
    <div class="box-body">

        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('success')); ?>

        </div>
        <?php endif; ?>
        <?php if(Session::has('failed')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?> !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <p><?php echo e(Session::get('failed')); ?></p>                
        </div>
        <?php endif; ?>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><?php echo Lang::get('lang.name'); ?></th>
                    <th><?php echo Lang::get('lang.display_order'); ?></th>
                    <th><?php echo Lang::get('lang.action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $statuss; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if ($status->name == 'Deleted') continue; ?>
                <tr>
                    <td><?php echo $status->name; ?></td>
                    <td><?php echo $status->sort; ?></td>
                    <td>
                        <a href="<?php echo route('status.edit',$status->id); ?>"><button class="btn btn-info btn-sm"><?php echo Lang::get('lang.edit_details'); ?></button></a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div><!-- /.box-body -->
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/status.blade.php ENDPATH**/ ?>