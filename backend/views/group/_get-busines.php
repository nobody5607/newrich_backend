<div class="row">
    <?php foreach ($model as $k => $v): ?>
        <div class="col-md-4 col-sm-4 col-xs-12">
            <?= $v->title; ?> <a href="#" class="btnEdit" data-url="<?= \yii\helpers\Url::to(['/create-busines/update?id='.$v->id])?>"><i class="glyphicon glyphicon-pencil"></i> แก้ไข</a>
        </div>
    <?php endforeach; ?>
</div>
<?= \appxq\sdii\widgets\ModalForm::widget([
    'id' => 'modal-create-busines',
    'size'=>'modal-lg',
]);
?>


<?php \richardfan\widget\JSRegister::begin([
//    'size' => 'modal-lg',
    'position' => \yii\web\View::POS_READY
]); ?>
<script>
    $(".btnEdit").on('click', function () {
        let url = $(this).attr('data-url');
        modalCreateBusine(url);
        return false;
    });


    function modalCreateBusine(url) {
        $('#modal-create-busines .modal-content').html('<div class=\"sdloader \"><i class=\"sdloader-icon\"></i></div>');
        $('#modal-create-busines').modal('show')
            .find('.modal-content')
            .load(url);
    }
</script>
<?php \richardfan\widget\JSRegister::end(); ?>

