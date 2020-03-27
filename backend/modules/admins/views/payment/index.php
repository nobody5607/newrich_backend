<?php

use yii\bootstrap4\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'อนุมัติการใช้งานระบบ';
$this->params['breadcrumbs'][] = $this->title;

?>
    <a href="<?= \yii\helpers\Url::to(['/admins']) ?>">&lt; ย้อนกลับ</a>
    <div class="box box-primary">
        <div class="box-header">
            <h2><?= Html::encode($this->title) ?></h2>
            <div class="pull-right">
                <?= Html::button('เพิ่มรายการ', ['data-url' => Url::to(['/admins/payment/create']), 'class' => 'btn btn-success btn-sm', 'id' => 'modal-addbtn-payment']) . ' ' .
                Html::button('ลบรายการ', ['data-url' => Url::to(['/admins/payment/deletes']), 'class' => 'btn btn-danger btn-sm', 'id' => 'modal-delbtn-payment', 'disabled' => false])
                ?>
            </div>
        </div>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php Pjax::begin(['id' => 'payment-grid-pjax']); ?>
            <?= GridView::widget([
                'id' => 'payment-grid',
                /*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['payment/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-payment']). ' ' .
                              Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['payment/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-payment', 'disabled'=>true]),*/
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [

                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => [
                            'class' => 'selectionPaymentIds'
                        ],
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:40px;text-align: center;'],
                    ],
                    [
                        'class' => 'appxq\sdii\widgets\ActionColumn',
                        'contentOptions' => ['style' => 'width:180px;text-align: center;'],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil"></span> แก้ไข',
                                    yii\helpers\Url::to(['/admins/payment/update?id=' . $model->id]), [
                                        'title' => 'แก้ไข',
                                        'class' => 'btn btn-primary btn-xs',
                                        'data-action' => 'update',
                                        'data-pjax' => 0
                                    ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span> ลบ',
                                    yii\helpers\Url::to(['/admins/payment/delete?id=' . $model->id]), [
                                        'title' => 'ลบ',
                                        'class' => 'btn btn-danger btn-xs',
                                        'data-confirm' => 'คุณต้องการลบรายการนี้ใช่หรือไม่',
                                        'data-method' => 'post',
                                        'data-action' => 'delete',
                                        'data-pjax' => 0
                                    ]);


                            },
                        ]
                    ],
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => function ($model) {
                            if (isset($model->user->profile->name)) {
                                return $model->user->profile->name;
                            }
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {

                            $status = 0;
                            if (isset($model->status)) {
                                $status = \cpn\chanpan\utils\CNUtils::$statusPayment[$model->status];
                            }
                            return $status;
                        }
                    ],

                    'stdate',
                    // 'create_by',
                    // 'create_date',
                    // 'rstat',
                    // 'update_by',
                    // 'update_date',


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