<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CreateGroup */

$this->title = 'Create Create Group';
$this->params['breadcrumbs'][] = ['label' => 'Create Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-group-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
