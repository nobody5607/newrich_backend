<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'สร้างกลุ่ม';
$this->params['breadcrumbs'][] = $this->title;

?>
    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="col-md-6 col-xs-6">
                    <div style="font-size:20pt">
                        <?= Html::encode($this->title) ?>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6 text-right">
                    <?= Html::button(SDHtml::getBtnAdd() . ' สร้างกลุ่ม', ['data-url' => Url::to(['create-group/create']), 'class' => 'btn btn-success', 'id' => 'modal-addbtn-create-group'])
                    ?>
                </div>

            </div>
        </div>
        <div class="box-body">

            <?php Pjax::begin(['id' => 'create-group-grid-pjax']); ?>
            <?= \kartik\grid\GridView::widget([
                'id' => 'create-group-grid',
                /*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['create-group/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-create-group']). ' ' .
                              Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['create-group/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-create-group', 'disabled'=>true]),*/
                'dataProvider' => $dataProvider,
                'layout'=> "{items}",
                'columns' => [

                    [
                        'format' => 'raw',
                        'label' => 'ชื่อกลุ่ม',
                        'value' => function ($model) {
                            return "<div class='linkCreateBusines' data-url=" . Url::to(['/group/busines?groupID=' . $model->id]) . " style='cursor:pointer;'>{$model->name}</div>";
                        }
                    ],
//                    'orderBy',

                    [
                        'class' => 'appxq\sdii\widgets\ActionColumn',
                        'contentOptions' => ['style' => 'width:200px;text-align: center;'],
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a('<span class="fa fa-eye"></span> ' . Yii::t('app', 'รายละเอียด'),
                                    yii\helpers\Url::to(['/group/busines?groupID=' . $model->id]), [
                                        'title' => Yii::t('app', 'รายละเอียด'),
                                        'class' => 'btn btn-default btn-sm',
                                        'data-action' => 'view',
                                        'data-pjax' => 0
                                    ]);
                            },
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('app', 'แก้ไข'),
                                    yii\helpers\Url::to(['create-group/update?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'Update'),
                                        'class' => 'btn btn-primary btn-sm',
                                        'data-action' => 'update',
                                        'data-pjax' => 0
                                    ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('app', 'ลบ'),
                                    yii\helpers\Url::to(['create-group/delete?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'Delete'),
                                        'class' => 'btn btn-danger btn-sm',
                                        'data-confirm' => Yii::t('chanpan', 'Are you sure you want to delete this item?'),
                                        'data-method' => 'post',
                                        'data-action' => 'delete',
                                        'data-pjax' => 0
                                    ]);


                            },
                        ]
                    ],
                ],
            ]); ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
<?= ModalForm::widget([
    'id' => 'modal-create-group',
    //'size'=>'modal-lg',
]);
?>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>
        // JS script
        $(".linkCreateBusines").on('click', function () {
            let url = $(this).attr('data-url');
            window.open(url,'_PARENT');
            //alert(url);
            return false;
        });
        function loadData(url) {
            $.get(url, function (result) {
                $("#reloadDive").html(result);
            });
            return false;
        }

        $(".pagination li a").on('click', function () {
            let url = $(this).attr('href');
            loadData(url)
            return false;
        });

        $('#modal-addbtn-create-group').on('click', function () {
            modalCreateGroup($(this).attr('data-url'));
        });

        $('#modal-delbtn-create-group').on('click', function () {
            selectionCreateGroupGrid($(this).attr('data-url'));
        });

        $('#create-group-grid-pjax').on('click', '.select-on-check-all', function () {
            window.setTimeout(function () {
                var key = $('#create-group-grid').yiiGridView('getSelectedRows');
                disabledCreateGroupBtn(key.length);
            }, 100);
        });

        $('.selectionCoreOptionIds').on('click', function () {
            var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
            disabledCreateGroupBtn(key.length);
        });

        $('#create-group-grid-pjax').on('dblclick', 'tbody tr', function () {
            var id = $(this).attr('data-key');
            modalCreateGroup('<?= Url::to(['create-group/update', 'id' => ''])?>' + id);
        });

        $('#create-group-grid-pjax').on('click', 'tbody tr td a', function () {
            var url = $(this).attr('href');
            var action = $(this).attr('data-action');

            if( action === 'view' ){
                window.open(url,'_PARENT');
            }
            else if (action === 'update') {
                modalCreateGroup(url);
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
                            $.pjax.reload({container: '#create-group-grid-pjax'});
                        } else {
                            swal({
                                title: result.message,
                                text: result.message,
                                type: result.status,
                                timer: 1000
                            });
                        }
                    }).fail(function () {
                        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                        console.log('server error');
                    });
                });
            }
            return false;
        });

        function disabledCreateGroupBtn(num) {
            if (num > 0) {
                $('#modal-delbtn-create-group').attr('disabled', false);
            } else {
                $('#modal-delbtn-create-group').attr('disabled', true);
            }
        }

        function selectionCreateGroupGrid(url) {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function () {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: $('.selectionCreateGroupIds:checked[name=\"selection[]\"]').serialize(),
                    dataType: 'JSON',
                    success: function (result, textStatus) {
                        if (result.status == 'success') {
                            swal({
                                title: result.status,
                                text: result.message,
                                type: result.status,
                                timer: 2000
                            });
                            $.pjax.reload({container: '#create-group-grid-pjax'});
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

        function modalCreateGroup(url) {
            $('#modal-create-group .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
            $('#modal-create-group').modal('show')
                .find('.modal-content')
                .load(url);
        }
    </script>
<?php \richardfan\widget\JSRegister::end(); ?>


