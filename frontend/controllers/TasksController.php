<?php


namespace frontend\controllers;


use common\models\Task;
use taskforce\models\Task as TaskEntity;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $tasks = Task::find()->where(['status' => TaskEntity::STATUS_NEW])->with(['category', 'city'])->all();
        return $this->render('index', compact('tasks'));
    }
}