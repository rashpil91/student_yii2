<?php

namespace app\models;
use Yii;

Class Photo 
{
    private static $path = 
    [    
        'student' => [
            'original' => '/uploads/student/',
            'thumb' => '/uploads/student/thumbs/'
        ]
    ];

    private static $noimage = "/uploads/student/thumbs/noimage.png";

    /*
     * Возвращает полный путь картинки.
     * Создает каталог и устанавливает права на запись, если его нет.
     */ 

    static function getPath($filename, $type = "original", $folder = "student")
    {
        if (empty(self::$path[$folder])) 
            throw new Exception('Неизвестный каталог');

        $path = Yii::getAlias('@app/web' . self::$path[$folder][$type]);

        if (!is_dir($path))
        {
            @mkdir($path, 0777);
        }

        return $path . $filename;

    }

    /*
     * Возвращает урл картинки для вывода.
     * По-умолчанию возвращает уменьшенную копию, если она существует
     */ 
    
    static function getImage($filename, $folder = "student")
    {

        if (empty(self::$path[$folder])) 
            throw new Exception('Неизвестный каталог');

        if (isset(self::$path[$folder]['thumb']) AND file_exists(Yii::getAlias('@app/web' . self::$path[$folder]['thumb']) . $filename))
            return self::$path[$folder]['thumb'] . $filename;

        if (isset(self::$path[$folder]['original']) AND file_exists(Yii::getAlias('@app/web' . self::$path[$folder]['original']) . $filename))
            return self::$path[$folder]['original'] . $filename;

        return self::$noimage;
    }

}

?>