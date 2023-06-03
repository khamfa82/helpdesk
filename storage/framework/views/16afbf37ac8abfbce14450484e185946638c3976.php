<?php $__env->startSection('Plugins'); ?>
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
<h1><?php echo Lang::get('lang.plugins'); ?></h1>
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
        <h3 class="box-title"><?php echo Lang::get('lang.plugins-list'); ?></h3>
        <button type="button" class="btn btn-primary pull-right" id="Edit_Ticket" data-toggle="modal" data-target="#Edit"><b><?php echo Lang::get('lang.add_plugin'); ?></b></button>        
        <div class="modal fade" id="Edit">
            <div class="modal-dialog">
                <div class="modal-content">  
                    <div class="modal-header">
                        <h4 class="modal-title"><?php echo Lang::get('lang.add_plugin'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php echo Form::open(['url'=>'post-plugin','files'=>true]); ?>

                        <label><?php echo Lang::get('lang.plugin'); ?> :</label> 
                        <div class="btn bg-olive btn-file" style="color:blue">
                            <?php echo Lang::get('lang.upload_file'); ?><input type="file" name="plugin">
                        </div>
                    </div><!-- /.modal-content -->   
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal" id="dismis"><?php echo Lang::get('lang.close'); ?></button>
                        <input type="submit" class="btn btn-primary pull-right" value="<?php echo Lang::get('lang.upload'); ?>">
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
    <div class="box-body">
        <div class="alert alert-info alert-dismissable">
            <i class="fa fa-info-circle"></i>
            <b><?php echo Lang::get('lang.plugin-info'); ?></b><br/>
            <a href="http://www.faveohelpdesk.com/plugins/" target="_blank"><?php echo Lang::get('lang.click-here'); ?></a>&nbsp;<?php echo Lang::get('lang.plugin-info-pro'); ?>

        </div>
        <?php if(count($errors) > 0): ?>
        <div class="alert alert-danger alert-dismissable">
            <i class="fa fa-ban"></i>
            <b><?php echo Lang::get('lang.alert'); ?>!</b><br/>
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>
        <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check-circle"></i>
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
        <div class="row">
            <div class="col-md-12">
                <script src="<?php echo e(asset('lb-faveo/plugins/jQuery/jQuery-2.1.4.min.js')); ?>" type="text/javascript"></script>
                <script type="text/javascript" src="<?php echo e(asset('lb-faveo/plugins/datatables/jquery.dataTables.js')); ?>"></script>
                <script type="text/javascript" src="<?php echo e(asset('lb-faveo/plugins/datatables/dataTables.bootstrap.js')); ?>"></script>

                <?php echo Datatable::table()
                ->addColumn('Name','Description','Author','Website','Version')       // these are the column headings to be shown
                ->setUrl('getplugin')   // this is the route where data will be retrieved
                ->render(); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/plugins.blade.php ENDPATH**/ ?>