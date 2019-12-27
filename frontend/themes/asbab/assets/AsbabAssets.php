<?php

namespace frontend\themes\asbab\assets;

use yii\web\AssetBundle;
class AsbabAssets extends AssetBundle{
    public $sourcePath = '@frontend/themes/asbab/assets';
    public $css = [
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css',
        'css/core.css',
        'css/shortcode/shortcodes.css',
        'style.css',
        'css/responsive.css',
        'css/custom.css',
    ];
    public $js = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'js/vendor/modernizr-3.5.0.min.js',
        'js/plugins.js',
        'js/slick.min.js',
        'js/owl.carousel.min.js',
        'js/waypoints.min.js',
        'js/main.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset', 
    ];
}
