<?php
    use yii\helpers\Url;
    $link = 'https://api.newriched.com';
    // $link = 'http://backend.newrich.local/';
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









 