<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\Withdraw */

$this->title = 'Create Withdraw';
$this->params['breadcrumbs'][] = ['label' => 'Withdraws', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="withdraw-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
