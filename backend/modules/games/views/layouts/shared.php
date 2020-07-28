<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>alfood</title>

    <?php Yii::$app->meta->displaySeo() ?>

    <meta property="fb:app_id" content="" />
    <meta property="og:locale" content="th_TH" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?= $this->title ?>" />
    <meta property="og:description"
          content="alfood"
    />
    <meta property="og:url" content="http://api.newriched.com/"/>
    <meta property="og:site_name" content="alfood" />
    <meta property="article:publisher" content="" />
    <meta name="twitter:card" content="summary"/>
    <meta name="twitter:site" content="alfood.web.app"/>
    <meta name="twitter:domain" content=""/>
</head>
<body>
    <?= $content; ?>
</body>
</html>