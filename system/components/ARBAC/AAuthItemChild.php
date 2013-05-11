<?php
    /**
    * @property string $parent
    * @property string $child
    */
    class AAuthItemChild extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'auth_item_child';
        }

        public function rules()
        {
            return array(
                array('parent, child', 'required'),
                array('parent, child', 'length', 'max'=>64),
                array('parent, child', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'children' => array(self::BELONGS_TO, 'AAuthItem', 'child'),
                'parents' => array(self::BELONGS_TO, 'AAuthItem', 'parent'),
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('parent',$this->parent,true);
            $criteria->compare('child',$this->child,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
    }
