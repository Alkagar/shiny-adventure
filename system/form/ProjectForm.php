<?php

    class ProjectForm extends CFormModel
    {
        public $name;
        public $description;


        public function rules()
        {
            return array(
                array('name, description', 'required'),
                array('name', 'length', 'max'=>128),
                array('name, description', 'safe'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'name' => Yii::t('form', 'label.project-name'),
                'description' => Yii::t('form', 'label.project-description'),
            );
        }
    }
