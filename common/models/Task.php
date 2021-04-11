<?php

namespace common\models;

use Yii;

class Task extends base\Task
{
    public int $short_description_length = 50;
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

    public function getShortDescription() : string
    {
        if (strlen($this->description) > $this->short_description_length) {
            $description = substr($this->description, 0, $this->short_description_length);
            $description = trim($description);
            return $description . "...";
        } else {
            return $this->description;
        }
    }
}
