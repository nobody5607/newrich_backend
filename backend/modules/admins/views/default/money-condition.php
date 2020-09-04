<?php
$this->title = "แก้ไขราคา";
?>
<div>
    <a href="<?= \yii\helpers\Url::to(['/admins'])?>">&lt; ย้อนกลับ</a>
    <h2>รับเงินคืนทำอย่างไร</h2>
    <form action="#">
        <textarea
            id="money_condition"
            name="money_condition"
            class="form-control"><?= isset($money_condition)?$money_condition:''; ?></textarea>
        <div class="text-right">
            <br>
            <button class="btn btn-primary btnSubmit">ยืนยัน</button>
        </div>
    </form>
</div>

<?php \richardfan\widget\JSRegister::begin()?>
<script>
    $(".btnSubmit").click(function(){
        let money_condition = $('#money_condition').val();
        let url = '<?= \yii\helpers\Url::to(['/admins/default/money-condition'])?>';
        $.post(url,{money_condition:money_condition}, function(result){
            if(result.status == 'success') {
                swal({
                    title: result.message,
                    text: result.message,
                    type: result.status,
                    timer: 1000
                });
                setTimeout(function () {
                },1500);
            } else {
                swal({
                    title: result.message,
                    text: result.message,
                    type: result.status,
                    timer: 1000
                });
            }
        });
        return false;
    });
</script>
<?php \richardfan\widget\JSRegister::end()?>
