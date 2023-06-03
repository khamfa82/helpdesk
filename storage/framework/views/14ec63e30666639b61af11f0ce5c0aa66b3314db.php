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
<h1><?php echo e(Lang::get('lang.agents')); ?></h1>
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
<?php echo Form::open(array('action' => 'Admin\helpdesk\AgentController@store' , 'method' => 'post') ); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.create_an_agent'); ?></h3>	
    </div>
    <div class="box-body">
        <?php if(Session::has('errors')): ?>
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            <?php if($errors->first('user_name')): ?>
            <li class="error-message-padding"><?php echo $errors->first('user_name', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('first_name')): ?>
            <li class="error-message-padding"><?php echo $errors->first('first_name', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('last_name')): ?>
            <li class="error-message-padding"><?php echo $errors->first('last_name', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('email')): ?>
            <li class="error-message-padding"><?php echo $errors->first('email', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('ext')): ?>
            <li class="error-message-padding"><?php echo $errors->first('ext', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('phone_number')): ?>
            <li class="error-message-padding"><?php echo $errors->first('phone_number', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('country_code')): ?>
            <li class="error-message-padding"><?php echo $errors->first('country_code', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('mobile')): ?>
            <li class="error-message-padding"><?php echo $errors->first('mobile', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('active')): ?>
            <li class="error-message-padding"><?php echo $errors->first('active', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('role')): ?>
            <li class="error-message-padding"><?php echo $errors->first('role', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('group')): ?>
            <li class="error-message-padding"><?php echo $errors->first('group', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('primary_department')): ?>
            <li class="error-message-padding"><?php echo $errors->first('primary_department', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('agent_time_zone')): ?>
            <li class="error-message-padding"><?php echo $errors->first('agent_time_zone', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('team')): ?>
            <li class="error-message-padding"><?php echo $errors->first('team', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('organization')): ?>
            <li class="error-message-padding"><?php echo $errors->first('organization', ':message'); ?></li>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php if(Session::has('fails2')): ?>
            <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b>Alert!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
                <li class="error-message-padding"><?php echo Session::get('fails2'); ?></li>
            </div>
        <?php endif; ?>
        <div class="row">
            <!-- username -->
            <div class="col-xs-3 form-group <?php echo e($errors->has('user_name') ? 'has-error' : ''); ?>">
                <?php echo Form::label('user_name',Lang::get('lang.user_name')); ?> <span class="text-red"> *</span>
                <?php echo Form::text('user_name',null,['class' => 'form-control']); ?>

            </div>
            <!-- firstname -->
            <div class="col-xs-3 form-group <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
                <?php echo Form::label('first_name',Lang::get('lang.first_name')); ?> <span class="text-red"> *</span>
                <?php echo Form::text('first_name',null,['class' => 'form-control']); ?>

            </div>
            <!-- lastname -->
            <div class="col-xs-3 form-group <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
                <?php echo Form::label('last_name',Lang::get('lang.last_name')); ?> <span class="text-red"> *</span>
                <?php echo Form::text('last_name',null,['class' => 'form-control']); ?>

            </div>
            <!-- organization -->
            <div class="col-xs-3 form-group <?php echo e($errors->has('organization') ? 'has-error' : ''); ?>">
                <?php echo Form::label('organization',Lang::get('lang.organization')); ?> <span class="text-red"> *</span>
                <?php echo Form::select('organization',[''=>Lang::get('lang.select_an_organization'),Lang::get('lang.organizations')=>$organizations->pluck('name','id')->toArray()],null,['class' => 'form-control select2']); ?>

            </div>
        </div>
        <div class="row">
            <!-- email address -->
            <div class="col-xs-4 form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
                <?php echo Form::label('email',Lang::get('lang.email_address')); ?> <span class="text-red"> *</span>
                <?php echo Form::email('email',null,['class' => 'form-control']); ?>

            </div>
            <div class="col-xs-1 form-group <?php echo e($errors->has('ext') ? 'has-error' : ''); ?>">
                <label for="ext"><?php echo Lang::get('lang.ext'); ?></label>	
                <?php echo Form::text('ext',null,['class' => 'form-control']); ?>

            </div>
            <!--country code-->
            <div class="col-xs-1 form-group <?php echo e($errors->has('country_code') ? 'has-error' : ''); ?>">

                <?php echo Form::label('country_code',Lang::get('lang.country-code')); ?> <?php if($send_otp->status ==1): ?><span class="text-red"> *</span><?php endif; ?>
                <?php echo Form::text('country_code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]); ?>


            </div>
            <!-- phone -->
            <div class="col-xs-3 form-group <?php echo e($errors->has('phone_number') ? 'has-error' : ''); ?>">
                <?php echo Form::label('phone_number',Lang::get('lang.phone')); ?>

                <?php echo Form::text('phone_number',null,['class' => 'form-control']); ?>

            </div>
            <!-- Mobile -->
            <div class="col-xs-3 form-group <?php echo e($errors->has('mobile') ? 'has-error' : ''); ?>">
                <?php echo Form::label('mobile',Lang::get('lang.mobile_number')); ?><?php if($send_otp->status ==1): ?><span class="text-red"> *</span><?php endif; ?>
                <?php echo Form::input('number', 'mobile',null,['class' => 'form-control']); ?>

            </div>
        </div>
        <div>
            <h4><?php echo Lang::get('lang.agent_signature'); ?></h4>
        </div>
        <div class="">
            <?php echo Form::textarea('agent_sign',null,['class' => 'form-control','size' => '30x5']); ?>

        </div>
        <div>
            <h4><?php echo e(Lang::get('lang.account_status_setting')); ?></h4>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <!-- acccount type -->
                <div class="form-group <?php echo e($errors->has('active') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('active',Lang::get('lang.status')); ?>

                    <div class="row">
                        <div class="col-xs-3">
                            <?php echo Form::radio('active','1',true); ?> <?php echo e(Lang::get('lang.active')); ?>

                        </div>
                        <div class="col-xs-3">
                            <?php echo Form::radio('active','0',null); ?> <?php echo e(Lang::get('lang.inactive')); ?>

                        </div>
                    </div>
                </div>
                <!-- Role -->
                <div class="form-group <?php echo e($errors->has('role') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('role',Lang::get('lang.role')); ?>

                    <div class="row">
                        <div class="col-xs-3">
                            <?php echo Form::radio('role','admin',true); ?> <?php echo e(Lang::get('lang.admin')); ?>

                        </div>
                        <div class="col-xs-3">
                            <?php echo Form::radio('role','agent',null); ?> <?php echo e(Lang::get('lang.agent')); ?>

                        </div>
                    </div>
                </div>

                <!-- Management Level -->
                <div class="form-group <?php echo e($errors->has('management_level') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('management_level',Lang::get('lang.management_level')); ?>

                    <div class="row">
                        <div class="col-xs-3">
                            <?php echo Form::radio('management_level',1,true); ?> <?php echo e(Lang::get('lang.level_1')); ?>

                        </div>
                        <div class="col-xs-3">
                            <?php echo Form::radio('management_level',2,null); ?> <?php echo e(Lang::get('lang.level_2')); ?>

                        </div>
                        <div class="col-xs-3">
                            <?php echo Form::radio('management_level',3,null); ?> <?php echo e(Lang::get('lang.level_3')); ?>

                        </div>
                    </div>
                </div>

                <!-- Tasks admin -->
                <div class="form-group <?php echo e($errors->has('all_emails') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('all_emails',Lang::get('lang.all_emails')); ?>

                    <div class="row">
                        <div class="col-xs-3">
                            <?php echo Form::radio('all_emails',1,true); ?> <?php echo e(Lang::get('lang.yes')); ?>

                        </div>
                        <div class="col-xs-3">
                            <?php echo Form::radio('all_emails',0,null); ?> <?php echo e(Lang::get('lang.no')); ?>

                        </div>
                    </div>
                </div>

                <!-- Can View Tasks -->
                <div class="form-group <?php echo e($errors->has('can_view_tasks') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('can_view_tasks',Lang::get('lang.can_view_tasks')); ?>

                    <div class="row">
                        <div class="col-xs-3">
                            <?php echo Form::radio('can_view_tasks',1,null); ?> <?php echo e(Lang::get('lang.yes')); ?>

                        </div>
                        <div class="col-xs-3">
                            <?php echo Form::radio('can_view_tasks',0,true); ?> <?php echo e(Lang::get('lang.no')); ?>

                        </div>
                    </div>
                </div>

                <!-- Receive All Emails -->
                <div class="form-group <?php echo e($errors->has('is_tasks_admin') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('is_tasks_admin',Lang::get('lang.is_tasks_admin')); ?>

                    <div class="row">
                        <div class="col-xs-3">
                            <?php echo Form::radio('is_tasks_admin',1,null); ?> <?php echo e(Lang::get('lang.yes')); ?>

                        </div>
                        <div class="col-xs-3">
                            <?php echo Form::radio('is_tasks_admin',0,true); ?> <?php echo e(Lang::get('lang.no')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
            </div>
        </div>
        <div class="row">
            <!-- assigned group -->
            <div class="col-xs-4 form-group <?php echo e($errors->has('group') ? 'has-error' : ''); ?>">
                <?php echo Form::label('organization',Lang::get('lang.assigned_group')); ?> <span class="text-red"> *</span>
                <?php echo Form::select('group',[''=>Lang::get('lang.select_a_group'),Lang::get('lang.groups')=>$groups->pluck('name','id')->toArray()],null,['class' => 'form-control select2']); ?>

            </div>

           <!-- primary department -->
            <div class="col-xs-4 form-group <?php echo e($errors->has('primary_department') ? 'has-error' : ''); ?>">
                <?php echo Form::label('primary_dpt', Lang::get('lang.primary_department')); ?> <span class="text-red"> *</span>

                <?php echo Form::select('primary_department', [''=>Lang::get('lang.select_a_department'), Lang::get('lang.departments')=>$departments->pluck('name','id')->toArray()],'',['class' => 'form-control select2']); ?>

            </div>

            <!-- timezone -->
            <div class="col-xs-4 form-group <?php echo e($errors->has('agent_time_zone') ? 'has-error' : ''); ?>">
                <?php echo Form::label('agent_tzone',Lang::get('lang.agent_time_zone')); ?> <span class="text-red"> *</span>
                <?php echo Form::select('agent_time_zone', [''=>Lang::get('lang.select_a_time_zone'),Lang::get('lang.time_zones')=>$timezones->pluck('name','id')->toArray()],1,['class' => 'form-control select2']); ?>

            </div>
        </div>
        <!-- Assign team -->
        <div class="form-group <?php echo e($errors->has('team') ? 'has-error' : ''); ?>">
            <?php echo Form::label('agent_tzone',Lang::get('lang.assigned_team')); ?> <span class="text-red"> *</span>
            <?php $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-group ">
                <input type="checkbox" name="team[]" value="<?php echo $val; ?>"  > <?php echo $key; ?><br/>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- Send email to user about registration password -->
        <br/>
        <div class="form-group">
            <input type="checkbox" name="send_email" checked> &nbsp;<label> <?php echo e(Lang::get('lang.send_password_via_email')); ?></label>
        </div>
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary']); ?>

    </div>
</div>
<?php echo Form::close(); ?>


<script type="text/javascript">
    $(function() {
        //Initialize Select2 Elements
        $(".select2").select2();
    });
    </script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/agent/agents/create.blade.php ENDPATH**/ ?>