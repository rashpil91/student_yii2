<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Teacher extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%teacher}}';
    }  

}

?>