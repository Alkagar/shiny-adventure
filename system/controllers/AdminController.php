<?php

    class AdminController extends AController
    {
        public function actionManage() 
        {
            $this->render('manage');
        }

        public function actionRemoveStatus($statusId, $returnUrl = '/admin/manageTaskStatuses')
        {
            $status = Status::model()->findByPk($statusId);
            if(!is_null($status)) {
                $status->delete();
            }
            if('' !== $returnUrl) {
                $this->redirect(array($returnUrl));
            }
        }

        public function actionManageTaskStatuses()
        {
            $saveResult = false;
            $form = new StatusForm();
            $statuses = Status::getAllByType('task');

            if(isset($_POST[get_class($form)])) {
                $form->attributes = $_POST[get_class($form)];
                if($form->validate()) {
                    $status = new Status();
                    $status->type = 'task';
                    $status->name = $form->name;
                    $status->description = $form->description;
                    $status->internal_type = $form->internal_type;

                    $saveResult = $status->save();
                    if($saveResult) {
                        $this->redirect(array('/admin/manageTaskStatuses'));
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                }
            }
            $this->render('manageTaskStatuses', array('form' => $form, 'saveResult' => $saveResult, 'statuses' => $statuses));
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
                    'roles' => array('admin'),
                    'users' => array('@'),
                ),
                array(
                    'deny'
                ),
            );
        }
    }
