<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\User;
use frontend\models\UserFilterForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class UsersController extends BaseController
{
    public function actionIndex($sort = UserFilterForm::SORT_RATING)
    {
        $filter = new UserFilterForm();
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');

        $filter->setSort($sort);

        if(Yii::$app->request->isPost) {
            $filter->load(Yii::$app->request->post());
        }

        $users = $filter->getUsers();

        return $this->render('index', [
            'users' => $users,
            'filter' => $filter,
            'categories' => $categories
        ]);
    }

    public function actionView($id)
    {
        $user = User::findOne($id);

        if(!$user || $user->role !== User::WORKER_ROLE) {
            throw new NotFoundHttpException('Страница не найдена');
        }

        return $this->render('view', [
            'user' => $user
        ]);
    }
}