<?php

    class TaskController extends AController
    {
        private $_id = null;
        private $_projectId = null;

        public function actionAdd($projectId)
        {
            $saveResult = false;
            $form = new TaskForm();
            if(isset($_POST[get_class($form)])) {
                $form->attributes = $_POST[get_class($form)];
                if($form->validate()) {
                    // add task 
                    $task = new Task();
                    $task->author_id = Yii::app()->user->model()->id;
                    $task->name = $form->name;
                    $task->description = $form->description;
                    $task->project_id = $projectId;
                    $task->time_spent = 0;
                    $task->parent_id = null;
                    $task->status_id = $form->status_id;

                    $saveResult = $task->save();
                    if($saveResult) {
                        Yii::app()->user->setFlash('notification', 'flash.operation-complete');
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                }
            }
            $this->render('add', array('form' => $form, 'saveResult' => $saveResult));
        }

        public function actionChange($id)
        {
            $saveResult = false;
            $task = Task::model()->findByPk($id);
            $form = new TaskForm();
            if(isset($_POST[get_class($form)])) {
                $form->attributes = $_POST[get_class($form)];
                if($form->validate()) {
                    // add task 
                    $task->name = $form->name;
                    $task->description = $form->description;
                    $task->time_spent = $form->time_spent;
                    $task->status_id = $form->status_id;

                    $saveResult = $task->save();
                    if($saveResult) {
                        Yii::app()->user->setFlash('notification', 'flash.operation-complete');
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                }
            } else {
                $form->status_id = $task->status_id;
            }
            $this->render('change', array('form' => $form, 'saveResult' => $saveResult, 'task' => $task));
        }

        public function actionRemove()
        {
            $this->render('remove');
        }

        public function init()
        {
            parent::init();
            // ## check if id was in request, and if so check if task exists for that id, if not throw exception
            $id = $this->request->getParam('id', $this->_id);
            if(!is_null($id)) {
                $task = Task::model()->findByPk($id);
                if(is_null($task)) {
                    throw new Exception(Yii::t('site', 'error.no-such-task'));
                }
                $this->_id = $task->id;
                $this->_projectId = $task->project_id;
            }

            // ## check if id was in request, and if so check if project exists for that id, if not throw exception
            $projectId = $this->request->getParam('projectId', $this->_projectId);
            if(!is_null($projectId)) {
                $project = Project::model()->findByPk($projectId);
                if(is_null($project)) {
                    throw new Exception(Yii::t('site', 'error.no-such-project'));
                }
                $this->_projectId = $project->id;
            }
            // ## end
        }

        public function filters()
        {
            return array(
                'accessControl',
            );
        }
        public function accessRules() 
        {
            $params = array();
            $params['project_id'] = $this->_projectId;
            return array(
                array(
                    'allow',
                    'actions' => array('add',),
                    'roles' => array('add_task' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('change',),
                    'roles' => array('edit_own_tasks' => $params),
                    'users' => array('@'),
                ),
                array(
                    'deny'
                ),
            );
        }
    }
