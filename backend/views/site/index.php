<div>
    <div>
        <input type="text" id="url" value="https://www.sam.or.th/api/product_dd3.php?From_date=2000-11-01&2999-11-30">
        <button class="btn btn-primary" id="BtnSaveData">Save Data</button>
    </div>
</div>
<?php
ini_set('post_max_size', '20m');

\richardfan\widget\JSRegister::begin([
    //'key' => 'bootstrap-modal',
    'position' => \yii\web\View::POS_READY
]);
?>
<script>
    var settings = {
        "url": "https://www.sam.or.th/api/product_dd3.php?From_date=2000-11-01&2999-11-30&page=1",
        "method": "GET",
        "timeout": 0,
    };

    $.ajax(settings).done(function (response) {
        console.log(response);
    });

</script>
<?php \richardfan\widget\JSRegister::end(); ?>
