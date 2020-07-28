<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Slider */

$this->title = 'ภาพ Slider';
$this->params['breadcrumbs'][] = ['label' => 'ภาพ Slider', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container bg-white">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>

