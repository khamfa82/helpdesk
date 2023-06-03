<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <?php
        $title = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
        if (isset($title->name)) {
            $title_name = $title->name;
        } else {
            $title_name = "SUPPORT CENTER";
        }
        ?>
        <title> <?php echo $__env->yieldContent('title'); ?> <?php echo strip_tags($title_name); ?> </title>
        <!-- faveo favicon -->
        <link href="<?php echo e(asset("lb-faveo/media/images/favicon.ico")); ?>"  rel="shortcut icon" >

        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="<?php echo e(asset("lb-faveo/css/bootstrap.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Admin LTE CSS -->
        <link href="<?php echo e(asset("lb-faveo/css/AdminLTEsemi.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="<?php echo e(asset("lb-faveo/css/font-awesome.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo e(asset("lb-faveo/css/ionicons.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- fullCalendar 2.2.5-->
        <link href="<?php echo e(asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo e(asset("lb-faveo/css/jquery.rating.css")); ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo e(asset("lb-faveo/css/app.css")); ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo e(asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")); ?>" rel="stylesheet" type="text/css" />

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo e(asset("lb-faveo/js/jquery2.1.1.min.js")); ?>" type="text/javascript"></script>
        <?php echo $__env->yieldContent('HeadInclude'); ?>
    </head>
    <body>
        <div id="page" class="hfeed site">
            <header id="masthead" class="site-header" role="banner">

                <div class="container" style="">
                    <div id="logo" class="site-logo text-center" style="font-size: 30px;">
                        <?php
                        $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first();
                        $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
                        ?>
                        <?php if($system->url): ?>
                        <a href="<?php echo $system->url; ?>" rel="home">
                            <?php else: ?>
                            <a href="<?php echo e(url('/')); ?>" rel="home">
                                <?php endif; ?>
                                <?php if($company->use_logo == 1): ?>
                                <img src="<?php echo e(asset('uploads/company')); ?><?php echo e('/'); ?><?php echo e($company->logo); ?>" alt="User Image" width="200px" height="200px"/>
                                <?php else: ?>
                                <?php if($system->name): ?>
                                <?php echo $system->name; ?>

                                <?php else: ?>
                                <b>SUPPORT</b> CENTER
                                <?php endif; ?>
                                <?php endif; ?>
                            </a>
                    </div><!-- #logo -->
                    <div id="navbar" class="navbar-wrapper text-center">
                        <nav class="navbar navbar-default site-navigation" role="navigation">
                            <ul class="nav navbar-nav navbar-menu">
                                <li <?php echo $__env->yieldContent('home'); ?>><a href="<?php echo e(route('/')); ?>"><?php echo Lang::get('lang.home'); ?></a></li>
                                <?php if($system->first()->status == 1): ?>
                                <li <?php echo $__env->yieldContent('submit'); ?>><a href="<?php echo e(route('form')); ?>">
                                  <?php echo Lang::get('lang.submit_a_ticket'); ?></a>
                                </li>
                                <?php endif; ?>
                                <li <?php echo $__env->yieldContent('kb'); ?>><a href="<?php echo url('knowledgebase'); ?>"><?php echo Lang::get('lang.knowledge_base'); ?></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo e(route('category-list')); ?>"><?php echo Lang::get('lang.categories'); ?></a></li>
                                        <li><a href="<?php echo e(route('article-list')); ?>"><?php echo Lang::get('lang.articles'); ?></a></li>
                                    </ul>
                                </li>
                                <?php $pages = App\Model\kb\Page::where('status', '1')->where('visibility', '1')->get();
                                ?>
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('pages',$page->slug)); ?>"><?php echo e($page->name); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(Auth::user()): ?>
                                <li <?php echo $__env->yieldContent('myticket'); ?>><a href="<?php echo e(url('mytickets')); ?>"><?php echo Lang::get('lang.my_tickets'); ?></a></li>

                                
                                <li <?php echo $__env->yieldContent('profile'); ?>><a href="#" ><?php echo Lang::get('lang.my_profile'); ?></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <div class="banner-wrapper user-menu text-center clearfix">
                                                <img src="<?php echo e(Auth::user()->profile_pic); ?>"class="img-circle" alt="User Image" height="80" width="80"/>
                                                <h3 class="banner-title text-info h4"><?php echo e(Auth::user()->first_name." ".Auth::user()->last_name); ?></h3>
                                                <div class="banner-content">
                                                     <a href="<?php echo e(url('auth/logout')); ?>" class="btn btn-custom btn-xs"><?php echo Lang::get('lang.log_out'); ?></a>
                                                </div>
                                                <?php if(Auth::user()): ?>
                                                <?php if(Auth::user()->role != 'user'): ?>
                                                <div class="banner-content">
                                                    <a href="<?php echo e(url('dashboard')); ?>" class="btn btn-custom btn-xs"><?php echo Lang::get('lang.dashboard'); ?></a>
                                                </div>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                                <?php if(Auth::user()): ?>
                                                <?php if(Auth::user()->role == 'user'): ?>
                                                <div class="banner-content">
                                                    <a href="<?php echo e(url('client-profile')); ?>" class="btn btn-custom btn-xs"><?php echo Lang::get('lang.profile'); ?></a>
                                                </div>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!-- .navbar-user -->
                            <?php else: ?>





                            <?php endif; ?>
                        </nav><!-- #site-navigation -->
                    </div><!-- #navbar -->
                   <?php /* <div id="header-search" class="site-search clearfix" style="padding-bottom:5px"><!-- #header-search -->
                        {!!Form::open(['method'=>'get','action'=>'Client\kb\UserController@search','class'=>'search-form clearfix'])!!}
                        <div class="form-border">
                            <div class="form-inline ">
                                <div class="form-group">
                                    <input type="text" name="s" id="s" class="search-field form-control input-lg" title="Enter search term" placeholder="{!! Lang::get('lang.have_a_question?_type_your_search_term_here') !!}" required />
                                </div>
                                <button type="submit" class="search-submit btn btn-custom btn-lg pull-right check-s">{!! Lang::get('lang.search') !!}</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div> */ ?>
                </div>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <!-- Right side column. Contains the navbar and content of the page -->
            <div class="site-hero clearfix">
                    <?php if(Breadcrumbs::exists()): ?>
                    <?php echo Breadcrumbs::render(); ?>

                    <?php endif; ?>
            </div>
            <!-- Main content -->
            <div id="main" class="site-main clearfix">
                <div class="container">
                    <div class="content-area">
                        <div class="row">
                            <?php if(Session::has('success')): ?>
                            <div class="alert alert-success alert-dismissable">
                                <i class="fa  fa-check-circle"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo e(Session::get('success')); ?>

                            </div>
                            <?php endif; ?>
                            <?php if(Session::has('warning')): ?>
                            <div class="alert alert-warning alert-dismissable">
                                <i class="fa  fa-check-circle"></i>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo Session::get('warning'); ?>

                            </div>
                            <?php endif; ?>
                            <!-- failure message -->
                            <?php if(Session::has('fails')): ?>
                            <?php if(Session::has('check')): ?>
