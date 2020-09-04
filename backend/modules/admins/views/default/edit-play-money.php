<?php
$this->title = "แก้ไขราคา";
?>
<div>
    <a href="<?= \yii\helpers\Url::to(['/admins'])?>">&lt; ย้อนกลับ</a>
    <h2>รับเงินคืนทำอย่างไร</h2>
    <form action="#">
        <textarea
            id="ReceiveMoney"
            name="ReceiveMoney"
            class="form-control"><?= isset($ReceiveMoney)?$ReceiveMoney:''; ?></textarea>
        <div class="text-right">
            <br>
            <button class="btn btn-primary btnSubmit">ยืนยัน</button>
        </div>
    </form>
</div>

<?php \richardfan\widget\JSRegister::begin()?>
<script>
    $(".btnSubmit").click(function(){
        let ReceiveMoney = $('#ReceiveMoney').val();
        // alert(ReceiveMoney);
        let url = '<?= \yii\helpers\Url::to(['/admins/default/edit-play-money'])?>';
        $.post(url,{ReceiveMoney:ReceiveMoney}, function(result){
            if(result.status == 'success') {
                swal({
                    title: result.message,
                    text: result.message,
                    type: result.status,
                    timer: 1000
                });
                setTimeout(function () {
                    location.href = '<?=  \yii\helpers\Url::to(['/admins']); ?>';
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
