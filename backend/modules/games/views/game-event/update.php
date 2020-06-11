<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\games\models\GameEvent */

$this->title = 'แก้ไขเกม ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'เกม', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
