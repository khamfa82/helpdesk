<?php $__env->startSection('title'); ?>
<?php echo Lang::get('lang.submit_a_ticket'); ?> -
<?php $__env->stopSection(); ?>

<?php $__env->startSection('submit'); ?>
class = "active"
<?php $__env->stopSection(); ?>
<!-- breadcrumbs -->
<?php $__env->startSection('breadcrumb'); ?>
<div class="site-hero clearfix">
    <ol class="breadcrumb breadcrumb-custom">
        <li class="text"><?php echo Lang::get('lang.you_are_here'); ?>: </li>
        <li><a href="<?php echo URL::route('form'); ?>"><?php echo Lang::get('lang.submit_a_ticket'); ?></a></li>
    </ol>
</div>
<?php $__env->stopSection(); ?>
<!-- /breadcrumbs -->
<?php $__env->startSection('check'); ?>
<div class="banner-wrapper  clearfix">
    <h3 class="banner-title text-center text-info h4"><?php echo Lang::get('lang.have_a_ticket'); ?>?</h3>
    <?php if(Session::has('check')): ?>
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
    <div class="banner-content text-center">
        <?php echo Form::open(['url' => 'checkmyticket' , 'method' => 'POST'] ); ?>

        <?php echo Form::label('email',Lang::get('lang.email')); ?><span class="text-red"> *</span>
        <?php echo Form::text('email_address',null,['class' => 'form-control']); ?>

        <?php echo Form::label('ticket_number',Lang::get('lang.ticket_number')); ?><span class="text-red"> *</span>
        <?php echo Form::text('ticket_number',null,['class' => 'form-control']); ?>

        <br/><input type="submit" value="<?php echo Lang::get('lang.check_ticket_status'); ?>" class="btn btn-info">
        <?php echo Form::close(); ?>

    </div>
