<?php $__env->startSection('Manage'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('manage-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('forms'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.manage')); ?></h1>
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

<?php if(Session::has('success')): ?>
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo e(Session::get('success')); ?>

</div>
<?php endif; ?>
<div class="box">
    <div class="box-header">
        <div class="box-title">
            <?php echo Lang::get('lang.forms'); ?>

        </div>
        <a href="<?php echo url('forms/create'); ?>" class="pull-right"><button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo Lang::get('lang.create_form'); ?></button></a> 
    </div>
    <div class="box-body">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><?php echo Lang::get('lang.form_name'); ?></th>
                    <th><?php echo Lang::get('lang.action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $forms = App\Model\helpdesk\Form\Forms::all();
                ?>
                <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $form->formname; ?></td>
                    <td>
                        <div class="btn-group">
                            <?php echo link_to_route('forms.edit', Lang::get('lang.edit') ,[$form->id],['id'=>'View','class'=>'btn btn-primary btn-sm']); ?>

                        </div>
                        <div class="btn-group">
                            <?php echo link_to_route('forms.show', Lang::get('lang.view_this_form') ,[$form->id],['id'=>'View','class'=>'btn btn-primary btn-sm']); ?>

                        </div>
                        <div class="btn-group">
                            <?php echo link_to_route('forms.add.child', 'Add Child' ,[$form->id],['id'=>'add-child','class'=>'btn btn-primary btn-sm']); ?>

                        </div>
                        <div class="btn-group">
                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#<?php echo e($form->id); ?>delete"><?php echo Lang::get('lang.delete_from'); ?></button>
                        </div>
                        <div class="modal fade" id="<?php echo e($form->id); ?>delete">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><?php echo Lang::get('lang.delete'); ?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <p><?php echo Lang::get('lang.are_you_sure_you_want_to_delete'); ?> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php echo Lang::get('lang.close'); ?></button>
                                        <?php echo link_to_route('forms.delete', Lang::get('lang.delete'),[$form->id],['id'=>'delete','class'=>'btn btn-danger btn-sm']); ?>

                                    </div>
                                </div> 
                            </div> 
                        </div> 
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table> 
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/manage/form/index.blade.php ENDPATH**/ ?>