<?php goto a; ?>
                            <?php endif; ?>
                            <div class="alert alert-danger alert-dismissable">
                                <i class="fa fa-ban"></i>
                                <b><?php echo Lang::get('lang.alert'); ?> !</b>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo e(Session::get('fails')); ?>

                            </div>
<?php a: ?>
                            <?php endif; ?>
                            <?php echo $__env->yieldContent('content'); ?>
                            <div id="sidebar" class="site-sidebar col-md-3">
                                <div class="widget-area">
                                    <section id="section-banner" class="section">
                                        <?php echo $__env->yieldContent('check'); ?>
                                    </section><!-- #section-banner -->
                                    <section id="section-categories" class="section">
                                        <?php echo $__env->yieldContent('category'); ?>
                                    </section><!-- #section-categories -->
                                </div>
                            </div><!-- #sidebar -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content-wrapper -->
            <?php
            $footer1 = App\Model\helpdesk\Theme\Widgets::where('name', '=', 'footer1')->first();
            $footer2 = App\Model\helpdesk\Theme\Widgets::where('name', '=', 'footer2')->first();
            $footer3 = App\Model\helpdesk\Theme\Widgets::where('name', '=', 'footer3')->first();
            $footer4 = App\Model\helpdesk\Theme\Widgets::where('name', '=', 'footer4')->first();
            ?>
            <footer id="colophon" class="site-footer" role="contentinfo">
                <div class="container">
                    <div class="row col-md-12">
                        <?php if($footer1->title == null): ?>
                        <?php else: ?>
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-about" class="section">
                                    <h2 class="section-title h4 clearfix"><?php echo $footer1->title; ?></h2>
                                    <div class="textwidget">
                                        <p><?php echo $footer1->value; ?></p>
                                    </div>
                                </section><!-- #section-about -->
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($footer2->title == null): ?>
                        <?php else: ?>
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-latest-news" class="section">
                                    <h2 class="section-title h4 clearfix"><?php echo $footer2->title; ?></h2>
                                    <div class="textwidget">
                                        <p><?php echo $footer2->value; ?></p>
                                    </div>
                                </section><!-- #section-latest-news -->
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($footer3->title == null): ?>
                        <?php else: ?>
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-newsletter" class="section">
                                    <h2 class="section-title h4 clearfix"><?php echo $footer3->title; ?></h2>
                                    <div class="textwidget">
                                        <p><?php echo $footer3->value; ?></p>
                                    </div>
                                </section><!-- #section-newsletter -->
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if($footer4->title == null): ?>
                        <?php else: ?>
                        <div class="col-md-3">
                            <div class="widget-area">
                                <section id="section-newsletter" class="section">
                                    <h2 class="section-title h4 clearfix"><?php echo e($footer4->title); ?></h2>
                                    <div class="textwidget">
                                        <p><?php echo $footer4->value; ?></p>
                                    </div>
                                </section>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr style="color:#E5E5E5"/>
                    <div class="row">
                        <div class="site-info col-md-6">
                            <p class="text-muted"><?php echo Lang::get('lang.copyright'); ?> &copy; <?php echo date('Y'); ?>  <a href="<?php echo $company->website; ?>" target="_blank"><?php echo $company->company_name; ?></a>. <?php echo Lang::get('lang.all_rights_reserved'); ?>. 
                                <!-- <?php echo Lang::get('lang.powered_by'); ?> <a href="http://www.faveohelpdesk.com/"  target="_blank">Faveo</a> -->
                            </p>
                        </div>
                        <div class="site-social text-right col-md-6">
