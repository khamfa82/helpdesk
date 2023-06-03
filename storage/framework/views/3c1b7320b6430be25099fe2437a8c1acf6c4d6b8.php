<?php $__env->startSection('Manage'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('manage-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sla'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo e(Lang::get('lang.manage')); ?></h1>
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
	<h2 class="box-title"><?php echo e(Lang::get('lang.SLA_plan')); ?></h2><a href="<?php echo e(route('sla.create')); ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo e(Lang::get('lang.create_SLA')); ?></a></div>

<div class="box-body table-responsive">

<!-- check whether success or not -->

<?php if(Session::has('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <i class="fa  fa-check-circle"></i>
        <b>Success!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Session::get('success'); ?>

    </div>
    <?php endif; ?>
    <!-- failure message -->
    <?php if(Session::has('fails')): ?>
    <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <b>Fail!</b>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo Session::get('fails'); ?>

    </div>
    <?php endif; ?>

<table class="table table-bordered dataTable" style="overflow:hidden;">

	<tr>
		<th width="100px"><?php echo e(Lang::get('lang.name')); ?></th>
		<th width="100px"><?php echo e(Lang::get('lang.status')); ?></th>
		<th width="100px"><?php echo e(Lang::get('lang.grace_period')); ?></th>
		<th width="100px"><?php echo e(Lang::get('lang.created')); ?></th>
		<th width="100px"><?php echo e(Lang::get('lang.last_updated')); ?></th>
		<th width="100px"><?php echo e(Lang::get('lang.action')); ?></th>
	</tr>

<?php
$default_sla = App\Model\helpdesk\Settings\Ticket::where('id','=','1')->first();
$default_sla = $default_sla->sla;
?>

	<!-- Foreach @var$slas as @var  sla -->
		<?php $__currentLoopData = $slas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sla): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<tr>
		<!-- sla Name with Link to Edit page along Id -->
		<td><a href="<?php echo e(route('sla.edit',$sla->id)); ?>"><?php echo $sla->name; ?>

		<?php if($sla->id == $default_sla): ?>
			( Default )
		<?php  
			$disable = 'disabled';
		?>
		<?php else: ?>
		<?php  
			$disable = '';
		?>
		<?php endif; ?>
		</a> </td>
		<!-- sla Status : if status==1 active -->
		<td>
			<?php if($sla->status=='1'): ?>
				<span style="color:green">Active</span>
			<?php else: ?>
				<span style="color:red">Disable</span>
			<?php endif; ?>
		</td>
		<!-- To show the sla's Time Period -->
		<td><?php echo $sla->grace_period; ?></td>
		<!-- Created Date -->
		<td><?php echo UTC::usertimezone($sla->created_at); ?></td>
		<!-- Last Updated -->
		<td> <?php echo UTC::usertimezone($sla->updated_at); ?> </td>
		<!-- Deleting Fields -->
		<td>
			<?php echo Form::open(['route'=>['sla.destroy', $sla->id],'method'=>'DELETE']); ?>

			<a href="<?php echo e(route('sla.edit',$sla->id)); ?>" class="btn btn-info btn-xs btn-flat"><i class="fa fa-edit" style="color:black;"> </i> Edit</a>
			<!-- To pop up a confirm Message -->
				<?php echo Form::button('<i class="fa fa-trash" style="color:black;"> </i> Delete',
            		['type' => 'submit',
            		'class'=> 'btn btn-warning btn-xs btn-flat '.$disable,
            		'onclick'=>'return confirm("Are you sure?")']); ?>

			<?php echo Form::close(); ?>

		</td>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tr>
	<!-- Set a link to Create Page -->

</table>

</div>
</div>
</div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/manage/sla/index.blade.php ENDPATH**/ ?>