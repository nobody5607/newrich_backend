<h3>ตั้งค่าบัญชีผู้ใช้งาน</h3>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\models\CreateGroup */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="create-group-form">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
    ]); ?>


    <div class="modal-body">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'member_type')->dropDownList(['B2B'=>'B2B','B2C'=>'B2C','C2C'=>'C2C']) ?>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <button class="btn btn-lg btn-block btn-primary" type="submit">ยืนยัน</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
    // JS script
    $('form#<?= $model->formName()?>').on('beforeSubmit', function (e) {
        $('.btn-submit').prepend('<span class="icon-spin"><i class="fa fa-spinner fa-spin"></i></span> ');
        $('.btn-submit').attr('disabled', true);

        var $form = $(this);
        $.post(
            $form.attr('action'), //serialize Yii2 form
            $form.serialize()
        ).done(function (result) {
            $('.btn-submit .icon-spin').remove();
            $('.btn-submit').attr('disabled', false);
            if (result.status == 'success') {
                swal({
                    title: result.message,
                    text: result.message,
                    type: result.status,
                    timer: 2000
                });
                setTimeout(function () {
                    location.reload();
                },2000);

            } else {
                swal({
                    title: result.message,
                    text: result.message,
                    type: result.status,
                    timer: 2000
                });
            }
        }).fail(function () {
            <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>
