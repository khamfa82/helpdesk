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
<?php if(!Session::has('error') && count($errors)>0): ?>
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b><?php echo Lang::get('lang.alert'); ?> !</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>
<div id="content" class="site-content col-md-12">
    <div id="corewidgetbox">
        <div class="widgetrow text-center">
        <?php if(Auth::user()): ?>
        <?php else: ?>
            <span onclick="javascript: window.location.href='<?php echo e(url('auth/register')); ?>';">
                <a href="<?php echo e(url('auth/register')); ?>" class="widgetrowitem defaultwidget" style="background-image: URL('lb-faveo/media/images/register.png');">
                    <span class="widgetitemtitle"><?php echo Lang::get('lang.register'); ?></span>
                </a>
            </span>
        <?php endif; ?>
        <?php $system = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();            
        ?>
        <?php if($system != null): ?> 
            <?php if($system->status): ?> 
                <?php if($system->status == 1): ?>
                    <span onclick="javascript: window.location.href='<?php echo URL::route('form'); ?>';">
                        <a href="<?php echo URL::route('form'); ?>" class="widgetrowitem defaultwidget" style="background-image: URL('lb-faveo/media/images/submitticket.png');">
                            <span class="widgetitemtitle"><?php echo Lang::get('lang.submit_a_ticket'); ?></span>
                        </a>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
            <span onclick="javascript: window.location.href='<?php echo e(url('mytickets')); ?>';">
                <a href="<?php echo e(url('mytickets')); ?>" class="widgetrowitem defaultwidget" style="background-image: URL('lb-faveo/media/images/news.png');">
                    <span class="widgetitemtitle"><?php echo Lang::get('lang.my_tickets'); ?></span>
                </a>
            </span>
            <span onclick="javascript: window.location.href='<?php echo e(url('/knowledgebase')); ?>';">
                <a href="<?php echo e(url('/knowledgebase')); ?>" class="widgetrowitem defaultwidget" style="background-image: URL('lb-faveo/media/images/knowledgebase.png');">
                    <span class="widgetitemtitle"><?php echo Lang::get('lang.knowledge_base'); ?></span>
                </a>
            </span>
        </div>
    </div>
<script type="text/javascript"> $(function(){ $('.dialogerror, .dialoginfo, .dialogalert').fadeIn('slow');$("form").bind("submit", function(e){$(this).find("input:submit").attr("disabled", "disabled");});});</script>
<script type="text/javascript" >try {if (top.location.hostname != self.location.hostname) { throw 1; }} catch (e) { top.location.href = self.location.href; }</script>
</div>   

<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.client.layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/client/helpdesk/guest-user/index.blade.php ENDPATH**/ ?>