<?php
    $isGlobalAdmin = Yii::app()->user->checkAccess('admin');
?>
<div class='menu'>
    <ul>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.home'), array('main/home')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.dashboard'), array('user/dashboard')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.project-add'), array('project/add')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.project-list'), array('project/list')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.edit-profile'), array('user/editProfile')); ?> </li>
        <?php if($isGlobalAdmin) : ?>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.register'), array('/user/register')); ?> </li>
        <?php endif; ?>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.logout'), array('main/logout')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.help'), array('main/help')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.gii'), array('/gii')); ?> </li>
    </ul>
</div>