<?php $socials = App\Model\helpdesk\Theme\Widgets::all(); ?>
                            <ul class="list-inline hidden-print">
                                <?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($social->name == 'facebook'): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo $social->value; ?>" class="btn btn-social btn-facebook" target="_blank"><i class="fa fa-facebook fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "twitter"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-twitter" target="_blank"><i class="fa fa-twitter fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "google"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-google-plus" target="_blank"><i class="fa fa-google-plus fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "linkedin"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-linkedin" target="_blank"><i class="fa fa-linkedin fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "vimeo"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-vimeo" target="_blank"><i class="fa fa-vimeo-square fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "youtube"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-youtube" target="_blank"><i class="fa fa-youtube-play fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "pinterest"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-pinterest" target="_blank"><i class="fa fa-pinterest fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "dribbble"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-dribbble" target="_blank"><i class="fa fa-dribbble fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "flickr"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-flickr" target="_blank"><i class="fa fa-flickr fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "instagram"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-instagram" target="_blank"><i class="fa fa-instagram fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($social->name == "rss"): ?>
                                <?php if($social->value): ?>
                                <li><a href="<?php echo e($social->value); ?>" class="btn btn-social btn-rss" target="_blank"><i class="fa fa-rss fa-fw"></i></a></li>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
            </footer><!-- #colophon -->
            <!-- jQuery 2.1.1 -->

            <script src="<?php echo e(asset("lb-faveo/js/jquery2.1.1.min.js")); ?>" type="text/javascript"></script>
            <!-- Bootstrap 3.3.2 JS -->
            <script src="<?php echo e(asset("lb-faveo/js/bootstrap.min.js")); ?>" type="text/javascript"></script>
            <!-- Slimscroll -->
            <script src="<?php echo e(asset("lb-faveo/js/superfish.js")); ?>" type="text/javascript"></script>

            <script src="<?php echo e(asset("lb-faveo/js/mobilemenu.js")); ?>" type="text/javascript"></script>

            <script src="<?php echo e(asset("lb-faveo/js/know.js")); ?>" type="text/javascript"></script>

            <script src="<?php echo e(asset("lb-faveo/js/jquery.rating.pack.js")); ?>" type="text/javascript"></script>

            <script src="<?php echo e(asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js")); ?>" type="text/javascript"></script>

            <script src="<?php echo e(asset("lb-faveo/plugins/iCheck/icheck.min.js")); ?>" type="text/javascript"></script>

            <script>
$(function () {
//Enable check and uncheck all functionality
    $(".checkbox-toggle").click(function () {
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
    $(".mailbox-star").click(function (e) {
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
});
            </script>

    </body>
</html>
<?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/client/layout/logclient.blade.php ENDPATH**/ ?>