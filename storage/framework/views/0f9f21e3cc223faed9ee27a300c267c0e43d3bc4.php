<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" ng-app="myApp">
        <title>Faveo | HELP DESK</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <meta name="_token" content="<?php echo csrf_token(); ?>"/>
        <!-- faveo favicon -->
        <link href="<?php echo e(asset("lb-faveo/media/images/favicon.ico")); ?>" rel="shortcut icon">
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo e(asset("lb-faveo/css/bootstrap.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo e(asset("lb-faveo/css/font-awesome.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo e(asset("lb-faveo/css/ionicons.min.css")); ?>" rel="stylesheet"  type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo e(asset("lb-faveo/css/AdminLTE.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link href="<?php echo e(asset("lb-faveo/css/skins/_all-skins.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- iCheck -->
        <link href="<?php echo e(asset("lb-faveo/plugins/iCheck/flat/blue.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <link href="<?php echo e(asset("lb-faveo/css/tabby.css")); ?>" rel="stylesheet" type="text/css"/>

        <link href="<?php echo e(asset("lb-faveo/css/jquerysctipttop.css")); ?>" rel="stylesheet" type="text/css"/>
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <link href="<?php echo e(asset("lb-faveo/css/editor.css")); ?>" rel="stylesheet" type="text/css"/>

        <link href="<?php echo e(asset("lb-faveo/css/jquery.ui.css")); ?>" rel="stylesheet" rel="stylesheet"/>

        <link href="<?php echo e(asset("lb-faveo/plugins/datatables/dataTables.bootstrap.css")); ?>" rel="stylesheet"  type="text/css"/>

        <link href="<?php echo e(asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")); ?>" rel="stylesheet" type="text/css"/>

        <link href="<?php echo e(asset("lb-faveo/css/faveo-css.css")); ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo e(asset("lb-faveo/css/notification-style.css")); ?>" rel="stylesheet" type="text/css" >

        <link href="<?php echo e(asset("lb-faveo/css/jquery.rating.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Select2 -->
        <link href="<?php echo e(asset("lb-faveo/plugins/select2/select2.min.css")); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset("css/close-button.css")); ?>" rel="stylesheet" type="text/css" />

        <!--Daterangepicker-->
        <link rel="stylesheet" href="<?php echo e(asset("lb-faveo/plugins/daterangepicker/daterangepicker.css")); ?>" rel="stylesheet" type="text/css" />
        <!--calendar -->
        <!-- fullCalendar 2.2.5-->
        <link href="<?php echo e(asset('lb-faveo/plugins/fullcalendar/fullcalendar.min.css')); ?>" rel="stylesheet" type="text/css" />
        
        <link type="text/css" href="<?php echo e(asset("css/bootstrap-custom.css")); ?>" rel="stylesheet">
        
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <!-- <script src="<?php echo e(asset("lb-faveo/js/jquery-2.1.4.js")); ?>" type="text/javascript"></script> -->

        <script src="<?php echo e(asset("lb-faveo/js/jquery2.1.1.min.js")); ?>" type="text/javascript"></script>

        <?php echo $__env->yieldContent('HeadInclude'); ?>
        <style type="text/css">
            #bar {
                border-right: 1px solid rgba(204, 204, 204, 0.41);
            }
            #bar a{
                color: #FFF;
            }
            #bar a:hover, #bar a:focus{
                background-color: #357CA5;
            }

        </style>
    </head>
    <body class="skin-blue fixed">
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo e(route('/')); ?>" class="logo"><img src="<?php echo e(asset('lb-faveo/media/images/logo.png')); ?>" width="100px;"></a>
                <?php
                $replacetop = \Event::dispatch('service.desk.agent.topbar.replace', array());

                if (count($replacetop) == 0) {
                    $replacetop = 0;
                } else {
                    $replacetop = $replacetop[0];
                }

                $replaceside = \Event::dispatch('service.desk.agent.sidebar.replace', array());

                if (count($replaceside) == 0) {
                    $replaceside = 0;
                } else {
                    $replaceside = $replaceside[0];
                }
                ?>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <?php if($replacetop==0): ?>
                        <ul class="tabs tabs-horizontal nav navbar-nav navbar-left">
                            <li <?php echo $__env->yieldContent('Dashboard'); ?>><a id="dash" data-target="#tabA" href="<?php echo e(URL::route('dashboard')); ?>" onclick="clickURL(event, '<?php echo e(URL::route('dashboard')); ?>');"><?php echo Lang::get('lang.dashboard'); ?></a></li>
                            <?php /*
                            <li @yield('Users')><a data-target="#tabB" href="#">{!! Lang::get('lang.users') !!}</a></li>
                            */ ?>
                            <li <?php echo $__env->yieldContent('Tickets'); ?>><a data-target="#tabC" href="#"><?php echo Lang::get('lang.tickets'); ?></a></li>
                            <li <?php echo $__env->yieldContent('Tools'); ?>><a data-target="#tabD" href="#"><?php echo Lang::get('lang.tools'); ?></a></li>
                            
                            <?php /* <li @yield('Report')><a href="{{URL::route('report.index')}}" onclick="clickReport(event);">Report</a></li> */ ?>
                            <li <?php echo $__env->yieldContent('Report'); ?>><a data-target="#tabE" href="#">Report</a></li>
                            <?php if(auth()->user()->can_view_tasks): ?>
                                <li <?php echo $__env->yieldContent('Tasks'); ?> class="bg-green"><a href="/tasks" onclick="clickURL(event, '/tasks');"><?php echo Lang::get('lang.tasks'); ?></a></li>
                            <?php endif; ?>
                            <?php \Event::dispatch('calendar.topbar', array()); ?>
                        </ul>
                        <?php else: ?>
                        <?php \Event::dispatch('service.desk.agent.topbar', array()); ?>
                        <?php endif; ?>

                        <ul class="nav navbar-nav navbar-right">
                            <?php if($auth_user_role == 'admin'): ?>
                            <li><a href="<?php echo e(url('admin')); ?>"><?php echo Lang::get('lang.admin_panel'); ?></a></li>

                            <?php endif; ?>
                            <?php echo $__env->make('themes.default1.update.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                    <?php /*    <li class="dropdown">
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
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php if($auth_user_id): ?>
                                <img src="<?php echo e($auth_user_profile_pic); ?>"class="user-image" alt="User Image"/>
                                <span class="hidden-xs"><?php echo e($auth_name); ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header"  style="background-color:#343F44;">
                                    <img src="<?php echo e($auth_user_profile_pic); ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        <?php echo e($auth_name); ?> - <?php echo e($auth_user_role); ?>

                                        <small></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer" style="background-color:#1a2226;">
                                    <div class="pull-left">
                                        <a href="<?php echo e(URL::route('profile')); ?>" class="btn btn-info btn-sm"><b><?php echo Lang::get('lang.profile'); ?></b></a>
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
                        <?php if(trim($__env->yieldContent('profileimg'))): ?>
                        <h1><?php echo $__env->yieldContent('profileimg'); ?></h1>
                        <?php else: ?>
                        <div class = "row">
                            <div class="col-xs-3"></div>
                            <div class="col-xs-2" style="width:50%;">
                                <a href="<?php echo url('profile'); ?>">
                                    <img src="<?php echo e($auth_user_profile_pic); ?>" class="img-circle" alt="User Image" />
                                </a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="info" style="text-align:center;">
                            <?php if($auth_user_id): ?>
                            <p><?php echo e($auth_name); ?></p>
                            <?php endif; ?>
                            <?php if($auth_user_id && $auth_user_active==1): ?>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            <?php else: ?>
                            <a href="#"><i class="fa fa-circle"></i> Offline</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <ul id="side-bar" class="sidebar-menu">
                        <?php if($replaceside==0): ?>
                        <?php echo $__env->yieldContent('sidebar'); ?>
                        <li class="header"><?php echo Lang::get('lang.Tickets'); ?></li>

                        <li <?php echo $__env->yieldContent('inbox'); ?>>
                             <a href="<?php echo e(url('tickets')); ?>" id="load-inbox">
                                <i class="fa fa-envelope"></i> <span><?php echo Lang::get('lang.inbox'); ?></span> <small class="label pull-right bg-green"><?php echo e(count($tickets)); ?></small>
                            </a>
                        </li>
                        <li <?php echo $__env->yieldContent('myticket'); ?>>
                             <a href="<?php echo e(url('/tickets?show=mytickets')); ?>" id="load-myticket">
                                <i class="fa fa-user"></i> <span><?php echo Lang::get('lang.my_tickets'); ?> </span>
                                <small class="label pull-right bg-green"><?php echo e(count($myticket)); ?></small>
                            </a>
                        </li>
                        
                        <li <?php echo $__env->yieldContent('unassigned'); ?>>
                            <a href="<?php echo e(url('/tickets?show=unassigned')); ?>" id="load-unassigned">
                                <i class="fa fa-th"></i> <span><?php echo Lang::get('lang.unassigned'); ?></span>
                                <small class="label pull-right bg-green"><?php echo e(count($unassigned)); ?></small>
                            </a>
                        </li>

                        <?php if(auth()->user()->management_level != 1): ?>
                            <li <?php echo $__env->yieldContent('escalated'); ?>>
                                <a href="<?php echo e(url('/tickets?show=escalated')); ?>" id="load-escalated">
                                    <i class="fa fa-arrow-up"></i> <span><?php echo Lang::get('lang.escalated'); ?></span>
                                    <small class="label pull-right bg-green"><?php echo e(\App\Model\helpdesk\Ticket\Tickets::getEscalatedTicketCount()); ?></small>
                                </a>
                            </li>
                       <?php endif; ?>

                        <li <?php echo $__env->yieldContent('overdue'); ?>>
                             <a href="<?php echo e(url('/tickets?show=overdue')); ?>" id="load-unassigned">
                                <i class="fa fa-calendar-times-o"></i> <span><?php echo Lang::get('lang.overdue'); ?></span>
                                <small class="label pull-right bg-green"><?php echo e(count($overdues)); ?></small>
                            </a>
                        </li>

                        <li <?php echo $__env->yieldContent('trash'); ?>>
                             <a href="<?php echo e(url('/tickets?show=trash')); ?>">
                                <i class="fa fa-trash-o"></i> <span><?php echo Lang::get('lang.trash'); ?></span>
                                <small class="label pull-right bg-green"><?php echo e(count($deleted)); ?></small>
                            </a>
                        </li>
                        <li class="header"><?php echo Lang::get('lang.Departments'); ?></li>
                        <?php
            $flattened = $department->flatMap(function ($values) {
                return $values->keyBy('status');
            });
            $statuses = $flattened->keys();
            ?>
                            <?php
                                $segments = \Request::segments();
                                $segment = "";
                                foreach($segments as $seg){
                                    $segment.="/".$seg;
                                }
                                if(count($segments) > 2) {
                                    $dept2 = $segments[1];
                                    $status2 = $segments[2];
                                } else {
                                     $dept2 = '';
                                    $status2 = '';
                                }
                            ?>
                        <?php $__currentLoopData = $department; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name=>$dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="treeview <?php if($dept2 === $name): ?> <?php echo $__env->yieldContent('ticket-bar'); ?> <?php endif; ?> ">
                            <a href="#">
                                <i class="fa fa-folder-open"></i> <span><?php echo $name; ?></span> <i class="fa fa-angle-left pull-right"></i>
                            </a>
                           <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($dept->get($status)): ?>
                           <ul class="treeview-menu">
                                <li <?php if($status2 == $dept->get($status)->status && $dept2 === $name): ?> <?php echo $__env->yieldContent('inbox'); ?> <?php endif; ?>><a href="<?php echo e(url('tickets?departments='.$name.'&status='.$dept->get($status)->status)); ?>"><i class="fa fa-circle-o"></i> <?php echo $dept->get($status)->status; ?><small class="label pull-right bg-green"><?php echo e($dept->get($status)->count); ?></small></a></li>
                            </ul>
                           <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>

<?php \Event::dispatch('service.desk.agent.sidebar', array()); ?>
                        <?php endif; ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
<?php
$agent_group = $auth_user_assign_group;
$group = App\Model\helpdesk\Agent\Groups::where('id', '=', $agent_group)->first();
?>
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <!-- <div class="tab-content" style="background-color: #80B5D3; position: relative; width:100% ;padding: 0 0px 0 0px; z-index:999"> --> <?php #TODO: Hii imeleta Error ?>
                <div class="tab-content" style="background-color: #80B5D3; position: fixed; width:100% ;padding: 0 0px 0 0px; z-index:999">

                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <div class="tabs-content">
                            <?php if($replacetop==0): ?>
                            <div class="tabs-pane <?php echo $__env->yieldContent('dashboard-bar'); ?>"  id="tabA">
                                <ul class="nav navbar-nav">
                                </ul>
                            </div>
                            <div class="tabs-pane <?php echo $__env->yieldContent('user-bar'); ?>" id="tabB">
                                <ul class="nav navbar-nav">
                                    <li id="bar" <?php echo $__env->yieldContent('user'); ?>><a href="<?php echo e(url('user')); ?>" ><?php echo Lang::get('lang.user_directory'); ?></a></li></a></li>
                                    <li id="bar" <?php echo $__env->yieldContent('organizations'); ?>><a href="<?php echo e(url('organizations')); ?>" ><?php echo Lang::get('lang.organizations'); ?></a></li></a></li>

                                </ul>
                            </div>
                            <div class="tabs-pane <?php echo $__env->yieldContent('ticket-bar'); ?>" id="tabC">
                                <ul class="nav navbar-nav">
                                    <li id="bar" <?php echo $__env->yieldContent('open'); ?>><a href="<?php echo e(url('/tickets?show=unanswered')); ?>" id="load-open"><?php echo Lang::get('lang.not-answered'); ?></a></li>
                                    <li id="bar" <?php echo $__env->yieldContent('answered'); ?>><a href="<?php echo e(url('/tickets?show=answered')); ?>" id="load-answered"><?php echo Lang::get('lang.answered'); ?></a></li>
                                    <li id="bar" <?php echo $__env->yieldContent('assigned'); ?>><a href="<?php echo e(url('/tickets?show=assigned')); ?>" id="load-assigned" ><?php echo Lang::get('lang.assigned'); ?></a></li>
                                    <li id="bar" <?php echo $__env->yieldContent('closed'); ?>><a href="<?php echo e(url('/tickets?show=closed')); ?>" ><?php echo Lang::get('lang.closed'); ?></a></li>
                                    <li id="bar" <?php echo $__env->yieldContent('reopened'); ?>><a href="<?php echo e(url('/tickets?show=reopened')); ?>" ><?php echo Lang::get('lang.reopened'); ?></a></li>
                                    <?php if ($group->can_create_ticket == 1) { ?>
                                        <li id="bar" <?php echo $__env->yieldContent('newticket'); ?>><a href="<?php echo e(url('/newticket')); ?>" ><?php echo Lang::get('lang.create_ticket'); ?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="tabs-pane <?php echo $__env->yieldContent('tools-bar'); ?>" id="tabD">
                                <ul class="nav navbar-nav">
                                    <li id="bar" <?php echo $__env->yieldContent('tools'); ?>><a href="<?php echo e(url('/canned/list')); ?>" ><?php echo Lang::get('lang.canned_response'); ?></a></li>
                                    <?php if(\Auth::user()->role == 'admin'): ?>
                                    <li id="bar" <?php echo $__env->yieldContent('kb'); ?>><a href="<?php echo e(url('/comment')); ?>" ><?php echo Lang::get('lang.knowledge_base'); ?></a></li> <?php /*TODO: fIX kb */ ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                            
                            <div class="tabs-pane <?php echo $__env->yieldContent('report-bar'); ?>" id="tabE">
                                <ul class="nav navbar-nav">
                                    <?php if($auth_user_role == 'admin'): ?>
                                        <li id="bar" ><a href="<?php echo e(URL::route('report.index')); ?>" >General Report</a></li>
                                        <li id="bar" ><a href="<?php echo e(URL::route('report.user')); ?>" >All Users Report</a></li> <?php /*TODO: IMPLEMENT USER REPORT */ ?>
                                        <li id="bar" ><a href="<?php echo e(URL::route('report.open')); ?>" >Detailed Tickets Report</a></li> <?php /*TODO: IMPLEMENT USER REPORT */ ?>
                                        <li id="bar" ><a href="<?php echo e(URL::route('report.crm')); ?>" >CRM Report Overview</a></li> <?php /*TODO: IMPLEMENT USER REPORT */ ?>
                                        <li id="bar" ><a href="<?php echo e(URL::route('report.graphical-reports')); ?>" >Detailed Graphical Reports</a></li> <?php /*TODO: IMPLEMENT USER REPORT */ ?>
                                    <?php endif; ?>
                                        <li id="bar" ><a href="<?php echo e(URL::route('report.user.show',[Auth::user()->id])); ?>" >My Report</a></li> <?php /*TODO: IMPLEMENT USER REPORT */ ?>

                                </ul>
                            </div>
                            <?php endif; ?>
<?php \Event::dispatch('service.desk.agent.topsubbar', array()); ?>
                        </div>
                    </div>
                </div>
                <section class="content-header">
                    <?php echo $__env->yieldContent('PageHeader'); ?>
                    <?php if(Breadcrumbs::exists()): ?>
                    <?php echo Breadcrumbs::render(); ?>

                    <?php endif; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                <?php if($dummy_installation == 1 || $dummy_installation == '1'): ?>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fa  fa-exclamation-triangle"></i> <?php if(\Auth::user()->role == 'admin'): ?>
                            <?php echo e(Lang::get('lang.dummy_data_installation_message')); ?> <a href="<?php echo e(route('clean-database')); ?>"><?php echo e(Lang::get('lang.click')); ?></a> <?php echo e(Lang::get('lang.clear-dummy-data')); ?>

                        <?php else: ?>
                            <?php echo e(Lang::get('lang.clear-dummy-data-agent-message')); ?>

                        <?php endif; ?>
                    </div>
                <?php elseif(!$is_mail_conigured): ?>
                <?php //dd(env('SUPPRESS_EMAIL_WARNING')); ?>

                    <?php if(env('SUPPRESS_EMAIL_WARNING', 'false')): ?>
                    <?php endif; ?>
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
            </div>
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <!-- <b><?php echo Lang::get('lang.version'); ?></b> <?php echo Config::get('app.version'); ?> -->
                </div>
                <?php
                $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                ?>
                <strong><?php echo Lang::get('lang.copyright'); ?> &copy; <?php echo date('Y'); ?>  
                    <a href="<?php echo $company->website; ?>" target="_blank"><?php echo $company->company_name; ?></a>.
                </strong> 
                <?php echo Lang::get('lang.all_rights_reserved'); ?>. 

                <!-- <?php echo Lang::get('lang.powered_by'); ?> <a href="http://www.faveohelpdesk.com/" target="_blank">Faveo</a> -->
            </footer>
        </div><!-- ./wrapper -->

        <script src="<?php echo e(asset("lb-faveo/js/ajax-jquery.min.js")); ?>" type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/plugins/moment/moment.js")); ?>" type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/js/bootstrap-datetimepicker4.7.14.min.js")); ?>" type="text/javascript"></script>
        <!-- Bootstrap 3.3.2 JS -->
        <script src="<?php echo e(asset("lb-faveo/js/bootstrap.min.js")); ?>" type="text/javascript"></script>
        <!-- Slimscroll -->
        <script src="<?php echo e(asset("lb-faveo/plugins/slimScroll/jquery.slimscroll.min.js")); ?>" type="text/javascript"></script>
        <!-- FastClick -->
        <script src="<?php echo e(asset("lb-faveo/plugins/fastclick/fastclick.min.js")); ?>"  type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo e(asset("lb-faveo/js/app.min.js")); ?>" type="text/javascript"></script>

        <!-- iCheck -->
        <script src="<?php echo e(asset("lb-faveo/plugins/iCheck/icheck.min.js")); ?>" type="text/javascript"></script>
        <!-- jquery ui -->
        <script src="<?php echo e(asset("lb-faveo/js/jquery.ui.js")); ?>" type="text/javascript"></script>

        <!-- <script src="<?php echo e(asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")); ?>" type="text/javascript"></script>-->

         <!-- <script src="<?php echo e(asset("lb-faveo/plugins/datatables/jquery.dataTables.js")); ?>" type="text/javascript"></script> -->
        <!-- Page Script -->
        <script src="<?php echo e(asset("lb-faveo/js/jquery.dataTables1.10.10.min.js")); ?>" type="text/javascript" ></script>

        <script type="text/javascript" src="<?php echo e(asset("lb-faveo/plugins/datatables/dataTables.bootstrap.js")); ?>"></script>


        <script src="<?php echo e(asset("lb-faveo/js/jquery.rating.pack.js")); ?>" type="text/javascript"></script>

        <script src="<?php echo e(asset("lb-faveo/plugins/select2/select2.full.min.js")); ?>" type="text/javascript"></script>



        <!-- full calendar-->
        <script src="<?php echo e(asset('lb-faveo/plugins/fullcalendar/fullcalendar.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('lb-faveo/plugins/daterangepicker/daterangepicker.js')); ?>" type="text/javascript"></script>
        <script>

        $(document).ready(function () {

            $('.noti_User').click(function () {
            var id = this.id;
                    var dataString = 'id=' + id;
                    $.ajax
                    ({
                    type: "POST",
                            url: "<?php echo e(url('mark-read')); ?>" + "/" + id,
                            data: dataString,
                            cache: false,
                            success: function (html)
                            {
                            }
                    });
            });
            });
                    $('#read-all').click(function () {

            var id2 = <?php echo $auth_user_id ?>;
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
        <script>
                    $(function() {
                    // Enable check and uncheck all functionality
                    $(".checkbox-toggle").click(function() {
                    var clicks = $(this).data('clicks');
                            if (clicks) {
                    //Uncheck all checkboxes
                    $("input[type='checkbox']", ".mailbox-messages").iCheck("uncheck");
                    } else {
                    //Check all checkboxes
                    $("input[type='checkbox']", ".mailbox-messages").iCheck("check");
                    }
                    $(this).data("clicks", !clicks);
                    });
                            //Handle starring for glyphicon and font awesome
                            $(".mailbox-star").click(function(e) {
                    e.preventDefault();
                            //detect type
                            var $this = $(this).find("a > i");
                            var glyph = $this.hasClass("glyphicon");
                            var fa = $this.hasClass("fa");
                            //Switch states
                            if (glyph) {
                    $this.toggleClass("glyphicon-star");
                            $this.toggleClass("glyphicon-star-empty");
                    }
                    if (fa) {
                    $this.toggleClass("fa-star");
                            $this.toggleClass("fa-star-o");
                    }
                    });
                    });</script>

        <script src="<?php echo e(asset("lb-faveo/js/tabby.js")); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset("lb-faveo/js/languagechanger.js")); ?>" type="text/javascript"></script>
        <!-- <script src="<?php echo e(asset("lb-faveo/plugins/filebrowser/plugin.js")); ?>" type="text/javascript"></script> -->

        <script src="<?php echo e(asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")); ?>" type="text/javascript"></script>

        <script type="text/javascript">
                    $.ajaxSetup({
                    headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                    });</script>
        <script type="text/javascript">
                    function clickURL(e, url) {
                        if (e.ctrlKey === true) {
                            window.open(url, '_blank');
                        } else {
                            window.location = url;
                        }
                    }

            function clickReport(e) {
            if (e.ctrlKey === true) {
            window.open('<?php echo e(URL::route("report.index")); ?>', '_blank');
            } else {
            window.location = "<?php echo e(URL::route('report.index')); ?>";
            }
            }
        </script>
        <script>
    $(function() {


        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue'
        });
        $('input[type="radio"]:not(.not-apply)').iCheck({
            radioClass: 'iradio_flat-blue'
        });

    });
</script>
<?php Event::dispatch('show.calendar.script', array()); ?>
<?php Event::dispatch('load-calendar-scripts', array()); ?>
        <?php echo $__env->yieldContent('FooterInclude'); ?>
    </body>
</html>
<?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/agent/layout/agent.blade.php ENDPATH**/ ?>