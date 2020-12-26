<!-- Sidebar -->
<?php
    use yii\helpers\Url;
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= \yii\helpers\Url::to(['/admins'])?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <img class="img img-fluid" style="width:50px" src="https://newrich-8ee77.web.app/assets/images/logo.png" alt="">
        </div>
        <div class="sidebar-brand-text mx-3">
             Newriched
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= Url::to(['/admins'])?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Newriched
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/admins/user'])?>">
            <i class="fas fa-fw fa-user"></i>
            <span>จัดการผู้ใช้งาน</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/admins/slider'])?>">
            <i class="fas fa-fw fa-photo-video"></i>
            <span>จัดการภาพ Banner</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
           aria-expanded="true" aria-controls="collapseUsers">
            <i class="fas fa-fw fa-users"></i>
            <span>ข้อมูลจากลูกค้า</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= Url::to(['/admins/refund'])?>">ส่วนลดเงินคืน</a>
                <hr class="sidebar-divider">
                <a class="collapse-item" href="<?= Url::to(['/admins/withdraw'])?>">ถอนเงิน</a>

            </div>
        </div>
    </li>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
           aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>ข้อกำหนดและเงื่อนไข</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= Url::to(['/admins/default/edit-play-money'])?>">รับเงินคืนทำอย่างไร</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>ตั้งค่า</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="<?= Url::to(['/admins/payment'])?>">อนุมัติการใช้งานระบบ</a>
                <a class="collapse-item" href="<?= Url::to(['/admins/setting/config'])?>">ตั้งค่าระบบ</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Alfood
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?= Url::to(['/games'])?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>คูปอง</span></a>
    </li>

    <!-- Heading -->
    <div class="sidebar-heading">
        Report Alfood
    </div>
    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="http://report.newriched.com/index.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>รายงานการขาย Alfood</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
