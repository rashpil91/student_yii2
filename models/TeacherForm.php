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
    
    public function scenarios()
    {

        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADD] = $scenarios[self::SCENARIO_DEFAULT];
        $scenarios[self::SCENARIO_EDIT] = $scenarios[self::SCENARIO_DEFAULT];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['firstname', 'lastname', 'patronymic'], 'required'],
            ['firstname', 'unique_check'],
        ];
    }

    public function unique_check($attribute, $param)
    {

        $query = Teacher::find();
        $query->where(['firstname' => $this->firstname]);
        $query->andWhere(['lastname' => $this->lastname]);
        $query->andWhere(['patronymic' => $this->patronymic]);
        if ($this->scenario == self::SCENARIO_EDIT) $query->andWhere(['!=', 'id', $this->_teacher->id]);

        if ($query->count())
        {
            $this->addError($attribute, "Преподаватель с этим ФИО уже есть в базе");
            return false;
        }  

        return true;
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