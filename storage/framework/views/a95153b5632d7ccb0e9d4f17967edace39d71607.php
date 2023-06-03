<?php $__env->startSection('content'); ?>  
<div id="page" class="hfeed site">
    <article class="hentry error404 text-center">
        <h1 class="error-title">4<i class="fa fa-frown-o text-info"></i><span class="visible-print text-danger">0</span>4</h1>
        <h2 class="entry-title text-muted"><?php echo Lang::get('lang.we_are_sorry_but_the_page_you_are_looking_for_can_not_be_found'); ?></h2>
        <div class="entry-content clearfix">
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
<?php echo $__env->make('themes.default1.client.layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/errors/404.blade.php ENDPATH**/ ?>