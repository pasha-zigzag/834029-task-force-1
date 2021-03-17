<?php

namespace frontend\controllers;

use common\models\Category;
use frontend\models\UserFilterForm;
use yii\helpers\ArrayHelper;

class UsersController extends BaseController
{
    public function actionIndex()
    {
        $filter = new UserFilterForm();
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'title');

        $users = $filter->getUsers();

        return $this->render('index', [
            'users' => $users,
            'filter' => $filter,
            'categories' => $categories
        ]);
    }
}