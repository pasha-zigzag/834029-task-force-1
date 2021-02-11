<?php

namespace common\models;

use DateTime;
use Yii;
use yii\helpers\ArrayHelper;

class User extends base\User
{
    public function getFavoriteUsers()
    {
        return $this->hasMany(Favorite::class, ['customer_id' => 'id']);
    }

    public function getCustomerReviews()
    {
        return $this->hasMany(Review::class, ['customer_id' => 'id']);
    }

    public function getWorkerReviews()
    {
        return $this->hasMany(Review::class, ['worker_id' => 'id']);
    }

    public function getCustomerTasks()
    {
        return $this->hasMany(Task::class, ['customer_id' => 'id']);
    }

    public function getWorkerTasks()
    {
        return $this->hasMany(Task::class, ['worker_id' => 'id']);
    }

    public function getWorkerRating()
    {
        $rating_array = ArrayHelper::map($this->workerReviews, 'id', 'rating');
        if(count($rating_array) === 0) {
            return number_format(0, 2);
        }
        return number_format(round(array_sum($rating_array) / count($rating_array), 2), 2);
    }

    public function getLastActivity()
    {
        $minutes = (time() - strtotime($this->last_active_time)) / 60;
        if($minutes <= 3) {
            return 'Сейчас на сайте';
        }
        return 'Был на сайте ' . Yii::$app->formatter->asRelativeTime($this->last_active_time);
    }
}
