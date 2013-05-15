<h1><?php echo Yii::t('site', 'title.project-manage-users-of'), ' ', $project->name;?></h1>
<div>
    <div class='notification' >
    </div>

    <table id='manage-users'>
        <thead>
            <tr>
                <?php 
                    echo CHtml::tag('td', array(), '&nbsp;');
                    foreach($roles as $role) :
                    $name = $role->name;
                    echo CHtml::tag('td', array(), AAuthNames::n($name));
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
                $disabled = 'project_owner' == $role->name && $user->id == $project->author_id;
                $tds .= CHtml::tag('td', array(), CHtml::checkbox($role->name, $assigned, array('disabled' => $disabled, 'id' => $role->name . '@' . $user->id)));
                endforeach; 
                $tr = CHtml::tag('tr', array(), $tds);
                echo $tr;
                endforeach;
            ?>
        </tbody>
    </table>
</div>

<script type='text/javascript'>
    $('.notification').hide();
    $('#manage-users input[type="checkbox"]').change(function() {
            var id = $(this).attr('id'),
            parts = id.split('@'),
            userId = parts[1],
            role = parts[0],
            success = '<?php echo Yii::t('site', 'flash.operation-complete'); ?>',
            error = '<?php echo Yii::t('site', 'flash.operation-error'); ?>',
            onResponse = function(response) {
                    $('.notification').slideDown().text(response.message);
                    setTimeout(function(){
                            $('.notification').slideUp();
                    }, 2000);
            },
            url = '';
            if($(this).is(':checked')) {
                    url = '<?php echo $this->createUrl('project/assignRoleToUser', array('id' => $project->id)); ?>'
                } else {
                    url = '<?php echo $this->createUrl('project/revokeRoleFromUser', array('id' => $project->id)); ?>'
            }
            $.ajax({
                    url : url, 
                    data : {'userId' : userId, 'role' : role},
                    dataType : 'json',
                    success : onResponse,
                    error : onResponse
            });
    });
</script>
