<h1><?php echo Yii::t('site', 'title.error'); ?></h1>

<div>
    <p> <?php echo Yii::t('site', 'msg.error-code'), ': ', $code; ?> </p>
    <p> <?php echo Yii::t('site', 'msg.error-description'), ': ', CHtml::encode($message); ?></p>
</div>
