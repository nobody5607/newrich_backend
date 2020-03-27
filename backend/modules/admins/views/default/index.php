<?php
$this->title = "จัดการ";
?>

<div class="row">
    <div class="col-md-12">
        <h2>เลือกเมนู</h2>
    </div>
    <div class="col-md-12">
        <a href="<?= \yii\helpers\Url::to(['/admins/user'])?>" class="btn btn-outline-info"><i class="fa fa-upload"></i> ผู้ใช้</a>

    </div>
    <div class="col-md-12">
        <br>
        <a href="<?= \yii\helpers\Url::to(['/site/index'])?>" class="btn btn-outline-info"><i class="fa fa-upload"></i> อัปโหลดข้อมูลการสั่งซื้อสินค้า</a>

    </div>

    <div class="col-md-12">
        <br>
        <a href="<?= \yii\helpers\Url::to(['/admins/default/price-package'])?>" class="btn btn-outline-info">แก้ไขราคา Package</a>
    </div>
    <div class="col-md-12">
        <br>
        <a href="<?= \yii\helpers\Url::to(['/admins/payment/index'])?>" class="btn btn-outline-info">อนุมัติการใช้งานระบบ</a>
    </div>
</div>

<!--ตัวที่จะ public พรุ่งนี้มีดังนี้นะครับ-->
<!--1 หน้าสร้างธุรกิจ จะสามารถเห็นได้เฉพาะคนที่มีสิทธิ์เท่านั้น-->
<!--2 ทุกคนสามารถสมัครสมาชิกได้ แต่ จะไม่สามารถใช้งานส่วนของ สร้างธุระกิจได้-->
<!--3 ผู้ใช้งานที่จะใช้งานส่วนของการสร้างธุรกิจได้ จะต้องชำระเงิน ก่อน-->
<!--4 ผู้ใช้ที่จะกอปลิงค์ไปให้คนอื่นสมัครต่อได้ จะต้องชำระเงินก่อน-->
<!--5 อัตราค่าสมัครของสมาชิก คิดเป็นกี่บาทครับ ?-->