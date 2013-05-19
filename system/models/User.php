<?php

    class User extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'user';
        }

        public function rules()
        {
            return array(
                array('mail, password', 'required'),
                array('status_id', 'numerical', 'integerOnly'=>true),
                array('mail', 'length', 'max'=>128),
                array('password', 'length', 'max'=>40),
                array('signature', 'length', 'max'=>64),
                array('id, mail, password, signature, status_id', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'attachments' => array(self::HAS_MANY, 'Attachment', 'author_id'),
                'projects' => array(self::HAS_MANY, 'Project', 'author_id'),
                'tasks' => array(self::HAS_MANY, 'Task', 'author_id'),
                'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
                'taskNotes' => array(self::HAS_MANY, 'TaskNote', 'author_id'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'mail' => 'Mail',
                'password' => 'Password',
                'signature' => 'Signature',
                'status_id' => 'Status',
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('mail',$this->mail,true);
            $criteria->compare('password',$this->password,true);
            $criteria->compare('signature',$this->signature,true);
            $criteria->compare('status_id',$this->status_id);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
    }
