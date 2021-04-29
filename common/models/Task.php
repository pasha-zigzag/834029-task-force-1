<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class Task extends base\Task
{
    public const SHORT_DESCRIPTION_LENGTH = 50;

    public function behaviors() : array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_UPDATE => false,
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['title', 'description', 'category_id', 'customer_id'], 'required'],
            [['title', 'description', 'status', 'attach_id'], 'string'],
            [['title'], 'string', 'min' => 10],
            [['description'], 'string', 'min' => 30],
            [['price', 'category_id', 'city_id', 'customer_id', 'worker_id'], 'integer'],
            [['price'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            [['created_at', 'finish_at'], 'safe'],
            [['latitude', 'longitude'], 'number'],
            [['attach_id'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['customer_id' => 'id']],
            [['worker_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['worker_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
    {
        return [
            'title' => 'Название',
            'description' => 'Подробности задания',
            'price' => 'Бюджет',
            'category_id' => 'Категория',
            'finish_at' => 'Сроки исполнения',
            'city_id' => 'Локация',
        ];
    }

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

    public function getFiles() : \yii\db\ActiveQuery
    {
        return $this->hasMany(File::class, ['attach_id' => 'attach_id']);
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

    public function saveTask() : bool
    {
        $this->status = \taskforce\models\Task::STATUS_NEW;
        $this->customer_id = Yii::$app->user->identity->getId();
        $this->attach_id = Yii::$app->session->get('attach_id');

        if (!$this->validate()) {
            return false;
        }

        $this->save();

        Yii::$app->session->remove('attach_id');
        return true;
    }
}
