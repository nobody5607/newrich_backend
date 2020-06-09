<?php

use yii\bootstrap4\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

?>

    <div class="create-group-form">

        <?php $form = ActiveForm::begin([
            'id' => $model->formName(),
        ]); ?>

        <div class="modal-header">
            <h4 class="modal-title" id="itemModalLabel">ส่ง Email</h4>
        </div>

        <div class="modal-body">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
            <?php
            echo $form->field($model, 'message')->widget(\cpn\chanpan\widgets\CNFroalaEditorWidget::className(), [
                'toolbar_size' => 'sm',
                'options' => ['class' => 'detail'],
            ])->label(false);
            ?>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <button class="btn btn-success" id="btnSendMail">ส่ง</button>
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
        // JS script
        $('form#<?= $model->formName()?>').on('beforeSubmit', function (e) {
            $("#btnSendMail").attr('disabled',true);
            $('.btn-submit').prepend('<span class="icon-spin"><i class="fa fa-spinner fa-spin"></i></span> ');
            $('.btn-submit').attr('disabled', true);

            var $form = $(this);
            $.post(
                $form.attr('action'), //serialize Yii2 form
                $form.serialize()
            ).done(function (result) {
                $("#btnSendMail").attr('disabled',false);
                $('.btn-submit .icon-spin').remove();
                $('.btn-submit').attr('disabled', false);
                if (result.status == 'success') {
                    swal({
                        title: result.message,
                        text: result.message,
                        type: result.status,
                        timer: 2000
                    });
                    $(document).find('#modal-create-group').modal('hide');
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
                $("#btnSendMail").attr('disabled',false);
                <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
                console.log('server error');
            });
            return false;
        });
    </script>
<?php \richardfan\widget\JSRegister::end(); ?>
