<?php
namespace app\models;

use yii\db\ActiveRecord;


/*
 * sgct - StudentGroupeCourseWithTeacher
 */


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

    public function getSgct()
    {
        return $this->hasMany(StudentGroupeCourseWithTeacher::className(), ['student_groupe' => 'id'])->where(['status' => 1])->with("teachers", "courses")->via("studentGroupe");
    }


    public function behaviors()
    {
        return [
            'student' => [
                'class' => 'app\behaviors\Student'
            ]
        ];
    }
}

?>