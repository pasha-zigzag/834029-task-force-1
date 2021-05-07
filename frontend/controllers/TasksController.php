<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\File;
use common\models\Task;
use common\models\User;
use frontend\models\TaskFilterForm;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class TasksController extends BaseController
{
    public $enableCsrfValidation = false;

    public function behaviors() : array
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['create'],
            'matchCallback' => function ($rule, $action) {
                return Yii::$app->user->identity->role != User::CUSTOMER_ROLE;
            }
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionIndex()
    {
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');
        $filter = new TaskFilterForm();

        if (Yii::$app->request->get('category')) {
            $filter->setCategory((int)Yii::$app->request->get('category'));
        }

        if (Yii::$app->request->isPost) {
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

        if (!$task) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('view', [
            'task' => $task
        ]);
    }

    public function actionCreate()
    {
        $model = new Task();
        $categories = Category::find()->select(['title'])->indexBy('id')->column();

        if(Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            $customer_id = Yii::$app->user->identity->getId();

            if ($model->createTask($customer_id)) {
                $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', compact('model', 'categories'));
    }

    public function actionLoadFiles()
    {
//        if (Yii::$app->request->isAjax) {
//            $files = UploadedFile::getInstancesByName('files');
//            File::saveFiles($files);
//
//            return true;
//        }
    }
}