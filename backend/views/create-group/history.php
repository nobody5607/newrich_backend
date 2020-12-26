<h3>ประวัติการถอนเงิน</h3>
<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        [
            'attribute'=>'createDate',
            'value'=>function($model){
                return \appxq\sdii\utils\SDdate::mysql2phpDateTime($model->createDate);
            }
        ],
        [
            'format'=>'raw',
            'attribute'=>'amount',
            'value'=>function($model){
                return number_format($model->amount, 2);
            }
        ],
        [
            'format'=>'raw',
            'attribute'=>'approveBy',
            'value'=>function($model){
                if($model->approveBy == ''){
                    return "<label class='text-warning'>รออนุมัติ</label>";
                }else{
                    return "<div class='text-success'>สำเร็จ</div>";
                }
            }
        ],
        [
            'format'=>'raw',
            'attribute'=>'image',
            'value'=>function($model){
                $path='';
                if($model->image){
                    $storageUrl = isset(\Yii::$app->params['storageUrl'])?\Yii::$app->params['storageUrl']:'';
                    $path = "{$storageUrl}/images/approved/{$model->image}";
                }
//                        return $path;
                return  "<img src='{$path}' class='img img-responsive' style='width:200px'>";

            }
        ],
    ],
]) ?>
<style>
    th,td{
        white-space: nowrap;
    }

</style>
