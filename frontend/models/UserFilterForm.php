<?php


namespace frontend\models;


use yii\base\Model;

class UserFilterForm extends Model
{
    public $category;
    public $username;
    public $is_free;
    public $is_online;
    public $has_reviews;
    public $is_favorite;

    public function rules() : array
    {
        return [
            ['name', 'string'],
            [['is_free', 'is_online', 'has_reviews', 'is_favorite'], 'boolean'],
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'category' => 'Категории',
            'username' => 'Поиск по имени',
            'is_free' => 'Сейчас свободен',
            'is_online' => 'Сейчас онлайн',
            'has_reviews' => 'Есть отзывы',
            'is_favorite' => 'В избранном',
        ];
    }
}