<h1><?php echo Yii::t('site', 'title.project-change');?></h1>
<div>
    <ul class='task-actions'>
        <?php echo AViewHelper::generateMenuButtonsForProject($project); ?>
    </ul>
    <div class='form'>

        <?php if(Yii::app()->user->hasFlash('notification')):?>
        <div class='notification'>
            <?php echo Yii::t('site', Yii::app()->user->getFlash('notification')); ?>
        </div>
        <?php endif; ?>

        <?php echo CHtml::beginForm('', 'post', array( 'enctype' => 'multipart/form-data',)); ?>
        <?php echo CHtml::errorSummary($form); ?>

        <div class="row">
            <div> <?php echo CHtml::activeLabel($form,'name'); ?> </div>
            <div> <?php echo CHtml::activeTextField($form,'name', array( 'value' => empty($form->name) ? $project->name : null,)); ?> </div>
        </div>

        <div class="row">
            <div> <?php echo CHtml::activeLabel($form,'description'); ?> </div>
            <div> <?php echo CHtml::activeTextArea($form,'description', array( 'value' => empty($form->description) ? $project->description : null,)); ?>
            </div>
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
                foreach($project->attachments as $attachment) : 
                $removeAttachmentLink = CHtml::tag('div', array('class' => 'float-left icons-small cursor icon-small-trash remove-attachment-link', 'id' => 'remove-attachment_' . $attachment->id), '');
                $showAttachmentLink = CHtml::link(substr(basename($attachment->url), 11), array('project/showAttachment', 'id' => $project->id, 'attachmentId' => $attachment->id), array('class' => 'float-left padding-left-medium', 'target' => '_blank', 'title' => Yii::t('site', 'link-title.show-attachment')));
            ?>
            <div class='clear-both attachment'>
                <?php echo $removeAttachmentLink, $showAttachmentLink; ?>
            </div>
            <?php endforeach; ?>
            <div class='clear-both attachment'> </div>
        </div>

        <?php if(!$saveResult):?>
        <div id='attachment-mockup' class='hidden attachment clear-both'>
            <?php echo CHtml::fileField('attachment-mockup', '', array()); ?>
        </div>
        <div class="row submit">
            <?php echo CHtml::submitButton(Yii::t('form', 'common.button.save')); ?>
        </div>
        <?php endif; ?>

        <?php echo CHtml::endForm(); ?>
    </div><!-- form -->
</div>

<script type='text/javascript'>
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
                            url: '<?php echo $this->createUrl('project/removeAttachment', array('id' => $project->id, )); ?>',
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

