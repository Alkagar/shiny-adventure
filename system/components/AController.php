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
    }

