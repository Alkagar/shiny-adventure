<?php
    $allTasks = $project->tasks;
?>
<h1><?php echo Yii::t('site', 'title.project-show'), ': ', $project->name;?></h1>
<div class='task-list'>
    <?php foreach($allTasks as $task) :?>
    <div class='entry'>
        <div class='entry-inline-info float-right table-row'>
            <div class='table-cell'>
                <?php echo $task->status->name; ?>
            </div>
            <div class='table-cell'>
                <?php echo $task->created_at; ?>
            </div>
            <div class='table-cell'> 
                <?php 
                    $icon = CHtml::tag('div', array('class' => 'icons-small icon-small-edit', 'style' => 'margin:0px;'), '');
                    $taskLinkChange = CHtml::link($icon, array('task/change', 'id' => $task->id), array('title' => Yii::t('site', 'link-title.edit-task')));
                    echo $taskLinkChange;
                ?>
            </div>
        </div>
        <h3 tabindex='0' class='showHide'><?php echo $task->name, ' [#' . $task->id . ']'; ?></h3>
        <div class='entry-content'>
            <div>
                <strong class='subtitle'> <?php echo Yii::t('site', 'text.task-description');?>:</strong>
                <div class='entry-description'>
                    <?php echo nl2br($task->description); ?>
                </div>
            </div>
            <div>
                <strong class='subtitle'> <?php echo Yii::t('site', 'text.task-status');?>:</strong>
                <div class='entry-description'>
                    <?php echo $task->status->name; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script type='text/javascript'>
    $('.showHide').click(function() {
            $(this).next('.entry-content').toggle(); 
            console.log($(this).parent());
            $(this).parent().toggleClass('entry-with-margins');
    });
</script>
