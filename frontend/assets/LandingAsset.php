<?php


namespace frontend\assets;


use yii\web\AssetBundle;

class LandingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/normalize.css',
        'css/style.css',
    ];
    public $js = [
        'js/main.js'
    ];

}