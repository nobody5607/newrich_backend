<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GroupUser */

$this->title = 'Update Group User: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Group Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-user-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
