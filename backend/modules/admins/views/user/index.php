<?php

use yii\bootstrap4\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ผู้ใช้';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="box box-primary">
    <div class="box-body">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php Pjax::begin(['id' => 'payment-grid-pjax']); ?>
        <?= GridView::widget([
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
                'heading' => $this->title,
            ],
            'id' => 'payment-grid',
            /*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['payment/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-payment']). ' ' .
                          Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['payment/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-payment', 'disabled'=>true]),*/
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [

                [
                    'class' => 'appxq\sdii\widgets\ActionColumn',
                    'contentOptions' => ['style' => 'width:200px;text-align: center;'],
                    'template' => '{update} {delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Html::a('<span class="fa fa-edit"></span> ',
                                yii\helpers\Url::to(['/admins/user/update?id=' . $model->id]), [
                                    'title' => 'แก้ไข',
                                    'class' => 'btn btn-primary btn-sm',
                                    'data-action' => 'update',
                                    'data-pjax' => 0
                                ]);
                        },
                        'delete' => function ($url, $model) {
                            return Html::a('<span class="fa fa-trash"></span> ',
                                yii\helpers\Url::to(['/admins/user/delete?id=' . $model->id]), [
                                    'title' => 'ลบ',
                                    'class' => 'btn btn-danger btn-sm',
                                    'data-confirm' => 'คุณต้องการลบรายการนี้ใช่หรือไม่',
                                    'data-method' => 'post',
                                    'data-action' => 'delete',
                                    'data-pjax' => 0
                                ]);


                        },
                    ]
                ],
                [
                    'label' => 'รหัสสมาชิก',
                    'value' => 'profile.user_id'
                ],
                [
                    'contentOptions' => ['style' => 'width:200px;text-align: left;'],
                    'format'=>'raw',
                    'attribute' => 'name',
                    'value' => function($model){
                        $defaultImage = 'https://newrich-8ee77.web.app/assets/images/logo.png';
                        $image2 = $model->profile->image2;
                        if($model->profile->image2 == ''){
                            $image2 = $defaultImage;
                        }

                        $name = $model->profile->name;
                        if($model->profile->name == ''){
                            $name = 'ไม่มีชื่อ';
                        }
                        return '<a href="#" data-toggle="tooltip" title="'.$model->email.'"><img style="width:30px;border-radius:30px;" src="'.$image2.'"> '.$name.'</a>';
                    }
                ],
                [
                    'attribute' => 'email',
                    'value' => 'profile.public_email'
                ],
                [
                    'attribute' => 'tel',
                    'value' => 'profile.tel'
                ],
                [
                    'attribute' => 'member_type',
                    'value' => 'profile.member_type',
                    'filter' => ['B2B' => 'B2B', 'B2C' => 'B2C', 'C2C']
                ],
                [
                    'attribute' => 'link',
                    'value' => 'profile.link'
                ],
                [
                    'label' => 'วันที่เป็นสมาชิก',
                    'value' => 'profile.create_date'
                ],



            ],
        ]); ?>
        <?php Pjax::end(); ?>

    </div>
</div>


<div class="modal fade" id="modal-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<style>
    th,td {
        white-space: nowrap;
    }
</style>
<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
    // JS script


    $('#modal-addbtn-payment').on('click', function () {
        modalPayment($(this).attr('data-url'));
    });

    $('#modal-delbtn-payment').on('click', function () {
        selectionPaymentGrid($(this).attr('data-url'));
    });

    $('#payment-grid-pjax').on('click', '.select-on-check-all', function () {
        window.setTimeout(function () {
            var key = $('#payment-grid').yiiGridView('getSelectedRows');
            disabledPaymentBtn(key.length);
        }, 100);
    });

    $('.selectionCoreOptionIds').on('click', function () {
        var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
        disabledPaymentBtn(key.length);
    });


    $('#payment-grid-pjax').on('click', 'tbody tr td a', function () {
        var url = $(this).attr('href');
        var action = $(this).attr('data-action');

        if (action === 'update' || action === 'view') {
            modalPayment(url);
        } else if (action === 'delete') {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete this item?')?>', function () {
                $.post(
                    url
                ).done(function (result) {
                    if (result.status == 'success') {
                        swal({
                            title: result.message,
                            text: result.message,
                            type: result.status,
                            timer: 1000
                        });
                        $.pjax.reload({container: '#payment-grid-pjax'});
                    } else {
                        swal({
                            title: result.message,
                            text: result.message,
                            type: result.status,
                            timer: 1000
                        });
                    }
                }).fail(function () {
                    console.log('server error');
                });
            });
        }
        return false;
    });

    function disabledPaymentBtn(num) {
        if (num > 0) {
            $('#modal-delbtn-payment').attr('disabled', false);
        } else {
            $('#modal-delbtn-payment').attr('disabled', true);
        }
    }

    function selectionPaymentGrid(url) {
        yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function () {
            $.ajax({
                method: 'POST',
                url: url,
                data: $('.selectionPaymentIds:checked[name=\"selection[]\"]').serialize(),
                dataType: 'JSON',
                success: function (result, textStatus) {
                    if (result.status == 'success') {
                        swal({
                            title: result.status,
                            text: result.message,
                            type: result.status,
                            timer: 2000
                        });
                        $.pjax.reload({container: '#payment-grid-pjax'});
                    } else {
                        swal({
                            title: result.status,
                            text: result.message,
                            type: result.status,
                            timer: 2000
                        });
                    }
                }
            });
        });
    }

    function modalPayment(url) {
        $('#modal-payment .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-payment').modal('show')
            .find('.modal-content')
            .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>




