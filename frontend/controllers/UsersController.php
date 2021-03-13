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

        $users = User::find()
            ->where(['role' => User::WORKER_ROLE])
            ->with('workerReviews', 'workerTasks');

        if($sort = Yii::$app->request->get('sort')) {
            switch($sort) {
                case UserFilterForm::SORT_RATING:
                    $users->leftJoin('review', 'user.id = review.worker_id')
                        ->groupBy('user.id')
                        ->orderBy('AVG(review.rating) DESC');
                    break;
                case UserFilterForm::SORT_COUNT:
                    $users->leftJoin('task', 'user.id = task.worker_id')
                        ->groupBy('user.id')
                        ->orderBy('COUNT(task.id) DESC');
                    break;
                case UserFilterForm::SORT_POPULARITY:
                    $users->leftJoin('favorite', 'user.id = favorite.worker_id')
                    ->groupBy('user.id')
                    ->orderBy('COUNT(favorite.worker_id) DESC');
                    break;
            }
        }

        if(Yii::$app->request->isPost) {
            $filter->load(Yii::$app->request->post());

            if(!empty($filter->category)) {
                $users->leftJoin('user_category', 'user.id = user_category.user_id')
                      ->andWhere(['IN', 'user_category.category_id', $filter->category]);
            }

            if($filter->is_free) {
                $users->leftJoin(
                    'task',
                    'user.id = task.worker_id AND task.status = :status',
                    [':status' => Task::STATUS_IN_WORK]
                )->groupBy('user.id')
                ->andHaving(['COUNT(task.id)' => '0']);
            }
            if($filter->is_online) {
                $users->andWhere([
                    '>',
                    'user.last_active_time',
                    new Expression('DATE_SUB(NOW(), INTERVAL 30 MINUTE)')
                ]);
            }
            if($filter->has_reviews) {
                $users->leftJoin('review', 'user.id = review.worker_id')
                      ->andWhere(['not', ['review.worker_id' => null]]);
            }
            if($filter->is_favorite) {
                $users->leftJoin('favorite', 'user.id = favorite.worker_id')
                      ->andWhere(['not', ['favorite.worker_id' => null]]);
            }

            if($filter->username) {
                $users->andWhere(['like', 'name', $filter->username]);
            }
        }

        $users = $users->all();

        return $this->render('index', [
            'users' => $users,
            'filter' => $filter,
            'categories' => $categories
        ]);
    }
}