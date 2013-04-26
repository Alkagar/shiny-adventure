<?php

    class UserForm extends CFormModel
    {
        public $mail;
        public $password;
        public $compare;
        public $signature;

        public function rules()
        {
            return array(
                array('mail, signature', 'required'),
                array('mail', 'email'),
                array('password', 'compare', 'compareAttribute' => 'compare'),
                array('compare', 'safe'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'mail' => Yii::t('form', 'label.email'),
                'password' => Yii::t('form', 'label.password'),
                'compare' => Yii::t('form', 'label.password-compare'),
                'signature' => Yii::t('form', 'label.signature'),
            );
        }
    }
