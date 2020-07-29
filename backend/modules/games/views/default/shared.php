<?php 
    use yii\helpers\Url;
    $this->title = $msg;
    $tag = "#Alfood Market #อาหารสดออนไลน์";
    $link = 'https://api.newriched.com';
    // $link = 'http://backend.newrich.local/';
    $mainUrl = "{$link}/games/default/view-data?uuid={$id}";
    $this->registerMetaTag([
            'property'=>'og:title',
            'content'=>$msg."{$tag}" 
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
        href="https://www.facebook.com/sharer/sharer.php?&u=<?= $mainUrl; ?>" target="_blank">
            <i class="fa fa-facebook"></i>
        </a>
        <a target="_blank" href="https://lineit.line.me/share/ui?url=<?= $mainUrl;?>" target="_blank"><i
                            class="fa fa-line"></i></a>









 