<!-- Start Header Style --><header id="htc__header" class="htc__header__area header--one">    <!-- Start Mainmenu Area -->    <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header">        <div class="container">            <div class="row">                <div class="menumenu__container clearfix">                    <div class="col-lg-2 col-md-2 col-sm-3 col-xs-5">                        <div class="logo">                            <a href="<?= \yii\helpers\Url::to(['/'])?>">                                <?php                                    $logo = isset(Yii::$app->params['logo_img'])?Yii::$app->params['logo_img']:'';                                ?>                                <img src="<?= $logo;?>" alt="logo images" style="width: 75px;">                            </a>                        </div>                    </div>                    <div class="col-md-7 col-lg-8 col-sm-5 col-xs-3">                        <?= $this->render('navbar',[                                'asset_path'=>$asset_path                        ]); ?>                    </div>                    <div class="col-md-3 col-lg-2 col-sm-4 col-xs-4">                        <div class="header__right">                            <div class="header__search search search__open">                                <a href="#"><i class="icon-magnifier icons"></i></a>                            </div>                            <div class="header__account">                                <a href="<?= \yii\helpers\Url::to(['/user/login'])?>"><i class="icon-user icons"></i></a>                            </div>                            <div class="htc__shopping__cart">                                <a href="<?= \yii\helpers\Url::to(['/cart/index'])?>"><i class="fa fa-shopping-cart"></i></a>                                <a href="<?= \yii\helpers\Url::to(['/cart/index'])?>"><span class="htc__qua">8</span></a>                            </div>                        </div>                    </div>                </div>            </div>            <div class="mobile-menu-area"></div>        </div>    </div>    <!-- End Mainmenu Area --></header><!-- End Header Area -->