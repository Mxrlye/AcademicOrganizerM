<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.4/fullcalendar.min.css',
    ];
    public $js = [
        'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.4/fullcalendar.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.4/locales/es.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ];
}
