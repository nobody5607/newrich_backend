<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CreateGroup */

$this->title = 'Update Create Group: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Create Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-group-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
