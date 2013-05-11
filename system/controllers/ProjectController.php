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
            if(is_null($project)) {
                throw new Exception('Nie ma takiego projektu');
            }
            $this->render('show', array('project' => $project));
        }

        public function actionChange()
        {
            $this->render('change');
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

        public function filters()
        {
            return array(
                'accessControl',
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
                    'actions' => array('remove',),
                    'roles' => array('project_owner' => $params),
                ),
                array(
                    'allow',
                    'actions' => array('change',),
                    'roles' => array('project_editor' => $params),
                ),
                array(
                    'allow',
                    'actions' => array('show',),
                    'roles' => array('project_member' => $params),
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
