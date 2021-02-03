<?php


namespace frontend\controllers;


use common\models\User;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $users = User::find()->where(['role' => 'worker'])->all();
        return $this->render('index', compact('users'));
    }
}