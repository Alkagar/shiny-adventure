<?php
    $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-trash',), '');
    $taskLinkRemove = CHtml::link($icon, array('task/remove', 'id' => $task->id), array('class' => 'float-right title-buttons', 'confirm' => Yii::t('site', 'messages.really-remove'), 'title' => Yii::t('site', 'link-title.remove-task')));

    $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-plus',), '');
    $taskLinkAddTask = CHtml::link($icon, array('task/add', 'projectId' => $task->project_id), array('class' => 'float-right title-buttons', 'title' => Yii::t('site', 'link-title.add-task')));

    $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-back',), '');
    $taskLinkGoBack = CHtml::link($icon, array('project/show', 'id' => $task->project_id), array('class' => 'float-right title-buttons', 'title' => Yii::t('site', 'link-title.go-back-to-project')));

?>
<h1><?php echo Yii::t('site', 'title.task-change');?></h1>
<div>
    <ul class='task-actions'>
        <?php
            echo $taskLinkRemove;
            echo $taskLinkAddTask;
            echo $taskLinkGoBack;
        ?>
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
                <?php 
                    echo CHtml::activeTextField($form,'name', array(
                        'value' => empty($form->name) ? $task->name : null,
                    )); 
                ?>
            </div>
        </div>

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'description'); ?>
            </div>
            <div>
                <?php 
                    echo CHtml::activeTextArea($form,'description', array(
                        'value' => empty($form->description) ? $task->description : null,
                    )); 
                ?>
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

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'time_spent'); ?>
            </div>
            <div>
                <?php 
                    echo CHtml::activeTextField($form, 'time_spent', array(
                        'value' => empty($form->time_spent) ? $task->time_spent : null,
                    )); 
                ?>
            </div>
        </div>

        <?php if(!$saveResult):?>
        <div class="row submit">
            <?php echo CHtml::submitButton(Yii::t('form', 'common.button.save')); ?>
        </div>
        <?php else: ?>
        <div class="row submit">
            <?php echo CHtml::link(Yii::t('site', 'link.return-to-project'), array('project/show', 'id' => $task->project_id));?>
        </div>
        <?php endif; ?>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
</div>

