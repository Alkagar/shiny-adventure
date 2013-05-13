<?php
    /*
    * @property string $name
    * @property integer $type
    * @property string $description
    * @property string $bizrule
    * @property string $data
    */
    class AAuthItem extends CActiveRecord
    {

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }

        public function tableName()
        {
            return 'auth_item';
        }

        public function rules()
        {
            return array(
                array('name, type', 'required'),
                array('type', 'numerical', 'integerOnly'=>true),
                array('name', 'length', 'max'=>64),
                array('description, bizrule, data', 'safe'),
                array('name, type, description, bizrule, data', 'safe', 'on'=>'search'),
            );
        }

        public function relations()
        {
            return array(
                'assignments' => array(self::HAS_MANY, 'AAuthAssignment', 'itemname'),
                'children' => array(self::HAS_MANY, 'AAuthItemChild', 'child'),
                'parent' => array(self::HAS_MANY, 'AAuthItemChild', 'parent'),
            );
        }

        public function search()
        {
            $criteria=new CDbCriteria;

            $criteria->compare('name',$this->name,true);
            $criteria->compare('type',$this->type);
            $criteria->compare('description',$this->description,true);
            $criteria->compare('bizrule',$this->bizrule,true);
            $criteria->compare('data',$this->data,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }

        public function assign($userId, $projectId = 0)
	{
            $auth = Yii::app()->authManager;
            return $auth->assignItem($this->_name, $userId, $projectId);
	}

        public function isAssigned($userId, $projectId = 0)
	{
            $authAssignment = new AAuthAssignment();
            $authAssignment->userid = $userId;
            $authAssignment->itemname = $this->name;
            $authAssignment->project_id = $projectId;
            $dp = $authAssignment->search();
            return $dp->getTotalItemCount() > 0;
	}
    }
