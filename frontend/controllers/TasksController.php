<?php


namespace frontend\controllers;


use common\models\Task;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->where(['status' => 'new'])->with(['category', 'city'])->all();
        return $this->render('index', compact('tasks'));
    }
}