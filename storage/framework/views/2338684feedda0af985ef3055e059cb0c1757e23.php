<?php $__env->startSection('Staffs'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('staffs-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('agents'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.agents')); ?> </h1>
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
        <h2 class="box-title"><?php echo Lang::get('lang.list_of_agents'); ?> </h2><a href="<?php echo e(route('agents.create')); ?>" class="btn btn-primary pull-right">
        <span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo Lang::get('lang.create_an_agent'); ?></a></div>
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
                    <th width="10px">S/N</th>
                    <th width="100px"><?php echo e(Lang::get('lang.name')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.user_name')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.role')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.management_level')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.all_emails')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.status')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.group')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.organization')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.department')); ?></th>
                    <th width="100px"><?php echo e(Lang::get('lang.created')); ?></th>
                    
                    <th width="100px"><?php echo e(Lang::get('lang.action')); ?></th>
                </tr>
            </thead>
            <?php $sn = 1; ?>
            <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $use): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($use->role == 'admin' || $use->role == 'agent'): ?>
                    <tr>
                        <td><?php echo e($sn++); ?></td>
                        <td><a href="<?php echo e(route('agents.edit', $use->id)); ?>"> <?php echo $use->first_name; ?> <?php echo " ". $use->last_name; ?></a></td>
                        <td><a href="<?php echo e(route('agents.edit', $use->id)); ?>"> <?php echo $use->user_name; ?></td>
                        <?php
                            if ($use->role == 'admin') {
                                echo '<td><button class="btn btn-success btn-xs">' . Lang::get('lang.admin') . '</button></td>';
                            } elseif ($use->role == 'agent') {
                                echo '<td><button class="btn btn-primary btn-xs">' . Lang::get('lang.agent') . '</button></td>';
                            }
                        ?>
                        <td><?php echo e(Lang::get('lang.level')); ?> <?php echo e($use->management_level); ?></td>
                        <td>
                            <?php if($use->all_emails && $use->role == 'admin'): ?>
                                <button class="btn btn-success btn-xs"> <?php echo e(Lang::get('lang.yes')); ?> </button>
                            <?php else: ?>
                                <button class="btn btn-warning btn-xs"> <?php echo e(Lang::get('lang.no')); ?> </button>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($use->active=='1'): ?>
                            <span style="color:green"><?php echo Lang::get('lang.active'); ?></span>
                            <?php else: ?>
                            <span style="color:red"><?php echo Lang::get('lang.inactive'); ?></span>
                            <?php endif; ?>
                            <?php
                            $group = App\Model\helpdesk\Agent\Groups::whereId($use->assign_group)->first();
                            $department = App\Model\helpdesk\Agent\Department::whereId($use->primary_dpt)->first();
                            $organization = App\Model\helpdesk\Agent_panel\Organization::whereId($use->organization_id)->first();
                            ?>
                        <td><?php echo e($group->name); ?></td>
                        <td><?php echo e($organization->name ?? "N/A"); ?></td>
                        <td><?php echo e($department->name); ?></td>
                        <td><?php echo e(UTC::usertimezone($use->created_at)); ?></td>
                        
                        <td>
                            <?php echo Form::open(['route'=>['agents.destroy', $use->id],'method'=>'DELETE']); ?>

                            <a href="<?php echo e(route('agents.edit', $use->id)); ?>" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> <?php echo Lang::get('lang.edit'); ?> </a>
                            <!-- To pop up a confirm Message -->
                            <a href="<?php echo e(route('agents.reset_password', $use->id)); ?>" class="btn btn-warning btn-xs btn-flat"><i class="fa fa-key" style="color:black;"> </i> Reset Password </a>

                            
                            <?php echo Form::close(); ?>

                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
        <div class="pull-right" style="margin-top : -10px; margin-bottom : -10px;">
            <?php /* {!! $user->links() !!} */ ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/agent/agents/index.blade.php ENDPATH**/ ?>