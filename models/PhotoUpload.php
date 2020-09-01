<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Student;
use app\models\Photo;
use yii\web\UploadedFile;
use yii\imagine\Image;

class PhotoUpload extends Model
{
    public $student_id;
    public $photo;
    private $_student = false;

    public function rules()
    {
        return [
            ['student_id', 'integer'],
            [['student_id', 'photo'], 'required'],
            ['student_id', 'student_check'],
            ['photo', 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 10485760, 'maxFiles' => 1, 'checkExtensionByMimeType' => false],
        ];
    }      

    public function student_check($attribute, $param)
    {
        
        $this->_student = Student::findOne(['id' => $this->$attribute]);

        if (!$this->_student)
        {
            $this->addError($this->attribute, "Ошибка при передаче данных");
            return false;
        }  

        if ($this->_student->photo)
        {
            $this->addError($this->attribute, "Фото уже загружено. Если хотите заменить, сначала удалите предыдущее.");
            return false;           
        }

        return true;
    }

    public function beforeValidate()
    {
        $photo = UploadedFile::getInstances($this, 'photo');
        if ($photo) $this->photo = $photo[0];

        return true;
    }

    private function loadImage($photo)
    {
        
        $image_name = strtotime("now") . "_" . Yii::$app->security->generateRandomString(5) . '.' . $photo->extension;
        $image_path = Photo::getPath($image_name);
        $image_path_thumb = Photo::getPath($image_name, "thumb");

        if ($photo->saveAs($image_path)) 
        {
            Image::thumbnail($image_path, null, 200)->save($image_path_thumb, ['quality' => 80]);
            Image::thumbnail($image_path, 800, null)->save($image_path, ['quality' => 80]);
            return $image_name;
        } 

        return false;

    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $photo = $this->loadImage($this->photo);

        if ($photo)
        {
            $this->_student->photo = $photo;
            return $this->_student->save();
        }

        return false;
    }    

}

