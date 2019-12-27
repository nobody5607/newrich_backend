<?php
    use yii\helpers\Url;
    $moduleID = '';
    $controllerID = '';
    $actionID = '';

    if (isset(Yii::$app->controller->module->id)) {
        $moduleID = Yii::$app->controller->module->id;
    }
    if (isset(Yii::$app->controller->id)) {
        $controllerID = Yii::$app->controller->id;
    }
    if (isset(Yii::$app->controller->action->id)) {
        $actionID = Yii::$app->controller->action->id;
    }

?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <div class="slimScrollDiv">
        <section id="sidebar" class="sidebar">
            <!-- search form -->
<!--            <img class="img img-responsive" onerror="this.src='assets/images/display_default.jpg'"-->
<!--                 src="https://posposgo.co:8088/images/1544081075806/shop/shop_2019101516330662.jpeg">-->
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu tree" data-widget="tree">
                <li class="header">
                    <span class="nav-item-icon"><?= $this->render('image/order.svg'); ?></span>
                    <span class="nav-item-txt">คำสั่งซื้อ</span>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>คำสั่งซื้อของฉัน</span>
                    </a>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>จัดส่งสินค้า</span>
                    </a>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>การคืนเงิน/คืนสินค้า</span>
                    </a>
                </li>
                <li class="header">
                    <span class="nav-item-icon"><?= $this->render('image/product.svg'); ?></span>
                    <span class="nav-item-txt">สินค้า</span>
                </li>
                <li class="li-sub-menu <?= ($controllerID == 'product' && $actionID == 'index')?'active':''?>">
                    <a href="<?= Url::to(['/product/product']) ?>">
                        <span>สินค้าของฉัน</span>
                    </a>
                </li>
                <li class="li-sub-menu <?= ($controllerID == 'product' && $actionID == 'create')?'active':''?>">
                    <a href="<?= Url::to(['/product/product/create']) ?>">
                        <span>เพิ่มสินค้าใหม่</span>
                    </a>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>สินค้าที่ถูกระงับ</span>
                    </a>
                </li>
                <li class="li-sub-menu <?= ($controllerID == 'categorys')?'active':''?>">
                    <a href="<?= Url::to(['/product/categorys']) ?>">
                        <span>หมวดหมู่สินค้า</span>
                    </a>
                </li>

                <li class="header">
                    <span class="nav-item-icon"><?= $this->render('image/promotion.svg'); ?></span>
                    <span class="nav-item-txt">โปรโมชั่น</span>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>โปรโมชั่น</span>
                    </a>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>ส่วนลด</span>
                    </a>
                </li>


                <li class="header">
                    <span class="nav-item-icon"><?= $this->render('image/money.svg'); ?></span>
                    <span class="nav-item-txt">การเงิน</span>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>รายรับของฉัน</span>
                    </a>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>บัญชีธนาคาร</span>
                    </a>
                </li>

                <li class="header">
                    <span class="nav-item-icon"><?= $this->render('image/market.svg'); ?></span>
                    <span class="nav-item-txt">ร้านค้า</span>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>การตั้งค่าร้านค้า</span>
                    </a>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>การตั้งค่าร้านค้า</span>
                    </a>
                </li>

                <li class="header">
                    <span class="nav-item-icon"><?= $this->render('image/report.svg'); ?></span>
                    <span class="nav-item-txt">รายงาน</span>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>รายงานการขาย</span>
                    </a>
                </li>
                <li class="li-sub-menu">
                    <a href="#">
                        <span>ประวัติการขาย</span>
                    </a>
                </li>
            </ul>
            <?php //dmstr\widgets\Menu::widget(\backend\components\AppComponent::navbarLeft()) ?>

        </section>
        <div>
            <div class="text-center">OK</div>
        </div>
        <div class="slimScrollRail"
             style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
    </div>
    <!-- /.sidebar -->
</aside>
<?php \appxq\sdii\widgets\CSSRegister::begin(); ?>
<style>
    .skin-red-light .main-header .logo:hover {
        background-color: #0b5b94;
    }

    .skin-red-light .main-header .navbar .sidebar-toggle:hover {
        background-color: #0b5b94;
    }

    .skin-red-light .sidebar-menu > li:hover > a, .skin-red-light .sidebar-menu > li.active > a {
        color: #FF5722;
        background: transparent;
    }

    .skin-red-light .wrapper, .skin-red-light .main-sidebar, .skin-red-light .left-side {
        background-color: #fff;
    }

    .li-sub-menu {
        padding-left: 25px !important;
    }

    .skin-red-light .sidebar-menu > li > a {
        border-left: 3px solid transparent;
        font-weight: 500;
    }

    .sidebar-menu > li > a {
        padding: 0px 0px 8px 16px;
        display: block;
    }

    .nav-item-txt {
        padding-left: 30px;
        font-weight: 600;
        font-size: 14px
    }

    .nav-item-icon {
        position: absolute;
        top: 40%;
        margin-top: -8px;
        width: 20px;
        height: 20px;
        fill: #a2a2a4;
        font-size: 0;
    }
</style>
<?php \appxq\sdii\widgets\CSSRegister::end(); ?>