</div>  
<?php $__env->stopSection(); ?>
<!-- content -->
<?php $__env->startSection('content'); ?>
<div id="content" class="site-content col-md-9">
    <?php if(Session::has('message')): ?>
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Session::get('message'); ?>

    </div>
    <?php endif; ?>
    <?php if(count($errors) > 0): ?>
    <?php if(Session::has('check')): ?>
    <?php goto a; ?>
    <?php endif; ?>
    <?php if(!Session::has('error')): ?>
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
    <?php a: ?>
    <?php endif; ?>
    <!-- open a form -->
    
    <script src="<?php echo e(asset("lb-faveo/js/jquery2.0.2.min.js")); ?>" type="text/javascript"></script>
    <!--
    |====================================================
    | SELECT FROM
    |====================================================
    -->
    <?php
    $encrypter = app('Illuminate\Encryption\Encrypter');
    $encrypted_token = $encrypter->encrypt(csrf_token());
    ?>
    <input id="token" type="hidden" value="<?php echo e($encrypted_token); ?>">
    <?php echo Form::open(['action'=>'Client\helpdesk\FormController@postedForm','method'=>'post', 'enctype'=>'multipart/form-data']); ?>

    <div>
        <div class="content-header">
            <h4><?php echo Lang::get('lang.ticket'); ?> </h4>
        </div>
        <div class="row col-md-12">
            
                <?php if(Auth::user()): ?>
                    
                        <?php echo Form::hidden('Name',Auth::user()->user_name,['class' => 'form-control']); ?>

                    
                <?php else: ?>
                    <div class="col-md-12 form-group <?php echo e($errors->has('Name') ? 'has-error' : ''); ?>">
                        <?php echo Form::label('Name',Lang::get('lang.name')); ?><span class="text-red"> *</span>
                        <?php echo Form::text('Name',null,['class' => 'form-control']); ?>

                    </div>
                <?php endif; ?>
            
            

                <?php if(Auth::user()): ?>
                    
                        <?php echo Form::hidden('Email',Auth::user()->email,['class' => 'form-control']); ?>

                    
                <?php else: ?>
                    <div class="col-md-12 form-group <?php echo e($errors->has('Email') ? 'has-error' : ''); ?>">
                        <?php echo Form::label('Email',Lang::get('lang.email')); ?>

                        <?php if($email_mandatory->status == 1 || $email_mandatory->status == '1'): ?>
                        <span class="text-red"> *</span>
                        <?php endif; ?>
                        <?php echo Form::email('Email',null,['class' => 'form-control']); ?>

                    </div>
                <?php endif; ?>


                
            
                <?php if(!Auth::user()): ?>
                    
            <div class="col-md-2 form-group <?php echo e(Session::has('country_code_error') ? 'has-error' : ''); ?>">
                <?php echo Form::label('Code',Lang::get('lang.country-code')); ?>

                 <?php if($email_mandatory->status == 0 || $email_mandatory->status == '0'): ?>
                        <span class="text-red"> *</span>
                        <?php endif; ?>

                <?php echo Form::text('Code',null,['class' => 'form-control', 'placeholder' => $phonecode, 'title' => Lang::get('lang.enter-country-phone-code')]); ?>

            </div>
            <div class="col-md-5 form-group <?php echo e($errors->has('mobile') ? 'has-error' : ''); ?>">
                <?php echo Form::label('mobile',Lang::get('lang.mobile_number')); ?>

                 <?php if($email_mandatory->status == 0 || $email_mandatory->status == '0'): ?>
                        <span class="text-red"> *</span>
                        <?php endif; ?>
                <?php echo Form::text('mobile',null,['class' => 'form-control']); ?>

            </div>
            <div class="col-md-5 form-group <?php echo e($errors->has('Phone') ? 'has-error' : ''); ?>">
                <?php echo Form::label('Phone',Lang::get('lang.phone')); ?>

                <?php echo Form::text('Phone',null,['class' => 'form-control']); ?>

            </div>
            <?php else: ?> 
                <?php echo Form::hidden('mobile',Auth::user()->mobile,['class' => 'form-control']); ?>

                <?php echo Form::hidden('Code',Auth::user()->country_code,['class' => 'form-control']); ?>

                <?php echo Form::hidden('Phone',Auth::user()->phone_number,['class' => 'form-control']); ?>

 
           <?php endif; ?>
            <div class="col-md-12 form-group <?php echo e($errors->has('help_topic') ? 'has-error' : ''); ?>">
                <?php echo Form::label('help_topic', Lang::get('lang.choose_a_help_topic')); ?> 
                <?php echo $errors->first('help_topic', '<spam class="help-block">:message</spam>'); ?>

                <?php
                $forms = App\Model\helpdesk\Form\Forms::get();
                $helptopic = App\Model\helpdesk\Manage\Help_topic::where('status', '=', 1)->get();
                ?>                  
                <select name="helptopic" class="form-control" id="selectid">
                    
                    <?php $__currentLoopData = $helptopic; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo $topic->id; ?>"><?php echo $topic->topic; ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <!-- priority -->
             <?php 
             $Priority = App\Model\helpdesk\Settings\CommonSettings::select('status')->where('option_name','=', 'user_priority')->first(); 
             $user_Priority=$Priority->status;
            ?>
             
             <?php if(Auth::user()): ?>

             <?php if(Auth::user()->active == 1): ?>
            <?php if($user_Priority == 1): ?>
             

             <div class="col-md-12 form-group">
                <div class="row">
                    <div class="col-md-1">
                        <label><?php echo Lang::get('lang.priority'); ?>:</label>
                    </div>
                    <div class="col-md-12">
                        <?php $Priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('status','=',1)->get(); ?>
                        <?php echo Form::select('priority', ['Priority'=>$Priority->pluck('priority_desc','priority_id')->toArray()],null,['class' => 'form-control select']); ?>

                    </div>
                 </div>
            </div>
           <?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>
            <div class="col-md-12 form-group <?php echo e($errors->has('Subject') ? 'has-error' : ''); ?>">
                <?php echo Form::label('Subject',Lang::get('lang.subject')); ?><span class="text-red"> *</span>
                <?php echo Form::text('Subject',null,['class' => 'form-control']); ?>

            </div>
            <div class="col-md-12 form-group <?php echo e($errors->has('Details') ? 'has-error' : ''); ?>">
                <?php echo Form::label('Details',Lang::get('lang.message')); ?><span class="text-red"> *</span>
                <?php echo Form::textarea('Details',null,['class' => 'form-control']); ?>

            </div>
            <div class="col-md-12 form-group">
                <div class="btn btn-default btn-file"><i class="fa fa-paperclip"> </i> <?php echo Lang::get('lang.attachment'); ?><input type="file" name="attachment[]" multiple/></div><br/>
                <?php echo Lang::get('lang.max'); ?>. 10MB
            </div>
            
            <?php Event::dispatch(new App\Events\ClientTicketForm()); ?>
            <div class="col-md-12" id="response"> </div>
            <div id="ss" class="xs-md-6 form-group <?php echo e($errors->has('') ? 'has-error' : ''); ?>"> </div>
            <div class="col-md-12 form-group"><?php echo Form::submit(Lang::get('lang.Send'),['class'=>'form-group btn btn-info pull-left', 'onclick' => 'this.disabled=true;this.value="Sending, please wait...";this.form.submit();']); ?></div>
        </div>
        <div class="col-md-12" id="response"> </div>
        <div id="ss" class="xs-md-6 form-group <?php echo e($errors->has('') ? 'has-error' : ''); ?>"> </div>
    </div>
    <?php echo Form::close(); ?>

</div>
<!--
|====================================================
| SELECTED FORM STORED IN SCRIPT
|====================================================
-->
<script type="text/javascript">
$(document).ready(function(){
   var helpTopic = $("#selectid").val();
   send(helpTopic);
   $("#selectid").on("change",function(){
       helpTopic = $("#selectid").val();
       send(helpTopic);
   });
   function send(helpTopic){
       $.ajax({
           url:"<?php echo e(url('/get-helptopic-form')); ?>",
           data:{'helptopic':helpTopic},
           type:"GET",
           dataType:"html",
           success:function(response){
               $("#response").html(response);
           },
           error:function(response){
              $("#response").html(response); 
           }
       });
   }
});

$(function() {
//Add text editor
    $("textarea").wysihtml5();
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.client.layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/client/helpdesk/form.blade.php ENDPATH**/ ?>