<?php

    class UserController extends AController
    {
        public function actionDashboard()
        {
            $userProjects = Project::getUserProjects();
            $this->render('dashboard', array(
                'projects' => $userProjects, 
            ));
        }

        public function actionEditProfile()
        {
            $form = new UserForm();
            if(isset($_POST[get_class($form)])) {
                $form->attributes = $_POST[get_class($form)];
                if($form->validate()) {
                    $user = Yii::app()->user->model();
                    if('' != $form->password) {
                        $user->password = sha1($form->password);
                    }
                    $user->mail = $form->mail;
                    $user->signature = $form->signature;
                    if($user->save()) {
                        Yii::app()->user->setFlash('notification', 'flash.operation-complete');
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                    Yii::app()->user->model();
                }
            }
            $this->render('editProfile', array('form' => $form));
        }

        public function actionRegister() 
        {
            $form = new UserForm();
            if(isset($_POST[get_class($form)])) {
                $form->attributes = $_POST[get_class($form)];
                if($form->validate()) {
                    $user = new User();
                    $user->password = sha1($form->password);
                    $user->mail = $form->mail;
                    $user->signature = $form->signature;
                    if($user->save()) {
                        Yii::app()->user->setFlash('notification', 'flash.operation-complete');
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                }
            }
            $this->render('register', array('form' => $form));
        }

        public function filters()
        {
            return array(
                'accessControl',
            );
        }
        public function accessRules() 
        {
            return array(

                array(
                    'allow',
                    'actions' => array('dashboard', 'editProfile'),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('register'),
                    'users' => array('@'),
                    'roles' => array('admin'),
                ),
                array(
                    'deny'
                ),
            );
        }
    }
