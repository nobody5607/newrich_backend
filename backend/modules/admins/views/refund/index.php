<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;
//use appxq\sdii\widgets\ModalForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\admins\models\RefundSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ส่วนลดขอเงินคืน';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
<div>
    <h2><?=  Html::encode($this->title) ?></h2>
</div>
<div class="table-responsive">
    <?= GridView::widget([
        'id' => 'refund-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'appxq\sdii\widgets\ActionColumn',
                'contentOptions' => ['style'=>'width:100px;text-align: center;'],
                'template' => '{update} {delete}',
                'buttons'=>[
                    'update'=>function($url, $model){
                        return Html::a('<span class="fas fa-edit"></span> '.Yii::t('app', 'Update'),
                            yii\helpers\Url::to(['refund/update?id='.$model->id]), [
                                'title' => Yii::t('app', 'Update'),
                                'class' => 'btn btn-primary btn-sm',
                                'data-action'=>'update',
                                'data-pjax'=>0
                            ]);
                    },
//                    'delete' => function ($url, $model) {
//                        return Html::a('<span class="fas fa-trash"></span> '.Yii::t('app', 'Delete'),
//                            yii\helpers\Url::to(['refund/delete?id='.$model->id]), [
//                                'title' => Yii::t('app', 'Delete'),
//                                'class' => 'btn btn-danger btn-sm',
//                                'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
//                                'data-method' => 'post',
//                                'data-action' => 'delete',
//                                'data-pjax'=>0
//                            ]);
//
//
//                    },
                ]
            ],
//            [
//                'class' => 'yii\grid\SerialColumn',
//                'headerOptions' => ['style'=>'text-align: center;'],
//                'contentOptions' => ['style'=>'width:60px;text-align: center;'],
//            ],
            [
               'attribute'=>'user_id',
               'value'=>function($model){
                    return \backend\lib\CNUtils::getUserById($model->user_id);
               },
                'filter'=>\yii\helpers\ArrayHelper::map(\common\modules\user\models\Profile::find()->asArray()->all(), 'user_id', 'name'),
            ],
            'order_id',
            [
                'format'=>'raw',
                'contentOptions'=>['class'=>'text-right'],
                'attribute'=>'amount',
                'value'=>function($model){
                    return isset($model->amount) ? number_format($model->amount,2):'';
                }

            ],
            [

                'contentOptions' => ['style'=>'width:130px;text-align: center;'],
                'attribute'=>'status',
                'value'=>function($model){
                    $item = \backend\lib\CNUtils::$statusApprove;
                    if(!$model->status){
                        return $item['0'];
                    }
                    return $item[$model->status];
                },
                'filter'=>\backend\lib\CNUtils::$statusApprove,
            ],
            [

                'contentOptions' => ['style'=>'width:130px;text-align: center;'],
                'attribute'=>'payment',
                'value'=>function($model){
                    $item = \backend\lib\CNUtils::$statusPayment;
                    if(!$model->status){
                        return $item['0'];
                    }
                    return $item[$model->payment];
                },
                'filter'=>\backend\lib\CNUtils::$statusPayment,
            ],
            [
                'attribute'=>'approveBy',
                'value'=>function($model){
                    return \backend\lib\CNUtils::getUserById($model->approveBy);
                },
                'filter'=>\yii\helpers\ArrayHelper::map(\common\modules\user\models\Profile::find()->asArray()->all(), 'user_id', 'name'),
            ],
            // 'approveDate',


        ],
    ]); ?>

</div>
</div>



