<?php


namespace frontend\controllers;


use common\models\Category;
use common\models\Task;
use frontend\models\TaskFilterForm;
use taskforce\models\Task as TaskEntity;
use yii\helpers\ArrayHelper;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $filter = new TaskFilterForm();
        $categories = ArrayHelper::map(Category::find()->all(), 'code', 'title');

        $tasks = Task::find()
            ->where(['status' => TaskEntity::STATUS_NEW])
            ->with(['category', 'city'])
            ->all();

        return $this->render('index', [
            'tasks' => $tasks,
            'filter' => $filter,
            'categories' => $categories
        ]);
    }
}