<h1><?php echo Yii::t('site', 'title.dashboard');?></h1>
<div>
    <div>
        <h2><?php echo Yii::t('site', 'subtitle.your-projects'); ?></h2>
        <?php 
            foreach($projects as $project) : 
            $projectLinkShow   = CHtml::link($project->name, array('project/show', 'id' => $project->id));
            $projectLinkRemove = CHtml::link(' ( x ) ', array('project/remove', 'id' => $project->id), array('confirm' => Yii::t('site', 'messages.really-remove')));

        ?>
        <div>
            <strong> <?php echo $projectLinkShow; ?> </strong> <?php echo $projectLinkRemove; ?>
            <p> 
            <?php echo $project->description; ?>
            </p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
