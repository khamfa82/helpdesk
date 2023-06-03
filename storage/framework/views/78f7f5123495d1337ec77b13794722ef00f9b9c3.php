<?php $__env->startSection('Manage'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('manage-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('help'); ?>
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
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(Lang::get('lang.help_topic')); ?></h3>
        <a href="<?php echo e(route('helptopic.create')); ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo e(Lang::get('lang.create_help_topic')); ?></a>
    </div>
    <div class="box-body table-responsive">
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
            <b><?php echo Lang::get('lang.alert'); ?> !</b>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo Session::get('fails'); ?>

        </div>
        <?php endif; ?>
        <table class="table table-bordered dataTable">
            <tr>
                <th width="100px"><?php echo e(Lang::get('lang.topic')); ?></th>
                <th width="100px"><?php echo e(Lang::get('lang.status')); ?></th>
                <th width="100px"><?php echo e(Lang::get('lang.type')); ?></th>
                <th width="100px"><?php echo e(Lang::get('lang.priority')); ?></th>
                <th width="100px"><?php echo e(Lang::get('lang.department')); ?></th>
                <th width="100px"><?php echo e(Lang::get('lang.last_updated')); ?></th>
                <th width="100px"><?php echo e(Lang::get('lang.action')); ?></th>
            </tr>
            <?php
            $default_helptopic = App\Model\helpdesk\Settings\Ticket::where('id', '=', '1')->first();
            $default_helptopic = $default_helptopic->help_topic;
            ?>
            <!-- Foreach @var$topics as @var  topic -->
            <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr style="padding-bottom:-30px">
                <!-- topic Name with Link to Edit page along Id -->
                <td><a href="<?php echo e(route('helptopic.edit',$topic->id)); ?>"><?php echo $topic->topic; ?>

                        <?php if($topic->id == $default_helptopic): ?>
                        ( Default )
                        <?php
                        $disable = 'disabled';
                        ?>
                        <?php else: ?>
                        <?php
                        $disable = '';
                        ?>
                        <?php endif; ?>
                    </a></td>

                <!-- topic Status : if status==1 active -->
                <td>
                    <?php if($topic->status=='1'): ?>
                    <span style="color:green"><?php echo Lang::get('lang.active'); ?></span>
                    <?php else: ?>
                    <span style="color:red"><?php echo Lang::get('lang.disable'); ?></span>
                    <?php endif; ?>
                </td>

                <!-- Type -->

                <td>
                    <?php if($topic->type=='1'): ?>
                    <span style="color:green"><?php echo Lang::get('lang.public'); ?></span>
                    <?php else: ?>
                    <span style="color:red"><?php echo Lang::get('lang.private'); ?></span>
                    <?php endif; ?>
                </td>
                <!-- Priority -->
                <?php $priority = App\Model\helpdesk\Ticket\Ticket_Priority::where('priority_id', '=', $topic->priority)->first(); ?>
                <td><?php echo $priority->priority_desc; ?></td>
                <!-- Department -->
                <?php if($topic->department != null): ?>
                <?php
                $dept = App\Model\helpdesk\Agent\Department::where('id', '=', $topic->department)->first();
                $dept = $dept->name;
                ?>
                <?php elseif($topic->department == null): ?>
                <?php $dept = ""; ?>
                <?php endif; ?>
                <td> <?php echo $dept; ?> </td>
                <!-- Last Updated -->
                <td> <?php echo UTC::usertimezone($topic->updated_at); ?> </td>
                <!-- Deleting Fields -->
                <td>
                    <?php echo Form::open(['route'=>['helptopic.destroy', $topic->id],'method'=>'DELETE']); ?>

                    <a href="<?php echo e(route('helptopic.edit',$topic->id)); ?>" class="btn btn-info btn-xs btn-flat"><i class="fa fa-trash" style="color:black;"> </i> <?php echo Lang::get('lang.edit'); ?></a>
                    <!-- To pop up a confirm Message -->
                    <?php echo Form::button('<i class="fa fa-trash" style="color:black;"> </i> '.Lang::get('lang.delete'),
                    ['type' => 'submit',
                    'class'=> 'btn btn-warning btn-xs btn-flat '.$disable,
                    'onclick'=>'return confirm("Are you sure?")']); ?>

                    </div>
                    <?php echo Form::close(); ?>

                </td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
            <!-- Set a link to Create Page -->

        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/manage/helptopic/index.blade.php ENDPATH**/ ?>