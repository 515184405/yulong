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
    <link rel="stylesheet" href="/asset/static/css/default.css">
    <script src="/asset/static/wigdet/jquery.min.js"></script>
</head>
<body>
<div class="wrapper">
    <!-- 头部 -->
    <header id="header" class="header transition">
        <div class="fy-container clearfix">
            <div class="left logo">
                <img src="/asset/static/image/logo-fff.png" alt="网站logo">
            </div>
            <ul id="nav_ul" class="nav-ul right">
                <li><a href="/">首页</a></li>
                <li><a href="#">关于</a></li>
                <li><a href="#">服务</a></li>
                <li><a href="/case">精品案例</a></li>
                <li><a href="/news">新闻动态</a></li>
                <li><a href="#">合作</a></li>
                <li><a href="#">联系</a></li>
                <li class="telephone-box js_telephone_box">
                    <i class="iconfont telephone-icon red">&#xe622;</i>
                    <p class="nav-telephone-number">
                        <a href="#">029-88661315</a>
                    </p>
                    <p><a href="#">029-88661315</a></p>
                    <p><a href="#">029-88661315</a></p>
                    <p><a href="#">029-88661315</a></p>
                    <i class="iconfont right-icon">&#xe66f;</i>
                </li>
            </ul>
        </div>
    </header>
    <!-- 头部 -->
    <!--内容部分-->
    <?php $this->beginBody() ?>

    <?= $content ?>

    <?php $this->endBody() ?>
    <!--内容部分-->
    <!--尾部-->
    <footer class="footer">
        <div class="fy-container">
            <p class="footer-link">
                <a href="#">关于我们</a> |
                <a href="#">服务项目</a> |
                <a href="#">网站案例</a> |
                <a href="#">建站常识</a> |
                <a href="#">常见问题</a> |
                <a href="#">联系方式</a>
            </p>
            <p class="footer-msg">
                <span>Copyright 2008-2019 西安凡高网络科技有限公司 ALL Rights Reserved. 陕西·西安高新区唐延路25号银河产业园3单元24层</span>
                <span class="margin-left:30px;">工信部备案号：陕ICP备14002553号</span>
            </p>
        </div>
    </footer>
    <!--尾部-->

</div>
<script>
    //导航固定动画
    var navAnimate = function(){
        $(window).scroll(function(e){
            var scrollTop = $(window).scrollTop();
            var topHeight = 100;
            if(location.pathname == '/'){
                topHeight = 600;
            }
            console.log(location.pathname)
            if(scrollTop >= topHeight){
                $('#header').addClass('active fadeInDown');
            }else{
                $('#header').removeClass('active fadeInDown');
            }
        })
    };

    //电话号码悬浮显示
    var telephoneShowFun = function(){
        $('.js_telephone_box').mouseenter(function(){
            $(this).css('height','auto');
        }).mouseleave(function(){
            $(this).css('height','0');
        })
    }
    navAnimate();
    telephoneShowFun();
</script>
</body>
</html>
<?php $this->endPage() ?>
