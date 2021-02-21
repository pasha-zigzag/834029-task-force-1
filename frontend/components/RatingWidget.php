<?php


namespace frontend\components;


use yii\base\Widget;
use yii\helpers\Html;

class RatingWidget extends Widget
{
    public float $rating;
    private string $html;
    private string $star_html = '<span></span>';
    private string $empty_star_html = '<span class="star-disabled"></span>';
    private int $stars_count;

    public function init()
    {
        parent::init();
        if ($this->rating === null) {
            $this->rating = 0;
        }
        $this->stars_count = round($this->rating);

        $stars_html = str_repeat($this->star_html, $this->stars_count);
        $empty_stars_html = str_repeat($this->empty_star_html, 5 - $this->stars_count);
        $this->html = $stars_html . $empty_stars_html;
        $this->html .= Html::tag('b', number_format($this->rating, 2));
    }

    public function run() : string
    {
        return $this->html;
    }
}