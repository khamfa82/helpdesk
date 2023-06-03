<?php
$social = new \App\Model\helpdesk\Settings\SocialMedia();
?>
<br>
<?php if($social->checkActive('twitter') || $social->checkActive('facebook') || $social->checkActive('google') || $social->checkActive('linkedin') || $social->checkActive('bitbucket') || $social->checkActive('github')): ?>
<center><?php echo e(Lang::get('lang.or')); ?></center>
<?php endif; ?>
<br>
<?php if($social->checkActive('twitter')): ?>
<a class="btn btn-block btn-social btn-twitter" href="<?php echo e(route('social.login', ['twitter'])); ?>" style="background-color: #55ACEE;color: white;">
    <span class="fa fa-twitter"></span> Sign in with Twitter
</a>
<?php endif; ?>
<?php if($social->checkActive('facebook')): ?>
<a class="btn btn-block btn-social btn-facebook" href="<?php echo e(route('social.login', ['facebook'])); ?>" style="background-color: #3B5998;color: white;">
    <span class="fa fa-facebook"></span> Sign in with Facebook
</a>
<?php endif; ?>
<?php if($social->checkActive('google')): ?>
<a class="btn btn-block btn-social btn-google-plus" href="<?php echo e(route('social.login', ['google'])); ?>" style="background-color: #DD4B39;color: white;">
    <span class="fa fa-google"></span> Sign in with Google
</a>
<?php endif; ?>
<?php if($social->checkActive('linkedin')): ?>
<a class="btn btn-block btn-social btn-linkedin" href="<?php echo e(route('social.login', ['linkedin'])); ?>" style="background-color: #007BB6;color: white;">
    <span class="fa fa-linkedin"></span> Sign in with Linkedin
</a>
<?php endif; ?>
<?php if($social->checkActive('bitbucket')): ?>
<a class="btn btn-block btn-social btn-bitbucket" href="<?php echo e(route('social.login', ['bitbucket'])); ?>" style="background-color: blue;color: white;">
    <span class="fa fa-bitbucket"></span> Sign in with Bitbucket
</a>
<?php endif; ?>
<?php if($social->checkActive('github')): ?>
<a class="btn btn-block btn-social btn-github" href="<?php echo e(route('social.login', ['github'])); ?>" style="background-color: black;color: white;">
    <span class="fa fa-github"></span> Sign in with Github
</a>
<?php endif; ?><?php /**PATH F:\xampp\htdocs\helpdesk\resources\views/themes/default1/client/layout/social-login.blade.php ENDPATH**/ ?>