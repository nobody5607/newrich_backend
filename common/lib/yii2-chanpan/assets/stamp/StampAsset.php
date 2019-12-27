<?php

 
namespace cpn\chanpan\assets\stamp;
 
class StampAsset extends \yii\web\AssetBundle{
    public $sourcePath='@cpn/chanpan/assets/stamp/assets';
    public $css = [
        'css/normalize.css',
        'css/foundation.min.css',
        'css/responsive-tables.css',
        'css/webicons.css',
        'css/styles.css',
        'css/designer.css',
        '',
        '',
    ];
    public $js = [
        //'jquery.min.js',
//        'bootstrap/js/bootstrap.min.js',
        'js/custom.modernizr.js',
        'js/responsive-tables.js',
        'js/foundation.min.js',
        'js/foundation.dropdown.js',
        'js/foundation.topbar.js',
//        'js/stamp.js',

    ];
    public $depends=[
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
