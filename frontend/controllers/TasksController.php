<?php

namespace frontend\controllers;

use common\models\Category;
use frontend\models\TaskFilterForm;
use yii\helpers\ArrayHelper;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');
        $filter = new TaskFilterForm();

        $tasks = $filter->getTasks();

        return $this->render('index', [
            'tasks' => $tasks,
            'filter' => $filter,
            'categories' => $categories
        ]);
    }
}