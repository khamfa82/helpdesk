<link href="<?php echo e(asset("lb-faveo/css/faveo-css.css")); ?>" rel="stylesheet" type="text/css" />
<?php $__env->startSection('Settings'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('settings-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('social-login'); ?>
class="active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('HeadInclude'); ?>
<?php $__env->stopSection(); ?>
<!-- header -->
<?php $__env->startSection('PageHeader'); ?>
<h2></h2>
<?php $__env->stopSection(); ?>
<!-- /header -->
<!-- breadcrumbs -->
<?php $__env->startSection('breadcrumbs'); ?>
<ol class="breadcrumb">

</ol>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Social Media</h3>
    </div>

    <div class="box-body table-responsive">
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

        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-hover">
                    <thead>
                        <tr>
                            <th>Provider</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Facebook</td>
                            <td>
                                <?php if($social->checkActive('facebook')===true): ?>
                                <span style="color: green">Active</span>
                                <?php else: ?> 
                                <span style="color: red">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('social/media/facebook')); ?>" class="btn btn-primary">Settings</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Google</td>
                            <td>
                                <?php if($social->checkActive('google')===true): ?>
                                <span style="color: green">Active</span>
                                <?php else: ?> 
                                <span style="color: red">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('social/media/google')); ?>" class="btn btn-primary">Settings</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Github</td>
                            <td>
                                <?php if($social->checkActive('github')===true): ?>
                                <span style="color: green">Active</span>
                                <?php else: ?> 
                                <span style="color: red">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('social/media/github')); ?>" class="btn btn-primary">Settings</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Twitter</td>
                            <td>
                                <?php if($social->checkActive('twitter')===true): ?>
                                <span style="color: green">Active</span>
                                <?php else: ?> 
                                <span style="color: red">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('social/media/twitter')); ?>" class="btn btn-primary">Settings</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Linkedin</td>
                            <td>
                                <?php if($social->checkActive('linkedin')===true): ?>
                                <span style="color: green">Active</span>
                                <?php else: ?> 
                                <span style="color: red">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('social/media/linkedin')); ?>" class="btn btn-primary">Settings</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Bitbucket</td>
                            <td>
                                <?php if($social->checkActive('bitbucket')===true): ?>
                                <span style="color: green">Active</span>
                                <?php else: ?> 
                                <span style="color: red">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(url('social/media/bitbucket')); ?>" class="btn btn-primary">Settings</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/social-media/index.blade.php ENDPATH**/ ?>