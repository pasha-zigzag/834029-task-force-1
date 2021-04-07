<?php


namespace frontend\controllers;


use common\models\City;
use frontend\models\SignupForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class RegisterController extends Controller
{
    public function actionIndex()
    {
        $model = new SignupForm();
        $cities = ArrayHelper::map(City::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Вы успешно зарегестрировались!');
            return $this->goHome();
        }

        return $this->render('index', compact('model', 'cities'));
    }
}