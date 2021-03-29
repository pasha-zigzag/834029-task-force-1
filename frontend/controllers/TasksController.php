<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Task;
use frontend\models\TaskFilterForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class TasksController extends BaseController
{
    public function actionIndex()
    {
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');
        $filter = new TaskFilterForm();

        if(Yii::$app->request->get('category')) {
            $filter->setCategory(Yii::$app->request->get('category'));
        }

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

    public function actionView($id)
    {
        $task = Task::findOne($id);

        if(!$task) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('view', [
            'task' => $task
        ]);
    }
}