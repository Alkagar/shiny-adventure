<h1><?php echo Yii::t('site', 'title.login');?></h1>
<div>
    <div class="form">
        <?php echo CHtml::beginForm(); ?>
        <?php echo CHtml::errorSummary($form); ?>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'username'); ?>
            </div>
            <div>
                <?php echo CHtml::activeTextField($form,'username') ?>
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
                <?php echo CHtml::activeCheckBox($form,'rememberMe'); ?>
                <?php echo CHtml::activeLabel($form,'rememberMe'); ?>
            </div>
        </div>

        <div class="row submit">
            <?php echo CHtml::submitButton(Yii::t('form', 'common.button.login')); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
</div>
