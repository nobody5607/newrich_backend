<?php
$this->title = "จัดการ";
?>

<div class="row">

    <div class="col-md-12">
        <h2>ยินดีต้อนรับคุณ <?= isset(\Yii::$app->user->identity->profile->name)?\Yii::$app->user->identity->profile->name:''?></h2>
        <hr>
        <h3>Newriched</h3>
    </div>
    <div class="col-md-12">
        <a href="<?= \yii\helpers\Url::to(['/admins/user'])?>" class="btn btn-outline-info"><i class="glyphicon glyphicon-user"></i> ผู้ใช้</a>

    </div>
    <div class="col-md-12">
        <br>
        <a href="<?= \yii\helpers\Url::to(['/admins/slider'])?>" class="btn btn-outline-info"><i class="glyphicon glyphicon-picture"></i> อัปโหลด Slider</a>

    </div>


    <div class="col-md-12">
        <br>
        <a href="<?= \yii\helpers\Url::to(['/site/index'])?>" class="btn btn-outline-info"><i class="glyphicon glyphicon-upload"></i> อัปโหลดข้อมูลการสั่งซื้อสินค้า</a>

    </div>

    <div class="col-md-12">
        <br>
        <a href="<?= \yii\helpers\Url::to(['/admins/default/edit-play-money'])?>" class="btn btn-outline-info"><i class="glyphicon glyphicon-briefcase"></i> แก้ไข รับเงินคืนทำอย่างไร</a>
    </div>
    <div class="col-md-12">
        <br>
        <a href="<?= \yii\helpers\Url::to(['/admins/default/money-condition'])?>" class="btn btn-outline-info"><i class="glyphicon glyphicon-flag"></i> แก้ไข เงื่อนไขรับเงินคืน</a>
    </div>
</div>

    <hr>
    <div class="row">

        <div class="col-md-12">
            <h3>Alfood</h3>
            <br>
            <a href="<?= \yii\helpers\Url::to(['/games'])?>" class="btn btn-outline-info"><i class="glyphicon glyphicon-star"></i> เกม alfood</a>
        </div>

        <div class="col-md-12">
            <br>
            <a href="<?= \yii\helpers\Url::to(['/admins/default/logout'])?>" class="btn btn-outline-danger"><i class="glyphicon glyphicon-off"></i> ออกจากระบบ</a>
        </div>
    </div>

<!--ตัวที่จะ public พรุ่งนี้มีดังนี้นะครับ-->
<!--1 หน้าสร้างธุรกิจ จะสามารถเห็นได้เฉพาะคนที่มีสิทธิ์เท่านั้น-->
<!--2 ทุกคนสามารถสมัครสมาชิกได้ แต่ จะไม่สามารถใช้งานส่วนของ สร้างธุระกิจได้-->
<!--3 ผู้ใช้งานที่จะใช้งานส่วนของการสร้างธุรกิจได้ จะต้องชำระเงิน ก่อน-->
<!--4 ผู้ใช้ที่จะกอปลิงค์ไปให้คนอื่นสมัครต่อได้ จะต้องชำระเงินก่อน-->
<!--5 อัตราค่าสมัครของสมาชิก คิดเป็นกี่บาทครับ ?-->
