<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Student;
use app\models\StudentGroupeCourseWithTeacher;

class StudentGroupe extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%student_groupe}}';
    }

    public function getStudentCount()
    {
        return $this->hasOne(Student::className(), ['student_groupe' => 'id'])->select("count(*) as count, student_groupe")->where(['falled' => 0])->groupBy('student_groupe');

    }

    public function getCourseCount()
    {
        return $this->hasOne(StudentGroupeCourseWithTeacher::className(), ['student_groupe' => 'id'])->select("count(*) as count, student_groupe")->where(['status' => 1])->groupBy('student_groupe');

    }
    
    public function getStudent()
    {
        return $this->hasMany(Student::className(), ['student_groupe' => 'id'])->where(['falled' => 0]);
    }

    public function getSgct()
    {
        return $this->hasMany(StudentGroupeCourseWithTeacher::className(), ['student_groupe' => 'id'])->where(['status' => 1])->with("teachers", "courses");
    }

    public function beforeDelete()
    {

        foreach (Student::find()->where(['student_groupe' => $this->id])->all() as $k =>$student) {
            $student->delete();
        }

        StudentGroupeCourseWithTeacher::deleteAll(['student_groupe' => $this->id]);

        return parent::beforeDelete();
    }

}

?>