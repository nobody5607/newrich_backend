<?php
use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data'],
    'id'=>$model->formName(),
]); ?>

<div class="alert alert-warning">
    หมายเหตุ ไฟล์ต้องเป็นไฟล์รูปแบบ excel เท่านั้น สามารถดาวน์โหลดตัวอย่างรูปแบบได้ <a href="<?= \yii\helpers\Url::to('@web/uploads/newrich_fields.xlsx')?>"> ที่นี้  </a>
</div>
<?= $form->field($model, 'file')->fileInput() ?>
    <button class="btn btn-primary">ยืนยัน</button>
<?php ActiveForm::end() ?>


<?php  \richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>

    $('form#<?= $model->formName()?>').on('beforeSubmit', function(e) {
        var $form = $(this);
        var formData = new FormData($(this)[0]);

        $.ajax({
            url:$form.attr('action'),
            type:'POST',
            data:formData,
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            success:function(result){
                <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
                if(result.status == 'success') {
                    setTimeout(function(){
                        location.reload();
                    },1000);
                }
            }
        }).fail(function( jqXHR, textStatus ) {
            <?= \appxq\sdii\helpers\SDNoty::show('result.message', 'result.status')?>
        });

        return false;
    });




</script>
<?php  \richardfan\widget\JSRegister::end(); ?>
