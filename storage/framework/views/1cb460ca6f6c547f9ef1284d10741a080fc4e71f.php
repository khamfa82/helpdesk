<?php $__env->startSection('home'); ?>
    class = "active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<link href="<?php echo e(asset("lb-faveo/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css")); ?>" rel="stylesheet" type="text/css" />
           <link href="<?php echo e(asset("lb-faveo/css/widgetbox.css")); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset("lb-faveo/plugins/iCheck/flat/blue.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        
        <link href="<?php echo e(asset("lb-faveo/css/jquerysctipttop.css")); ?>" rel="stylesheet" type="text/css">
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <div class="site-hero clearfix">
        <ol class="breadcrumb breadcrumb-custom">
            <li class="text"><?php echo Lang::get('lang.you_are_here'); ?>: </li>
            <li><a href="<?php echo URL::route('/'); ?>"><?php echo Lang::get('lang.home'); ?></a></li>
        </ol>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php if(Session::has('status')): ?>
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"> </i> <b> <?php echo Lang::get('lang.success'); ?> </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo e(Session::get('status')); ?>

</div>
<?php endif; ?>

<?php if(count($errors) > 0): ?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b><?php echo Lang::get('lang.alert'); ?> !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li><?php echo e($error); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>
<div id="content" class="site-content col-md-12">
    <div id="corewidgetbox">
        <div class="widgetrow text-center">
        <?php if(Auth::user()): ?>
        <?php else: ?>
            <span onclick="javascript: window.location.href='<?php echo e(url('auth/login')); ?>';">
                <a href="<?php echo e(url('auth/login')); ?>"  style="background-image:url(<?php echo e(URL::asset('lb-faveo/media/images/register.png')); ?>)">
                    <span class="widgetitemtitle"><?php echo Lang::get('lang.login'); ?></span>
                </a>
            </span>
        <?php endif; ?>
        <?php $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();            
        ?>
        <?php if($system != null): ?> 
            <?php if($system->status): ?> 
                <?php if($system->status == 1): ?>
                    <span onclick="javascript: window.location.href='<?php echo URL::route('form'); ?>';">
                        <a href="<?php echo URL::route('form'); ?>" class="widgetrowitem defaultwidget" style="background-image:url(<?php echo e(URL::asset('lb-faveo/media/images/submitticket.png')); ?>)">
                            <span class="widgetitemtitle"><?php echo Lang::get('lang.submit_a_ticket'); ?></span>
                        </a>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
            <span onclick="javascript: window.location.href='<?php echo e(url('mytickets')); ?>';">
                <a href="<?php echo e(url('mytickets')); ?>" class="widgetrowitem defaultwidget" style="background-image:url(<?php echo e(URL::asset('lb-faveo/media/images/news.png')); ?>)">
                    <span class="widgetitemtitle"><?php echo Lang::get('lang.my_tickets'); ?></span>
                </a>
            </span>
            <span onclick="javascript: window.location.href='<?php echo e(url('/knowledgebase')); ?>';">
                <a href="<?php echo e(url('/knowledgebase')); ?>" class="widgetrowitem defaultwidget" style="background-image:url(<?php echo e(URL::asset('lb-faveo/media/images/knowledgebase.png')); ?>)">
                    <span class="widgetitemtitle"><?php echo Lang::get('lang.knowledge_base'); ?></span>
                </a>
            </span>
        </div>
    </div>

     <div class="login-box" style=" width: 500px;"  valign = "center">
 <div class="form-border">
     
                <div align="center">
                 <h4 style="background-color: #0084b4;"> <a href="<?php echo e(route('/')); ?>" class="logo"><img src="<?php echo e(asset('lb-faveo/media/images/logo.png')); ?>" width="100px;"></a>
                 </h4>
                  
                </div>
               
                <div>
 <h3 class="box-title" align="center"><?php echo e(Lang::get('lang.registration')); ?></h3>
                  
                </div>   
                <div>
<placeholder="Let’s set up your account in just a couple of steps.">
                  
                </div>       
    <!-- form open -->
<?php echo Form::open(['action'=>'Auth\AuthController@postRegister', 'method'=>'post']); ?>


<!-- fullname -->
<div class="form-group has-feedback <?php echo e($errors->has('full_name') ? 'has-error' : ''); ?>">
            
 <?php echo Form::text('full_name',null,['placeholder'=>Lang::get('lang.full_name'),'class' => 'form-control']); ?>

 <span class="glyphicon glyphicon-user form-control-feedback"></span>

</div>
<!-- Email -->
<?php if(($email_mandatory->status == 1 || $email_mandatory->status == '1')): ?>
<div class="form-group has-feedback <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
    <?php echo Form::text('email',null,['placeholder'=>Lang::get('lang.email'),'class' => 'form-control']); ?>

    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>
<?php elseif(($settings->status == 0 || $settings->status == '0') && ($email_mandatory->status == 0 || $email_mandatory->status == '0')): ?>
<div class="form-group has-feedback <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
    <?php echo Form::text('email',null,['placeholder'=>Lang::get('lang.email'),'class' => 'form-control']); ?>

    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
</div>
<?php else: ?>
    <?php echo Form::hidden('email', null); ?>

<?php endif; ?>
<?php if($settings->status == '1' || $settings->status == 1): ?>
<div class='row'>
    <div class="col-md-3">
        <div class="form-group <?php echo e($errors->has('code') ? 'has-error' : ''); ?>">
        <?php echo Form::text('code',null,['placeholder'=>91,'class' => 'form-control']); ?>

        </div>    
    </div>
    <div class="col-md-9">
        <div class="form-group has-feedback <?php echo e($errors->has('mobile') ? 'has-error' : ''); ?>">
        <?php echo Form::text('mobile',null,['placeholder'=>Lang::get('lang.mobile'),'class' => 'form-control']); ?>

        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
        </div>
    </div>
</div>
<?php else: ?>
    <?php echo Form::hidden('mobile', null); ?>

    <?php echo Form::hidden('code', null); ?>


<?php endif; ?>
<!-- Password -->
<div class="form-group has-feedback <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
           
    <?php echo Form::password('password',['placeholder'=>Lang::get('lang.password'),'class' => 'form-control']); ?>

    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

</div>
<!-- Confirm password -->
<div class="form-group has-feedback <?php echo e($errors->has('password_confirmation') ? 'has-error' : ''); ?>">
           
    <?php echo Form::password('password_confirmation',['placeholder'=>Lang::get('lang.retype_password'),'class' => 'form-control']); ?>

    <span class="glyphicon glyphicon-log-in form-control-feedback"></span>

</div>
   

  

    <div >
        <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo Lang::get('lang.register'); ?></button>
    </div>

        <div>
        <div class="checkbox icheck" align="center">
            <label>
               Already got an account? <a href="<?php echo e(url('auth/login')); ?>" class="text-center"><?php echo Lang::get('lang.login'); ?></a>                
            </label>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php echo $__env->make('themes.default1.client.layout.social-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div><!-- /.col --> </div>
</div>
</div>
<?php echo Form::close(); ?>  

<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.client.layout.logclient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/auth/register.blade.php ENDPATH**/ ?>