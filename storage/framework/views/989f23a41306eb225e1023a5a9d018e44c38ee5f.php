<?php $__env->startSection('API'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('settings-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('plugin'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.api')); ?></h1>
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
<div class="box box-primary">
<?php echo Form::open(['url'=>'api','method'=>'post','files'=>true]); ?>

    <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(Lang::get('lang.api_settings')); ?></h3>     
        
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <?php endif; ?>
                <?php if(Session::has('success')): ?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo e(Session::get('success')); ?>

                </div>
                <?php endif; ?>
                <!-- fail message -->
                <?php if(Session::has('fails')): ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo e(Session::get('fails')); ?>

                </div>
                <?php endif; ?>
                        <h4><?php echo Lang::get('lang.api_configurations'); ?></h4>
        <!-- Guest user page Content -->
        <div class="row">
            <div class="col-md-3">
                <div class="form-group <?php echo e($errors->has('api_enable') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('api',Lang::get('lang.api')); ?>

                    <?php echo $errors->first('api_enable', '<spam class="help-block">:message</spam>'); ?>

                    <div class="row">
                        <div class="col-xs-5">
                            <input type="radio" name="api_enable" value="1" <?php if($systems->api_enable ==1): ?> checked <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.enable')); ?>

                            <!-- <?php echo Form::radio('api_enable','1',true); ?> <?php echo e(Lang::get('lang.enable')); ?> -->
                        </div>
                        <div class="col-xs-5">
                            <input type="radio" name="api_enable" value="0" <?php if($systems->api_enable == 0): ?> checked <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.disable')); ?>

                            <!-- <?php echo Form::radio('api_enable','0'); ?> <?php echo e(Lang::get('lang.disable')); ?> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group <?php echo e($errors->has('api_key_mandatory') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('api_key_mandatory',Lang::get('lang.api_key_mandatory')); ?>

                    <?php echo $errors->first('api_key_mandatory', '<spam class="help-block">:message</spam>'); ?>

                    <div class="row">
                        <div class="col-xs-5">
                            <input type="radio" name="api_key_mandatory" value="1" <?php if($systems->api_key_mandatory == 1): ?> checked <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.enable')); ?>

                            <!-- <?php echo Form::radio('api_key_mandatory','1',true); ?> <?php echo e(Lang::get('lang.enable')); ?> -->
                        </div>
                        <div class="col-xs-5">
                             <input type="radio" name="api_key_mandatory" value="0" <?php if($systems->api_key_mandatory == 0): ?> checked <?php endif; ?>>&nbsp;<?php echo e(Lang::get('lang.disable')); ?>

                            <!-- <?php echo Form::radio('api_key_mandatory','0'); ?> <?php echo e(Lang::get('lang.disable')); ?> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Date and Time Format: text: required: eg - 03/25/2015 7:14 am -->
            <div class="col-md-3">
                <div class="form-group <?php echo e($errors->has('api_key') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('api_key',Lang::get('lang.api_key')); ?>

                    <?php echo $errors->first('api_key', '<spam class="help-block">:message</spam>'); ?>

                    <?php echo Form::text('api_key',$systems->api_key,['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="col-md-3">
                <br/>
                <a class="btn btn-primary" id="generate"> <i class="fa fa-refresh"> </i> <?php echo Lang::get('lang.generate_key'); ?></a>
            </div>
        </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
     <div class="row">
            <div class="col-md-12">
            <h4><?php echo Lang::get('lang.webhooks'); ?></h4>
        <div class="col-md-6">
                    <div class="form-group <?php echo e($errors->has('ticket_detail') ? 'has-error' : ''); ?>">
                        <?php echo Form::label('ticket_detail',Lang::get('lang.enter_url_to_send_ticket_details'),['class'=>'required']); ?>

                        <?php echo Form::text('ticket_detail',$ticket_detail,['class' => 'form-control','placeholder'=>'http://www.example.com']); ?>

                        <p></p>
                    </div>
                </div>
                </div></div>
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.update'),['class'=>'btn btn-primary']); ?> 
    </div>
    <?php echo Form::close(); ?>   
</div>
<a href="#" id="clickGenerate" data-toggle="modal" data-target="#generateModal"></a>    
<div class="modal fade" id="generateModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo Lang::get('lang.api_key'); ?></h4>
            </div>
            <div class="modal-body" id="messageBody">
            </div>
            <div class="modal-footer" id="messageBody">
                <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close"><?php echo Lang::get('lang.close'); ?></button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="<?php echo e(asset("lb-faveo/js/ajax-jquery.min.js")); ?>"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
// Close a ticket
    $('#generate').on('click', function(e) {
        $.ajax({
            type: "GET",
            url: "<?php echo url('generate-api-key'); ?>",
            beforeSend: function() {
                $("#generate").empty();
                var message = "<i class='fa fa-refresh fa-spin'> </i>  <?php echo Lang::get('lang.generate_key'); ?>";
                $('#generate').html(message);
            },
            success: function(response) {
                // alert(response);

                $("#messageBody").empty();
                var message = "<div class='alert alert-default' style='margin-bottom: -5px;'>Copy and paste in the api to set a different Api key</div> <br/><b>Api key</b> : " + response;
                $('#messageBody').html(message);

                $('#clickGenerate').trigger("click");
                $("#generate").empty();
                var message = "<i class='fa fa-refresh'> </i>  <?php echo Lang::get('lang.generate_key'); ?>";
                $('#generate').html(message);
            }
        })
        return false;
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/common/api/settings.blade.php ENDPATH**/ ?>