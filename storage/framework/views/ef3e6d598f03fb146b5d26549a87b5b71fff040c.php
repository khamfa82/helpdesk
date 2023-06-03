<?php $__env->startSection('content'); ?>  
<div id="page" class="hfeed site">
    <article class="hentry error404 text-center">
        <h1 class="error-title"><i class="fa fa-frown-o text-info"></i><span class="visible-print text-danger">0</span></h1>
        <h2 class="entry-title text-muted"><?php echo Lang::get('lang.sorry_something_went_wrong'); ?></h2>
        <div class="entry-content clearfix">
            <p class="lead"><?php echo Lang::get('lang.were_working_on_it_and_well_get_it_fixed_as_soon_as_we_can'); ?></p>
            <p><a onclick="goBack()" href="#"><?php echo Lang::get('lang.go_back'); ?></a></p>
        </div><!-- .entry-content -->
    </article><!-- .hentry -->
</div><!-- #page -->

<script>
    function goBack() {
        window.history.back();
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('themes.default1.client.layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/errors/500.blade.php ENDPATH**/ ?>