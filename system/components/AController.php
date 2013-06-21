<?php
    class AController extends CController
    {
        public $layout = '/layouts/main';
        public $request;

        public function init() 
        {
            parent::init();
            $this->request = Yii::app()->getRequest();

            Yii::app()->language = 'pl';
            
            // need to work on that
            //Yii::app()->attachEventHandler('onError',array($this,'handleError'));
            //Yii::app()->attachEventHandler('onException',array($this,'handleError'));
        }

        protected function _sendMail($to, $subject, $view, $params = array())
        {
            $mail = Yii::app()->Smtpmail;
            $mail->SetFrom('alkagar@gmail.com', 'Shiny Adventure');
            $mail->Subject = $subject;

            $content = $this->renderPartial('/mails/' . $view, $params, true);
            $mail->MsgHTML($content);

            if(!is_array($to)) {
                $to = array($to);
            } 
            foreach($to as $emailAddress) {
                $mail->AddAddress($emailAddress, "");
            }

            if(!$mail->Send()) {
                return $mail->ErrorInfo;
            } else {
                return true;
            }
        }

        protected function _saveAttachments($belongsTo, $type, $path, $fileVarName = 'attachment')
        {
            $saveResult = true;
            $files = CUploadedFile::getInstancesByName($fileVarName);
            foreach($files as $uploadedFile) {
                $name = $uploadedFile->getName();
                $name = time() . '_' . str_replace(' ', '_', $name);
                $path = $path . $name;
                $saveResult = $saveResult && $uploadedFile->saveAs($path);
                if($saveResult) {
                    $attachment = new Attachment();
                    $attachment->url = $path;
                    $attachment->author_id = Yii::app()->user->id;
                    $attachment->belongs_to = $belongsTo;
                    $attachment->type = $type;
                    $saveResult = $saveResult && $attachment->save();
                }
            }
            return $saveResult;
        }

        public function beforeRender($view) 
        {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/scripts/jquery.min.js');
            Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/scripts/default.js');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/cssreset-min.css');
            Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/default.css');
            return true;
        }

        /*
        public function handleError(CEvent $event)
        {        
            if ($event instanceof CExceptionEvent)
            {
                $this->render('/common/error');
            }
            elseif($event instanceof CErrorEvent)
            {
                $this->render('/common/error');
            }
            $event->handled = TRUE;
        }
        */
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
                    'controllers' => array('main', 'gii'),
                    'users' => array('*'),
                ),
                array(
                    'deny'
                ),
            );
        }
    }

