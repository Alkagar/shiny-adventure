<?php

    class MainController extends AController
    {

        /**
        * This is the system action to handle external exceptions.
        */
        public function actionError()
        {
            if($error=Yii::app()->errorHandler->error)
            {
                if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
                else
                $this->render('//common/error', $error);
            }
        }
    }
