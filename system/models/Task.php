<?php

    class Task extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'task';
        }

        public function rules()
        {
            return array(
                array('project_id, time_spent, author_id, parent_id, status_id', 'numerical', 'integerOnly'=>true),
                array('name', 'length', 'max'=>255),
                array('description, created_at, modified_at', 'safe'),
                array('id, name, description, project_id, time_spent, author_id, parent_id, created_at, modified_at, status_id', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'parent' => array(self::BELONGS_TO, 'Task', 'parent_id'),
                'tasks' => array(self::HAS_MANY, 'Task', 'parent_id'),
                'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
                'status' => array(self::BELONGS_TO, 'Status', 'status_id'),
                'author' => array(self::BELONGS_TO, 'User', 'author_id'),
                'assignees' => array(self::HAS_MANY, 'Assignee', 'task_id'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'name' => 'Name',
                'description' => 'Description',
                'project_id' => 'Project',
                'time_spent' => 'Time Spent',
                'author_id' => 'Author',
                'parent_id' => 'Parent',
                'created_at' => 'Created At',
                'modified_at' => 'Modified At',
                'status_id' => 'Status',
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('name',$this->name,true);
            $criteria->compare('description',$this->description,true);
            $criteria->compare('project_id',$this->project_id);
            $criteria->compare('time_spent',$this->time_spent);
            $criteria->compare('author_id',$this->author_id);
            $criteria->compare('parent_id',$this->parent_id);
            $criteria->compare('created_at',$this->created_at,true);
            $criteria->compare('modified_at',$this->modified_at,true);
            $criteria->compare('status_id',$this->status_id);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

        public function beforeValidate() 
        {
            if ($this->isNewRecord) {
                $this->created_at = new CDbExpression('NOW()');
            } 
            $this->modified_at = new CDbExpression('NOW()');

            return parent::beforeValidate();
        }
    }
