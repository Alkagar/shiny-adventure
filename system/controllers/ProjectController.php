<?php

    class ProjectController extends AController
    {
        public function actionAdd()
        {
            $saveResult = false;
            $form = new ProjectForm();
            if(isset($_POST[get_class($form)])) {
                $form->attributes = $_POST[get_class($form)];
                if($form->validate()) {
                    // add project
                    $project = new Project();
                    $project->author_id = Yii::app()->user->model()->id;
                    $project->name = $form->name;
                    $project->description = $form->description;

                    $saveResult = $project->save();
                    if($saveResult) {

                        // add default auth_assigment to this project only if project saved in db
                        $authManager = Yii::app()->authManager;
                        $authManager->assignItem('project_owner', Yii::app()->user->id, $project->id);

                        Yii::app()->user->setFlash('notification', 'flash.operation-complete');
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                }
            }
            $this->render('add', array('form' => $form, 'saveResult' => $saveResult));
        }

        public function actionShow($id)
        {
            $project = Project::model()->findByPk($id);
            $this->render('show', array('project' => $project));
        }

        public function actionChange($id)
        {
            $saveResult = false;
            $project = Project::model()->findByPk($id);
            $form = new ProjectForm();
            if(isset($_POST[get_class($form)])) {
                $form->attributes = $_POST[get_class($form)];
                if($form->validate()) {
                    // add project
                    $project->name = $form->name;
                    $project->description = $form->description;

                    $saveResult = $project->save();
                    if($saveResult) {
                        Yii::app()->user->setFlash('notification', 'flash.operation-complete');
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                }
            }
            $this->render('change', array('form' => $form, 'saveResult' => $saveResult, 'project' => $project));
        }

        public function actionList()
        {
            $this->render('list');
        }

        public function actionRemove($id)
        {
            $project = Project::model()->findByPk($id);
            $result = $project->delete();
            if($result) {
                Yii::app()->user->setFlash('notification', 'flash.operation-complete');
            } else {
                Yii::app()->user->setFlash('notification', 'flash.operation-error');
            }
            $this->render('remove');
        }

        public function actionManageUsers($id)
        {
            $project = Project::model()->findByPk($id);
            $users = User::model()->findAll();
            $roles = AAuthItem::model()->findAll();
            $this->render('manage-users', array(
                'project' => $project,
                'users' => $users,
                'roles' => $roles,
            ));
        }

        // ## admin actions:
        public function actionRevokeRoleFromUser($id, $userId, $role) 
        {
            header('Content-type: application/json');
            $jsonResponse = array();

            $authManager = Yii::app()->authManager;
            $jsonResponse['status'] = 'OK';
            $jsonResponse['message'] = Yii::t('site', 'flash.operation-complete');
            try {
                $authManager->revokeItem($role, $userId, $id);
            } catch (CException $ex) {
                $jsonResponse['status'] = 'ERROR';
                $jsonResponse['message'] = $ex->getMessage();
            }

            echo CJSON::encode($jsonResponse);

            Yii::app()->end();
            }

        public function actionAssignRoleToUser($id, $userId, $role) 
        {
            header('Content-type: application/json');
            $jsonResponse = array();

            $authManager = Yii::app()->authManager;
            $jsonResponse['status'] = 'OK';
            $jsonResponse['message'] = Yii::t('site', 'flash.operation-complete');
            try {
                $authManager->assignItem($role, $userId, $id);
            } catch (CException $ex) {
                $jsonResponse['status'] = 'ERROR';
                $jsonResponse['message'] = $ex->getMessage();
            }
            echo CJSON::encode($jsonResponse);

            Yii::app()->end();
        }

        // ## end

        // ## controller stuff:

        public function init()
        {
            parent::init();
            // ## check if id was in request, and if so check if project exists for that id, if not throw exception
            $id = $this->request->getParam('id', null);
            if(!is_null($id)) {
                $project = Project::model()->findByPk($id);
                if(is_null($project)) {
                    throw new Exception(Yii::t('site', 'error.no-such-project'));
                }
            }
            // ## end
        }

        public function filters()
        {
            $ajaxOnly = array('assignRoleToUser', 'revokeRoleFromUser');
            return array(
                'accessControl',
                'ajaxOnly + ' . join($ajaxOnly, ', '),
            );
        }
        public function accessRules() 
        {
            $projectId = $this->request->getParam('id', 0);
            $params = array();
            $params['project_id'] = $projectId;
            return array(
                array(
                    'allow',
                    'actions' => array('remove', 'manageUsers', 'assignRoleToUser', 'revokeRoleFromUser'),
                    'roles' => array('project_owner' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('change',),
                    'roles' => array('project_editor' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('show',),
                    'roles' => array('project_member' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('add', 'list',),
                    'users' => array('@'),
                ),
                array(
                    'deny'
                ),
            );
        }


    }
