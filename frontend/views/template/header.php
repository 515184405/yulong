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
    <div class="list-aslide">
        <img src="/asset/static/image/logo.png" alt="" class="list-logo">
        <div class="list-aslide-nav">
            <a href="#">返回首页</a>
            <a class="active" href="#">设计案例</a>
            <a href="#">文章动态</a>
        </div>
        <img src="http://www.1000zhu.com/images/wechat_code.jpg" alt="" class="erweima">
        <p>扫一扫微信二维码</p>
    </div>
    <div class="list-container">
        <div class="list-header clearfix">
            <i class="iconfont aslide-switch left"></i>
            <div class="list-header-nav left">
                    <a class="lhn-item active">全部</a>
                    <a class="lhn-item">教育</a>
                    <a class="lhn-item">旅游</a>
                    <a class="lhn-item">房产</a>
                    <a class="lhn-item">金融</a>
                    <a class="lhn-item">科技</a>
                    <a class="lhn-item">医疗</a>
                    <a class="lhn-item">制造</a>
                    <a class="lhn-item">农业</a>
                    <a class="lhn-item">媒体</a>
                    <a class="lhn-item">其他</a>

            </div>
        </div>
    </div>
</body>
</html>