<h1><?php echo Yii::t('site', 'title.project-manage-users-of'), ' ', $project->name;?></h1>
<div>
    <?php if(Yii::app()->user->hasFlash('notification')):?>
    <div class='notification'>
        <?php echo Yii::t('site', Yii::app()->user->getFlash('notification')); ?>
    </div>
    <?php endif; ?>

    <table id='manage-users'>
        <thead>
            <tr>
                <?php 
                    echo CHtml::tag('td', array(), '&nbsp;');
                    foreach($roles as $role) :
                    echo CHtml::tag('td', array(), $role->name);
                    endforeach; 
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($users as $user) :
                    $tds = '';
                    $tds = CHtml::tag('td', array(), $user->mail);
                    foreach($roles as $role) :
                    $assigned = $role->isAssigned($user->id, $project->id);
                    $tds .= CHtml::tag('td', array(), CHtml::checkbox($role->name, $assigned, array()));
                    endforeach; 
                    $tr = CHtml::tag('tr', array(), $tds);
                    echo $tr;
                    endforeach;
            ?>
        </tbody>
    </table>


</div>
