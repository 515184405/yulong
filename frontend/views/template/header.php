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
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'case')!==false ? 'active' : ''?>" href="/case">设计案例</a>
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'news')!==false ? 'active' : ''?>" href="/news">文章动态</a>
            <a class="<?= strpos(Yii::$app->request->getPathInfo(),'unit')!==false ? 'active' : ''?>" href="/unit">组件列表</a>
        </div>
        <img src="/asset/static/image/wx-callme.jpg" alt="联系我们" class="erweima">
        <p>扫一扫微信二维码</p>
        <a class="QQ-box" href="tencent://message/?Site=baidu.com&uin=515184405&Menu=yes"><i class="iconfont QQ">&#xe74d;</i>515184405</a>
        <a class="tel-box" href="TEL:15321353313"><i class="iconfont QQ">&#xe622;</i>15321353313</a>
        <p class="aslide-footer">高端定制 ● 品牌设计</p>
    </div>
    <div class="list-container transition">
        <?=$this->render('../template/nav',compact('data'));?>
        <div class="list-content transition">
            <div class="lc-content">

