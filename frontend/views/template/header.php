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
    <script src="/asset/static/wigdet/layer/layer.js"></script>
</head>
<body>
    <input type="hidden" id="form_csrf" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
    <div class="list-aslide transition">
        <img src="/asset/static/image/logo.png" alt="" class="list-logo">
        <div class="list-aslide-nav">
            <a href="/">返回首页</a>
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'case')!==false ? 'active' : ''?>" href="/case">设计案例</a>
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'news')!==false ? 'active' : ''?>" href="/news">文章动态</a>
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'unit')!==false ? 'active' : ''?>" href="/unit">组件列表</a>
            <!--data-url登录成功后跳转地址 为空时不跳转到任何地方-->
            <a data-url="/user" class="<?=Yii::$app->getUser()->getId() ? 'js_download" href="/user"' : 'login_btn" href="javascript:;"'?>">个人中心</a>
        </div>
        <img src="/asset/static/image/wx-callme.jpg" alt="联系我们" class="erweima">
        <p>扫一扫微信二维码</p>
        <p class="aslide-footer">高端定制 ● 品牌设计</p>
    </div>
    <div class="list-container transition">
        <?=$this->render('../template/nav',compact('data'));?>
        <div class="list-content transition">
            <div class="lc-content">


