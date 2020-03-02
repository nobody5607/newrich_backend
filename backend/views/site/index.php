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
    // JS script
    $('#BtnSaveData').on('click', function () {
        let url = $("#url").val();
        $.ajax(
            {
                // Define AJAX properties.
                method: "get",
                url: url,
                dataType: "json",
                timeout: (2 * 10000),


                // Define the succss method.
                success: function(){
                    //$( "#response" ).text( "Success!" );
                },


                // Define the error method.
                error: function( objAJAXRequest, strError ){
                    alert(
                        "Error! Type: " +
                        strError
                    );
                }
            }
        );



        return false;
    });

</script>
<?php \richardfan\widget\JSRegister::end(); ?>
