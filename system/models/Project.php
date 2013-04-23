<?php

    class Project extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'project';
        }

        public function rules()
        {
            return array(
                array('name', 'required'),
                array('author_id', 'numerical', 'integerOnly'=>true),
                array('name', 'length', 'max'=>128),
                array('description, created_at, modified_at', 'safe'),
                array('id, name, description, author_id, created_at, modified_at', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'author' => array(self::BELONGS_TO, 'User', 'author_id'),
                'tasks' => array(self::HAS_MANY, 'Task', 'project_id'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'name' => 'Name',
                'description' => 'Description',
                'author_id' => 'Author',
                'created_at' => 'Created At',
                'modified_at' => 'Modified At',
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('name',$this->name,true);
            $criteria->compare('description',$this->description,true);
            $criteria->compare('author_id',$this->author_id);
            $criteria->compare('created_at',$this->created_at,true);
            $criteria->compare('modified_at',$this->modified_at,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
    }
