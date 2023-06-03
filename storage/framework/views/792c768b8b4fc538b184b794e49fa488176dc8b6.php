<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo Lang::get('lang.admin_panel'); ?></h1>
<?php $__env->stopSection(); ?>
<!-- /header -->
<!-- breadcrumbs -->
<?php $__env->startSection('breadcrumbs'); ?>
<?php $__env->stopSection(); ?>
<!-- /breadcrumbs -->
<!-- content -->
<?php $__env->startSection('content'); ?>
<!-- failure message -->
        <?php if(Session::has('fails')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"> </i> <b> <?php echo Lang::get('lang.alert'); ?>! </b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo e(Session::get('fails')); ?>

        </div>
        <?php endif; ?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.staffs'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('agents')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-user fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.agents'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                 <!--col-md-2-->
                 <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('organizations')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-building fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.organizations'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('departments')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-sitemap fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.departments'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('teams')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-users fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.teams'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('groups')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-group fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.groups'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<!-- /.box -->

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.email'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('emails')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-envelope-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.emails'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('banlist')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-ban fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.ban_lists'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('template-sets')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-mail-forward fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.templates'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('getemail')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-at fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.email-settings'); ?></p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('queue')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-upload fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.queues'); ?></p>
                    </div>
                </div>
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('getdiagno')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-plus fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.diagnostics'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.manage'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('helptopic')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-file-text-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.help_topics'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('sla')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-clock-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.sla_plans'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->

                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('forms')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-file-text fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.forms'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('workflow')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-sitemap fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.workflow'); ?></p>
                    </div>
                </div>
                <!-- priority -->
                 <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('ticket/priority')); ?>">
                                <span class="fa-stack fa-2x">
                                    
                                    <i class="fa fa-asterisk fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.priority'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('url/settings')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-server fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >Url</p>
                    </div>
                </div>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.ticket'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('getticket')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-file-text-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.ticket'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                
                 <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('getresponder')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-reply-all fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.auto_response'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('getalert')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-bell-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.alert_notices'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('setting-status')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-plus-square-o"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >Statuses</p>
                    </div>
                </div>
                                
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('getratings')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-star"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.ratings'); ?></p>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('close-workflow')); ?>">
                                <span class="fa-stack fa-2x">    
                                    <i class="fa fa-sitemap"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.close_ticket_workflow'); ?></p>
                    </div>
                </div>
               <?php \Event::dispatch('settings.ticket.view',[]); ?>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.settings'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo url('getcompany'); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-building-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.company'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('getsystem')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-laptop fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.system'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->

                
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('social/media')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-globe fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo e(Lang::get('lang.social-login')); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('languages')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-language fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title"><?php echo Lang::get('lang.language'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('job-scheduler')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa  fa-hourglass-o fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.cron'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('security')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa  fa-lock fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.security'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
                
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('settings-notification')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-bell"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.notification'); ?></p>
                    </div>
                </div>
                
                <?php \Event::dispatch('settings.system',[]); ?>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.error-debug'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <!-- <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(route('error.logs')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-list-alt fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.view-logs'); ?></p>
                    </div>
                </div>
         -->        <!--/.col-md-2-->                                        
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(route('err.debug.settings')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-bug fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.debug-options'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->                                        
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.widgets'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('widgets')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-list-alt fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.widgets'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->                                        
                <!--col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('social-buttons')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-cubes fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.social'); ?></p>
                    </div>
                </div>
                
                <!--/.col-md-2-->                                        
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.plugin'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('plugins')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-plug fa-stack-1x"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.plugin'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->

            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo Lang::get('lang.api'); ?></h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('api')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-cogs"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" ><?php echo Lang::get('lang.api'); ?></p>
                    </div>
                </div>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Logs</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <!--/.col-md-2-->
                <div class="col-md-2 col-sm-6">
                    <div class="settingiconblue">
                        <div class="settingdivblue">
                            <a href="<?php echo e(url('logs')); ?>">
                                <span class="fa-stack fa-2x">
                                    <i class="fa fa-lock"></i>
                                </span>
                            </a>
                        </div>
                        <p class="box-title" >Logs</p>
                    </div>
                </div>
                <!--/.col-md-2-->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<?php \Event::dispatch('service.desk.admin.settings', array()); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/setting.blade.php ENDPATH**/ ?>