<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= \yii\helpers\Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="/asset/static/css/default.css">
    <link rel="stylesheet" href="/asset/static/css/list-layout.css">
    <script src="/asset/static/wigdet/jquery.min.js"></script>
</head>
<body>
    <div class="list-aslide transition">
        <img src="/asset/static/image/logo.png" alt="" class="list-logo">
        <div class="list-aslide-nav">
            <a href="/">返回首页</a>
            <a class="active" href="#">设计案例</a>
            <a href="#">文章动态</a>
        </div>
        <img src="http://www.1000zhu.com/images/wechat_code.jpg" alt="" class="erweima">
        <p>扫一扫微信二维码</p>
    </div>
    <div class="list-container transition">
        <div class="list-header transition clearfix">
            <i class="iconfont aslide-switch left"></i>
            <?=$this->render('../template/nav');?>
        </div>
        <div class="list-content transition">
            <div class="lc-content">

