<h1><?php echo Yii::t('site', 'title.task-add');?></h1>
<div>
    <ul class='task-actions'>
        <?php echo AViewHelper::generateMenuButtonsForProject($project); ?>
    </ul>
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
                <?php echo CHtml::activeLabel($form,'name'); ?>
            </div>
            <div>
                <?php echo CHtml::activeTextField($form,'name', array()); ?>
            </div>
        </div>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'description'); ?>
            </div>
            <div>
                <?php echo AViewHelper::activeMarkdownTextArea($form, 'description'); ?>
            </div>
        </div>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'status_id'); ?>
            </div>
            <div>
                <?php echo CHtml::activeDropDownList($form, 'status_id', $form->getStatusArray(), array()); ?>
            </div>
        </div>

        <?php if(!$saveResult):?>
        <div class="row submit">
            <?php echo CHtml::submitButton(Yii::t('form', 'common.button.save')); ?>
        </div>
        <?php endif; ?>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
</div>

