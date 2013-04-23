<?php

    class Status extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'status';
        }

        public function rules()
        {
            return array(
                array('name, type', 'length', 'max'=>64),
                array('description', 'length', 'max'=>255),
                array('id, name, type, description', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'tasks' => array(self::HAS_MANY, 'Task', 'status_id'),
                'users' => array(self::HAS_MANY, 'User', 'status_id'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'name' => 'Name',
                'type' => 'Type',
                'description' => 'Description',
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('name',$this->name,true);
            $criteria->compare('type',$this->type,true);
            $criteria->compare('description',$this->description,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
    }
