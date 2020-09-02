<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\Course;

class CourseForm extends Model
{

    public $id;
    public $name;
    public $time;

    private $_course;

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';    

    public function __construct($course = false)
    {
        
        if ($course)
        {
            $this->id = $course->id;
            $this->name = $course->name;
            $this->time = $course->time;

            $this->_course = $course;
        
        } else 
            $this->_course = new Course();

    }

    public function rules()
    {
        return [
            [['name', 'time'], 'required'],
            ['name', 'unique', 'targetClass' => 'app\models\Course', 'message' => 'Курс с таким названием уже существует.', 'on' => self::SCENARIO_ADD],
            ['name', 'unique', 'targetClass' => 'app\models\Course', 'filter' => 'id != ' . $this->id, 'message' => 'Курс с таким названием уже существует.', 'on' => self::SCENARIO_EDIT],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'time' => 'Продолжительность'
        ];
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $course = $this->_course;
        $course->name = $this->name;
        $course->time = $this->time;
        $course->save();
        
        $this->id = $course->id;

        return true;
    }

}

?>