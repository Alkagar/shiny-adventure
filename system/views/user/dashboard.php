<h1><?php echo Yii::t('site', 'title.dashboard');?></h1>
<div class='dashboard'>
    <h2><?php echo Yii::t('site', 'text.subtitle-dashboard-projects'); ?></h2>
    <?php foreach($projects as $project) : ?>
    <?php
        $projectLinkShow   = CHtml::link($project->name, array('project/show', 'id' => $project->id));
    ?>
    <div class='entry entry-with-margins'>
        <div class='entry-inline-info float-right table-row'>
            <div class='table-cell'>
                <?php echo $project->author->signature; ?>
            </div>
            <div class='table-cell'>
                <?php echo $project->created_at; ?>
            </div>
        </div>
        <h3> <?php echo $projectLinkShow; ?> </h3>
    </div>
    <?php endforeach; ?>
    <h2><?php echo Yii::t('site', 'text.subtitle-dashboard-tasks'); ?></h2>
    <?php foreach($assignees as $assignee) : ?>
    <?php 
        $task = $assignee->task;
        $taskLinkShow   = CHtml::link($task->name, array('task/change', 'id' => $task->id, 'project_id' => $task->project_id));
    ?>
    <div class='entry entry-with-margins'>
        <div class='entry-inline-info float-right table-row'>
            <div class='table-cell'>
                <?php echo $task->status->name; ?>
            </div>
            <div class='table-cell'>
                <?php echo $task->author->signature; ?>
            </div>
            <div class='table-cell'>
                <?php echo $task->created_at; ?>
            </div>
        </div>
        <h3> <?php echo $taskLinkShow; ?> </h3>
    </div>
    <?php endforeach; ?>
</div>
