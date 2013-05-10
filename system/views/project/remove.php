<h1><?php echo Yii::t('site', 'title.project-remove');?></h1>
<div>
    <?php if(Yii::app()->user->hasFlash('notification')):?>
    <div class='notification'>
        <?php echo Yii::t('site', Yii::app()->user->getFlash('notification')); ?>
    </div>
    <?php endif; ?>
</div>
