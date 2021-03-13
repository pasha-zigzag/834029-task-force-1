<?php


namespace frontend\models;


use yii\base\Model;

class TaskFilterForm extends Model
{
    public $category;
    public $title;
    public $period;
    public $has_responses;
    public $is_remote;

    public const PERIOD_ARRAY = [
        'day' => 'За день',
        'week' => 'За неделю',
        'month' => 'За месяц'
    ];

    public function rules() : array
    {
        return [
            ['category','safe'],
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
}