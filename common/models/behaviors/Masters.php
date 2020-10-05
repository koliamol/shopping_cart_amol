<?php 

namespace common\models\behaviors;

use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

trait Masters {
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'modified_date',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getStatusList () {
        return [1 => 'Active', 0 => 'In Active'];
    }
   
    public function getStatusName () {
        $statusTypeList = $this->getStatusList();
        $name = isset($statusTypeList[$this->status]) ? $statusTypeList[$this->status] : '';
        return $name;
    }

    public function getDisplayOn () {
        return [1 => 'Yes', 0 => 'No'];
    }
}