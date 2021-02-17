<?php


namespace frontend\components;


use yii\base\Widget;

class RatingWidget extends Widget
{
    public int $rating;
    private string $html;

    public function init()
    {
        parent::init();
        if ($this->rating === null) {
            $this->rating = 0;
        } else {
            $this->rating = round($this->rating);
        }

        $stars_html = str_repeat('<span></span>', $this->rating);
        $empty_stars_html = str_repeat('<span class="star-disabled"></span>', 5 - $this->rating);
        $this->html = $stars_html . $empty_stars_html;
    }

    public function run() : string
    {
        return $this->html;
    }
}