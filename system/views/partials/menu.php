<?php
    if(Yii::app()->user->isGuest) {
        $this->renderPartial('//partials/menu-guest');
    } else {
        $this->renderPartial('//partials/menu-authenticated');
    }

