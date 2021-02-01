<?php

namespace app\common\models;

use Yii;

class User extends \app\common\models\base\User
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
}
