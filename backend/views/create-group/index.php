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
$datas = $dataProvider->getModels();
?>
<div class="row">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-xs-8">
                <h3>กลุ่มธุรกิจ</h3>
            </div>
            <div class="col-md-4 col-xs-4 text-right">
                <?= Html::button(SDHtml::getBtnAdd() . ' สร้างกลุ่ม', ['data-url' => Url::to(['create-group/create']), 'class' => 'btn btn-success btnCreate', 'id' => 'modal-addbtn-create-group'])
                ?>
            </div>
        </div>
    </div>
    <?php if ($datas): ?>
        <?php foreach ($datas as $k => $v): ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                <div class="thumbnail">
                    <div class="caption">

                        <div class="col-lg-12 well-add-card">
                            <h4>
                                <?php
                                if (isset($v['name'])) {
                                    echo $v['name'];
                                }
                                ?>
                            </h4>
                        </div>

                        <div>
                            <div class="col-md-12">

                                <?php

                                if (isset($v['createDate'])) {
                                    echo \appxq\sdii\utils\SDdate::mysql2phpThDate($v['createDate']);
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-lg-12">

                            <div class="clearfix"></div>
                            <br>
                            <div class="">


                                <div class="row text-center">
                                    <div class="col-md-6 col-xs-6 text-center">
                                        <a
                                                class="btn btn-default btn-lg btn-block"
                                                href="<?= \yii\helpers\Url::to(['/group/busines?groupID=' . $v->id]) ?>">
                                            <i class="glyphicon glyphicon-eye-open"></i> แสดง
                                        </a>

                                        <a href="#" style="margin-top:20px"
                                           class="btn btn-primary btnEdit btn-lg btn-block"
                                           data-url="<?= \yii\helpers\Url::to(['/create-group/update?id=' . $v->id]) ?>">
                                            <i class="glyphicon glyphicon-pencil"></i> แก้ไข
                                        </a>
                                    </div>
                                    <div class="col-md-6 col-xs-6 text-center">
                                        <a href="#"
                                           class="btn btn-danger btnDelete btn-lg btn-block"
                                           data-url="<?= \yii\helpers\Url::to(['/create-group/delete?id=' . $v->id]) ?>">
                                            <i class="glyphicon glyphicon-trash"></i> ลบ</a>

                                        <a
                                                class="btn btn-success btn-lg btn-block" style="margin-top:20px"
                                                href="<?= \yii\helpers\Url::to(['/group-user/index?id=' . $v->id]) ?>">
                                            <i class="glyphicon glyphicon-user"></i> เพิ่มผู้ใช้</a>
                                    </div>
                                </div>


                            </div>
                            <div class="clearfix"></div>

                        </div>
                        <div class="row"></div>

                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>

    <?php endif; ?>
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
    $(".btnCreate").on('click', function () {
        let url = $(this).attr('data-url');
        modalCreateGroup(url);
        //alert(url);
        return false;
    });

    $(".btnEdit").on('click', function () {
        let url = $(this).attr('data-url');
        modalCreateGroup(url);
        return false;
    });
    $(".btnDelete").on('click', function () {
        let url = $(this).attr('data-url');
        bootbox.confirm('คุณต้องการลบรายการนี้ใช่หรือไม่', function (result) {
            if (result === true) {
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
                        location.reload();
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
            }
        })
        return false;
    });


    function modalCreateGroup(url) {
        $('#modal-create-group .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-create-group').modal('show')
            .find('.modal-content')
            .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>


