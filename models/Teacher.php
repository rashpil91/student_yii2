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
    
    public function getCourseCount()
    {
        return $this->hasOne(StudentGroupeCourseWithTeacher::className(), ['teacher' => 'id'])->select("count(*) as count, teacher")->where(['status' => 1])->groupBy('teacher');

    }

    public function beforeDelete()
    {

        StudentGroupeCourseWithTeacher::deleteAll(['teacher' => $this->id]);
        return parent::beforeDelete();
    }
}

?>