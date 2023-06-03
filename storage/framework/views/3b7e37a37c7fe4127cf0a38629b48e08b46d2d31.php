<?php $__env->startSection('Settings'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('settings-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('system'); ?>
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
<!-- open a form -->
<?php echo Form::model($systems,['url' => 'postsystem/'.$systems->id, 'method' => 'PATCH' , 'id'=>'formID']); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(Lang::get('lang.system-settings')); ?></h3> 
    </div>
    <!-- Helpdesk Status: radio Online Offline -->
    <div class="box-body">
        <!-- check whether success or not -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('success'); ?>

        </div>
        <?php endif; ?>
        <!-- failure message -->
        <?php if(Session::has('fails')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <b><?php echo Lang::get('lang.alert'); ?>!</b><br/>
            <li class="error-message-padding"><?php echo Session::get('fails'); ?></li>
        </div>
        <?php endif; ?>
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
        </div>
        <?php endif; ?>
        <div class="row">
           
            <!-- Helpdesk Name/Title: text Required   -->
            <div class="col-md-4">
                <div class="form-group <?php echo e($errors->has('name') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('name',Lang::get('lang.name/title')); ?>

                    <?php echo $errors->first('name', '<spam class="help-block">:message</spam>'); ?>

                    <?php echo Form::text('name',$systems->name,['class' => 'form-control']); ?>

                </div>
            </div>
             <!-- Helpdesk URL:      text   Required -->
             <div class="col-md-4">
                <div class="form-group <?php echo e($errors->has('url') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('url',Lang::get('lang.url')); ?>

                    <?php echo $errors->first('url', '<spam class="help-block">:message</spam>'); ?>

                    <?php echo Form::text('url',$systems->url,['class' => 'form-control']); ?>

                </div>
            </div>
            <!-- Default Time Zone: Drop down: timezones table : Required -->
            <div class="col-md-4">
                <div class="form-group <?php echo e($errors->has('time_zone') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('time_zone',Lang::get('lang.timezone')); ?>

                    <?php echo $errors->first('time_zone', '<spam class="help-block">:message</spam>'); ?>

                    <?php echo Form::select('time_zone',['Time Zones'=>$timezones->pluck('name','id')->toArray()],null,['class'=>'form-control']); ?>

                </div>
            </div>
        </div>
        <div class="row">
            <!-- Date and Time Format: text: required: eg - 03/25/2015 7:14 am -->
            <div class="col-md-4">
                <div class="form-group <?php echo e($errors->has('date_time_format') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('date_time_format',Lang::get('lang.date_time')); ?>

                    <?php echo $errors->first('date_time_format', '<spam class="help-block">:message</spam>'); ?>

                    <?php echo Form::select('date_time_format',['Date Time Formats'=>$date_time->pluck('format','id')->toArray()],null,['class' => 'form-control']); ?>

                </div>
            </div>
           
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo Form::label('status',Lang::get('lang.status')); ?>

                    <div class="row">
                        <div class="col-xs-5">
                            <?php echo Form::radio('status','1',true); ?> <?php echo e(Lang::get('lang.online')); ?>

                        </div>
                        <div class="col-xs-6">
                            <?php echo Form::radio('status','0'); ?> <?php echo e(Lang::get('lang.offline')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <?php echo Form::label('user_set_ticket_status',Lang::get('lang.user_set_ticket_status')); ?>

                    <div class="row">
                        <div class="col-xs-5">
                            <input type="radio" name="user_set_ticket_status" value="0" <?php if($common_setting->status == '0'): ?>checked="true" <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.no')); ?>

                        </div>
                        <div class="col-xs-6">
                            <input type="radio" name="user_set_ticket_status" value="1" <?php if($common_setting->status == '1'): ?>checked="true" <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.yes')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">    
            <div class="col-md-4" data-toggle="tooltip" title="<?php echo Lang::get('lang.the_rtl_support_is_only_applicable_to_the_outgoing_mails'); ?>">
                <div class="form-group">
                    <?php echo Form::label('status',Lang::get('lang.rtl')); ?>

                    <div class="row">
                        <div class="col-xs-12">
                            <?php
                            $rtl = App\Model\helpdesk\Settings\CommonSettings::where('option_name', '=', 'enable_rtl')->first();
                            ?>
                            <input type="checkbox" name="enable_rtl" <?php if($rtl->option_value == 1): ?> checked <?php endif; ?>> <?php echo e(Lang::get('lang.enable')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-toggle="tooltip" title="<?php echo Lang::get('lang.otp_usage_info'); ?>">
                <div class="form-group">
                    <?php echo Form::label('send_otp',Lang::get('lang.allow_unverified_users_to_create_ticket')); ?>

                    <div class="row">
                        <div class="col-xs-5">
                            <input type="radio" name="send_otp" value="0" <?php if($send_otp->status == '0'): ?>checked="true" <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.yes')); ?>

                        </div>
                        <div class="col-xs-6">
                            <input type="radio" name="send_otp" value="1" <?php if($send_otp->status == '1'): ?>checked="true" <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.no')); ?>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-toggle="tooltip" title="<?php echo Lang::get('lang.email_man_info'); ?>">
                <div class="form-group">
                    <?php echo Form::label('email_mandatory',Lang::get('lang.make-email-mandatroy')); ?>

                    <div class="row">
                        <div class="col-xs-5">
                            <input type="radio" name="email_mandatory" value="1" <?php if($email_mandatory->status == '1'): ?>checked="true" <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.yes')); ?>

                        </div>
                        <div class="col-xs-6">
                            <input type="radio" name="email_mandatory" value="0" <?php if($email_mandatory->status == '0'): ?>checked="true" <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.no')); ?>

                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['onclick'=>'sendForm()','class'=>'btn btn-primary']); ?>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/system.blade.php ENDPATH**/ ?>