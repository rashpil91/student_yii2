<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class StudentForm extends Model
{
    public $id;
    public $firstname;
    public $lastname;
    public $patronymic;
    public $student_groupe;
    public $falled;
    public $photo;
    private $_student;
    private $_student_groupe;

    public function __construct($student, $student_groupe)
    {
        
        $this->id = $student->id;
        $this->firstname = $student->firstname;
        $this->lastname = $student->lastname;
        $this->patronymic = $student->patronymic;
        $this->student_groupe = $student->student_groupe;
        $this->photo = $student->photo;
        $this->falled = $student->falled;
       
        $this->_student = $student;
        $this->_student_groupe = ArrayHelper::getColumn($student_groupe, 'id');
    }

    public function rules()
    {

        return [
            [['firstname', 'lastname', 'patronymic', 'student_groupe'], 'required'],
            ['student_groupe', 'in', 'allowArray' => true,  'range' => $this->_student_groupe]
        ];
    }

    public function attributeLabels()
    {

        return [
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'student_groupe' => 'Группа',
            'photo' => "Фото"
        ];
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $student = $this->_student;
        $student->firstname = $this->firstname;
        $student->lastname = $this->lastname;
        $student->patronymic = $this->patronymic;
        $student->student_groupe = $this->student_groupe;

        if ($this->_student->falled) 
        {
            $student->falled = 0;
        }

        return $student->save();
    }

}

?>