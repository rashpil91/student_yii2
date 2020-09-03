<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\StudentGroupeCourseWithTeacher;

class StudentGroupeCourseWithTeacherForm extends Model
{

    public $id;
    public $student_groupe;
    public $course;
    public $teacher;
    public $status;

    private $_course_teacher;
    private $_course;
    private $_student_groupe;
    private $_teacher;
    private $_status;

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';    

    public function __construct($course_teacher = false, $course, $student_groupe, $teacher, $status)
    {
        
        if ($course_teacher)
        {

            $this->student_groupe = $course_teacher->student_groupe;
            $this->course = $course_teacher->course;
            $this->teacher = $course_teacher->teacher;
            $this->status = $course_teacher->status;

            $this->_course_teacher = $course_teacher;
        
        } else
            $this->_course_teacher = new StudentGroupeCourseWithTeacher();
        
        $this->_course = ArrayHelper::getColumn($course, 'id');
        $this->_student_groupe = ArrayHelper::getColumn($student_groupe, 'id');
        $this->_teacher = ArrayHelper::getColumn($teacher, 'id');
        $this->_status = array_keys($status);

    }

    public function rules()
    {
        return [
            [['student_groupe', 'course', 'teacher'], 'required'],
            ['status', 'required'],
            ['course', 'in', 'allowArray' => true,  'range' => $this->_course],
            ['student_groupe', 'in', 'allowArray' => true,  'range' => $this->_student_groupe],
            ['teacher', 'in', 'allowArray' => true,  'range' => $this->_teacher],
            ['status', 'in', 'allowArray' => true,  'range' => $this->_status, 'on' => self::SCENARIO_EDIT],
            ['student_groupe', 'unique_check']
 
        ];
    }

    public function attributeLabels()
    {
        return [
            'student_groupe' => 'Группа',
            'course' => 'Курс',
            'teacher' => 'Преподаватель',
            'status' => 'Статус'
        ];
    }

    public function scenarios()
    {

        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = $scenarios[self::SCENARIO_DEFAULT];
        $scenarios[self::SCENARIO_EDIT] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }

    public function unique_check($attribute, $param)
    {

        $query = StudentGroupeCourseWithTeacher::find();
        $query->where(['student_groupe' => $this->$attribute]);
        $query->andWhere(['teacher' => $this->teacher]);
        $query->andWhere(['course' => $this->course]);

        if ($this->scenario == self::SCENARIO_EDIT)
            $query->andWhere(['!=', 'id', $this->_course_teacher->id]);

        if ($query->count())
        {
            $this->addError($attribute, "Группа уже записана на выбранный курс с этим преподавателем.");
            return false;
        }  

        return true;
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $course_teacher = $this->_course_teacher;
        $course_teacher->student_groupe = $this->student_groupe;
        $course_teacher->course = $this->course;
        $course_teacher->teacher = $this->teacher;
        $course_teacher->status = $this->status;

        $course_teacher->save();

        $this->id = $course_teacher->id;

        return true;
    }

}

?>