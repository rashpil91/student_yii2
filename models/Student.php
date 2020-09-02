<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use app\models\Log; 
use app\models\Photo;

class Student extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%student}}';
    }  

    public function getStudentGroupe()
    {
        return $this->hasOne(StudentGroupe::className(), ['id' => 'student_groupe']);
    }

    public function afterSave($insert, $changedAttributes)
    {

        if (isset($changedAttributes['falled']) AND $this->attributes['falled'] == 0)
        {
            $log = new Log();
            $log->date = time();
            $log->user_id = Yii::$app->user->id;
            $log->ip = Yii::$app->request->userIP;
            $log->event = 1;
            $log->extra = implode(" ", [$this->attributes['lastname'], $this->attributes['firstname'], $this->attributes['patronymic']]);
            $log->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function beforeDelete()
    {

        if ($this->photo)
        {
            $image_path = Photo::getPath($this->photo);
            $image_path_thumb = Photo::getPath($this->photo, "thumb");

            if (file_exists($image_path)) @unlink($image_path);
            if (file_exists($image_path_thumb)) @unlink($image_path_thumb);           
        }

        $log = new Log();
        $log->date = time();
        $log->user_id = Yii::$app->user->id;
        $log->ip = Yii::$app->request->userIP;
        $log->event = 2;
        $log->extra = implode(" ", [$this->attributes['lastname'], $this->attributes['firstname'], $this->attributes['patronymic']]);
        $log->save();

        return parent::beforeDelete();
    }
}

?>