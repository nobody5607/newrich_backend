<?php
    ///create-group/index?token=eJp-pFtC4I8Hw9GgbuDD3zf2Ocl3Dej5
    $token = isset(\Yii::$app->session['token'])?\Yii::$app->session['token']:'';
?>
<div style="margin-bottom:20px;">
    <a href="<?= \yii\helpers\Url::to(['/create-group/index?token='.$token])?>"><i class="glyphicon glyphicon-chevron-left"></i> ย้อนกลับ</a>
</div>
<div id="showBusinese"></div>

<?php \richardfan\widget\JSRegister::begin()?>
<script>
    function initBusiness(){
        let url = '<?= \yii\helpers\Url::to(['/group/get-busines?groupID='.$groupID])?>';
        $.get(url, function(result){
            $("#showBusinese").html(result);
        });
        return false;
    }
    initBusiness();
</script>
<?php \richardfan\widget\JSRegister::end();?>
<script>
    // var app = new Vue({
    //     el: '#app',
    //     data: {
    //         title: 'สร้างธุรกิจ',
    //         name1:'ลงทนในธุรกิจ',
    //         name2:'สงเสริมการลงทุน',
    //         name3:'เรียนรู้ผ่าน ZOOM'
    //     },
    //     methods:{
    //         editName1(){
    //             alert('ok')
    //         }
    //     }
    // })
</script>
