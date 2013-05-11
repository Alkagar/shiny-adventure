<?php
    $status = (Yii::app()->user->isGuest) ? (Yii::t('site', 'footer.not-logged')) : (Yii::t('site', 'footer.logged-as') . ' ' . Yii::app()->user->model()->signature);
?>

<div class='footer'>
    <ul>
        <li>
        <?php echo $status; ?>
        <?php 
            if(!Yii::app()->user->isGuest) {
                echo ' ( id: ', Yii::app()->user->id, ' ) ';
                /*
                $authManager = Yii::app()->authManager;
                $roles =  $authManager->getRoles(Yii::app()->user->model()->id);
                foreach($roles as $role) {
                    echo ' [ name: ', $role->name, '; bizRule: ', $role->bizRule, '; data: ', $role->data, ' ]';
                }
                */
            }
        ?>
        <li>
    </ul>
</div>
