<?php $userInfo = $this->params['userInfo']; ?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>聚友团队后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/asset/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/asset/style/admin.css" media="all">
    <script src="/asset/layui/layui.js"></script>
</head>
<body class="layui-layout-body">

<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="<?= Yii::$app->params['frontend_url']; ?>" target="_blank" title="前台">
                        <i class="layui-icon layui-icon-website"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search.html?keywords=">
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">

                <li class="layui-nav-item" lay-unselect>
                    <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
                        <i class="layui-icon layui-icon-notice"></i>

                        <!-- 如果有新消息，则显示小圆点 -->
                        <span class="layui-badge-dot"></span>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="theme">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="note">
                        <i class="layui-icon layui-icon-note"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;">
                        <cite><?=Yii::$app->view->params['userInfo']['username']?></cite>
                    </a>
                    <dl class="layui-nav-child">
<!--                        <dd><a lay-href="set/user/info.html">基本资料</a></dd>-->
                        <dd><a href="/user/info?id=<?=Yii::$app->user->getId();?>">修改密码 </a></dd>
                        <hr>
                        <dd style="text-align: center;"><a href="/site/logout">退出</a></dd>
                    </dl>
                </li>

                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                    <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
            </ul>
        </div>

        <!-- 侧边菜单 -->
        <div id="layui-side-menu" class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo" lay-href="home/console.html">
                    <span><img style="width: 120px;" src="/asset/image/logo-fff.png" alt=""></span>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                    <li data-name="home" class="layui-nav-item">
                        <a href="/console" class="" lay-tips="控制台" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>控制台</cite>
                        </a>
                    </li>
                    <li data-name="home" class="layui-nav-item">
                        <a href="/banner"  class="" lay-tips="轮播管理" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>轮播管理</cite>
                        </a>
                    </li>
                    <li data-name="home" class="layui-nav-item">
                        <a href="/cases"  class="" lay-tips="案例管理" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>案例管理</cite>
                        </a>
                    </li>
                    <li data-name="home" class="layui-nav-item">
                        <a href="/widget"  class="" lay-tips="组件管理" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>组件管理</cite>
                        </a>
                    </li>
                    <li data-name="home" class="layui-nav-item">
                        <a href="/news" lay-tips="文章管理" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>文章管理</cite>
                        </a>
                    </li>
                    <li data-name="home" class="layui-nav-item">
                        <a href="/team" lay-tips="人员管理" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>人员管理</cite>
                        </a>
                    </li>
                    <?php if($userInfo['type'] == 1){ ?>
                    <li data-name="home" class="layui-nav-item">
                        <a href="javascript:;" lay-tips="用户管理" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>用户管理</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd>
                                <a href="/user">用户列表</a>
                            </dd>
                            <dd >
                                <a href="/user/info">添加用户 </a>
                            </dd>
                            <dd >
                                <a href="/user/info?id=<?=Yii::$app->user->getId();?>">修改密码 </a>
                            </dd>
                        </dl>
                    </li>
                    <?php }else{ ?>
                    <li data-name="home" class="layui-nav-item">
                        <a href="/user/info?id=<?=Yii::$app->user->getId();?>" lay-tips="修改密码" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>修改密码</cite>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-fluid layui-show">
                <!--内容部分-->
                <?php $this->beginBody() ?>
                <div class="wrapper">
                    <?= $content ?>
                </div>
                <?php $this->endBody() ?>
                <!--内容部分-->
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
</div>
</body>
</html>
<?php $this->endPage() ?>


