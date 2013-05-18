<?php

    class History extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'history';
        }

        public function rules()
        {
            // will receive user inputs.
            return array(
                array('user_id, ref_id', 'numerical', 'integerOnly'=>true),
                array('type', 'length', 'max'=>64),
                array('change, date', 'safe'),
                array('id, type, change, date, user_id, ref_id', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'type' => 'Type',
                'change' => 'Change',
                'date' => 'Date',
                'user_id' => 'User',
                'ref_id' => 'Ref',
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('type',$this->type,true);
            $criteria->compare('change',$this->change,true);
            $criteria->compare('date',$this->date,true);
            $criteria->compare('user_id',$this->user_id);
            $criteria->compare('ref_id',$this->ref_id);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
    }
