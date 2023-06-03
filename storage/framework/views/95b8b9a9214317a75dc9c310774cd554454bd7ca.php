<link href="<?php echo e(asset("lb-faveo/css/faveo-css.css")); ?>" rel="stylesheet" type="text/css" />
<?php $__env->startSection('Settings'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('settings-bar'); ?>
active
<?php $__env->stopSection(); ?>

<?php $__env->startSection('company'); ?>
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
<?php echo Form::model($companys,['url' => 'postcompany/'.$companys->id, 'method' => 'PATCH','files'=>true]); ?>

<!-- <div class="form-group <?php echo e($errors->has('company_name') ? 'has-error' : ''); ?>"> -->
<!-- table  -->
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo e(Lang::get('lang.company_settings')); ?></h3>
    </div>
    <!-- Name text form Required -->
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
            <?php if($errors->first('company_name')): ?>
            <li class="error-message-padding"><?php echo $errors->first('company_name', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('website')): ?>
            <li class="error-message-padding"><?php echo $errors->first('website', ':message'); ?></li>
            <?php endif; ?>
            <?php if($errors->first('phone')): ?>
            <li class="error-message-padding"><?php echo $errors->first('phone', ':message'); ?></li>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-4">
                <!-- comapny name -->
                <div class="form-group <?php echo e($errors->has('company_name') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('company_name',Lang::get('lang.name')); ?> <span class="text-red"> *</span>
                    <?php echo Form::text('company_name',$companys->company_name,['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="col-md-4">
                <!-- website -->
                <div class="form-group <?php echo e($errors->has('website') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('website',Lang::get('lang.website')); ?>

                    <?php echo Form::url('website',$companys->website,['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="col-md-4">
                <!-- phone -->
                <div class="form-group <?php echo e($errors->has('phone') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('phone',Lang::get('lang.phone')); ?>

                    <?php echo Form::text('phone',$companys->phone,['class' => 'form-control']); ?>

                </div>
            </div>
            <div class="col-md-12">
                <!-- comapny address -->
                <div class="form-group <?php echo e($errors->has('address') ? 'has-error' : ''); ?>">
                    <?php echo Form::label('address',Lang::get('lang.address')); ?>

                    <?php echo Form::textarea('address',$companys->address,['class' => 'form-control','size' => '30x5']); ?>

                </div>
            </div>
            <div class="col-md-2">
                <!-- logo -->
                <?php echo Form::label('logo',Lang::get('lang.logo')); ?>

                <div class="btn bg-olive btn-file" style="color:blue"> Upload file
                    <?php echo Form::file('logo'); ?>

                </div>
            </div>
            <div id="logo-display" style="display: block;">
                <?php if($companys->logo != null): ?>
                <div class="col-md-2">
                    <?php echo Form::checkbox('use_logo'); ?> <label> <?php echo Lang::get('lang.use_logo'); ?></label>
                </div>
                <?php endif; ?>
                <?php $company = App\Model\helpdesk\Settings\Company::where('id', '=', '1')->first(); ?>
                <?php if($companys->logo != null): ?>
                <div class="col-md-2 image" data-content="<?php echo e(Lang::get('lang.click-delete')); ?>">
                    <img src="<?php echo e(asset('uploads/company')); ?><?php echo e('/'); ?><?php echo e($company->logo); ?>" alt="User Image" id="company-logo" width="100px" style="border:1px solid #DCD1D1" />
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <?php echo Form::submit(Lang::get('lang.submit'),['class'=>'form-group btn btn-primary']); ?>

    </div>
    <!-- Modal -->   
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" style="display: none; padding-right: 15px;background-color: rgba(0, 0, 0, 0.7);">
        <div class="modal-dialog" role="document">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="custom-alert-body" >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary pull-left yes" data-dismiss="modal"></button>
                        <button type="button" class="btn btn-default no"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $(".image").on("click", function() {
            $("#myModal").css("display", "block");
            $("#myModalLabel").html("<?php echo Lang::get('lang.delete-logo'); ?>");
            $(".yes").html("<?php echo Lang::get('lang.yes'); ?>");
            $(".no").html("<?php echo e(Lang::get('lang.cancel')); ?>");
            $("#custom-alert-body").html("<?php echo e(Lang::get('lang.confirm')); ?>");
        });
        $('.no,.closemodal').on("click", function() {
            $("#myModal").css("display", "none");
        });
        $('.yes').on('click', function() {
            var src = $('#company-logo').attr('src').split('/');
            var file = src[src.length - 1];

            var path = "uploads/company/" + file;
            // alert(path); 
            $.ajax({
                type: "GET",
                url: "<?php echo e(route('delete.logo')); ?>",
                dataType: "html",
                data: {data1: path},
                success: function(data) {
                    if (data == "true") {
                        var msg = "Logo deleted succesfully."
                        $("#logo-display").css("display", "none");
                        $("#myModal").css("display", "none");
                    } else {
                        $("#myModal").css("display", "none");
                    }
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.admin.layout.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/admin/helpdesk/settings/company.blade.php ENDPATH**/ ?>