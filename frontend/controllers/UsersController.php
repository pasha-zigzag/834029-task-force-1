<?php


namespace frontend\controllers;


use common\models\Category;
use common\models\User;
use frontend\models\UserFilterForm;
use yii\helpers\ArrayHelper;

class UsersController extends BaseController
{
    public function actionIndex()
    {
        $filter = new UserFilterForm();
        $categories = ArrayHelper::map(Category::find()->all(), 'code', 'title');

        $users = User::find()
            ->where(['role' => User::WORKER_ROLE])
            ->with('workerReviews', 'workerTasks')
            ->all();

        return $this->render('index', [
            'users' => $users,
            'filter' => $filter,
            'categories' => $categories
        ]);
    }
}