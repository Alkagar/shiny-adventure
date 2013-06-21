<?php
    $manageStatuses = CHtml::link(Yii::t('site', 'manage.task-statuses'), '/admin/manageTaskStatuses', array());
?>
<h1><?php echo Yii::t('site', 'title.admin-manage');?></h1>
<div class=''>
    <ul>
        <li><?php echo $manageStatuses; ?></li>
    </ul>
</div>
