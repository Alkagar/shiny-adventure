<?php

    class UserController extends AController
    {
        public function actionDashboard()
        {
            $criteria = Project::getUserProjectsCriteria();
            $userProjects = Project::model()->findAll($criteria);
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
    }
