<?php

use yii\bootstrap4\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

?>

<div id="tableBank">
    <h4 class="modal-title" id="itemModalLabel">เชื่อมต่อบัญชีธนาคาร</h4><br>
    <table class="table table-responsive table-bordered">
        <tr>
            <td>ชื่อธนาคาร</td>
            <td><b><?= isset($model->banks->name) ? $model->banks->name : ''; ?></b></td>
            <td>
                <button class="btn btn-primary btnEditPayment"><i class="glyphicon glyphicon-pencil"></i></button>
            </td>
        </tr>
        <tr>
            <td>ชื่อบัญชี</td>
            <td><b><?= isset($model->name) ? $model->name : ''; ?></b></td>
            <td></td>
        </tr>
        <tr>
            <td>เลขที่บัญชี</td>
            <td>
                <div><b><?= isset($model->account) ? $model->account : ''; ?></b></div>
                <div><b><?= isset($model->detail) ? $model->detail : ''; ?></b></div>
            <td></td>
            </td>
        </tr>

    </table>
</div>

<div class="create-group-form" id="formBank">

    <?php $form = ActiveForm::begin([
        'id' => $model->formName(),
    ]); ?>

    <div class="modal-header">
        <h4 class="modal-title" id="itemModalLabel">เชื่อมต่อบัญชีธนาคาร</h4>
    </div>

    <div>


        <div>
            <?= $form->field($model, 'user_id')->hiddenInput(['maxlength' => true])->label(false) ?>
            <?= $form->field($model, 'bank')
                ->dropDownList(\yii\helpers\ArrayHelper::map(\backend\models\Bankitem::find()->all(), 'id', 'name'), [
                    'prompt' => 'เลือกธนาคาร...'
                ]) ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'account')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'detail')->textarea()->hint('เช่น ที่อยู่สาขา') ?>
        </div>


    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <button class="btn btn-primary btn-lg btn-block" id="btnSave">บันทึก</button>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
    $('#tableBank,#formBank').hide();

    function checkBank() {
        let name = "<?= $model->name; ?>";
        if (name != '') {
            $('#tableBank').show();
        }else{
            $('#formBank').show();
        }
    }

    checkBank();

    $(".btnEditPayment").on('click', function () {
        $('#tableBank,#formBank').hide();
        $('#formBank').show();
    });
    // JS script
    $('form#<?= $model->formName()?>').on('beforeSubmit', function (e) {
        $("#btnSave").attr('disabled', true);
        $('.btn-submit').prepend('<span class="icon-spin"><i class="fa fa-spinner fa-spin"></i></span> ');
        $('.btn-submit').attr('disabled', true);

        var $form = $(this);
        $.post(
            $form.attr('action'), //serialize Yii2 form
            $form.serialize()
        ).done(function (result) {
            $("#btnSave").attr('disabled', false);
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
                }, 2000);

            } else {
                swal({
                    title: result.message,
                    text: result.message,
                    type: result.status,
                    timer: 2000
                });
            }
        }).fail(function () {
            $("#btnSave").attr('disabled', false);
            <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
            console.log('server error');
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end(); ?>
<?php \appxq\sdii\widgets\CSSRegister::begin() ?>
<style>

    .invalid-feedback {
        color: red;
        margin-top: 10px;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end() ?>
