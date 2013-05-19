<?php
    class TaskNote extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'task_note';
        }

        public function rules()
        {
            return array(
                array('author_id, task_id', 'numerical', 'integerOnly'=>true),
                array('created_at, modified_at, content', 'safe'),
                array('id, author_id, created_at, modified_at, content, task_id', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'task' => array(self::BELONGS_TO, 'Task', 'task_id'),
                'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('author_id',$this->author_id);
            $criteria->compare('created_at',$this->created_at,true);
            $criteria->compare('modified_at',$this->modified_at,true);
            $criteria->compare('content',$this->content,true);
            $criteria->compare('task_id',$this->task_id);

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
