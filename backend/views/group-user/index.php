<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\helpers\Url;
use appxq\sdii\widgets\GridView;
use appxq\sdii\widgets\ModalForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GroupUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Group Users';
$this->params['breadcrumbs'][] = $this->title;

?>
    <a href="#" id="back">&lt; ย้อนกลับ</a>
    <div class="box box-primary">
        <div class="box-header">
            <i class=""></i> <?= Html::encode($this->title) ?>
            <div class="pull-right">
                <?= Html::button(SDHtml::getBtnAdd(), ['data-url' => Url::to(['group-user/create?groupID='.$groupID]), 'class' => 'btn btn-success btn-sm', 'id' => 'modal-addbtn-group-user']);
                ?>
            </div>
        </div>
        <div class="box-body">
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php Pjax::begin(['id' => 'group-user-grid-pjax']); ?>
            <?= GridView::widget([
                'id' => 'group-user-grid',
                /*	'panelBtn' => Html::button(SDHtml::getBtnAdd(), ['data-url'=>Url::to(['group-user/create']), 'class' => 'btn btn-success btn-sm', 'id'=>'modal-addbtn-group-user']). ' ' .
                              Html::button(SDHtml::getBtnDelete(), ['data-url'=>Url::to(['group-user/deletes']), 'class' => 'btn btn-danger btn-sm', 'id'=>'modal-delbtn-group-user', 'disabled'=>true]),*/
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'yii\grid\CheckboxColumn',
                        'checkboxOptions' => [
                            'class' => 'selectionGroupUserIds'
                        ],
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:40px;text-align: center;'],
                    ],
                    [
                        'class' => 'yii\grid\SerialColumn',
                        'headerOptions' => ['style' => 'text-align: center;'],
                        'contentOptions' => ['style' => 'width:60px;text-align: center;'],
                    ],

                    [
                       'attribute'=>'user_id',
                       'value'=>function($model){
                            if(isset($model->user->profile->name)){
                                return $model->user->profile->name;
                            }
                       }
                    ],

                    [
                        'class' => 'appxq\sdii\widgets\ActionColumn',
                        'contentOptions' => ['style' => 'width:180px;text-align: center;'],
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<span class="fa fa-pencil"></span> ' . Yii::t('app', 'Update'),
                                    yii\helpers\Url::to(['group-user/update?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'Update'),
                                        'class' => 'btn btn-primary btn-xs',
                                        'data-action' => 'update',
                                        'data-pjax' => 0
                                    ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<span class="fa fa-trash"></span> ' . Yii::t('app', 'Delete'),
                                    yii\helpers\Url::to(['group-user/delete?id=' . $model->id]), [
                                        'title' => Yii::t('app', 'Delete'),
                                        'class' => 'btn btn-danger btn-xs',
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
    'id' => 'modal-group-user',
    //'size'=>'modal-lg',
]);
?>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
    <script>

        $("#back").on('click', function () {
            window.history.back();
        })
        // JS script

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

        $('#modal-addbtn-group-user').on('click', function () {
            modalGroupUser($(this).attr('data-url'));
        });

        $('#modal-delbtn-group-user').on('click', function () {
            selectionGroupUserGrid($(this).attr('data-url'));
        });

        $('#group-user-grid-pjax').on('click', '.select-on-check-all', function () {
            window.setTimeout(function () {
                var key = $('#group-user-grid').yiiGridView('getSelectedRows');
                disabledGroupUserBtn(key.length);
            }, 100);
        });

        $('.selectionCoreOptionIds').on('click', function () {
            var key = $('input:checked[class=\"' + $(this).attr('class') + '\"]');
            disabledGroupUserBtn(key.length);
        });

        $('#group-user-grid-pjax').on('dblclick', 'tbody tr', function () {
            var id = $(this).attr('data-key');
            modalGroupUser('<?= Url::to(['group-user/update', 'id' => ''])?>' + id);
        });

        $('#group-user-grid-pjax').on('click', 'tbody tr td a', function () {
            var url = $(this).attr('href');
            var action = $(this).attr('data-action');

            if (action === 'update' || action === 'view') {
                modalGroupUser(url);
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
                            $.pjax.reload({container: '#group-user-grid-pjax'});
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

        function disabledGroupUserBtn(num) {
            if (num > 0) {
                $('#modal-delbtn-group-user').attr('disabled', false);
            } else {
                $('#modal-delbtn-group-user').attr('disabled', true);
            }
        }

        function selectionGroupUserGrid(url) {
            yii.confirm('<?= Yii::t('chanpan', 'Are you sure you want to delete these items?')?>', function () {
                $.ajax({
                    method: 'POST',
                    url: url,
                    data: $('.selectionGroupUserIds:checked[name=\"selection[]\"]').serialize(),
                    dataType: 'JSON',
                    success: function (result, textStatus) {
                        if (result.status == 'success') {
                            swal({
                                title: result.status,
                                text: result.message,
                                type: result.status,
                                timer: 2000
                            });
                            $.pjax.reload({container: '#group-user-grid-pjax'});
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

        function modalGroupUser(url) {
            $('#modal-group-user .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
            $('#modal-group-user').modal('show')
                .find('.modal-content')
                .load(url);
        }
    </script>
<?php \richardfan\widget\JSRegister::end(); ?>