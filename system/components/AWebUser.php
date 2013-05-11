<?php
    class AWebUser extends CWebUser {
        private $_model;
        private $_access = array();

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
            $this->setState('__id', $this->model()->id);
        }

        protected function afterLogout()
        {
            unset($this->_model);
        }

        /**
        * Performs access check for this user.
        * @param string $operation the name of the operation that need access check.
        * @param int $projectId id of the project, if generic access provide '0'
        * @param array $params name-value pairs that would be passed to business rules associated
        * with the tasks and roles assigned to the user.
        * @return boolean whether the operations can be performed by this user.
        */
        public function checkAccess($operation, $params = array(), $allowCaching = true)
        {
            $access = Yii::app()->getAuthManager()->checkAccess($operation, $this->getId(), $params);
            return $access;
        }

    }

