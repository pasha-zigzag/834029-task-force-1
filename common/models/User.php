<?php

namespace common\models;

use DateTime;
use Yii;
use yii\helpers\ArrayHelper;
use yii\db\ActiveQuery;

class User extends base\User
{
    public const WORKER_ROLE = 'worker';
    public const CUSTOMER_ROLE = 'customer';
    public const NOW_ONLINE_MINUTES = 30;

    public function getFavoriteUsers() : ActiveQuery
    {
        return $this->hasMany(Favorite::class, ['customer_id' => 'id']);
    }

    public function getCustomerReviews() : ActiveQuery
    {
        return $this->hasMany(Review::class, ['customer_id' => 'id']);
    }

    public function getWorkerReviews() : ActiveQuery
    {
        return $this->hasMany(Review::class, ['worker_id' => 'id']);
    }

    public function getCustomerTasks() : ActiveQuery
    {
        return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }

    public function getWorkerTasks() : ActiveQuery
    {
        return $this->hasMany(Task::class, ['worker_id' => 'id']);
    }

    public function getWorkerRating() : string
    {
        $rating_array = ArrayHelper::map($this->workerReviews, 'id', 'rating');
        $review_count = count($rating_array);

        if($review_count === 0) {
            return 0;
        }

        return array_sum($rating_array) / $review_count;
    }

    public function getLastActivity() : string
    {
        $minutes = (time() - strtotime($this->last_active_time)) / 60;
        if($minutes <= self::NOW_ONLINE_MINUTES) {
            return 'Сейчас онлайн';
        }
        return 'Был на сайте ' . Yii::$app->formatter->asRelativeTime($this->last_active_time);
    }
}
