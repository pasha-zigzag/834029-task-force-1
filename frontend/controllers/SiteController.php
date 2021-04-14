<?php
namespace frontend\controllers;

use Yii;
use common\models\Task;
use frontend\models\SigninForm;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/tasks']);
        }

        $this->layout = 'landing';

        $login_form = new SigninForm();
        $tasks = Task::find()->limit(4)->orderBy('created_at DESC')->all();

        if (Yii::$app->request->getIsPost()) {
            $login_form->load(Yii::$app->request->post());
            if ($login_form->validate()) {
                $user = $login_form->getUser();
                Yii::$app->user->login($user);
                return $this->redirect(['/tasks']);
            }
        }

        return $this->render('index', compact('login_form', 'tasks'));
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
