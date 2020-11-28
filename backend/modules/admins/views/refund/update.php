<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\Refund */

$this->title = 'Update Refund: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Refunds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
