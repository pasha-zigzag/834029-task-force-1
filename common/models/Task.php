<?php

namespace common\models;

use Yii;

class Task extends base\Task
{
    public const SHORT_DESCRIPTION_LENGTH = 50;
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
        if (strlen($this->description) > self::SHORT_DESCRIPTION_LENGTH) {
            $description = substr($this->description, 0, self::SHORT_DESCRIPTION_LENGTH);
            $description = trim($description);
            return $description . "...";
        } else {
            return $this->description;
        }
    }
}
