<?php

    class MainController extends AController
    {

        public function actionIndex()
        { 
            $this->render('index', array( ));
        }

        public function actionHelp() 
        {
            $this->render('help', array( ));
        }

        public function actionLogin() 
        {
            $form = new LoginForm();
            if(isset($_POST[get_class($form)])) {
                $form->attributes=$_POST['LoginForm'];
                if($form->validate()) {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
            $this->render('login', array('form' => $form));
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
