<?php

namespace frontend\models;

use common\models\User;
use taskforce\models\Task;
use Yii;
use yii\base\Model;
use yii\db\Expression;

class UserFilterForm extends Model
{
    public $category;
    public $username;
    public $is_free;
    public $is_online;
    public $has_reviews;
    public $is_favorite;
    public string $sort;

    const SORT_RATING = 'rating';
    const SORT_COUNT = 'count';
    const SORT_POPULARITY = 'popularity';

    public function rules() : array
    {
        return [
            ['category', 'exist'],
            ['username', 'string'],
            [['is_free', 'is_online', 'has_reviews', 'is_favorite'], 'boolean'],
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'category' => 'Категории',
            'username' => 'Поиск по имени',
            'is_free' => 'Сейчас свободен',
            'is_online' => 'Сейчас онлайн',
            'has_reviews' => 'Есть отзывы',
            'is_favorite' => 'В избранном',
        ];
    }

    public function setSort(string $sort) : void
    {
        $this->sort = $sort;
    }

    public function getUsers() : array
    {
        $users = User::find()
            ->where(['role' => User::WORKER_ROLE])
            ->with('workerReviews', 'workerTasks');

        switch($this->sort) {
            case self::SORT_RATING:
                $users->leftJoin('review r', 'user.id = r.worker_id')
                    ->groupBy('user.id')
                    ->orderBy('AVG(r.rating) DESC');
                break;
            case self::SORT_COUNT:
                $users->leftJoin('task t', 'user.id = t.worker_id')
                    ->groupBy('user.id')
                    ->orderBy('COUNT(t.id) DESC');
                break;
            case self::SORT_POPULARITY:
                $users->leftJoin('favorite f', 'user.id = f.worker_id')
                    ->groupBy('user.id')
                    ->orderBy('COUNT(f.worker_id) DESC');
                break;
        }

        if(!empty($this->category)) {
            $users->leftJoin('user_category', 'user.id = user_category.user_id')
                ->andWhere(['IN', 'user_category.category_id', $this->category]);
        }

        if($this->is_free) {
            $users->leftJoin(
                'task',
                'user.id = task.worker_id AND task.status = :status',
                [':status' => Task::STATUS_IN_WORK]
            )->groupBy('user.id')
                ->andHaving(['COUNT(task.id)' => '0']);
        }

        if($this->is_online) {
            $users->andWhere([
                '>',
                'user.last_active_time',
                new Expression('DATE_SUB(NOW(), INTERVAL 30 MINUTE)')
            ]);
        }

        if($this->has_reviews) {
            $users->leftJoin('review', 'user.id = review.worker_id')
                ->andWhere(['not', ['review.worker_id' => null]]);
        }

        if($this->is_favorite) {
            $users->leftJoin('favorite', 'user.id = favorite.worker_id')
                ->andWhere(['not', ['favorite.worker_id' => null]]);
        }

        if($this->username) {
            $users->andWhere(['like', 'name', $this->username]);
        }

        return $users->all();
    }
}