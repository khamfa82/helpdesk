<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- faveo favicon -->
        <link href="<?php echo e(asset("lb-faveo/media/images/favicon.ico")); ?>" rel="shortcut icon">
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo e(asset("lb-faveo/css/bootstrap.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo e(asset("lb-faveo/css/font-awesome.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo e(asset("lb-faveo/css/ionicons.min.css")); ?>" rel="stylesheet" type="text/css" >
        <!-- Theme style -->
        <link href="<?php echo e(asset("lb-faveo/css/AdminLTE.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo e(asset("lb-faveo/css/skins/_all-skins.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo e(asset("lb-faveo/plugins/iCheck/flat/blue.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- This controlls the top tabs -->
        <link href="<?php echo e(asset("lb-faveo/css/tabby.css")); ?>" rel="stylesheet" type="text/css" >
        <!-- In app notification style -->
        <link href="<?php echo e(asset("css/notification-style.css")); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset("lb-faveo/css/jquerysctipttop.css")); ?>" rel="stylesheet" type="text/css">

        <link  href="<?php echo e(asset("lb-faveo/css/editor.css")); ?>" rel="stylesheet" type="text/css">

        <link href="<?php echo e(asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")); ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo e(asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")); ?>" rel="stylesheet" type="text/css" >
        <!-- select2 -->
        <link href="<?php echo e(asset("lb-faveo/plugins/select2/select2.min.css")); ?>" rel="stylesheet" type="text/css">
        <!-- Colorpicker -->

        <link href="<?php echo e(asset("lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.css")); ?>" rel="stylesheet" type="text/css" />

        <script src="<?php echo e(asset("lb-faveo/plugins/filebrowser/plugin.js")); ?>" type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/js/jquery-2.1.4.js")); ?>" type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/js/jquery2.1.1.min.js")); ?>" type="text/javascript"></script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <?php echo $__env->yieldContent('HeadInclude'); ?>
    </head>
    <body class="skin-yellow fixed">
        <?php
        $replacetop = 0;
        $replacetop = \Event::dispatch('service.desk.admin.topbar.replace', array());
        if (count($replacetop) == 0) {
            $replacetop = 0;
        } else {
            $replacetop = $replacetop[0];
        }
        $replaceside = 0;
        $replaceside = \Event::dispatch('service.desk.admin.sidebar.replace', array());
        if (count($replaceside) == 0) {
            $replaceside = 0;
        } else {
            $replaceside = $replaceside[0];
        }
        //dd($replacetop);
        ?>
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo e(route('/')); ?>" class="logo"><img src="<?php echo e(asset('lb-faveo/media/images/logo.png')); ?>" width="100px"></a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <?php $notifications = App\Http\Controllers\Common\NotificationController::getNotifications(); ?>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-collapse">

                        <ul class="nav navbar-nav navbar-left">
                            <?php if($replacetop==0): ?>
                            <li <?php echo $__env->yieldContent('settings'); ?>><a href="<?php echo url('dashboard'); ?>"><?php echo Lang::get('lang.agent_panel'); ?></a></li>
                            <?php else: ?>
                            <?php \Event::dispatch('service.desk.admin.topbar', array()); ?>
                            <?php endif; ?>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="<?php echo e(url('admin')); ?>"><?php echo Lang::get('lang.admin_panel'); ?></a></li>
                            <?php echo $__env->make('themes.default1.update.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <!-- User Account: style can be found in dropdown.less -->
                            <ul class="nav navbar-nav navbar-right">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown notifications-menu" id="myDropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="myFunction()">
                                    <i class="fa fa-bell-o"></i>
                                    <span class="label label-danger" id="count"><?php echo $notifications->count(); ?></span>
                                </a>
                                <ul class="dropdown-menu" style="width:500px">

                                    <div id="alert11" class="alert alert-success alert-dismissable" style="display:none;">
                                        <button id="dismiss11" type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <h4><i class="icon fa fa-check"></i>Alert!</h4>
                                        <div id="message-success1"></div>
                                    </div>

                                    <li id="refreshNote">

                                    <li class="header">You have <?php echo $notifications->count(); ?> notifications. <a class="pull-right" id="read-all" href="#">Mark all as read.</a></li>

                                    <ul class="menu">

                                        <?php if($notifications->count()): ?>
                                        <?php $__currentLoopData = $notifications->orderBy('created_at', 'desc')->get()->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php if($notification->notification->type->type == 'registration'): ?>
                                        <?php if($notification->is_read == 1): ?>
                                        <li class="task" style="list-style: none; margin-left: -30px;"><span>&nbsp<img src="<?php echo e($notification -> users -> profile_pic); ?>" class="user-image"  style="width:6%;height: 5%" alt="User Image" />
                                                <a href="<?php echo route('user.show', $notification->notification->model_id); ?>" id="<?php echo e($notification -> notification_id); ?>" class='noti_User'>
                                                    <?php echo $notification->notification->type->message; ?>

                                                </a></span>
                                        </li>
                                        <?php else: ?>
                                        <li style="list-style: none; margin-left: -30px;"><span>&nbsp<img src="<?php echo e($notification -> users -> profile_pic); ?>" class="user-image"  style="width:6%;height: 5%" alt="User Image" />
                                                <a href="<?php echo route('user.show', $notification->notification->model_id); ?>" id="<?php echo e($notification -> notification_id); ?>" class='noti_User'>
                                                    <?php echo $notification->notification->type->message; ?>

                                                </a></span>
                                        </li>
                                        <?php endif; ?>
                                        <?php else: ?>
                                        <?php if($notification->is_read == 1): ?>
                                        <li  class="task" style="list-style: none;margin-left: -30px"><span>&nbsp<img src="<?php echo e($notification -> users -> profile_pic); ?>" class="img-circle"  style="width:6%;height: 5%" alt="User Image" />
                                                <a href="<?php echo route('ticket.thread', $notification->notification->model_id); ?>" id='<?php echo e($notification -> notification_id); ?>' class='noti_User'>
                                                    <?php echo $notification->notification->type->message; ?> with id "<?php echo $notification->notification->model->ticket_number; ?>"
                                                </a></span>
                                        </li>
                                        <?php elseif($notification->notification->model): ?>
                                        <li style="list-style: none;margin-left: -30px"><span>&nbsp<img src="<?php echo e($notification -> users -> profile_pic); ?>" class="img-circle"  style="width:6%;height: 5%" alt="User Image" />
                                                <a href="<?php echo route('ticket.thread', $notification->notification->model_id); ?>" id='<?php echo e($notification -> notification_id); ?>' class='noti_User'>
                                                    <?php echo $notification->notification->type->message; ?> with id "<?php echo $notification->notification->model->ticket_number; ?>"
                                                </a></span>
                                        </li>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </ul>
                            </li>
                            <li class="footer no-border"><div class="col-md-5"></div><div class="col-md-2">
                                    <img src="<?php echo e(asset("lb-faveo/media/images/gifloader.gif")); ?>" style="display: none;" id="notification-loader">
                                </div><div class="col-md-5"></div></li>
                            <li class="footer"><a href="<?php echo e(url('notifications-list')); ?>">View all</a>
                            </li>
                        </ul>
                        </li>
                       <?php  /*
                        <li class="dropdown">
                            <?php $src = Lang::getLocale().'.png'; ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><img src="{{asset("lb-faveo/flags/$src")}}"></img> &nbsp;<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                @foreach($langs as $key => $value)
                                            <?php $src = $key.".png"; ?>
                                            <li><a href="#" id="{{$key}}" onclick="changeLang(this.id)"><img src="{{asset("lb-faveo/flags/$src")}}"></img>&nbsp;{{$value[0]}}&nbsp;
                                            @if(Lang::getLocale() == "ar")
                                            &rlm;
                                            @endif
                                            ({{$value[1]}})</a></li>
                                @endforeach       
                            </ul>
                        </li>
                        */ ?>
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php if(Auth::user()): ?>

                                <img src="<?php echo e(Auth::user()->profile_pic); ?>"class="user-image" alt="User Image"/>

                                <span class="hidden-xs"><?php echo Auth::user()->first_name." ".Auth::user()->last_name; ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header" style="background-color:#343F44;">
                                    <?php if(Auth::user()): ?>
                                    <img src="<?php echo e(Auth::user()->profile_pic); ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo Auth::user()->first_name; ?><?php echo " ". Auth::user()->last_name; ?> - <?php echo e(Auth::user()->role); ?>

                                        <small></small>
                                    </p>
                                    <?php endif; ?>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer"  style="background-color:#1a2226;">
                                    <div class="pull-left">
                                        <a href="<?php echo e(url('admin-profile')); ?>" class="btn btn-info btn-sm"><b><?php echo Lang::get('lang.profile'); ?></b></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo e(url('auth/logout')); ?>" class="btn btn-danger btn-sm"><b><?php echo Lang::get('lang.sign_out'); ?></b></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <div class="user-panel">
                        <div class = "row">
                            <div class="col-xs-3"></div>
                            <div class="col-xs-2" style="width:50%;">
                                <a href="<?php echo url('profile'); ?>">
                                    <img src="<?php echo e(Auth::user()->profile_pic); ?>" class="img-circle" alt="User Image" />
                                </a>
                            </div>
                        </div>
                        <div class="info" style="text-align:center;">
                            <?php if(Auth::user()): ?>
                            <p><?php echo Auth::user()->first_name; ?><?php echo " ". Auth::user()->last_name; ?></p>
                            <?php endif; ?>
                            <?php if(Auth::user() && Auth::user()->active==1): ?>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            <?php else: ?>
                            <a href="#"><i class="fa fa-circle"></i> Offline</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <?php if($replaceside==0): ?>
                        <center><a href="<?php echo e(url('admin')); ?>"><li class="header"><span style="font-size:1.5em;"><?php echo e(Lang::get('lang.admin_panel')); ?></span></li></a></center>
                        <li class="header"><?php echo Lang::get('lang.settings-2'); ?></li>
                        <li class="treeview <?php echo $__env->yieldContent('Staffs'); ?>">
                            <a  href="#">
                                <i class="fa fa-users"></i> <span><?php echo Lang::get('lang.staffs'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $__env->yieldContent('agents'); ?>><a href="<?php echo e(url('agents')); ?>"><i class="fa fa-user "></i><?php echo Lang::get('lang.agents'); ?></a></li>
                                <li <?php echo $__env->yieldContent('organizations'); ?>><a href="<?php echo e(url('organizations')); ?>"><i class="fa fa-building"></i><?php echo Lang::get('lang.organizations'); ?></a></li>
                                <li <?php echo $__env->yieldContent('departments'); ?>><a href="<?php echo e(url('departments')); ?>"><i class="fa fa-sitemap"></i><?php echo Lang::get('lang.departments'); ?></a></li>
                                <li <?php echo $__env->yieldContent('teams'); ?>><a href="<?php echo e(url('teams')); ?>"><i class="fa fa-users"></i><?php echo Lang::get('lang.teams'); ?></a></li>
                                <li <?php echo $__env->yieldContent('groups'); ?>><a href="<?php echo e(url('groups')); ?>"><i class="fa fa-users"></i><?php echo Lang::get('lang.groups'); ?></a></li>
                            </ul>
                        </li>

                        <li class="treeview <?php echo $__env->yieldContent('Emails'); ?>">
                            <a href="#">
                                <i class="fa fa-envelope-o"></i>
                                <span><?php echo Lang::get('lang.email'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $__env->yieldContent('emails'); ?>><a href="<?php echo e(url('emails')); ?>"><i class="fa fa-envelope"></i><?php echo Lang::get('lang.emails'); ?></a></li>
                                <li <?php echo $__env->yieldContent('ban'); ?>><a href="<?php echo e(url('banlist')); ?>"><i class="fa fa-ban"></i><?php echo Lang::get('lang.ban_lists'); ?></a></li>
                                <li <?php echo $__env->yieldContent('template'); ?>><a href="<?php echo e(url('template-sets')); ?>"><i class="fa fa-mail-forward"></i><?php echo Lang::get('lang.templates'); ?></a></li>
                                <li <?php echo $__env->yieldContent('email'); ?>><a href="<?php echo e(url('getemail')); ?>"><i class="fa fa-at"></i><?php echo Lang::get('lang.email-settings'); ?></a></li>
                                <li <?php echo $__env->yieldContent('queue'); ?>><a href="<?php echo e(url('queue')); ?>"><i class="fa fa-upload"></i><?php echo Lang::get('lang.queues'); ?></a></li>
                                <li <?php echo $__env->yieldContent('diagnostics'); ?>><a href="<?php echo e(url('getdiagno')); ?>"><i class="fa fa-plus"></i><?php echo Lang::get('lang.diagnostics'); ?></a></li>

                                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Auto Response</a></li> -->
                                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Rules/a></li> -->
                                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Breaklines</a></li> -->
                                <!-- <li><a href="#"><i class="fa fa-circle-o"></i> Log</a></li> -->
                            </ul>
                        </li>

                        <li class="treeview <?php echo $__env->yieldContent('Manage'); ?>">
                            <a href="#">
                                <i class="fa  fa-cubes"></i>
                                <span><?php echo Lang::get('lang.manage'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $__env->yieldContent('help'); ?>><a href="<?php echo e(url('helptopic')); ?>"><i class="fa fa-file-text-o"></i><?php echo Lang::get('lang.help_topics'); ?></a></li>
                                <li <?php echo $__env->yieldContent('sla'); ?>><a href="<?php echo e(url('sla')); ?>"><i class="fa fa-clock-o"></i><?php echo Lang::get('lang.sla_plans'); ?></a></li>
                                <li <?php echo $__env->yieldContent('forms'); ?>><a href="<?php echo e(url('forms')); ?>"><i class="fa fa-file-text"></i><?php echo Lang::get('lang.forms'); ?></a></li>
                                <li <?php echo $__env->yieldContent('workflow'); ?>><a href="<?php echo e(url('workflow')); ?>"><i class="fa fa-sitemap"></i><?php echo Lang::get('lang.workflow'); ?></a></li>
                                <li <?php echo $__env->yieldContent('priority'); ?>><a href="<?php echo e(url('ticket/priority')); ?>"><i class="fa fa-asterisk"></i><?php echo Lang::get('lang.priority'); ?></a></li>
                                <li <?php echo $__env->yieldContent('url'); ?>><a href="<?php echo e(url('url/settings')); ?>"><i class="fa fa-server"></i><?php echo Lang::get('lang.url'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview <?php echo $__env->yieldContent('Tickets'); ?>">
                            <a  href="#">
                                <i class="fa fa-ticket"></i> <span><?php echo Lang::get('lang.tickets'); ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $__env->yieldContent('tickets'); ?>><a href="<?php echo e(url('getticket')); ?>"><i class="fa fa-file-text"></i><?php echo Lang::get('lang.ticket'); ?></a></li>
                                <li <?php echo $__env->yieldContent('auto-response'); ?>><a href="<?php echo e(url('getresponder')); ?>"><i class="fa fa-reply-all"></i><?php echo Lang::get('lang.auto_response'); ?></a></li>
                                <li <?php echo $__env->yieldContent('alert'); ?>><a href="<?php echo e(url('getalert')); ?>"><i class="fa fa-bell"></i><?php echo Lang::get('lang.alert_notices'); ?></a></li>
                                <li <?php echo $__env->yieldContent('status'); ?>><a href="<?php echo e(url('setting-status')); ?>"><i class="fa fa-plus-square-o"></i><?php echo Lang::get('lang.status'); ?></a></li>
                                <li <?php echo $__env->yieldContent('ratings'); ?>><a href="<?php echo e(url('getratings')); ?>"><i class="fa fa-star"></i><?php echo Lang::get('lang.ratings'); ?></a></li>
                                <li <?php echo $__env->yieldContent('close-workflow'); ?>><a href="<?php echo e(url('close-workflow')); ?>"><i class="fa fa-sitemap"></i><?php echo Lang::get('lang.close-workflow'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview <?php echo $__env->yieldContent('Settings'); ?>">
                            <a href="#">
                                <i class="fa fa-cog"></i>
                                <span><?php echo Lang::get('lang.settings'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $__env->yieldContent('company'); ?>><a href="<?php echo e(url('getcompany')); ?>"><i class="fa fa-building"></i><?php echo Lang::get('lang.company'); ?></a></li>
                                <li <?php echo $__env->yieldContent('system'); ?>><a href="<?php echo e(url('getsystem')); ?>"><i class="fa fa-laptop"></i><?php echo Lang::get('lang.system'); ?></a></li>
                                <li <?php echo $__env->yieldContent('social-login'); ?>><a href="<?php echo e(url('social/media')); ?>"><i class="fa fa-globe"></i> <?php echo Lang::get('lang.social-login'); ?></a></li>
                                <li <?php echo $__env->yieldContent('languages'); ?>><a href="<?php echo e(url('languages')); ?>"><i class="fa fa-language"></i><?php echo Lang::get('lang.language'); ?></a></li>
                                <li <?php echo $__env->yieldContent('cron'); ?>><a href="<?php echo e(url('job-scheduler')); ?>"><i class="fa fa-hourglass"></i><?php echo Lang::get('lang.cron'); ?></a></li>
                                <li <?php echo $__env->yieldContent('security'); ?>><a href="<?php echo e(url('security')); ?>"><i class="fa fa-lock"></i><?php echo Lang::get('lang.security'); ?></a></li>
                                <li <?php echo $__env->yieldContent('notification'); ?>><a href="<?php echo e(url('settings-notification')); ?>"><i class="fa fa-bell"></i><?php echo Lang::get('lang.notifications'); ?></a></li>
                                <li <?php echo $__env->yieldContent('storage'); ?>><a href="<?php echo e(url('storage')); ?>"><i class="fa fa-save"></i><?php echo Lang::get('storage::lang.storage'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview <?php echo $__env->yieldContent('error-bugs'); ?>">
                            <a href="#">
                                <i class="fa fa-heartbeat"></i>
                                <span><?php echo Lang::get('lang.error-debug'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <!-- <li <?php echo $__env->yieldContent('error-logs'); ?>><a href="<?php echo e(route('error.logs')); ?>"><i class="fa fa-list-alt"></i> <?php echo Lang::get('lang.view-logs'); ?></a></li> -->
                                <li <?php echo $__env->yieldContent('debugging-option'); ?>><a href="<?php echo e(route('err.debug.settings')); ?>"><i class="fa fa-bug"></i> <?php echo Lang::get('lang.debug-options'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview <?php echo $__env->yieldContent('Themes'); ?>">
                            <a href="#">
                                <i class="fa fa-pie-chart"></i>
                                <span><?php echo Lang::get('lang.widgets'); ?></span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li <?php echo $__env->yieldContent('widget'); ?>><a href="<?php echo e(url('widgets')); ?>"><i class="fa fa-list-alt"></i> <?php echo Lang::get('lang.widgets'); ?></a></li>
                                <li <?php echo $__env->yieldContent('socail'); ?>><a href="<?php echo e(url('social-buttons')); ?>"><i class="fa fa-cubes"></i> <?php echo Lang::get('lang.social'); ?></a></li>
                            </ul>
                        </li>
                        <li class="treeview <?php echo $__env->yieldContent('Plugins'); ?>">
                            <a href="<?php echo e(url('plugins')); ?>">
                                <i class="fa fa-plug"></i>
                                <span><?php echo Lang::get('lang.plugin'); ?></span>
                            </a>
                        </li>
                        <li class="treeview <?php echo $__env->yieldContent('API'); ?>">
                            <a href="<?php echo e(url('api')); ?>">
                                <i class="fa fa-cogs"></i>
                                <span><?php echo Lang::get('lang.api'); ?></span>
                            </a>
                        </li>
                        <li class="treeview <?php echo $__env->yieldContent('Log'); ?>">
                            <a href="<?php echo e(url('logs')); ?>">
                                <i class="fa fa-lock"></i>
                                <span>Logs</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php \Event::dispatch('service.desk.admin.sidebar', array()); ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <!--<div class="row">-->
                    <!--<div class="col-md-6">-->
                    <?php echo $__env->yieldContent('PageHeader'); ?>
                    <!--</div>-->
                    <?php /* @if(Breadcrumbs::exists())
                    {!! Breadcrumbs::render() !!}
                    @endif */ ?>
                    <!--</div>-->
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php if($dummy_installation == 1 || $dummy_installation == '1'): ?>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa  fa-exclamation-triangle"></i> <?php echo e(Lang::get('lang.dummy_data_installation_message')); ?> <a href="<?php echo e(route('clean-database')); ?>"><?php echo e(Lang::get('lang.click')); ?></a> <?php echo e(Lang::get('lang.clear-dummy-data')); ?>

                    </div>
                    <?php elseif(!$is_mail_conigured): ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="callout callout-warning lead">
                                <h4><i class="fa fa-exclamation-triangle"></i>&nbsp;<?php echo e(Lang::get('Alert')); ?></h4>
                                <p style="font-size:0.8em">
                                <?php if(\Auth::user()->role == 'admin'): ?>
                                    <?php echo e(Lang::get('lang.system-outgoing-incoming-mail-not-configured')); ?>&nbsp;<a href="<?php echo e(URL::route('emails.create')); ?>"><?php echo e(Lang::get('lang.confihure-the-mail-now')); ?></a>
                                <?php else: ?>
                                    <?php echo e(Lang::get('lang.system-mail-not-configured-agent-message')); ?>

                                <?php endif; ?>
                                </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php echo $__env->yieldContent('content'); ?>
                </section><!-- /.content -->
                <!-- /.content-wrapper -->
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <!-- <b><?php echo Lang::get('lang.version'); ?></b> <?php echo Config::get('app.version'); ?> -->
                </div>
                <?php
                $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                ?>
                <strong><?php echo Lang::get('lang.copyright'); ?> &copy; <?php echo date('Y'); ?>  <a href="<?php echo $company->website; ?>" target="_blank"><?php echo $company->company_name; ?></a>.</strong> <?php echo Lang::get('lang.all_rights_reserved'); ?>. 
                <!-- <?php echo Lang::get('lang.powered_by'); ?> <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a> -->
            </footer>
        </div><!-- ./wrapper -->
        <!-- jQuery 2.1.3 -->
        <script src="<?php echo e(asset("lb-faveo/js/ajax-jquery.min.js")); ?>" type="text/javascript"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo e(asset("lb-faveo/js/bootstrap.min.js")); ?>" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="<?php echo e(asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")); ?>" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="<?php echo e(asset("lb-faveo/plugins/fastclick/fastclick.min.js")); ?>" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo e(asset("lb-faveo/js/app.min.js")); ?>" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo e(asset("lb-faveo/plugins/iCheck/icheck.min.js")); ?>" type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")); ?>" type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/plugins/datatables/jquery.dataTables.js")); ?>" type="text/javascript"></script>
        <!-- Page Script -->
        <script src="<?php echo e(asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")); ?>" type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")); ?>"  type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")); ?>"  type="text/javascript"></script>
        <!-- Colorpicker -->
        <script src="<?php echo e(asset("lb-faveo/plugins/colorpicker/bootstrap-colorpicker.min.js")); ?>" ></script>
        <!--date time picker-->
        <script src="<?php echo e(asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")); ?>" type="text/javascript"></script>
        <!-- select2 -->
         <script src="<?php echo e(asset("lb-faveo/plugins/select2/select2.min.js")); ?>" ></script>

<?php if(trim($__env->yieldContent('no-toolbar'))): ?>
    <h1><?php echo $__env->yieldContent('no-toolbar'); ?></h1>
<?php else: ?>
    <script>
    $(function () {
    //Add text editor
        $("textarea").wysihtml5();
        $('.dataTable').DataTable();

    });
    </script>
<?php endif; ?>
    <script>
        $('#read-all').click(function () {

            var id2 = <?php echo \Auth::user()->id ?>;
            var dataString = 'id=' + id2;
            $.ajax
                    ({
                        type: "POST",
                        url: "<?php echo e(url('mark-all-read')); ?>" + "/" + id2,
                        data: dataString,
                        cache: false,
                        beforeSend: function () {
                            $('#myDropdown').on('hide.bs.dropdown', function () {
                                return false;
                            });
                            $("#refreshNote").hide();
                            $("#notification-loader").show();
                        },
                        success: function (response) {
                            $("#refreshNote").load("<?php echo $_SERVER['REQUEST_URI']; ?>  #refreshNote");
                            $("#notification-loader").hide();
                            $('#myDropdown').removeClass('open');
                        }
                    });
        });</script>

    <script src="<?php echo e(asset("lb-faveo/js/tabby.js")); ?>"></script>
    <!-- CK Editor -->
    <script src="<?php echo e(asset("lb-faveo/plugins/filebrowser/plugin.js")); ?>"></script>
    <script src="<?php echo e(asset("lb-faveo/js/languagechanger.js")); ?>" type="text/javascript"></script>
    <?php echo $__env->yieldContent('FooterInclude'); ?>
</body>
<script>
    $(function() {


        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
        $('input[type="radio"]').iCheck({
            radioClass: 'iradio_flat-blue'
        });

    });
</script>
</html>
<?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/layout/admin.blade.php ENDPATH**/ ?>