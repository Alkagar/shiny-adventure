<?php

    class StatusForm extends CFormModel
    {
        public $name;
        public $type;
        public $description;
        public $internal_type;

        public function rules()
        {
            return array(
                array('name, description, internal_type', 'required'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'type' => Yii::t('form', 'label.status-type'),
                'name' => Yii::t('form', 'label.status-name'),
                'description' => Yii::t('form','label.status-description'),
                'internalType' => Yii::t('form','label.status-internal-type'),
            );
        }

        public static function getTaskInternalTypes() 
        {
            return array(
                'o' => Yii::t('site', 'config.status-internal-open'),
                'c' => Yii::t('site', 'config.status-internal-closed'),
                'n' => Yii::t('site', 'config.status-internal-new'),
            );
        }
    }
