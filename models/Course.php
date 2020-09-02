<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Course extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%course}}';
    }  

}

?>