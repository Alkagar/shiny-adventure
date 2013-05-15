<h1><?php echo Yii::t('site', 'title.register-user');?></h1>
<div>
    <div class='form'>

        <?php if(Yii::app()->user->hasFlash('notification')):?>
        <div class='notification'>
            <?php echo Yii::t('site', Yii::app()->user->getFlash('notification')); ?>
        </div>
        <?php endif; ?>

        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::errorSummary($form); ?>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'mail'); ?>
            </div>
            <div>
                <?php echo CHtml::activeTextField($form,'mail', array()); 
                ?>
            </div>
        </div>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'password'); ?>
            </div>
            <div>
                <?php echo CHtml::activePasswordField($form,'password') ?>
            </div>
        </div>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'compare'); ?>
            </div>
            <div>
                <?php echo CHtml::activePasswordField($form,'compare') ?>
            </div>
        </div>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'signature'); ?>
            </div>
            <div>
                <?php echo CHtml::activeTextField($form,'signature', array()); ?>
            </div>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton(Yii::t('form', 'common.button.save')); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
</div>
