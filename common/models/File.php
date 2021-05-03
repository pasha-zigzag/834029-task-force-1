<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;

class File extends base\File
{
    public const MIN_ATTACH_ID = -2147483648;
    public const MAX_ATTACH_ID = 2147483647;

    public static function saveFiles(array $files, $attach_id)
    {
        $upload_dir = Yii::getAlias('@webroot/uploads');

        if(!file_exists($upload_dir)) {
            FileHelper::createDirectory($upload_dir);
        }

        foreach ($files as $file) {
            $newname = Yii::$app->security->generateRandomString(8) . '.' . $file->getExtension();

            $file->saveAs($upload_dir . '/' . $newname);

            $task_file = new File();
            $task_file->name = $newname;
            $task_file->source = '/uploads/' . $newname;
            $task_file->attach_id = $attach_id;
            $task_file->save();
        }
    }
}
