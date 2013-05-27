<?php

    class TaskController extends AController
    {
        private $_id = null;
        private $_projectId = null;

        public function actionAdd($projectId)
        {
            $project = Project::model()->findByPk($projectId);
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
                        $this->redirect(array('/task/change', 'id' => $task->id, 'projectId' => $task->project_id));
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                }
            }
            $this->render('add', array('form' => $form, 'saveResult' => $saveResult, 'project' => $project, ));
        }

        public function actionAddTaskNote($id)
        {
            header('Content-type: application/json');
            $jsonResponse = array();
            $taskId = $id;
            $userId = Yii::app()->user->id;
            $content = $this->request->getParam('content', null);
            if(is_null($content) || empty($content)) {
                $jsonResponse['status'] = 'ERROR';
                $jsonResponse['message'] = Yii::t('site', 'flash.operation-error');
            } else {
                $taskNote = new TaskNote();
                $taskNote->task_id = $taskId;
                $taskNote->author_id = $userId;
                $taskNote->content = $content;
                if($taskNote->save()) {
                    $taskNote = TaskNote::model()->findByPk($taskNote->id);
                    $jsonResponse['status'] = 'OK';
                    $jsonResponse['message'] = Yii::t('site', 'flash.operation-complete');
                    $jsonResponse['created_at'] = $taskNote->created_at;
                } else {
                    $jsonResponse['status'] = 'ERROR';
                    $jsonResponse['message'] = Yii::t('site', 'flash.operation-error');
                }
            } 
            echo CJSON::encode($jsonResponse);
            Yii::app()->end();
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

        public function actionRemoveAssigneeFromTask($id, $userId)
        {
            header('Content-type: application/json');
            $jsonResponse = array();

            $assignee = new Assignee();
            $assignee->task_id = $id;
            $assignee->user_id = $userId;
            $dp = $assignee->search();
            if(1 == $dp->getTotalItemCount()) {
                $assigneeToRemove = $dp->getData();
                $assigneeToRemove = $assigneeToRemove[0];
                if($assigneeToRemove->delete()) {
                    $jsonResponse['status'] = 'OK';
                    $jsonResponse['message'] = Yii::t('site', 'flash.operation-complete');
                } else {
                    $jsonResponse['status'] = 'ERROR';
                    $jsonResponse['message'] = Yii::t('site', 'flash.operation-error');
                }
            } else {
                $jsonResponse['status'] = 'ERROR';
                $jsonResponse['message'] = Yii::t('site', 'flash.operation-error');
            }

            echo CJSON::encode($jsonResponse);

            Yii::app()->end();
        }

        public function actionAddAssigneeToTask($id, $userId)
        {
            header('Content-type: application/json');
            $jsonResponse = array();

            $assignee = new Assignee();
            $assignee->task_id = $id;
            $assignee->user_id = $userId;
            $dp = $assignee->search();
            if(0 == $dp->getTotalItemCount() && $assignee->save() ) {
                $jsonResponse['status'] = 'OK';
                $jsonResponse['message'] = Yii::t('site', 'flash.operation-complete');
                $jsonResponse['removeLink'] = $this->createUrl('task/removeAssigneeFromTask', array('id' => $id, 'userId' => $userId));
                $mail = $assignee->user->mail;
                $changeUrl = $this->createUrl('task/change', array('id' => $id, 'project_id' => $this->_projectId));
                $this->_sendMail($mail, Yii::t('site', 'mail.assign-notification'), 'assign-notification', array('linkToTask' => $changeUrl));
            } else {
                $jsonResponse['status'] = 'ERROR';
                $jsonResponse['message'] = Yii::t('site', 'flash.operation-error');
            }

            echo CJSON::encode($jsonResponse);

            Yii::app()->end();
        }

        public function actionRemove($id)
        {
            $task = Task::model()->findByPk($id);
            $result = $task->delete();
            if($result) {
                Yii::app()->user->setFlash('notification', 'flash.operation-remove-complete');
            } else {
                Yii::app()->user->setFlash('notification', 'flash.operation-remove-error');
            }
            $this->render('remove', array('task' => $task));
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
            $ajaxOnly = array('addAssigneeToTask', 'removeAssigneeFromTask', 'addTaskNote');
            return array(
                'accessControl',
                'ajaxOnly + ' . join($ajaxOnly, ', '),
            );
        }

        public function accessRules() 
        {
            $params = array();
            $params['project_id'] = $this->_projectId;
            $params['task_id'] = $this->_id;
            $params['user_id'] = Yii::app()->user->id;
            return array(
                array(
                    'allow',
                    'actions' => array('remove',),
                    'roles' => array('remove_all_tasks' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('remove',),
                    'roles' => array('remove_own_tasks' => $params),
                    'expression' => array('AAuthExpressions', 'isTaskAuthor'),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('addTaskNote', ),
                    'roles' => array('add_task' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('add', ),
                    'roles' => array('add_task' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('change', 'addAssigneeToTask', 'removeAssigneeFromTask', ),
                    'roles' => array('edit_own_tasks' => $params),
                    'users' => array('@'),
                ),
                array(
                    'deny'
                ),
            );
        }
    }
