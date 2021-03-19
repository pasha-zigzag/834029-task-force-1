<?php

namespace frontend\controllers;

use common\models\Category;
use frontend\models\TaskFilterForm;
use Yii;
use yii\helpers\ArrayHelper;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');
        $filter = new TaskFilterForm();

        if(Yii::$app->request->isPost) {
            $filter->load(Yii::$app->request->post());
        }

        $tasks = $filter->getTasks();

        return $this->render('index', [
            'tasks' => $tasks,
            'filter' => $filter,
            'categories' => $categories
        ]);
    }
}