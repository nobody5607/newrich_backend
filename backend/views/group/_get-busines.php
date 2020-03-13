<div class="row">
    <?php foreach ($model as $k => $v): ?>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="thumbnail">
                    <div class="caption">
                        <div class="col-lg-12">

                            <i class="glyphicon glyphicon-calendar"></i> <?php

                            if(isset($v['createDate'])){
                                echo \appxq\sdii\utils\SDdate::mysql2phpThDate($v['createDate']);
                            }
                            ?>
                            <div class="pull-right">
                                <a href="#" class="btnEdit" data-url="<?= \yii\helpers\Url::to(['/create-busines/update?id=' . $v->id]) ?>">
                                    <i class="glyphicon glyphicon-pencil"></i> แก้ไข</a>
                            </div>

                        </div>
                        <div class="col-lg-12 well-add-card">
                            <h4>
                                <?= $v->title; ?>
                            </h4>
                        </div>

                        <div>
                            <div class="col-md-12">


                            </div>
                        </div>
                        <div class="row"></div>

                    </div>
                </div>
        </div>
    <?php endforeach; ?>
</div>
<?= \appxq\sdii\widgets\ModalForm::widget([
    'id' => 'modal-create-busines',
    'size' => 'modal-lg',
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

