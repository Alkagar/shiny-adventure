<h1><?php echo Yii::t('site', 'title.admin-manage-task-statuses');?></h1>
<div class='grid-row'>

    <div class='column grid-5'>
        <h2><?php echo Yii::t('site', 'text.admin-manage-status-list');?></h2>
        <ol>
        <?php foreach($statuses as $status) :?>
        <?php 
            $linkText = $status->name . ' ( ' . $status->description . ' ) ';
            $removeLink = CHtml::link($linkText, array('/admin/removeStatus', 'statusId' => $status->id));
        ?>
        <li><?php echo $removeLink; ?></li>
        <?php endforeach; ?>
        </ol>
    </div>

    <div class='form column grid-5'>
        <h2><?php echo Yii::t('site', 'text.admin-manage-status-form');?></h2>

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
                <?php echo CHtml::activeTextField($form, 'description'); ?>
            </div>
        </div>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form, 'internal_type'); ?>
            </div>
            <div>
                <?php echo CHtml::activeDropDownList($form, 'internal_type', StatusForm::getTaskInternalTypes(), array()); ?>
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
