<?php
    class AController extends CController
    {
        public $layout='//layouts/main';

        public function init() 
        {
            parent::init();

            Yii::app()->language = 'pl_pl';
        }
    }
