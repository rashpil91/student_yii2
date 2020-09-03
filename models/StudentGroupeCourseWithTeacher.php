<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class StudentGroupeCourseWithTeacher extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%student_groupe_course_with_teacher}}';
    } 
    
    public function getCourses()
    {
        return $this->hasOne(Course::className(), ['id' => 'course']);
    }    

    public function getTeachers()
    {
        return $this->hasOne(Teacher::className(), ['id' => 'teacher']);
    }    

    public function getStudentGroupe()
    {
        return $this->hasOne(StudentGroupe::className(), ['id' => 'student_groupe']);
    }

    public function getStudent()
    {
        return $this->hasMany(Student::className(), ['student_groupe' => 'id'])->where(['falled' => 0])->via('studentGroupe');

    } 
}

?>