<?php $__env->startSection('Manage'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('manage-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('workflow'); ?>
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
<?php $__env->stopSection(); ?>
<!-- /breadcrumbs -->
<!-- content -->
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title"><?php echo Lang::get('lang.ticket_workflow'); ?></h3>
                <a href="<?php echo URL::route('workflow.create'); ?>" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-plus"></span> &nbsp;<?php echo Lang::get('lang.create'); ?></a>
            </div>
            <!-- /.box-header -->
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
                    <b><?php echo Lang::get('lang.alert'); ?> !</b>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <?php echo Session::get('fails'); ?>

                </div>
                <?php endif; ?>
                <?php echo Datatable::table()
                ->addColumn(Lang::get('lang.name'),
                Lang::get('lang.status'),
                Lang::get('lang.order'),
                Lang::get('lang.rules'),
                Lang::get('lang.target_channel'),
                Lang::get('lang.created'),
                Lang::get('lang.updated'),
                Lang::get('lang.action')) // these are the column headings to be shown
                ->setUrl(route('workflow.list'))   // this is the route where data will be retrieved
                ->render(); ?>

            </div>
            <!-- </div> -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>
<script>
    $(function() {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/manage/workflow/index.blade.php ENDPATH**/ ?>