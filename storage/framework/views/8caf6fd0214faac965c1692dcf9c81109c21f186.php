<?php $__env->startSection('Dashboard'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('dashboard-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('profile'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.view-profile')); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('profileimg'); ?>
<img src="<?php echo e(Auth::user()->profile_pic); ?>" class="img-circle" alt="User Image" width="100%"/>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><b><?php echo Lang::get('lang.profile'); ?></b>&nbsp;&nbsp;<a href="<?php echo e(URL::route('agent-profile-edit')); ?>"><i class="fa fa-fw fa-edit"> </i></a></h3>
        <?php if(Session::has('success')): ?>
        <br><br>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('success')); ?>

        </div>
        <?php endif; ?>
        <!-- fail message -->
        <?php if(Session::has('fails')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?> !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('fails')); ?>

        </div>
        <?php endif; ?>
    </div>
    <?php
    if ($user->primary_dpt) {
        $dept = App\Model\helpdesk\Agent\Department::where('id', '=', $user->primary_dpt)->first();
        $dept = $dept->name;
    } else {
        $dept = "";
    }
    if ($user->assign_group) {
        $grp = App\Model\helpdesk\Agent\Groups::where('id', '=', $user->assign_group)->first();
        $grp = $grp->name;
    } else {
        $grp = "";
    }
    if ($user->agent_tzone) {
        $timezone = App\Model\helpdesk\Utility\Timezones::where('id', '=', $user->agent_tzone)->first();
        $timezone = $timezone->name;
    } else {
        $timezone = "";
    }
    ?>
    <div class="row">
        <div class="col-md-6">
            <div class="box-header  with-border">
                <h3 class="box-title"><b><?php echo Lang::get('lang.user_information'); ?></b></h3>
            </div>
            <div class="box-body">
                <div class="form-group row">
                    <?php if($user->gender == 1): ?>
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.gender'); ?>:</label></div> <div class='col-xs-7'><?php echo e('Male'); ?></div>
                    <?php else: ?>
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.gender'); ?>:</label></div> <div class='col-xs-7'><?php echo e('Female'); ?></div>
                    <?php endif; ?>
                </div>
                <div class="form-group  row">
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.department'); ?>:</label></div> <div class='col-xs-7'> <?php echo e($dept); ?></div>
                </div>
                <div class="form-group  row">
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.group'); ?>:</label></div> <div class='col-xs-7'> <?php echo e($grp); ?></div>
                </div>
                <div class="form-group  row">
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.company'); ?>:</label></div> <div class='col-xs-7'> <?php echo e($user->company); ?></div>
                </div>
                <div class="form-group  row">
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.role'); ?>:</label></div> <div class='col-xs-7'>  <?php echo e($user->role); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box-header  with-border">
                <h3 class="box-title"><b><?php echo Lang::get('lang.contact_information'); ?></b></h3>
            </div>
            <div class="box-body">
                <div class="form-group row">
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.email'); ?>:</label></div> <div class='col-xs-7'> <?php echo e($user->email); ?></div>
                </div>
                <div class="form-group row">
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.phone_number'); ?>:</label></div> <div class='col-xs-7'> <?php echo e($user->ext); ?><?php echo e($user->phone_number); ?></div>
                </div>
                <div class="form-group row">
                    <div class='col-xs-4'><label><?php echo Lang::get('lang.mobile'); ?>:</label></div> <div class='col-xs-7'> <?php echo e($user->mobile); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.agent.layout.agent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/agent/helpdesk/user/profile.blade.php ENDPATH**/ ?>