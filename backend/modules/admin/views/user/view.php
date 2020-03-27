<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\User */

$this->title = 'User#'.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title" id="itemModalLabel"><?= Html::encode($this->title) ?></h4>
    </div>
    <div class="modal-body">
        <?= DetailView::widget([
	    'model' => $model,
	    'attributes' => [
		'id',
		'username',
		'email:email',
		'password_hash',
		'auth_key',
		'confirmed_at',
		'unconfirmed_email:email',
		'blocked_at',
		'registration_ip',
		'created_at',
		'updated_at',
		'flags',
		'last_login_at',
	    ],
	]) ?>
    </div>
</div>