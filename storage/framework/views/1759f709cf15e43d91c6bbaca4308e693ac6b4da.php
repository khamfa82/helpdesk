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
<div class="box box-primary">
    <div class="box-header">
        <h2 class="box-title"><?php echo Lang::get('lang.list_of_departments'); ?></h2><a href="<?php echo e(route('departments.create')); ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo e(Lang::get('lang.create_a_department')); ?></a></div>
    <div class="box-body table-responsive ">
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
            <b><?php echo Lang::get('lang.fails'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('fails'); ?>

        </div>
        <?php endif; ?>
        <!-- table -->
        <table class="table table-bordered dataTable" style="overflow:hidden;">
            <tr>
                <th><?php echo e(Lang::get('lang.name')); ?></th>
                <th><?php echo e(Lang::get('lang.type')); ?></th>
                <th><?php echo e(Lang::get('lang.sla_plan')); ?></th>
                <th><?php echo e(Lang::get('lang.department_manager')); ?></th>
                <th><?php echo e(Lang::get('lang.action')); ?></th>
            </tr>
            <?php
            $default_department = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
            $default_department = $default_department->department;
            ?>
            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><a href="<?php echo e(route('departments.edit', $department->id)); ?>"> <?php echo e($department -> name); ?>

                        <?php if($default_department == $department->id): ?>
                        ( Default )
                        <?php
                        $disable = 'disabled';
                        ?>
                        <?php else: ?>
                        <?php
                        $disable = '';
                        ?>
                        <?php endif; ?>
                    </a></td>
                <td>
                    <?php if($department->type=='1'): ?>
                    <span style="color:green"><?php echo Lang::get('lang.public'); ?></span>
                    <?php else: ?>
                    <span style="color:red"><?php echo Lang::get('lang.private'); ?></span>
                    <?php endif; ?>
                </td>
                <?php
                if ($department->manager == 0) {
                    $manager = "";
                } else {
                    $manager = App\User::whereId($department->manager)->first();
                    $manager = $manager->full_name;
                }

                if ($department->sla == null) {
                    $sla = "";
                } else {
                    $sla = App\Model\helpdesk\Manage\Sla_plan::whereId($department->sla)->first();
                    $sla = $sla->grace_period;
                }
                ?>

                <td><?php echo e($sla); ?></td>
                <td><?php echo e($manager); ?></td>
                <td>
                    <?php echo Form::open(['route'=>['departments.destroy', $department->id],'method'=>'DELETE']); ?>

                    <a href="<?php echo e(route('departments.edit', $department->id)); ?>" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> <?php echo Lang::get('lang.edit'); ?></a>
                    
                    
                    <!-- To pop up a confirm Message -->
                    <?php echo Form::button('<i class="fa fa-trash" style="color:black;"> </i> '.Lang::get('lang.delete'),
                    ['type' => 'submit',
                    'class'=> 'btn btn-warning btn-xs btn-flat '.$disable,
                    'onclick'=>'return confirm("Are you sure?")']); ?>

                    

                    <?php echo Form::close(); ?>

                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/agent/departments/index.blade.php ENDPATH**/ ?>