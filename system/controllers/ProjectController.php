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

                        $this->redirect(array('/project/change', 'id' => $project->id));
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

                    $files = CUploadedFile::getInstancesByName('attachment');
                    foreach($files as $uploadedFile) {
                        $name = $uploadedFile->getName();
                        $name = time() . '_' . str_replace(' ', '_', $name);
                        $path = Yii::app()->params['projectAttachmentPath'] . $name;
                        $saveResult = $saveResult && $uploadedFile->saveAs($path);
                        if($saveResult) {
                            $attachment = new Attachment();
                            $attachment->url = $path;
                            $attachment->author_id = Yii::app()->user->id;
                            $attachment->belongs_to = $project->id;
                            $attachment->type = 'project';
                            $saveResult = $saveResult && $attachment->save();
                        }
                    }

                    if($saveResult) {
                        Yii::app()->user->setFlash('notification', 'flash.operation-complete');
                    } else {
                        Yii::app()->user->setFlash('notification', 'flash.operation-error');
                    }
                }
            }
            $this->render('change', array('form' => $form, 'saveResult' => $saveResult, 'project' => $project));
        }

        public function actionRemoveAttachment($attachmentId) 
        {
            header('Content-type: application/json');
            $jsonResponse = array();

            $attachment = Attachment::model()->findByPk($attachmentId);
            if(!is_null($attachment) && $attachment->delete()) {
                unlink($attachment->url);
                $jsonResponse['status'] = 'OK';
                $jsonResponse['message'] = Yii::t('site', 'flash.operation-complete');
            } else {
                $jsonResponse['status'] = 'ERROR';
                $jsonResponse['message'] = Yii::t('site', 'flash.operation-error');
            }
            echo CJSON::encode($jsonResponse);
            Yii::app()->end();
        }

        public function actionList()
        {
            $this->render('list');
        }

        public function actionRemove($id)
        {
            $project = Project::model()->findByPk($id);
            $attachmentFilesNames = array();
            foreach($project->attachments as $attachment) {
                $attachmentFilesNames[] = $attachment->url;
            }
            $result = $project->delete();
            if($result) {
                foreach($attachmentFilesNames as $url) {
                    unlink($url);
                }
                Yii::app()->user->setFlash('notification', 'flash.operation-complete');
            } else {
                Yii::app()->user->setFlash('notification', 'flash.operation-error');
            }
            $this->render('remove', array('project' => $project));
        }

        public function actionShowAttachment($attachmentId) 
        {
            $attachment = Attachment::model()->findByPk($attachmentId);
            if(is_null($attachment)) {
                throw new Exception(Yii::t('site', 'error.no-such-attachment'));
            } else {
                header('Content-disposition: attachment; filename=' . $attachment->getFileName());
                readfile($attachment->url);
                Yii::app()->end();
            }
        }

        public function actionManageUsers($id)
        {
            $project = Project::model()->findByPk($id);
            $users = User::model()->findAll();
            $roles = AAuthItem::model()->findAll();
            $roles = new AAuthItem();
            $roles->type = AAuthItem::ROLE;
            $dp = $roles->search();
            $roles = $dp->getData();
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
            $ajaxOnly = array('assignRoleToUser', 'revokeRoleFromUser', 'removeAttachment');
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
                    'actions' => array('manageUsers', 'assignRoleToUser', 'revokeRoleFromUser', ),
                    'roles' => array('manage_users_in_project' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('remove',),
                    'roles' => array('remove_project' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('change', 'removeAttachment'),
                    'roles' => array('edit_project' => $params),
                    'users' => array('@'),
                ),
                array(
                    'allow',
                    'actions' => array('show', 'showAttachment'),
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
