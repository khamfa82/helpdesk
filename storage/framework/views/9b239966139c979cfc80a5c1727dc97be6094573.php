<?php $__env->startSection('Tickets'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('tickets-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('tickets'); ?>
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
<?php echo Form::model($tickets,['url' => 'postticket/'.$tickets->id, 'method' => 'PATCH']); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(Lang::get('lang.ticket-setting')); ?></h3>
    </div>
    <div class="box-body">
        <!-- check whether success or not -->
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa  fa-check-circle"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('success'); ?>

        </div>
        <?php endif; ?>
        <!-- failure message -->
        <?php if(Session::has('fails')): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('fails'); ?>

        </div>
        <?php endif; ?>
        <?php if(Session::has('errors')): ?>
        <?php //dd($errors); ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?>!</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <br/>
            <?php if($errors->first('status')): ?>
            <li class="error-message-padding"><?php echo $errors->first('status', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('priority')): ?>
            <li class="error-message-padding"><?php echo $errors->first('priority', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('sla')): ?>
            <li class="error-message-padding"><?php echo $errors->first('sla', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('help_topic')): ?>
            <li class="error-message-padding"><?php echo $errors->first('help_topic', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('collision_avoid')): ?>
            <li class="error-message-padding"><?php echo $errors->first('collision_avoid', ':message'); ?></li>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="row">
            <!-- Default Status: Required : manual: Dropdowm  -->
            <div class="col-md-6">
                <div class="form-group <?php echo e($errors->has('status') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('status',Lang::get('lang.default_status')); ?>

                    <select class="form-control" id="status" name="status">
                        <option value="1" >Open</option>
                    </select>
                </div>
            </div>
            <!-- Default Priority:	Required : manual : Dropdowm  -->
            <div class="col-md-6">
                <div class="form-group <?php echo e($errors->has('priority') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('priority',Lang::get('lang.default_priority')); ?>

                    <?php echo Form::select('priority', [''=>'select a priority','Priorities'=>$priority->pluck('priority_desc','priority_id')->toArray()],null,['class' => 'form-control']); ?>

                </div>
            </div>
        </div>
        <div class="row">
            <!-- Default SLA:	Required : manual : Dropdowm  -->
            <!-- <div class="col-md-4">
                <div class="form-group <?php echo e($errors->has('sla') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('sla',Lang::get('lang.default_sla')); ?>

                    <?php echo Form::select('sla', $slas->pluck('grace_period','id'),null,['class' => 'form-control']); ?>

                </div>
            </div> -->
            <!-- Default Help Topic:  Dropdowm from Help topic table	 -->
            <!-- <div class="col-md-4">
                <div class="form-group <?php echo e($errors->has('help_topic') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('help_topic',Lang::get('lang.default_help_topic')); ?>

                    <?php echo Form::select('help_topic', $topics->pluck('topic','id'),null,['class' => 'form-control']); ?>

                </div>
            </div>
            --><!-- Agent Collision Avoidance Duration: text-number   -minutes  -->
            <div class="col-md-6">
                <div class="form-group <?php echo e($errors->has('collision_avoid') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('collision_avoid',Lang::get('lang.agent_collision_avoidance_duration')); ?> 
                    <div class="input-group">
                        <input type="number" class="form-control" name="collision_avoid" min="0"  step="1" value="<?php echo e($tickets->collision_avoid); ?>" placeholder="in minutes">
                        <div class="input-group-addon">
                            <span><i class="fa fa-clock-o"></i> <?php echo Lang::get('lang.in_minutes'); ?></span>
                        </div>
                    </div>
                </div> 
            </div> 
            <div class="col-md-6">
                <div class="form-group <?php echo e($errors->has('help_topic') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('help_topic',Lang::get('lang.lock_ticket_frequency')); ?>


                    <select name='lock_ticket_frequency' class="form-control">
                        <option <?php if($tickets->lock_ticket_frequency == null): ?> selected="true" <?php endif; ?> value="0"><?php echo Lang::get('lang.no'); ?></option>
                        <option <?php if($tickets->lock_ticket_frequency == 1): ?> selected="true" <?php endif; ?> value="1"><?php echo Lang::get('lang.only-once'); ?></option>
                        <option <?php if($tickets->lock_ticket_frequency == 2): ?> selected="true" <?php endif; ?> value="2"><?php echo Lang::get('lang.frequently'); ?></option>
                    </select>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group <?php echo e($errors->has('num_format') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('num_format',Lang::get('lang.format')); ?> 
                     <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e(Lang::get('lang.ticket-number-format')); ?>"><i class="fa fa-question-circle" style="padding: 0px;"></i></a>
                    <?php echo Form::text('num_format',null,['class'=>'form-control','id'=>'format']); ?>


                    <div id="result"></div>

                </div>
                
            </div> 

            <div class="col-md-6">
                <div class="form-group <?php echo e($errors->has('num_sequence') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('num_sequence',Lang::get('lang.type')); ?> 
                    <a href="#" data-toggle="tooltip" data-placement="right" title="<?php echo e(Lang::get('lang.ticket-number-type')); ?>"><i class="fa fa-question-circle" style="padding: 0px;"></i></a>
        
                    <?php echo Form::select('num_sequence',[''=>'Select','sequence'=>'Sequence','random'=>'Random'],null,['class'=>'form-control','id'=>'type']); ?>


                    <div id="result"></div>
                </div> 
            </div> 
           

        </div>
    </div>


    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['class'=>'btn btn-primary']); ?>

    </div>
</div>
<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('FooterInclude'); ?>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    $(document).ready(function () {
        var format = $("#format").val();
        var type = $("#type").val();
        send(format, type);
        $("#format").keyup(function () {
            format = $("#format").val();
            type = $("#type").val();
            send(format, type);
        });
        $("#type").on('change', function () {
            format = $("#format").val();
            type = $("#type").val();
            send(format, type);
        });
        function send(format, type) {
            $.ajax({
                url: "<?php echo e(url('get-ticket-number')); ?>",
                type: "GET",
                dataType: "html",
                data: {'format': format, 'type': type},
                success: function (response) {
                    $("#result").html("Number :<b> " + response + "</b>");
                },
                error: function (response) {
                    console.log(response);
                    $("#result").html("<i>Invalid format</i>");
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/ticket.blade.php ENDPATH**/ ?>