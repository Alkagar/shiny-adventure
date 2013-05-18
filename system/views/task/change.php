<h1><?php echo Yii::t('site', 'title.task-change');?></h1>
<div>
    <ul class='task-actions'>
        <?php echo ATaskHelper::generateMenuButtonsForTask($task); ?>
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
                <?php echo AViewHelper::activeMarkdownTextArea($form, 'description', array('value' => empty($form->description) ? $task->description : null,)); ?>
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

        <div class="row">
            <div>
                <?php echo CHtml::activeLabel($form,'assignees'); ?>
            </div>
                <?php echo ATaskHelper::taskShowAssigneesHtml($task); ?>
            <div class='clear-both'>
                <?php 
                    $addUsersIcon = CHtml::tag('div', array('class' => 'float-left icons-small cursor icon-small-plus add-assignee',), '');
                    echo AViewHelper::dropDownUserList('user-mockup', '', array('class' => 'float-left')), $addUsersIcon;
                ?>
            </div>
        </div>
        <div class="row"></div>

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

<script type='text/javascript'>
    $('.add-assignee').click(function() {
            var add = $(this),
            select = add.prev('select'),
            parentDiv = select.parent();
            userId = select.val(),
            taskId = <?php echo $task->id; ?>;
            $.ajax({
                    url : '<?php echo $this->createUrl('task/addAssigneeToTask'); ?>',
                    data : { id : taskId, userId : userId},
                    dataType : 'json',
                    success : function(response) {
                            if(response.status == 'OK') {
                                    var removeLink = response.removeLink,
                                    removeDiv = $('<div />').addClass('remove-assignee attachment cursor clear-both').text(select.find(':selected').text()).attr('id', 'remove-assignee_' + userId);
                                    parentDiv.before(removeDiv);
                            }
                            SH.showNotification(response.message);
                        },
                        error : function(response) {
                            SH.showNotification(response.message);
                        }
                });
        });
        $(document).on('click', '.remove-assignee', function() {
                var taskId = <?php echo $task->id; ?>,
                removeElement = $(this),
                parts = removeElement.attr('id').split('_'),
                userId = parts[1];
                $.ajax({
                        url : '<?php echo $this->createUrl('task/removeAssigneeFromTask'); ?>',
                        data : { id : taskId, userId : userId},
                        dataType : 'json',
                        success : function(response) {
                                removeElement.remove();
                                SH.showNotification(response.message);
                        },
                        error : function(response) {
                                alert(response.message);
                        }
                });
        });
    </script>
