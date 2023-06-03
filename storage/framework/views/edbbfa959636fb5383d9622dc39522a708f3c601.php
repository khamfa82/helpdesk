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



<!-- <?php if(count($errors) > 0): ?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b><?php echo Lang::get('lang.alert'); ?> !</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li><?php echo e($error); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?> -->


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

<?php if(Session::has('error')): ?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa  fa-check-circle"> </i> <b> <?php echo Lang::get('lang.alert'); ?> </b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo e(Session::get('error')); ?>

</div>
<?php else: ?>

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
<?php endif; ?>

<div id="content" class="site-content col-md-12">
    <!-- <div id="corewidgetbox">
        <div class="widgetrow text-center"> -->
        <?php if(Auth::user()): ?>
        <?php else: ?> <?php /*
            <span onclick="javascript: window.location.href='{{url('auth/register')}}';">
                <a href="{{url('auth/register')}}"  style="background-image:url({{ URL::asset('lb-faveo/media/images/register.png') }})">
                    <span class="widgetitemtitle">{!! Lang::get('lang.register') !!}</span>
                </a>
            </span> */ ?>
        <?php endif; ?>
        <?php $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();            
        /*
        @if($system != null) 
            @if($system->status) 
                @if($system->status == 1)
                    <span onclick="javascript: window.location.href='{!! URL::route('form') !!}';">
                        <a href="{!! URL::route('form') !!}" class="widgetrowitem defaultwidget" style="background-image:url({{ URL::asset('lb-faveo/media/images/submitticket.png') }})">
                            <span class="widgetitemtitle">{!! Lang::get('lang.submit_a_ticket') !!}</span>
                        </a>
                    </span>
                @endif
            @endif
        @endif
            <span onclick="javascript: window.location.href='{{url('mytickets')}}';">
                <a href="{{url('mytickets')}}" class="widgetrowitem defaultwidget" style="background-image:url({{ URL::asset('lb-faveo/media/images/news.png') }})">
                    <span class="widgetitemtitle">{!! Lang::get('lang.my_tickets') !!}</span>
                </a>
            </span>
            <span onclick="javascript: window.location.href='{{url('/knowledgebase')}}';">
                <a href="{{url('/knowledgebase')}}" class="widgetrowitem defaultwidget" style="background-image:url({{ URL::asset('lb-faveo/media/images/knowledgebase.png') }})">
                    <span class="widgetitemtitle">{!! Lang::get('lang.knowledge_base') !!}</span>
                </a>
            </span> */ ?>
        <!-- </div>
    </div> -->
<script type="text/javascript"> $(function(){ $('.dialogerror, .dialoginfo, .dialogalert').fadeIn('slow');$("form").bind("submit", function(e){$(this).find("input:submit").attr("disabled", "disabled");});});</script>
<script type="text/javascript" >try {if (top.location.hostname != self.location.hostname) { throw 1; }} catch (e) { top.location.href = self.location.href; }</script>
</div></div>
 <div class="login-box" style=" width: 500px;
    height: 150px;"  valign = "center">
 <div class="form-border">
     
                <div align="center">
                 <h4 style="background-color: #0084b4;"> <a href="<?php echo e(route('/')); ?>" class="logo"><img src="<?php echo e(asset('lb-faveo/media/images/logo.png')); ?>" width="100px;"></a>
</h4>
                  
                </div>
               
                <div>
 <h4 class="box-title" align="center"><?php echo e(Lang::get('lang.login_to_start_your_session')); ?></h4>
                  
                </div>

  
<!-- form open -->
<?php echo Form::open(['action'=>'Auth\AuthController@postLogin', 'method'=>'post']); ?>

<!-- Email -->
 <div class="col-xs-12">
<div class="form-group has-feedback <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
    <?php echo Form::text('email',null,['placeholder'=> Lang::get("lang.email") ,'class' => 'form-control']); ?>

    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

</div>
</div>
 <div class="col-xs-12">

<!-- Password -->
<div class="form-group has-feedback <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
        
 <?php echo Form::password('password',['placeholder'=>Lang::get("lang.password"),'class' => 'form-control']); ?>

    <span class="glyphicon glyphicon-lock form-control-feedback"></span>

</div>
</div>
        
        
    <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo Lang::get("lang.login"); ?></button>
    </div><!-- /.col -->


</form>


 
<div class="row">
        <div class="col-xs-12">

    <div class="col-xs-4">

<div>
            <label>
                <input type="checkbox" name="remember"> <?php echo Lang::get("lang.remember"); ?>

            </label>
        </div>  </div>
    <!-- /.col -->

    <div class="col-xs-6">
 
<a href="<?php echo e(url('password/email')); ?>"><?php echo Lang::get("lang.iforgot"); ?></a><br> 

</div>
<?php /*
 <div class="col-xs-2">
 
<a href="{{url('auth/register')}}" class="text-center">{!! Lang::get("lang.register") !!}</a>


</div> */ ?>
            <div class="col-md-12">
                <?php echo $__env->make('themes.default1.client.layout.social-login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>

<!-- /.login-page -->
  </div><!-- /.col -->
</div>


<?php echo Form::close(); ?>  

<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.client.layout.logclient', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/auth/login.blade.php ENDPATH**/ ?>