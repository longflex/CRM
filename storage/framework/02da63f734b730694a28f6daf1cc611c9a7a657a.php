<?php $__env->startSection('breadcrumb'); ?>
<div class="ui breadcrumb">
    <div class="active section"><?php echo e(trans('laralum.dashboard')); ?></div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('title', trans('laralum.dashboard')); ?>
<?php $__env->startSection('icon', "dashboard"); ?>
<?php $__env->startSection('subtitle'); ?>
<?php echo e(trans('laralum.welcome_user', ['name' => Laralum::loggedInUser()->name])); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="ui doubling stackable two column grid container">
    <div class="column">
        <div class="ui padded segment">
            <?php echo Laralum::widget('basic_stats_1'); ?>

        </div>
        <br>
        <div class="ui padded segment">
            <?php echo Laralum::widget('latest_users_graph'); ?>

        </div>
        <br>
        <div class="ui padded segment">
            <?php echo Laralum::widget('latest_posts_graph'); ?>

        </div>
        <br>
    </div>
    <div class="column">
        <div class="ui padded segment">
            <?php echo Laralum::widget('basic_stats_2'); ?>

        </div>
        <br>
        <div class="ui padded segment">
            <?php echo Laralum::widget('users_country_geo_graph'); ?>

        </div>
        <br>
        <div class="ui padded segment">
            <?php echo Laralum::widget('roles_users'); ?>

        </div>
        <br>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.panel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>