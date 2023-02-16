<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/styles.css',
        'css/fonts.css'
    ];
    public $js = [
        "javascript/application.js",
        "bootstable.js"
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        '\rmrevin\yii\fontawesome\AssetBundle'

    ];

    public static function dd() 
    {
        echo '<pre>';
        var_dump(...func_get_args());
        echo '</pre>';

        die();
    }
   
}

