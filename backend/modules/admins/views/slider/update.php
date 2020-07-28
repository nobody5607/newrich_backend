<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Slider */

$this->title = 'แก้ไข Slider: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ภาพ Sliders', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container bg-white">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>

</div>
