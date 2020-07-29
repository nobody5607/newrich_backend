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

    <title><?= $msg; ?></title>

 <meta property="og:title"                  content="<?= $msg; ?>"/>
    <meta property="og:type"                content="website"/>
    <meta property="og:url"                 content="<?= $mainUrl?>"/>
    <meta property="og:image"               content="<?= $image; ?>"/>
    <meta property="og:site_name"           content="alfood.web.app"/>
    <meta property="fb:admins"              content="000000000000000000"/>
    <meta property="og:description"         content="<?= $msg; ?>" /> 
</head>
<body>
    
 
 <a class="text-white btn btn-default" style="background: #4267b2;
        border-radius: 5px;
        color: white; font-size:20pt;    width: 55px;" 
        href="https://www.facebook.com/sharer/sharer.php?kid_directed_site=0&sdk=joey&u=<?= $mainUrl; ?>&display=popup&ref=plugin&src=share_button" target="_blank">
            <i class="fa fa-facebook"></i>
        </a>
</body>
</html>









 