<?php

namespace frontend\controllers;

use common\models\Category;
use frontend\models\UserFilterForm;
use Yii;
use yii\helpers\ArrayHelper;

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
}