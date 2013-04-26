<div class='menu'>
    <ul>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.home'), array('main/home')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.dashboard'), array('user/dashboard')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.edit-profile'), array('user/editProfile')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.logout'), array('main/logout')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.help'), array('main/help')); ?> </li>
        <li> <?php echo CHtml::link(Yii::t('site', 'menu.gii'), array('/gii')); ?> </li>
    </ul>
</div>
