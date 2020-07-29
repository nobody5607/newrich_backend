<?php
    use yii\helpers\Url;
    $link = 'https://api.newriched.com/';
    // $link = 'http://backend.newrich.local/';
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "%3A%2F$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $mainUrl = "{$link}/games/default/view-data?uuid=" . $id;
 
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($model->msg)?$model->msg:''; ?></title>
    <meta property="og:url"           content="<?= $mainUrl?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?= isset($model->msg)?$model->msg:''; ?>" />
    <meta property="og:description"   content="<?= isset($model->msg)?$model->msg:''; ?>" />
    <meta property="og:image"         content="<?= isset($image)?$image:''; ?>" />
</head>
<body>
    

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
 
</body>
</html>









 