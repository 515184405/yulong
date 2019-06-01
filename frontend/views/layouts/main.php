<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <meta name="keywords" content="网站建设,专业网站建设团队,网站设计,网站制作,做网站"/>
    <meta name="description" content="北京聚友开发小组团队,专业从事网站建设.高品质建站服务.丰富的网站建设经验,响应式网站设计、网站制作开发"/>

    <link rel="stylesheet" href="/asset/static/css/default.css">
    <script src="/asset/static/wigdet/jquery.min.js"></script>
    <script src="/asset/static/wigdet/layer/layer.js"></script>
</head>
<body>
<div class="wrapper">
    <p style="transform: scale(0.7);" class="login-register-box none"><a class="login_btn" href="javascript:;">登 陆</a> <span style="position: relative;top:-1px;">|</span> <a class="register_btn" href="javascript:;">注 册</a></p>
    <!-- 头部 -->
    <header id="header" class="header transition">
        <div class="fy-container clearfix">
            <div class="left logo">
                <img src="/asset/static/image/logo-fff.png" alt="网站logo">
            </div>
            <ul id="nav_ul" class="nav-ul right">
                <li><a class="<?= Yii::$app->request->getPathInfo()=='' ? 'active' : ''?>" href="/">首页</a></li>
                <li><a class="<?= strpos(Yii::$app->request->getPathInfo(),'service')!==false ? 'active' : ''?>" href="/service">服务项目</a></li>
                <li><a class="<?= strpos(Yii::$app->request->getPathInfo(),'case')!==false ? 'active' : ''?>" href="/case">精品案例</a></li>
                <li><a class="<?= strpos(Yii::$app->request->getPathInfo(),'unit')!==false ? 'active' : ''?>" href="/unit">前端组件</a></li>
                <li><a class="<?= strpos(Yii::$app->request->getPathInfo(),'news')!==false ? 'active' : ''?>" href="/news">新闻动态</a></li>
                <li><a class="<?= strpos(Yii::$app->request->getPathInfo(),'about')!==false ? 'active' : ''?>" href="/about">关于我们</a></li>
                <li><a class="<?= strpos(Yii::$app->request->getPathInfo(),'contact')!==false ? 'active' : ''?>" href="/contact">联系我们</a></li>
                <!--登录前-->
                <?php if(Yii::$app->id){?>
                <li><p class="login-register-box"><a class="login_btn" href="javascript:;">登 陆</a> <span style="position: relative;top:-1px;">|</span> <a class="register_btn" href="javascript:;">注 册</a></p></li>
                <?php }else{ ?>
                <!--登录后-->
                <li class="user-box js_user_box">
                    <a href="javascript:;"><img src="//t.cn/RCzsdCq" class="layui-nav-img">依鸣</a><i class="iconfont user-icon"></i>
                    <dl class="fy-nav-child transition js_nav_child">
                        <dd><a href="javascript:;">修改信息</a></dd>
                        <dd><a href="javascript:;">安全管理</a></dd>
                        <dd class="t-c" style="border-top:1px solid #ddd"><a href="javascript:;">退出</a></dd>
                    </dl>
                </li>
                <?php } ?>
                <!-- <li class="telephone-box js_telephone_box">
                    <i class="iconfont telephone-icon red">&#xe622;</i>
                    <p class="nav-telephone-number">
                        <a href="TEL:15321353313">15321353313</a>
                    </p>
                    <p><a href="#">029-88661315</a></p>
                    <p><a href="#">029-88661315</a></p>
                    <p><a href="#">029-88661315</a></p>
                    <i class="iconfont right-icon">&#xe66f;</i>
                </li>-->
            </ul>
        </div>
    </header>
    <!-- 头部 -->
    <!--内容部分-->
    <?php $this->beginBody() ?>

    <?= $content ?>

    <?php $this->endBody() ?>
    <!--内容部分-->
    <!--推荐部分-->
    <?php if (Yii::$app->request->getPathInfo() != '' && strpos(Yii::$app->request->getPathInfo(),'user')===false) { ?>
        <?= $this->render('../template/right_aslide'); ?>
    <?php } ?>
    <!--推荐部分-->
    <!--尾部-->
    <footer class="footer">
        <div class="fy-container">
            <p class="footer-link">
                <a href="/">首页</a></li>
                <a href="/service">服务项目</a>
                <a href="/case">精品案例</a>
                <a href="/unit">前端组件</a>
                <a href="/news">新闻动态</a>
                <a href="/about">关于我们</a>
                <a href="/contact">联系我们</a>
            </p>
            <p class="footer-msg">
                <span>Copyright 2008-2019 聚友网络科技有限公司 ALL Rights Reserved. ********************</span>
                <span class="margin-left:30px;">工信部备案号：辽ICP备******号</span>
            </p>
        </div>
    </footer>
    <?= $this->render('../template/public-footer'); ?>
</div>
<script>
    //导航固定动画
    var navAnimate = function () {
        $(window).scroll(function (e) {
            var scrollTop = $(window).scrollTop();
            var topHeight = 100;
            if (location.pathname == '/') {
                topHeight = 600;
            }
            if (scrollTop >= topHeight) {
                $('#header').addClass('active fadeInDown');
            } else {
                $('#header').removeClass('active fadeInDown');
            }
        })
    };

    //我的悬浮弹窗
    $(".js_user_box").mouseenter(function(){
        $(".js_nav_child").show(0).addClass('active');
    }).mouseleave(function(){
        $(".js_nav_child").removeClass('active').hide(300);
    })

    //电话号码悬浮显示
    // var telephoneShowFun = function(){
    //     $('.js_telephone_box').mouseenter(function(){
    //         $(this).css('height','auto');
    //     }).mouseleave(function(){
    //         $(this).css('height','0');
    //     })
    // }
    navAnimate();
    //telephoneShowFun();
</script>
</body>
</html>
<?php $this->endPage() ?>
