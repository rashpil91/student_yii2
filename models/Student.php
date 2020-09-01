<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Student extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%student}}';
    }  

    public function getStudentGroupe()
    {
        return $this->hasOne(StudentGroupe::className(), ['id' => 'student_groupe']);
    }


}

?>