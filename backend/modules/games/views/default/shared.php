<?php
    use yii\helpers\Url;
    $link = 'https://api.newriched.com';
    // $link = 'http://backend.newrich.local/';
    $this->registerMetaTag([
            'property'=>'og:title',
            'content'=>$msg 
    ]);
    $this->registerMetaTag([
            'property'=>'og:type',
            'content'=>'website'
    ]);
    $this->registerMetaTag([
            'property'=>'og:url',
            'content'=>"{$link}/games/default/view-data?uuid={$id}"
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

 <a class="text-white btn btn-default" style="background: #4267b2;
        border-radius: 5px;
        color: white; font-size:20pt;    width: 55px;" 
        href="https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=<?= $mainUrl; ?>&display=popup&ref=plugin&src=share_button" target="_blank">
            <i class="fa fa-facebook"></i>
        </a>








 