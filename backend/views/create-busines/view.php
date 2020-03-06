<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CreateBusines */

$this->title = 'Create Busines#'.$model->title;
$this->params['breadcrumbs'][] = ['label' => 'Create Busines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-busines-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'title',
		'detail',
		'createBy',
		'createDate',
		'orderBy',
	    ],
	]) ?>
    </div>
</div>
