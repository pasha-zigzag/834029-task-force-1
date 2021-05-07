<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;

class File extends base\File
{
//    public static function saveFiles(array $files)
//    {
//        $upload_dir = Yii::getAlias('@webroot/uploads');
//
//        if(!file_exists($upload_dir)) {
//            FileHelper::createDirectory($upload_dir);
//        }
//
//        foreach ($files as $file) {
//            $newname = Yii::$app->security->generateRandomString(8) . '.' . $file->getExtension();
//
//            $file->saveAs($upload_dir . '/' . $newname);
//
//            $task_file = new File();
//            $task_file->name = $newname;
//            $task_file->source = '/uploads/' . $newname;
//            $task_file->save();
//        }
//    }
}
