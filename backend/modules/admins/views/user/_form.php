<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use appxq\sdii\helpers\SDNoty;
use appxq\sdii\helpers\SDHtml;

/* @var $this yii\web\View */
/* @var $model backend\modules\admins\models\User */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">ผู้ใช้</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
	<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'member_type')->dropDownList(['B2B' => 'B2B', 'B2C' => 'B2C', 'C2C']) ?>



    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-primary btn-submit' : 'btn btn-primary  btn-submit']) ?>
	
            </div>
        </div>
    </div> 

    <?php ActiveForm::end(); ?>

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
            // swal({
            //     title: result.message,
            //     text: result.message,
            //     type: result.status,
            //     timer: 1000
            // });

            $.notify(result.message,{
                position:'top right',
                className: 'success',
            });

            $(document).find('#modal-user').modal('hide');
            $.pjax.reload({container:'#user-grid-pjax'});

        } else {
            swal({
                title: result.message,
                text: result.message,
                type: result.status,
                timer: 1000
            });
        } 
    }).fail(function() {
        <?= SDNoty::show("'" . SDHtml::getMsgError() . "Server Error'", '"error"')?>
        console.log('server error');
    });
    return false;
});
</script>
<?php  \richardfan\widget\JSRegister::end(); ?>