<?php
use yii\helpers\Html; 

\cpn\chanpan\assets\bootbox\BootBoxAsset::register($this);
\cpn\chanpan\assets\notify\NotifyAsset::register($this);
\cpn\chanpan\assets\SweetAlertAsset::register($this);


?>
 
<?php
 $actionArr = ['security','registration','recovery'];
// \appxq\sdii\utils\VarDumper::dump(Yii::$app->controller->id);
  if (in_array(Yii::$app->controller->id, $actionArr)) {

     echo $this->render(
         'main-login',
         ['content' => $content]
     );
 } else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    \backend\themes\adminlte\assets\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    $skin = isset(Yii::$app->params['skin'])?Yii::$app->params['skin']:'skin-blue';
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        
        <?php $baseUrl = $this->theme->baseUrl;?>
        <link rel="stylesheet" href="<?= $baseUrl;?>/css/custom.css"/>

    </head>
    <body class="skin-blue layout-top-nav">
    <?php $this->beginBody() ?>
    <div class="">
        
        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>


         
        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>
        <?php \richardfan\widget\JSRegister::begin();?>
            <script>

            </script>
        <?php \richardfan\widget\JSRegister::end();?>

        <?php \appxq\sdii\widgets\CSSRegister::begin();?>
        <style>
            
        </style>
        <?php \appxq\sdii\widgets\CSSRegister::end();?>
        
    </div>
        <?= \bluezed\scrollTop\ScrollTop::widget() ?>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php  } ?>
