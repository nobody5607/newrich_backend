<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
Yii::$app->language = 'th';

dmstr\web\AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" >
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $baseUrl = $this->theme->baseUrl;?>
    <link rel="stylesheet" href="<?= $baseUrl;?>/css/custom.css"/>
</head>
<body class="login-page" style="background:#fff; ">

    <?php $this->beginBody() ?>
        <div class="container" >
            <h3 class="text-center" style="color: #fff;font-family: serif;    font-weight: bold;">
                <img src="https://newriched.com/assets/images/logo.png" alt="Newriched" style="width: 80px;margin-top:20px;">
                <div style="margin-top:20px"></div>
                <label style="color: red;">NEW</label><span style="color:#0c1923">Riched</span>
            </h3>
            <?= $content ?>
        </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

