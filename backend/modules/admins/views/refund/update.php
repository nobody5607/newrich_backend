<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\Refund */

$this->title = 'Update Refund: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'ส่วนลดเงินคืน', 'url' => ['index']];
$this->params['breadcrumbs'][] = \backend\lib\CNUtils::getUserById($model->user_id);

//$this->params['breadcrumbs'][] = $this->title;



?>
<div class="refund-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
