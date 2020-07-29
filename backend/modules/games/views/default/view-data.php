<?php 
    use yii\helpers\Url;
    $this->title = $msg;
    $link = 'https://api.newriched.com';
    // $link = 'http://backend.newrich.local/';
    $mainUrl = "{$link}/games/default/view-data?uuid={$id}";
    $this->registerMetaTag([
            'property'=>'og:title',
            'content'=>$msg 
    ]);
    $this->registerMetaTag([
            'property'=>'og:type',
            'content'=>'article'
    ]);
    $this->registerMetaTag([
            'property'=>'og:url',
            'content'=>"{$link}/games/default/shared?uuid={$id}"
    ]); 
    $this->registerMetaTag([
            'property'=>'og:image',
            'content'=>$image
    ]);
    $this->registerMetaTag([
            'property'=>'og:description',
            'content'=>$msg 
    ]);
?> 
<div class="container">
    <div>
        <h1>ใส่ใจในความพิงพอใจ</h1>
    </div>
    <div>
        <img src='<?= $image; ?>' class='img img-responsive' style='width:50%'>
    </div>
    <div>
        <?= $model->msg;?>
    </div>

    <div>
    <br>
        <a href='https://alfood.web.app/event'>Alfood Market</a>
    </div>

</div>