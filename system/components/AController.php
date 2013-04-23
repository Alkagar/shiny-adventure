<?php
    class AController extends CController
    {
        public $layout='//layouts/base';

        public function init() 
        {
            parent::init();

            Yii::app()->language = 'pl_pl';
        }
    }
