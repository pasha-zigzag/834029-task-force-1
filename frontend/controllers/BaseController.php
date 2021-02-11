<?php


namespace frontend\controllers;


use common\models\User;
use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        $user = User::findOne(1); // TODO Yii::$app->user->id
        $user->last_active_time = date('Y-m-d H:i:s');
        $user->save();
        return parent::beforeAction($action);
    }
}