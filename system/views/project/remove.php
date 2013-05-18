<h1><?php echo Yii::t('site', 'title.project-remove');?></h1>
<div>
    <ul class='task-actions'>
        <?php echo AViewHelper::generateMenuButtonsForProject($project); ?>
    </ul>
    <?php if(Yii::app()->user->hasFlash('notification')):?>
    <div class='notification'>
        <?php echo Yii::t('site', Yii::app()->user->getFlash('notification')); ?>
    </div>
    <?php endif; ?>
</div>
