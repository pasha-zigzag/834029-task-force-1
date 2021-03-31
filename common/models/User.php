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

    public function getAge() : string
    {
        if(!$this->birthday) {
            return 'возраст не указан';
        }

        $birthday = new DateTime($this->birthday);
        $diff = (new DateTime())->diff($birthday);
        return Yii::t(
            'app',
            '{n, plural, one{# год} few{# лет} many{# лет} other{# лет}}',
            ['n' => $diff->y]
        );
    }

    public function getRegisterDuration() : string
    {
        $text = Yii::$app->formatter->asRelativeTime($this->register_at);
        $now = new DateTime();
        $register = new DateTime($this->register_at);
        $diff = $register->diff($now);

        if($diff->y) {
            $diff = 'P'.$diff->y.'Y';
        } elseif($diff->m) {
            $diff = 'P'.$diff->m.'M';
        } elseif($diff->d) {
            $diff = 'P'.$diff->d.'D';
        } elseif($diff->h) {
            $diff = 'P'.$diff->h.'H';
        } elseif($diff->m) {
            $diff = 'P'.$diff->m.'M';
        }

        return Yii::$app->formatter->asDuration($diff) . ' на сайте';
    }
}
