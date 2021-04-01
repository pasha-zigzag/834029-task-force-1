<?php

namespace common\models;

use Yii;

class Task extends base\Task
{
    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Response::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }
}
