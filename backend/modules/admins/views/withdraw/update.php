<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\Withdraw */

$this->title = 'Update Withdraw: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ถอนเงิน', 'url' => ['index']];
$this->params['breadcrumbs'][] = \backend\lib\CNUtils::getUserById($model->user_id);
?>
<div class="withdraw-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
