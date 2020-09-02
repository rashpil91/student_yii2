<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Log extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%log}}';
    }  
    
}

?>