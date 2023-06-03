<?php $__env->startSection('Emails'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('emails-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('emails'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.emails')); ?></h1>
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
	<div class="row">
<div class="col-md-12">
<div class="box box-primary">
<div class="box-header">
	<h2 class="box-title"><?php echo Lang::get('lang.emails'); ?></h2><a href="<?php echo e(route('emails.create')); ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo e(Lang::get('lang.create_email')); ?></a></div>

<div class="box-body table-responsive">

<!-- check whether success or not -->

<?php if(Session::has('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo e(Session::get('success')); ?>

    </div>
    <?php endif; ?>
    <!-- failure message -->
    <?php if(Session::has('fails')): ?>
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo e(Session::get('fails')); ?>

    </div>
    <?php endif; ?>

    <?php
    $default_system_email = App\Model\helpdesk\Settings\Email::where('id', '=', '1')->first();
    if($default_system_email->sys_email) {
    	$default_email = $default_system_email->sys_email;
    } else {
    	$default_email = null;
    }
    ?>
    		<!-- table -->
				<table class="table table-bordered dataTable" style="overflow:hidden;">
	<tr>
							<th width="100px"><?php echo e(Lang::get('lang.email')); ?></th>
							<th width="100px"><?php echo e(Lang::get('lang.priority')); ?></th>
							<th width="100px"><?php echo e(Lang::get('lang.department')); ?></th>
							<th width="100px"><?php echo e(Lang::get('lang.created')); ?></th>
							<th width="100px"><?php echo e(Lang::get('lang.last_updated')); ?></th>
							<th width="100px"><?php echo e(Lang::get('lang.action')); ?></th>
						</tr>
						<?php $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>

							<td><a href="<?php echo e(route('emails.edit', $email->id)); ?>"> <?php echo e($email -> email_address); ?></a>
							<?php if($default_email == $email->id): ?> 
								( Default )
								<?php $disabled = 'disabled'; ?>
							<?php else: ?>
								<?php $disabled = ''; ?>
							<?php endif; ?>
							</td>
							<?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id','=',$email->priority)->first(); ?>
							<?php if($email->priority == null): ?>
								<?php $priority = "<a href=". url('getticket') .">System Default</a>"; ?>
							<?php else: ?> 
								<?php $priority = ucfirst($priority->priority_desc); ?>
							<?php endif; ?>
							<td><?php echo $priority; ?></td>
							<?php if($email->department !== null): ?>
								<?php  $department = App\Model\helpdesk\Agent\Department::where('id','=',$email->department)->first(); 
								$dept = $department->name; ?>
							<?php elseif($email->department == null): ?>
								<?php  $dept = "<a href=". url('getsystem') .">System Default</a>"; ?>
							<?php endif; ?>

							<td><?php echo $dept; ?></td>
							<td><?php echo UTC::usertimezone($email->created_at); ?></td>
							<td><?php echo UTC::usertimezone($email->updated_at); ?></td>
							<td>
							<?php echo Form::open(['route'=>['emails.destroy', $email->id],'method'=>'DELETE']); ?>

							<a href="<?php echo e(route('emails.edit', $email->id)); ?>" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
							<!-- To pop up a confirm Message -->
								<?php echo Form::button('<i class="fa fa-trash" style="color:black;"> </i> Delete',
				            		['type' => 'submit',
				            		'class'=> 'btn btn-warning btn-xs btn-flat '. $disabled,
				            		'onclick'=>'return confirm("Are you sure?")']); ?>

							<?php echo Form::close(); ?>

							</td>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/emails/emails/index.blade.php ENDPATH**/ ?>