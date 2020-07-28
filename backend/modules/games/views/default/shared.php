<?php

    use yii\helpers\Url;

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "%3A%2F$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $mainUrl = "https://api.newriched.com/games/default/view-data?uuid=" . $id;
    $new_url = str_replace(":", "%3A", $mainUrl);
    $link_url = str_replace("/", "%2F", $new_url);

    $this->title = 'รายละเอียด';
    Yii::$app->meta->keywords = isset($model->msg)?$model->msg:'';
    Yii::$app->meta->description = isset($model->msg)?$model->msg:'';
    Yii::$app->meta->image = $image;

?> 
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<p style="font-size: 18px;">
    <div>
        <label for="">แชร์ข้อมูล</label>
    </div>
    <div>
        <a class="text-white btn btn-default" href="https://www.facebook.com/sharer.php?u=<?= $mainUrl; ?>"
            target="_blank">
            <i class="fa fa-facebook"></i>
        </a>
        <a class="text-white btn btn-default" href="https://twitter.com/share?url=<?= $mainUrl; ?>" target=" _blank">
            <i class="fa fa-twitter "></i>
        </a>
    </div>


</p>