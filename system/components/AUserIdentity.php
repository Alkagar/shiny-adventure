<?php

    class AUserIdentity extends CUserIdentity
    {
        private $_id;

        public function authenticate()
        {
            $user = new User();
            $user->mail = $this->username;
            $user->password = sha1($this->password);
            $userCount = (int)$user->search()->totalItemCount;

            if ($userCount === 0) {
                $this->errorCode=self::ERROR_USERNAME_INVALID;
            } else {
                $this->errorCode=self::ERROR_NONE;
                $this->setState('email', $this->username);
            }
            return ! $this->errorCode;
        }
    }
