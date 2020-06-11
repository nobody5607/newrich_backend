<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\games\models\GameEvent */

$this->title = 'เพิ่มคำตอบเกม';
$this->params['breadcrumbs'][] = ['label' => 'Game Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
