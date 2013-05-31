<h1><?php echo Yii::t('site', 'title.task-change');?></h1>
<ul class='task-actions'>
    <?php echo ATaskHelper::generateMenuButtonsForTask($task); ?>
</ul>
<div class='grid-row'>

    <div class='form column grid-5'>
        <?php if(Yii::app()->user->hasFlash('notification')):?>
        <div class='notification'>
            <?php echo Yii::t('site', Yii::app()->user->getFlash('notification')); ?>
        </div>
        <?php endif; ?>

        <?php echo CHtml::beginForm('', 'post', array( 'enctype' => 'multipart/form-data',)); ?>
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
                <?php echo AViewHelper::activeMarkdownTextArea($form, 'description', array('value' => empty($form->description) ? $task->description : null,), false); ?>
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

        <div class="row">
            <br />
        </div>

        <div class="row">
            <div class='clear-both attachment'>
                <?php 
                    $addAttachmentIcon = CHtml::tag('div', array('class' => 'float-left icons-small cursor icon-small-plus add-attachment',), '');
                    $addAttachmentLink = CHtml::tag('div', array('class' => 'float-left padding-left-medium cursor add-attachment',), Yii::t('site', 'text.add-attachment'));
                    echo $addAttachmentIcon, $addAttachmentLink;
                ?>
            </div>
        </div>

        <div class="row">
            <?php 
                foreach($task->attachments as $attachment) : 
                $removeAttachmentLink = CHtml::tag('div', array('class' => 'float-left icons-small cursor icon-small-trash remove-attachment-link', 'id' => 'remove-attachment_' . $attachment->id), '');
                $showAttachmentLink = CHtml::link(substr(basename($attachment->url), 11), array('project/showAttachment', 'id' => $task->project_id, 'attachmentId' => $attachment->id), array('class' => 'float-left padding-left-medium', 'target' => '_blank', 'title' => Yii::t('site', 'link-title.show-attachment')));
            ?>
            <div class='clear-both attachment'>
                <?php echo $removeAttachmentLink, $showAttachmentLink; ?>
            </div>
            <?php endforeach; ?>
            <div class='clear-both attachment'> </div>
        </div>

        <div class="row"></div>

        <?php if(!$saveResult):?>
        <div id='attachment-mockup' class='hidden attachment clear-both'>
            <?php echo CHtml::fileField('attachment-mockup', '', array()); ?>
        </div>
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

    <div class='grid-5 column form task-notes'>

        <br /> <br /> <br /> <br /> <br /> <br /> <br />
        <div id="wmd-preview" class=" wmd-panel wmd-preview"></div>
        <br /><br />
        <?php echo AViewHelper::markdownTextArea('task-note','-note', array(), false); ?>
        <?php echo CHtml::button(Yii::t('form', 'common.button.add-note'), array('id' => 'add-note', 'name' => 'add-note', ));?>
        <?php echo ATaskHelper::taskShowNotes($task); ?>
    </div>

</div>

<script type='text/javascript'>
    $('#add-note').click(function() {
            var textarea = $('[name="task-note"]'),
            button = $(this),
            content = textarea.val(),
            parentDiv = textarea.parent('.form');
            taskId = <?php echo $task->id; ?>;

            $.ajax({
                    url : '<?php echo $this->createUrl('task/addTaskNote', array('id' => $task->id)); ?>',
                    data : { id : taskId, content: content},
                    type : 'POST',
                    dataType : 'json',
                    success : function(response) {
                            SH.showNotification(response.message);
                            noteContent = $('<div></div>').addClass('task-note').text(content);
                            textarea.val('');
                            noteDate = $('<time></time>').addClass('task-note-date').text(response.created_at);
                            button.after(noteDate);
                            noteDate.after(noteContent);
                    },
                    error : function(response) {
                            SH.showNotification(response.message);
                    }
            });
    });
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
                                    removeDiv = $('<div></div>').addClass('remove-assignee attachment cursor clear-both').text(select.find(':selected').text()).attr('id', 'remove-assignee_' + userId);
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

    $('.remove-attachment-link').click(function() {
            var reallyRemove = '<?php echo Yii::t('site', 'messages.really-remove');?>',
            attachmentDiv = $(this),
            id = $(this).attr('id'),
            parts = id.split('_'),
            attachmentId = parts[1],
            onResponse = function(response) {
                    SH.showNotification(response.message, function() {
                            if(response.status == 'OK') {
                                    attachmentDiv.parent().remove();
                            }
                    });
            };
            if(confirm(reallyRemove)) {
                    $.ajax({
                            url: '<?php echo $this->createUrl('project/removeAttachment', array('id' => $task->project_id, )); ?>',
                            data: {'attachmentId' : attachmentId},
                            success : onResponse,
                            error : onResponse,
                    });
            }
            return false; 
    });
    var attachmentCount = 0;
    $('.add-attachment').click(function() {
            var mockup = $('#attachment-mockup'),
            newAttachment = mockup.clone(),
            newInput = newAttachment.find('input'),
            newId =  'attachment[' + (attachmentCount++) + ']';
            newInput.attr('name', newId).attr('id', newId);
            newAttachment.toggleClass('hidden').attr('id', '');
            $(this).parent().append(newAttachment);
    });
</script>
