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

    public function getStudent()
    {
        return $this->hasMany(Student::className(), ['student_groupe' => 'id']);
    }
}

?>