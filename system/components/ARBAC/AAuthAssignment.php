<?php
    /**
    * @property string $itemname
    * @property string $userid
    * @property string $bizrule
    * @property string $data
    * @property integer $project_id
    */
    class AAuthAssignment extends CActiveRecord
    {
        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'auth_assignment';
        }

        public function rules()
        {
            return array(
                array('itemname, userid, project_id', 'required'),
                array('project_id', 'numerical', 'integerOnly'=>true),
                array('itemname, userid', 'length', 'max'=>64),
                array('bizrule, data', 'safe'),
                array('itemname, userid, bizrule, data, project_id', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'authItem' => array(self::BELONGS_TO, 'AAuthItem', 'itemname'),
                'project' => array(self::BELONGS_TO, 'Project', 'project_id'),
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('itemname',$this->itemname,true);
            $criteria->compare('userid',$this->userid,true);
            $criteria->compare('bizrule',$this->bizrule,true);
            $criteria->compare('data',$this->data,true);
            $criteria->compare('project_id',$this->project_id);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
    }
