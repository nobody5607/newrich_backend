<?php
    $this->title = "แก้ไขราคา";
?>
<div>
    <a href="<?= \yii\helpers\Url::to(['/admins/index'])?>">&lt; ย้อนกลับ</a>
    <h2>แก้ไขจำนวนเงิน Package</h2>
    <form action="#">
        <label>จำนวนเงิน</label>
        <input type="text" id="price" name="price" value="<?= isset($price)?$price:''; ?>" class="form-control">
        <div class="text-right">
            <br>
            <button class="btn btn-primary btnSubmit">ยืนยัน</button>
        </div>
    </form>
</div>

<?php \richardfan\widget\JSRegister::begin()?>
<script>
    $(".btnSubmit").click(function(){
        let price = $('#price').val();
        let url = '<?= \yii\helpers\Url::to(['/admins/price'])?>';
        $.post(url,{price:price}, function(result){
            if(result.status == 'success') {
                swal({
                    title: result.message,
                    text: result.message,
                    type: result.status,
                    timer: 1000
                });
                setTimeout(function () {
                     location.href = '<?=  \yii\helpers\Url::to(['/admins/index']); ?>';
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
