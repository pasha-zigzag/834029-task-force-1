<?php


namespace frontend\controllers;


use common\models\Task;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $tasks = Task::find()->where(['status' => 'new'])->with(['category', 'city'])->all();
        return $this->render('index', compact('tasks'));
    }
}