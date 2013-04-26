<?php
    class AWebUser extends CWebUser {
        private $_model;

        public function model($refresh = true) 
        {
            if(empty($this->_model) || $refresh) {
                $user = new User();
                $user->mail = Yii::app()->user->email;

                $userDataProvider = $user->search();
                if((int)$userDataProvider->totalItemCount !== 1) {
                    throw new CException(Yii::t('errors', 'too-many-users-found'), 2001);
                }
                $users = $userDataProvider->getData();
                $this->_model = array_shift($users);
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

