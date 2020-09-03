<?php

namespace app\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\base\Behavior;
use app\models\Log; 
use app\models\Photo;

class Student extends Behavior
{

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_UPDATE  => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE   => 'beforeDelete',
        ];
    }

    private function insertLog($event, $extra)
    {
        $log = new Log();
        $log->date = time();
        $log->user_id = Yii::$app->user->id;
        $log->ip = Yii::$app->request->userIP;
        $log->event = $event;
        $log->extra = $extra;
        $log->save();       
    }

    public function afterSave($event)
    {

        if (isset($event->changedAttributes['falled']) AND $event->sender['falled'] == 0)
        {
            $this->insertLog(1, implode(" ", [$event->sender['lastname'], $event->sender['firstname'], $event->sender['patronymic']]));
        }

    }

    public function beforeDelete($event)
    {

        if ($event->sender['photo'])
        {
            $image_path = Photo::getPath($event->sender['photo']);
            $image_path_thumb = Photo::getPath($event->sender['photo'], "thumb");

            if (file_exists($image_path)) @unlink($image_path);
            if (file_exists($image_path_thumb)) @unlink($image_path_thumb);           
        }

        $this->insertLog(2, implode(" ", [$event->sender['lastname'], $event->sender['firstname'], $event->sender['patronymic']]));

    }
}

?>