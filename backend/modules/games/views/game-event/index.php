<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\games\models\GameEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'เกม';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="game-event-index">
    <a href="<?= \yii\helpers\Url::to(['/games'])?>">< ย้อนกลับ</a>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p class="text-right">
        <?= Html::a('เพิ่มเกม', ['create?parent_id='.$parent_id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'parent_id',
            'number',
            'title',
            'answer',
            'qu1',
            'qu2',
            'createDate',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
