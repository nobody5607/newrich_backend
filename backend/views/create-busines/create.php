<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CreateBusines */

$this->title = 'Create Create Busines';
$this->params['breadcrumbs'][] = ['label' => 'Create Busines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-busines-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
