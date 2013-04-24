<?php
    class AWebUser extends CWebUser {
        private $_model;

        public function model() 
        {
            if(empty($this->_model)) {
                $user = new User();
                $user->mail = Yii::app()->user->email;
                $user = $user->search()->getData();
                $this->_model = $user;
            } 
            return $this->_model;
        }

        public function login(AUserIdentity $identity, $duration = 0) 
        {
            parent::login($identity, $duration);
            $this->setReturnUrl(Yii::app()->params['dashboardPage']);
            $this->model();
        }

        protected function afterLogout()
        {
            unset($this->_model);
        }
    }

