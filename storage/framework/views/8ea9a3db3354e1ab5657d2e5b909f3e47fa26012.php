<?php $__env->startSection('title'); ?>
Category List -
<?php $__env->stopSection(); ?>

<?php $__env->startSection('kb'); ?>
class = "active"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div id="content" class="site-content col-md-12">
    <!-- Start of Page Container -->
    <div class="row home-listing-area">
        <div class="span8">
            <h2><?php echo Lang::get('lang.categories'); ?></h2>
        </div>
    </div>
    <div class="row separator">
        <?php $__currentLoopData = $categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xs-6">
            
            <?php
            $all = App\Model\kb\Relationship::where('category_id', $category->id)->get();
            /* from whole attribute pick the article_id */
            $article_id = $all->pluck('article_id');
            ?>
            <section class="articles-list">
                <h3><i class="fa fa-folder-open-o fa-fw text-muted"></i> <a href="<?php echo e(url('category-list/'.$category->slug)); ?>"><?php echo e($category->name); ?></a> <span>(<?php echo e(count($all)); ?>)</span></h3>
                <ul class="articles">
                    <hr>
                    <?php foreach ($article_id as $id) {
                        ?>
                        <?php
                        $article = App\Model\kb\Article::where('id', $id);
                        if (!Auth::user() || Auth::user()->role == 'user') {
                            $article = $article->where('status', 1);
                            $article = $article->where('type', 1);
                        }
                        $article = $article->orderBy('publish_time', 'desc');
                        $article = $article->get();
                        //dd($article);
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $article; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $arti): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <li class="article-entry image" style="margin-left: 50px;">
                            <h4><a href="<?php echo e(url('show/'.$arti->slug)); ?>"><?php echo e($arti->name); ?></a></h4>
                            <span class="article-meta"><?php echo e($arti->created_at->format('l, d-m-Y')); ?>

                                <?php $str = $arti->description ?>
                                <?php $excerpt = App\Http\Controllers\Client\kb\UserController::getExcerpt($str, $startPos = 0, $maxLength = 55) ?>
                                <p><?php echo $excerpt; ?> <a class="readmore-link" href="<?php echo e(url('show/'.$arti->slug)); ?>"><?php echo Lang::get('lang.read_more'); ?></a></p>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> 
                        <li>No articles available</li>
                        <?php endif; ?>
                    <?php }
                    ?>
                </ul>
            </section>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<!-- end of page content -->
<?php $__env->stopSection(); ?>


<?php echo $__env->make('themes.default1.client.layout.client', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/client/kb/article-list/categoryList.blade.php ENDPATH**/ ?>