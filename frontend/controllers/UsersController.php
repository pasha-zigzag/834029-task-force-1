<?php


namespace frontend\controllers;


use common\models\Category;
use common\models\User;
use frontend\models\UserFilterForm;
use taskforce\models\Task;
use Yii;
use yii\db\Expression;
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