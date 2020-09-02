<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\Teacher;

class TeacherForm extends Model
{

    public $id;
    public $firstname;
    public $lastname;
    public $patronymic;

    private $_teacher;

    const SCENARIO_ADD = 'add';
    const SCENARIO_EDIT = 'edit';    

    public function __construct($teacher = false)
    {
        
        if ($teacher)
        {
            $this->id = $teacher->id;
            $this->firstname = $teacher->firstname;
            $this->lastname = $teacher->lastname;
            $this->patronymic = $teacher->patronymic;

            $this->_teacher = $teacher;
        
        } else 
            $this->_teacher = new Teacher();

    }

    public function rules()
    {
        return [
            [['firstname', 'lastname', 'patronymic'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'patronymic' => 'Отчество',
        ];
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $teacher = $this->_teacher;
        $teacher->firstname = $this->firstname;
        $teacher->lastname = $this->lastname;
        $teacher->patronymic = $this->patronymic;
        $teacher->save();
        
        $this->id = $teacher->id;

        return true;
    }

}

?>