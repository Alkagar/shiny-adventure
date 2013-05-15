<?php

    class TaskForm extends CFormModel
    {
        public $name;
        public $description;
        public $project_id;
        public $time_spent;
        public $parent_id;
        public $status_id;


        public function rules()
        {
            return array(
                array('name, description', 'required'),
                array('name', 'length', 'max'=>128),
                array('name, project_id, parent_id, time_spent, status_id, description', 'safe'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'name' => Yii::t('form', 'label.task-name'),
                'description' => Yii::t('form', 'label.task-description'),
                'project_id' => Yii::t('form', 'label.task-project-id'),
                'parent_id' => Yii::t('form', 'label.task-parent-id'),
                'time_spent' => Yii::t('form', 'label.task-time-spent'),
                'status_id' => Yii::t('form', 'label.task-status-id'),
            );
        }

        public function getStatusArray()
        {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(array('type' => 'task'));
            $statuses = Status::model()->findAll($criteria);
            $statusArray = array();
            foreach($statuses as $status) {
                $statusArray[$status->id] = $status->name;
            }
            return $statusArray;
        }
    }
