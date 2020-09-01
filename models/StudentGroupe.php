<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class StudentGroupe extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%student_groupe}}';
    }  

}

?>