<?php

    class Assignee extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'assignee';
        }

        public function rules()
        {
            return array(
                array('task_id, user_id', 'numerical', 'integerOnly'=>true),
                array('id, task_id, user_id', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'task' => array(self::BELONGS_TO, 'Task', 'task_id'),
                'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'task_id' => 'Task',
                'user_id' => 'User',
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('task_id',$this->task_id);
            $criteria->compare('user_id',$this->user_id);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
    }
