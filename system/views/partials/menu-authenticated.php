<div class='menu'>
    <ul>
        <li>
        <?php echo CHtml::link(Yii::t('site', 'menu.home'), array('main/home')); ?>
        </li>
        <li>
        <?php echo CHtml::link(Yii::t('site', 'menu.help'), array('main/help')); ?>
        </li>
        <li>
        <?php echo CHtml::link(Yii::t('site', 'menu.gii'), array('/gii')); ?>
        </li>
        <li>
        <?php echo CHtml::link(Yii::t('site', 'menu.logout'), array('main/logout')); ?>
        </li>
    </ul>
</div>
