<?php
    $status = (Yii::app()->user->isGuest) ? (Yii::t('site', 'footer.not-logged')) : (Yii::t('site', 'footer.logged-as') . ' ' . Yii::app()->user->model()->signature);
?>

<div class='footer'>
    <ul>
        <li>
        <?php echo $status; ?>
        <li>
    </ul>
</div>
