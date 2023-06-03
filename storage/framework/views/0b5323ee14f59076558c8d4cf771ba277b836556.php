<?php $__env->startSection('title'); ?>
Knowledge Base - Service Desk
<?php $__env->stopSection(); ?>

<?php $__env->startSection('knowledgebase'); ?>
class = "active"
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php if(Session::has('success')): ?>
<div class="alert alert-success alert-dismissable">
    <i class="fa  fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo e(Session::get('success')); ?>

</div>
<?php endif; ?>
<!-- failure message -->
<?php if(Session::has('fails')): ?>
<div class="alert alert-danger alert-dismissable">
    <i class="fa fa-ban"></i>
    <b><?php echo Lang::get('lang.alert'); ?>!</b>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php echo e(Session::get('fails')); ?>

</div>
<?php endif; ?>

<div id="content" class="site-content col-md-9">
    <div class="row">
        <?php $categories = App\Model\kb\Category::all();
        ?>
        <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <?php
        $all = App\Model\kb\Relationship::all();
        /* from whole attribute pick the article_id */
        $page = App\Model\kb\Relationship::where('category_id', '=', $category->id)->paginate('3');
        /* from whole attribute pick the article_id */
        $article_id = $page->pluck('article_id');
        $count = count($article_id);
        ?>
        <div class="col-md-6">
            <section class="box-categories">
                <h1 class="section-title h4 clearfix">
                    <i class="fa fa-folder-open-o fa-fw text-muted"></i>
                    <small class="pull-right">
                      <a href="<?php echo e(url('category-list/'.$category->slug)); ?>">
                        <i class="fa fa-hdd-o fa-fw"></i>(<?php echo e($count); ?>)
                      </a>
                    </small>
                    <a href="<?php echo e(url('category-list/'.$category->slug)); ?>">
                      <?php echo e($category->name); ?>

                    </a>
                </h1>
                <ul class="fa-ul" style="min-height:150px">
                    <?php
                    foreach ($article_id as $id) {
                        //$format = App\Model\helpdesk\Settings\System::where('id','1')->first()->date_time_format;
                        $tz = App\Model\helpdesk\Settings\System::where('id', '1')->first()->time_zone;
                        $tz = \App\Model\helpdesk\Utility\Timezones::where('id', $tz)->first()->name;
                        date_default_timezone_set($tz);
                        $date = \Carbon\Carbon::now()->toDateTimeString();
                        //dd($date);

                        $article = App\Model\kb\Article::where('id', '=', $id);
                        if (Auth::check()) {
                            if (\Auth::user()->role == 'user') {
                                $article = $article->where('status', '1');
                            }
                        } else {
                            $article = $article->where('status', '1');
                        }
                        $article = $article->where('type', '1');
                        $article = $article->orderBy('publish_time','desc')->get();
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $article; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li>
                            <i class="fa-li fa fa-list-alt fa-fw text-muted"></i>
                            <h3 class="h5"><a href="#"><a href="<?php echo e(url('show/'.$arti->slug)); ?>"> <b><?php echo e($arti->name); ?></b></a></h3>
                            <!-- <span class="article-meta"><?php echo e($arti->created_at->format('l, d-m-Y')); ?></span> -->
                            <?php
                            // $str = $arti->description;
                            // $len = strlen($str);
                            //
                            // $excerpt = App\Http\Controllers\Client\kb\UserController::getExcerpt($str, $startPos = 0, $maxLength = 20);

                            //echo strip_tags($excerpt); ?>
                              <!--<br/>
                            <a class="more-link text-center" href="<?php echo e(url('show/'.$arti->slug)); ?>" style="color: orange">
                              <?php echo Lang::get('lang.read_more'); ?>

                            </a> -->
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p><?php echo Lang::get('lang.no_article'); ?></p>
                        <?php endif; ?>
                    <?php } ?>
                </ul>
                <p class="more-link text-center"><a href="<?php echo e(url('category-list/'.$category->slug)); ?>" class="btn btn-custom btn-xs"><?php echo Lang::get('lang.view_all'); ?></a></p>
            </section>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <section class="section">
        <div class="banner-wrapper banner-horizontal clearfix">
            <h4 class="banner-title h4"><?php echo Lang::get('lang.need_more_support'); ?>?</h4>
            <div class="banner-content">
                <p><?php echo Lang::get('lang.if_you_did_not_find_an_answer_please_raise_a_ticket_describing_the_issue'); ?>.</p>
            </div>
            <p><a href="<?php echo URL::route('form'); ?>" class="btn btn-custom"><?php echo Lang::get('lang.submit_a_ticket'); ?></a></p>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('category'); ?>
<h2 class="section-title h4 clearfix"><?php echo Lang::get('lang.categories'); ?><small class="pull-right"><i class="fa fa-hdd-o fa-fw"></i></small></h2>
<ul class="nav nav-pills nav-stacked nav-categories">
    <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
    $num = \App\Model\kb\Relationship::where('category_id', '=', $category->id)->get();
    $article_id = $num->pluck('article_id');
    $numcount = count($article_id);
    ?>
    <li><a href="<?php echo e(url('category-list/'.$category->slug)); ?>"><span class="badge pull-right"><?php echo e($numcount); ?></span><?php echo e($category->name); ?></a></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('themes.default1.client.layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/client/kb/article-list/home.blade.php ENDPATH**/ ?>