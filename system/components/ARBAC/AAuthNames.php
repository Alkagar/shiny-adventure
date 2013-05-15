<?php
    class AAuthNames {
        public static function n($name) 
        {
            return Yii::t('site', 'rbac.' . $name);
        }
    }

