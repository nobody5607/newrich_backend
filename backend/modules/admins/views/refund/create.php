<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\Refund */

$this->title = 'Create Refund';
$this->params['breadcrumbs'][] = ['label' => 'Refunds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="refund-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
