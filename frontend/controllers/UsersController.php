<?php


namespace frontend\controllers;


use common\models\User;

class UsersController extends BaseController
{
    public function actionIndex()
    {
        $users = User::find()->where(['role' => User::WORKER_ROLE])->with('workerReviews', 'workerTasks')->all();
        return $this->render('index', compact('users'));
    }
}