<?php


namespace frontend\controllers;


use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\models\User;

class BaseController extends Controller
{
    public function behaviors() : array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ]
        ];
    }

    public function beforeAction($action)
    {
        $user = User::findOne(Yii::$app->user->getId());
        $user->last_active_time = date('Y-m-d H:i:s');
        $user->save();
        return parent::beforeAction($action);
    }
}