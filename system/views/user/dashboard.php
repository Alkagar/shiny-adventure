<h1><?php echo Yii::t('site', 'title.dashboard');?></h1>
<div class='dashboard'>
    <?php foreach($projects as $project) : ?>
    <div class='project'>
        <?php
            $projectLinkShow   = CHtml::link($project->name, array('project/show', 'id' => $project->id));

            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-trash',), '');
            $projectLinkRemove = CHtml::link($icon, array('project/remove', 'id' => $project->id), array('confirm' => Yii::t('site', 'messages.really-remove')));
            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-edit',), '');
            $projectLinkChange = CHtml::link($icon, array('project/change', 'id' => $project->id), array());
            $icon = CHtml::tag('li', array('class' => 'icons-small icon-small-users',), '');
            $projectLinkManageUsers = CHtml::link($icon, array('project/manageUsers', 'id' => $project->id), array());
        ?>
        <div>
            <ul class='actions'>
                <?php echo Yii::app()->user->checkAccess('project_editor', array('project_id' => $project->id)) ? $projectLinkChange : ''; ?>
                <?php echo Yii::app()->user->checkAccess('project_owner', array('project_id' => $project->id)) ? $projectLinkRemove : ''; ?>
                <?php echo Yii::app()->user->checkAccess('project_owner', array('project_id' => $project->id)) ? $projectLinkManageUsers : ''; ?>
            </ul>
        </div>

        <h3> <?php echo $projectLinkShow; ?> </h3>
        <div>
            <strong class='subtitle'> <?php echo Yii::t('site', 'text.project-description');?>:</strong>
            <div class='project-description'>
                <?php echo $project->description; ?>
            </div>
        </div>
        <div>
            <strong class='subtitle'> <?php echo Yii::t('site', 'text.project-yours-roles');?>:</strong>
            <div class='project-description'>
                <?php 
                    $assignments = $project->getUserAssignmentsForProject(Yii::app()->user->id);
                    $roles = array();
                    foreach($assignments as $assignment) {
                        $roles[] = AAuthNames::n($assignment->itemname);
                    }
                    echo join($roles, ', ');
                ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
