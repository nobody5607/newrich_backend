<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CreateGroup */

$this->title = 'Create Group#'.$model->name;
$this->params['breadcrumbs'][] = ['label' => 'Create Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-group-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'name',
		'createBy',
		'createDate',
		'orderBy',
	    ],
	]) ?>
    </div>
</div>
