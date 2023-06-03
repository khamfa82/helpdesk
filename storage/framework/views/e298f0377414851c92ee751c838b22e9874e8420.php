<?php $__env->startSection('Manage'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('manage-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('priority'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h1><?php echo Lang::get('lang.ticket_priority'); ?></h1>
<?php $__env->stopSection(); ?>
<!-- /header -->
<!-- breadcrumbs -->
<?php $__env->startSection('breadcrumbs'); ?>
<ol class="breadcrumb">
</ol>
<?php $__env->stopSection(); ?>

<!-- content -->
<?php $__env->startSection('content'); ?>

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
<div class="box box-primary">
    <div class="box-header with-border">
        <span class="lead border-right"><?php echo Lang::get('lang.priority'); ?></span>
        <div class="pull-right">
             <a href="<?php echo e(route('priority.create')); ?>" class="btn btn-primary"> <span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo e(Lang::get('lang.create_ticket_priority')); ?></a>
        </div>
    </div>

      <div class="box-header with-border">
    <a class="right" title="" data-placement="right" data-toggle="tooltip" href="#" data-original-title="<?php echo e(Lang::get('lang.active_user_can_select_the_priority_while_creating_ticket')); ?>">

        <span class="lead border-right" ><?php echo Lang::get('lang.current'); ?><?php echo Lang::get('lang.user_priority_status'); ?></span>
       
           </a>

                            <div class="btn-group pull-right" id="toggle_event_editing">
                                <button type="button"  class="btn <?php echo e($user_status->status == '0' ? 'btn-info' : 'btn-default'); ?> locked_active">Inactive</button>
                                <button type="button"  class="btn <?php echo e($user_status->status == '1' ? 'btn-info' : 'btn-default'); ?> unlocked_inactive">Active</button>
                            </div>
                            <!-- <div class="alert alert-info" id="switch_status"></div> -->
                      
             <!-- <a href="<?php echo e(route('priority.create')); ?>" class="btn btn-primary"><?php echo e(Lang::get('lang.create_ticket_priority')); ?></a> -->
        
    </div>





    <div class="box-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Color</th>
                    <th>Urgency</th>
                    <th>Is Public</th>
                    <th>Is Default</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($priority->priority_id); ?></td>
                        <td>
                            <a style='color: <?php echo e($priority->status == 1 ? 'green' : 'red'); ?>'><?php echo e($priority->status == 1 ? 'Active' : 'Inactive'); ?></a>
                        </td>
                        <td><?php echo e($priority->priority); ?></td>
                        <td><?php echo e($priority->priority_desc); ?></td>
                        <td>
                            <button class='btn btn-sm' style ='background-color:<?php echo e($priority->priority_color); ?>'></button>
                        </td>
                        <td><?php echo e($priority->priority_urgency); ?></td>
                        <td><?php echo e($priority->ispublic); ?></td>
                        <td>
                            <?php if($priority->is_default > 0): ?>
                                <a href="/ticket/priority/<?php echo e($priority->priority_id); ?>/edit" class='btn btn-info btn-xs'>Edit</a>&nbsp;<a href="#" class='btn btn-warning btn-info btn-xs' disabled='disabled' > Delete </a>
                            <?php else: ?>
                                <a href="/ticket/priority/<?php echo e($priority->priority_id); ?>/edit" class='btn btn-info btn-xs'>Edit</a>&nbsp;<a href="#" class='btn btn-warning btn-info btn-xs' onclick='confirmDelete("<?php echo e($priority->priority_id); ?>")'> Delete </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="box-footer">
    </div>
</div>
<script type="text/javascript">
    $('a').tooltip()
</script>

<script>
    function confirmDelete(priority_id) {
        var r = confirm('Are you sure?');
        if (r == true) {
            // console.log(r);
            // alert('<?php echo url("ticket_priority"); ?>/' + priority_id + '/destroy');
            window.location = '<?php echo url("ticket/priority"); ?>/' + priority_id + '/destroy';
            //    $url('ticket_priority/' . $priority->priority_id . '/destroy')
        } else {
            return false;
        }
    }
</script>
<script>
    $('#toggle_event_editing button').click(function () {

        var user_settings_priority=1;
         var user_settings_priority=0;
        if ($(this).hasClass('locked_active') ) {
         

            user_settings_priority = 0
        } if ( $(this).hasClass('unlocked_inactive')) {
          
            user_settings_priority = 1;
        }

        /* reverse locking status */
        $('#toggle_event_editing button').eq(0).toggleClass('locked_inactive locked_active btn-default btn-info');
        $('#toggle_event_editing button').eq(1).toggleClass('unlocked_inactive unlocked_active btn-info btn-default');
        $.ajax({
            type: 'post',
            url: '<?php echo e(route("user.priority.index")); ?>',
            data: {
                "_token": "<?php echo e(csrf_token()); ?>",
                user_settings_priority: user_settings_priority},
            success: function (result) {
                // with('success', Lang::get('lang.approval_settings-created-successfully'));
                // alert("Hi, testing");
                alert(result);
                location.reload(); 
            }
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/manage/ticket_priority/index.blade.php ENDPATH**/ ?>