<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

$token = isset(\Yii::$app->session['token'])?\Yii::$app->session['token']:'';

$baseUrl = isset(\Yii::$app->session['redirectUrl'])?\Yii::$app->session['redirectUrl']:'';
//\appxq\sdii\utils\VarDumper::dump($baseUrl);
if($baseUrl == ''){
    $baseUrl = 'http://newriched.com';//'http://localhost:3000/login';//
}
$url = \yii\helpers\Url::to(['/admins']);

//\appxq\sdii\utils\VarDumper::dump($baseUrl);
AppAsset::register($this);

\cpn\chanpan\assets\bootbox\BootBoxAsset::register($this);
\cpn\chanpan\assets\notify\NotifyAsset::register($this);
\cpn\chanpan\assets\SweetAlertAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $content ?>
</div>

<?php \appxq\sdii\widgets\CSSRegister::begin();?>
<style>
    @import url('https://fonts.googleapis.com/css?family=Kanit|Sriracha&display=swap');
    .adminTemplate{
        font-family: 'Kanit', sans-serif;
    }
    .navbar-inverse {
        background-color: #4abdac;
        border-color: #4abdac;
    }
    .navbar-inverse .navbar-brand {
        color: #ffffff;
    }
    #navbar{
        background: #4abdac;
        padding: 10px;
        position: relative;
        font-size: 16pt;
        color: #fff;;
    }
    div.required label.control-label:after {
        content: "*";
        color: red;
    }
    @media screen and (max-width: 480px)
    {
        .kv-table-wrap tr > td:first-child {
            border-top: 0px double #ccc;
            margin-top: 10px;
            font-size: 2em;
        }
        .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
            border: 0px solid #ddd;
        }
        .kv-table-wrap th, .kv-table-wrap td {
            font-size: 2em;
        }
        th.action-column {
            display: none;
        }
        #showBusinese{
            font-size:14pt;
        }
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end();?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
