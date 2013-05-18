<h1><?php echo Yii::t('site', 'title.task-remove');?></h1>
<div>
    <ul class='task-actions'>
        <?php echo ATaskHelper::generateMenuButtonsForTask($task); ?>
    </ul>
    <?php if(Yii::app()->user->hasFlash('notification')):?>
    <div class='notification'>
        <?php echo Yii::t('site', Yii::app()->user->getFlash('notification')); ?>
    </div>
    <?php endif; ?>
</div>
