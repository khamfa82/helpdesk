<?php $__env->startSection('Staffs'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('staffs-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('organizations'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.organizations')); ?> </h1>
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
        <h2 class="box-title"><?php echo Lang::get('lang.list_of_organizations'); ?> </h2><a href="<?php echo e(route('organizations.create')); ?>" class="btn btn-primary pull-right">
        <span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo Lang::get('lang.create_organization'); ?></a></div>
    <div class="box-body table-responsive">
        <?php
        $users = App\User::where('role', '!=', 'user')->orderBy('id', 'ASC')
            // ->paginate(50);
            ->get();
//	dd($users);
        ?>
        <!-- check whether success or not -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('success')); ?>

        </div>
        <?php endif; ?>
        <!-- failure message -->
        <?php if(Session::has('fails')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.fails'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('fails')); ?>

        </div>
        <?php endif; ?>
        <!-- Warning Message -->
        <?php if(Session::has('warning')): ?>
        <div class="alert alert-warning alert-dismissable">
            <i class="fa fa-warning"></i>
            <b><?php echo Lang::get('lang.warning'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('warning')); ?>

        </div>
        <?php endif; ?>
        <!-- Agent table -->
        <!-- <table class="table table-bordered dataTable" style="overflow:hidden;"> -->
        <table class="table table-hover table-striped dataTable">
            <thead>
                <tr>
                    <th width="100px">S/N</th>
                    <th width="100px"><?php echo e(Lang::get('lang.name')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.phone')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.website')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.address')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.action')); ?></th>
                </tr>
            </thead>
            <?php $sn = 1; ?>
            <tbody>
            <?php $__currentLoopData = $organizations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(auth()->user()->role == 'admin' || auth()->user()->role == 'agent'): ?>
                    <tr>
                        <td><?php echo e($sn++); ?></td>
                        <td><a href="<?php echo e(route('organizations.edit', $organization->id)); ?>"> <?php echo $organization->name; ?></a></td>
                        <td><?php echo e($organization->phone); ?></td>
                        <td><?php echo e($organization->website); ?></td>
                        <td><?php echo e($organization->address); ?></td>
                       
                        <td>
                            <?php echo Form::open(['route'=>['organizations.destroy', $organization->id],'method'=>'DELETE']); ?>

                            <a href="<?php echo e(route('organizations.edit', $organization->id)); ?>" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> <?php echo Lang::get('lang.edit'); ?> </a>
                            
                            
                            <?php echo Form::close(); ?>

                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="pull-right" style="margin-top : -10px; margin-bottom : -10px;">
            <?php /* {!! $organization->links() !!} */ ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/agent/helpdesk/organization/index.blade.php ENDPATH**/ ?>