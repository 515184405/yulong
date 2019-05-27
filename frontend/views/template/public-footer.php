<!--公共尾部-->
<div class="floated-box">
    <p id="scrollTop" class="floated-item scroll-top"><i class="iconfont transition">&#xe606;</i></p>
    <p class="floated-item wx-icon"><i class="iconfont transition">&#xe65a;</i></p>
    <a target="_blank" href="tencent://Message/?Uin=515184405&amp;websiteName=q-zone.qq.com&amp;Menu=yes" class="floated-item qq-icon"><i class="transition iconfont">&#xe608;</i>
        <div class="floated-tel-content transition">
            <p>点我咨询</p>
        </div>
    </a>
    <div class="floated-item tel-icon"><i class="iconfont transition">&#xe622;</i>
        <div class="floated-tel-content transition">
            <p>建站咨询热线</p>
            <p>153-2135-3313</p>
        </div>
    </div>
</div>

<!--登陆模块-->
<div class="login t-c none" id="user_login">
    <h2 class="login-title"><img src="/asset/static/image/logo2.png" alt=""></h2>
    <p class="login-desc">微信、QQ是两个独立账号信息不互通</p>
    <div class="login-type">
        <a href="#">
            <i class="iconfont transition">&#xe608;</i>
            <p>Q Q 登陆</p>
        </a>
        <a href="#">
            <i class="iconfont transition">&#xe65a;</i>
            <p>微信登陆</p>
        </a>
    </div>
    <p class="layui-row login-bottom">
        <a class="left" href="#">账号登陆</a>
        <span class="right">没有账号？<a class="theme register_btn" href="javascript:;">立即注册</a></span>
    </p>
</div>
<!--登陆模块-->

<!--注册模块-->
<div class="login t-c none" id="user_register">
    <h2 class="login-title"><img src="/asset/static/image/logo2.png" alt=""></h2>
    <p class="login-desc">微信、QQ是两个独立账号信息不互通</p>
    <div class="login-type">
        <a href="#">
            <i class="iconfont transition">&#xe608;</i>
            <p>Q Q 注册</p>
        </a>
        <a href="#">
            <i class="iconfont transition">&#xe65a;</i>
            <p>微信注册</p>
        </a>
    </div>
    <div class="t-c login-bottom">
        <p class="reigster-agree"><i id="iagree_btn" class="theme iconfont">&#xe6a2;</i>我已阅读并接受 <a class="register-advice" target="_blank" href="#">《注册声明》</a>、 <a target="_blank" class="register-advice" href="#">《版权声明》</a></p>
        <span>已有账号？<a class="theme login_btn" href="javascript:;">立即登陆</a></span>
    </div>
</div>
<!--注册模块-->

<!--wap底部导航-->
<div data-animate="slideInUp" id="js_other_link" class="other-link none">
    <a class="animated" href="/service">服务</a>
    <a class="animated delay-01s" href="/about">关于</a>
    <a class="animated delay-02s" href="">合作</a>
    <a class="animated delay-03s" href="/contact">联系</a>
</div>
<div class="wap-list-nav none">
    <a class="<?= Yii::$app->request->getPathInfo()=='' ? 'active' : ''?>" href="/"><i class="iconfont">&#xe603;</i>首页</a>
    <a class="<?= strpos(Yii::$app->request->getPathInfo(),'case')!==false ? 'active' : ''?>" href="/case"><i class="iconfont">&#xe64a;</i>案例</a>
    <a id="js_other_icon" class="icon-other" href="javascript:;"><i class="iconfont transition">&#xe794;</i></a>
    <a class="<?= strpos(Yii::$app->request->getPathInfo(),'unit')!==false ? 'active' : ''?>" href="/unit"><i class="iconfont">&#xe617;</i>组件</a>
    <a class="<?= strpos(Yii::$app->request->getPathInfo(),'news')!==false ? 'active' : ''?>" href="/news"><i class="iconfont">&#xe681;</i>文章</a>
</div>

<script>
    //滚动置顶
    $('#scrollTop').click(function(){
        $('body,html,.list-container').animate({
            'scrollTop' : 0
        },300);
    })
    //微信弹框
    $(".wx-icon").click(function(){
        layer.open({
            type: 1,
            anim: 2,
            shade: false,
            title: false, //不显示标题
            content: '<img style="max-width: 100%;" src="/asset/static/image/wx-callme.jpg" alt="">', //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        });
    })
    //底部移动端导航其他链接事件
    $("#js_other_icon").click(function(){
        var iconfont = $(this).find('.iconfont');
        var animateType = $("#js_other_link").data('animate');
        if(iconfont.hasClass('active')){
            iconfont.removeClass('active');
            $("#js_other_link").removeClass('active').find('a').removeClass(animateType);
        }else{
            iconfont.addClass('active');
            $("#js_other_link").addClass('active').find('a').addClass(animateType);
        }
    });

    //弹出登陆
    $(".login_btn").click(function() {
        layer.closeAll();
        layer.open({
            type: 1,
            title: ' ',
            area: ['500px', '380px'],
            skin: 'layui-login', //没有背景色
            anim: 4,
            content: $('#user_login'),
            end: function () {
                $('#user_login').hide();
            }
        });
    })
    /*弹出注册*/
    $(".register_btn").click(function(){
        layer.closeAll();
        layer.open({
            type: 1,
            title: ' ',
            area: ['550px','400px'],
            skin: 'layui-login', //没有背景色
            anim: 4,
            content: $('#user_register'),
            end:function(){
                $('#user_register').hide();
            }
        });
    })

    //必须统一才能注册
    $('#iagree_btn').click(function(){
        layer.msg('登录/注册必须同意该协议',{
            icon:"4"
        })
    })


</script>