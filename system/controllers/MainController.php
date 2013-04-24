<?php

    class MainController extends AController
    {

        public function actionIndex()
        { 
            if(Yii::app()->user->isGuest) {
                $this->redirect(Yii::app()->params['loginPage']);
            } else {
                $this->redirect(Yii::app()->params['dashboardPage']);
            }
        }

        public function actionHelp() 
        {
            $this->render('help', array( ));
        }

        public function actionLogin() 
        {
            $form = new LoginForm();
            if(isset($_POST[get_class($form)])) {
                $form->attributes = $_POST[get_class($form)];
                if($form->validate()) {
                    $form->login();
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            $this->render('login', array('form' => $form));
        }

        public function actionLogout() 
        {
            if(! Yii::app()->user->isGuest) {
                Yii::app()->user->logout(true);
            }
            $this->redirect(Yii::app()->params['loginPage']);
        }

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
