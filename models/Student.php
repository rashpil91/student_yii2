<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Student extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%student}}';
    }  

}

?>