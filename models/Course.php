<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/*
 * sgct - StudentGroupeCourseWithTeacher
 */

class Course extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%course}}';
    }
    
    public function getSgct()
    {
        return $this->hasMany(StudentGroupeCourseWithTeacher::className(), ['course' => 'id']);
    }

    public function getStudentGroupe()
    {
        return $this->hasMany(StudentGroupe::className(), ['id' => 'student_groupe'])->via('sgct');

    }    

    public function getTeacher()
    {
        return $this->hasMany(Teacher::className(), ['id' => 'teacher'])->via('sgct');

    }   

    public function beforeDelete()
    {

        StudentGroupeCourseWithTeacher::deleteAll(['course' => $this->id]);
        return parent::beforeDelete();
    }

}

?>