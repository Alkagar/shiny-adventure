<?php
    class Attachment extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'attachment';
        }

        public function rules()
        {
            return array(
                array('belongs_to, author_id', 'numerical', 'integerOnly'=>true),
                array('url', 'length', 'max'=>255),
                array('type', 'length', 'max'=>64),
                array('created_at, modified_at', 'safe'),
                array('id, belongs_to, url, created_at, modified_at, author_id, type', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            );
        }

        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'belongs_to' => 'Belongs To',
                'url' => 'Url',
                'created_at' => 'Created At',
                'modified_at' => 'Modified At',
                'author_id' => 'Author',
                'type' => 'Type',
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('id',$this->id);
            $criteria->compare('belongs_to',$this->belongs_to);
            $criteria->compare('url',$this->url,true);
            $criteria->compare('created_at',$this->created_at,true);
            $criteria->compare('modified_at',$this->modified_at,true);
            $criteria->compare('author_id',$this->author_id);
            $criteria->compare('type',$this->type,true);

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
