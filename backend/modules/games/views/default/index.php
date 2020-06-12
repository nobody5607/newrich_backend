<div class="games-default-index">
    <?php
        $storageUrl = isset(\Yii::$app->params['storageUrl']) ? \Yii::$app->params['storageUrl'] : '';
    ?>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php for($i=1; $i<=5; $i++):?>
                <a href="<?= \yii\helpers\Url::to(['//games/game-event/index?parent_id='.$i])?>"><img src="<?= $storageUrl."/images/{$i}.png"?>" alt="" class="img img-responsive"></a>
            <?php endfor;?>
        </div>
    </div>
</div>
