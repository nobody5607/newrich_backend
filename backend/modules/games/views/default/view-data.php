<?php
    use yii\helpers\Url;
?> 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 
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
        <a href='https://alfood.web.app/event'>Alfood</a>
    </div>

</div>