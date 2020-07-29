<?php
    use yii\helpers\Url;
    $link = 'https://api.newriched.com/';
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "%3A%2F$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $mainUrl = "{$link}/games/default/view-data?uuid=" . $id;
    $new_url = str_replace(":", "%3A", $mainUrl);
    $link_url = str_replace("/", "%2F", $new_url);
    Yii::$app->meta->keywords = isset($model->msg)?$model->msg:'';
    Yii::$app->meta->description = isset($model->msg)?$model->msg:'';
    Yii::$app->meta->image = $image;
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
    <title><?= $model->msg; ?></title>
    <meta property="og:url"           content="https://alfood.web.app/" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?= $model->msg; ?>" />
    <meta property="og:description"   content="<?= $model->msg; ?>" />
    <meta property="og:image"         content="<?= $image; ?>" />
</head>
<body>
    

<!-- Load Facebook SDK for JavaScript -->
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <!-- Your share button code -->
  <label for="">แชร์ข้อมูล</label>
  <div class="fb-share-button" 
    data-href="<?= $mainUrl; ?>" 
    data-layout="button_count">
  </div>



 
</body>
</html>