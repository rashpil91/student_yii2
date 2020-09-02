<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\StudentGroupe;

class StudentGroupeForm extends Model
{

    public $number;
    private $_student_groupe;

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';    

    public function __construct($student_groupe = false)
    {
        
        if ($student_groupe)
        {

            $this->number = $student_groupe->number;
            $this->_student_groupe = $student_groupe;
        
        } else 
            $this->_student_groupe = new StudentGroupe();

    }

    public function rules()
    {
        return [
            ['number', 'required'],
            ['number', 'unique', 'targetClass' => 'app\models\StudentGroupe', 'message' => 'Группа с этим номером уже существует.', 'on' => self::SCENARIO_ADD],
            ['number', 'unique', 'targetClass' => 'app\models\StudentGroupe', 'filter' => 'id != ' . $this->_student_groupe->id, 'message' => 'Группа с этим номером уже существует.', 'on' => self::SCENARIO_EDIT],
        ];
    }

    public function attributeLabels()
    {
        return [
            'number' => 'Номер'
        ];
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $student_groupe = $this->_student_groupe;
        $student_groupe->number = $this->number;
        return $student_groupe->save();
    }

}

?>