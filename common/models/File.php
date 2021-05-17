<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;

class File extends base\File
{
    public static function saveFiles(array $files, string $attach_id) : void
    {
        $upload_dir = Yii::getAlias('@webroot/uploads');

        if(!file_exists($upload_dir)) {
            FileHelper::createDirectory($upload_dir);
        }

        foreach ($files as $file) {
            $new_name = Yii::$app->security->generateRandomString(8) . '.' . $file->getExtension();

            $file->saveAs($upload_dir . '/' . $new_name);

            $task_file = new self();
            $task_file->name = $new_name;
            $task_file->source = '/uploads/' . $new_name;
            $task_file->attach_id = $attach_id;
            $task_file->save();
        }
    }
}
