<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CreateBusines */

$this->title = 'Update Create Busines: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Create Busines', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-busines-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
