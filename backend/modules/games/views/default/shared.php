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
    <title>มนุษย์มดมหากาฬ (อังกฤษ: Ant-Man) เป็นภาพยนตร์ซูเปอร์ฮีโรอเมริกัน ในปี ค.ศ. 2015 ที่สร้างจากหนังสือการ์ตูนของมาร์เวลเรื่อง แอนต์-แมน สร้างโดย มาร์เวล สตูดิโอส์ ... ทำให้ครอสถูกย่อส่วนจนตาย แลงค์ถูกย่อส่วนลงไปเรื่อย ๆ จนติดอยู่ในมิติควอนตัม</title>

    <meta property="og:url"           content="<?= $mainUrl?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?= isset($model->msg)?$model->msg:''; ?>" />
    <meta property="og:description"   content="<?= isset($model->msg)?$model->msg:''; ?>" />
    <meta property="og:image"         content="<?= isset($image)?$image:''; ?>" />
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









 