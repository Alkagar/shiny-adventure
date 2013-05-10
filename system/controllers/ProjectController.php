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
                        $bizRule = 'return $data["project_id"] === $params["project_id"]';
                        $bizData = array('project_id' => $project->id);
                        $authManager->assign('project_owner', Yii::app()->user->model()->id, $bizRule, $bizData);

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
    }
