<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

$this->title='ส่วนลดเงินคืน';
?>

<div class="card">
    <div class="card-header"><?= Html::encode($this->title)?></div>
    <div class="card-body">

        <?php $form = ActiveForm::begin([
            'id'=>$model->formName(),
        ]); ?>

        <div>
            <div class="mb-3">
                <label>ชื่อลูกค้า: <b><?= \backend\lib\CNUtils::getUserById($model->user_id)?></b></label>

            </div>


            <div class="row">
                <div class="col-md-6">	<?= $form->field($model, 'order_id')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">	<?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'status')->inline()->radioList(\backend\lib\CNUtils::$statusApprove) ?>
                </div>
                <div class="col-md-6">

                    <?= $form->field($model, 'payment')->inline()->radioList(\backend\lib\CNUtils::$statusPayment) ?>

                </div>
            </div>

        </div>
        <div class="modal-footer">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'ยืนยัน'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-submit' : 'btn btn-primary btn-lg btn-submit']) ?>

        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
// JS script
$('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
    $('.btn-submit').prepend('<span class="icon-spin"><i class="fa fa-spinner fa-spin"></i></span> ');
    $('.btn-submit').attr('disabled',true);

    var $form = $(this);
    $.post(
        $form.attr('action'), //serialize Yii2 form
        $form.serialize()
    ).done(function(result) {
        $('.btn-submit .icon-spin').remove();
        $('.btn-submit').attr('disabled',false);
        if(result.status == 'success') {
            swal({
                title: result.message,
                text: result.message,
                type: result.status,
                timer: 1000
            });
            setTimeout(function(){
                location.href = '<?= \yii\helpers\Url::to(['/admins/refund'])?>';
            },1500);

        } else {
            swal({
                title: result.message,
                text: result.message,
                type: result.status,
                timer: 1000
            });
        } 
    }).fail(function() {
        console.log('server error');
    });
    return false;
});
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>
