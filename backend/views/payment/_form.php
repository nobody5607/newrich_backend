<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Payment */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="payment-form">

    <?php $form = ActiveForm::begin([
	    'id'=>$model->formName(),
    ]); ?>

    <div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="itemModalLabel"><i class="fa fa-table"></i> อนุมัติการใช้งานระบบ</h4>
    </div>

    <div class="modal-body">

    <?php
        $userID = \common\modules\user\classes\CNUserFunc::getUserId();
        $data = (new \yii\db\Query())
            ->select(['user.id','profile.name'])
            ->from('user')
            ->innerJoin('profile','profile.user_id=user.id')
            ->where(['profile.parent_id'=>$userID])
            ->orWhere(['user.id'=>$userID])
            ->all();
        $items = \yii\helpers\ArrayHelper::map($data,'id','name');
        echo $form->field($model, 'user_id')->widget(\kartik\select2\Select2::classname(), [
            'data' => $items,
            'options' => ['placeholder' => 'เลือกผู้ใช้ ...'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
    ?>
	<?php
        echo $form->field($model, 'status')->radioList(\cpn\chanpan\utils\CNUtils::$statusPayment);
    ?>
    <?php
        echo $form->field($model, 'stdate')->widget(\kartik\date\DatePicker::classname(), [
            'options' => ['placeholder' => 'เลือกวันที่เริ่มใช้งาน...'],
            'pluginOptions' => [
                'autoclose'=>true,
                'todayHighlight' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
    ?>
    <?php
    echo $form->field($model, 'endate')->widget(\kartik\date\DatePicker::classname(), [
        'options' => ['placeholder' => 'เลือกวันที่หมดอายุการใช้งาน...'],
        'pluginOptions' => [
            'autoclose'=>true,
            'todayHighlight' => true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>




    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block btn-submit' : 'btn btn-primary btn-lg btn-block btn-submit']) ?>
	
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
    //$('.btn-submit').attr('disabled',true);

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
            $(document).find('#modal-payment').modal('hide');
            $.pjax.reload({container:'#payment-grid-pjax'});

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