<?php

    class LoginForm extends CFormModel
    {
        public $username;
        public $password;
        public $rememberMe;

        private $_identity;

        public function rules()
        {
            return array(
                array('username, password', 'required'),
                array('rememberMe', 'boolean'),
                array('password', 'authenticate'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'rememberMe' => Yii::t('form', 'label.remember-me'),
                'username' => Yii::t('form', 'label.username'),
                'password' => Yii::t('form', 'label.password'),
            );
        }

        public function authenticate($attribute,$params)
        {
            if(!$this->hasErrors())
            {
                $this->_identity = new AUserIdentity($this->username, $this->password);
                if(!$this->_identity->authenticate()) {
                    $this->addError('password', Yii::t('form', 'validate.login-error'));
                }
            }
        }

        /**
        * @return boolean whether login is successful
        */
        public function login()
        {
            if($this->_identity===null) {
                $this->_identity=new AUserIdentity($this->username,$this->password);
                $this->_identity->authenticate();
            }
            if($this->_identity->errorCode===AUserIdentity::ERROR_NONE) {
                $duration=$this->rememberMe ? 3600*24*30 : 0;
                Yii::app()->user->login($this->_identity,$duration);
                return true;
            }
            return false;
        }
    }
