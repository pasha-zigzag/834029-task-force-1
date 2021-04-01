<?php


namespace frontend\controllers;


use Yii;
use yii\web\Controller;

class RegisterController extends Controller
{
    public function beforeAction($action) {

        Yii::$app->getModule('debug')->instance->allowedIPs = [];
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}