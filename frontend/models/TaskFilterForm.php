<?php

namespace frontend\models;

use common\models\Task;
use taskforce\models\Task as TaskEntity;
use yii\base\Model;
use yii\db\Expression;

class TaskFilterForm extends Model
{
    public $category;
    public $title;
    public $period;
    public $has_responses;
    public $is_remote;

    public const PERIOD_DAY = 'day';
    public const PERIOD_WEEK = 'week';
    public const PERIOD_MONTH = 'month';

    public const PERIOD_ARRAY = [
        self::PERIOD_DAY => 'За день',
        self::PERIOD_WEEK => 'За неделю',
        self::PERIOD_MONTH => 'За месяц'
    ];

    public function rules() : array
    {
        return [
            ['category', 'exist'],
            [['title', 'period'], 'string'],
            ['period', 'in', 'range' => self::PERIOD_ARRAY],
            [['has_responses', 'is_remote'], 'boolean'],
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'category' => 'Категории',
            'title' => 'Поиск по названию',
            'period' => 'Период',
            'has_responses' => 'Без откликов',
            'is_remote' => 'Удалённая работа',
        ];
    }

    public function getTasks() : array
    {
        $tasks = Task::find()
            ->where(['status' => TaskEntity::STATUS_NEW])
            ->with(['category', 'city']);

        if(!empty($this->category)) {
            $tasks->andWhere(['in', 'category_id', $this->category]);
        }

        if($this->has_responses) {
            $tasks->join('LEFT JOIN', 'response', 'task.id = response.task_id')
                ->andWhere(['response.task_id' => null]);
        }

        if($this->is_remote) {
            $tasks->andWhere(['city_id' => null]);
        }

        switch ($this->period) {
            case self::PERIOD_DAY:
                $tasks->andWhere(['>', 'task.created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 DAY)')]);
                break;
            case self::PERIOD_WEEK:
                $tasks->andWhere(['>', 'task.created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 WEEK)')]);
                break;
            case self::PERIOD_MONTH:
                $tasks->andWhere(['>', 'task.created_at', new Expression('DATE_SUB(NOW(), INTERVAL 1 MONTH)')]);
                break;
        }

        if($this->title) {
            $tasks->andWhere(['like', 'title', $this->title]);
        }

        return $tasks->all();
    }

    public function setCategory($category_id)
    {
        $this->category = [$category_id];
    }
}