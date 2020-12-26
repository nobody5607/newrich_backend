<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ResourceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
use yii\helpers\Url;
$this->title = 'จัดการภาพ Banner';
$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container-fluid width90 bg-white">
        <h2><?= Html::encode($this->title)?></h2>

        <div class="row mt-3 mb-3">
            <div class="col-md-6"></div>
            <div class="col-md-6 text-right"><?= Html::a('เพิ่มรายการ', ['create'], ['class' => 'btn btn-success']) ?></div>
        </div>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'layout'=> "{items}\n<div class='text-center d-flex justify-content-center'>{pager}</div>",
            'tableOptions'=>['class'=>'table table-hover','style'=>'background: #fff;','id'=>'table-shared2'],

            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'contentOptions' => ['style' => 'width:100px;text-align: center;'],
                    'template' => '{update} {delete} ',
                    'buttons' => [
                        'update' => function($url, $model) {
                            return Html::a('<span class="fas fa-edit"></span> ', yii\helpers\Url::to(['/admins/slider/update?id='.$model->id]), [
                                'class' => 'btn btn-primary btn-sm',
                                'data-action' => 'update',
                                'data-pjax' => 0
                            ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fas fa-trash"></span> ', yii\helpers\Url::to(['/admins/slider/delete/', 'id' => $model->id]), [
                                'class' => 'btn btn-danger btn-sm btnDelete',
                                'data-confirm' => 'คุณต้องการลบรายการนี้ใช้หรือไม่',
                                'data-method' => 'post',
                                'data-action' => 'delete',
                                'data-pjax' => 0
                            ]);

                        },
                    ]
                ],
                [
                    'format'=>'raw',
                    'attribute'=>'image',
                    'value'=>function($model){
                        $path='';
                        if($model->image){
                            $storageUrl = isset(\Yii::$app->params['storageUrl'])?\Yii::$app->params['storageUrl']:'';
                            $path = "{$storageUrl}/images/{$model->image}";
                        }
                        return  "<img src='{$path}' class='img img-responsive' style='width:200px'>";
                    }
                ],
                'getAt',
                'order',


            ],
        ]); ?>

    </div>


<?php $this->registerCss("
.pagination li{
        margin-right: 14px;
}
.pagination li.active{
        z-index: 3;
    color: #485d52;
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
    border-radius: 100%;
    padding-right: 14px;
    padding-left: 14px;
    padding-top: 5px;
    padding-bottom: 5px;
    margin-top: -5px;
}
 .page-link {
    position: relative;
    display: block;
    padding: 0.5rem 0.75rem;
    margin-left: -1px;
    line-height: 1.25;
    color: #485d52;
    background-color: transparent !important;
    border: none !important;
}
.page-link:hover {
    color: #485d52;
}


")?>
