<!--公共尾部-->
<a id="website_btn" href="javascript:;" class="website-btn">
    建站咨询
</a>
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
<!--    <p class="login-desc">用户登录</p>-->
    <div class="login-type">
        <a href="#">
            <i class="iconfont transition">&#xe608;</i>
            <p>Q Q 登陆</p>
        </a>
        <a href="#">
            <i class="iconfont transition">&#xe610;</i>
            <p>新浪登陆</p>
        </a>
    </div>
    <div class="t-c login-bottom">
        <p class="reigster-agree"><i class="iagree_btn theme iconfont">&#xe6a2;</i>我已阅读并接受 <a target="_blank" class="register-advice" href="javascript:;">《注册声明》与《版权声明》</a></p>
        <span >没有账号？<a class="theme register_btn" href="javascript:;">立即注册</a></span>
    </div>
</div>
<!--登陆模块-->

<!--注册模块-->
<div class="login t-c none" id="user_register">
    <h2 class="login-title"><img src="/asset/static/image/logo2.png" alt=""></h2>
<!--    <p class="login-desc">用户注册</p>-->
    <div class="login-type">
        <a href="#">
            <i class="iconfont transition">&#xe608;</i>
            <p>Q Q 注册</p>
        </a>
        <a href="#">
            <i class="iconfont transition">&#xe610;</i>
            <p>新浪注册</p>
        </a>
    </div>
    <div class="t-c login-bottom">
        <p class="reigster-agree"><i class="iagree_btn theme iconfont">&#xe6a2;</i>我已阅读并接受 <a target="_blank" class="register-advice" href="javascript:;">《注册声明》与《版权声明》</a></p>
        <span>已有账号？<a class="theme login_btn" href="javascript:;">立即登陆</a></span>
    </div>
</div>
<!--注册模块-->
<!--协议模块-->
<div class="xieyi none">
    <h2>注册声明</h2>
    <p>一、用户注册、登陆，视为接受本协议的约束。</p>
    <p>二、用户承诺遵守国家的法律法规及部门规章</p>
    <p>三、用户承诺遵守“聚友团队”的知识产权政策.</p>
    <p>四、站内插件用于行业交流、学习。</p>
    <p>五、用户侵犯第三人的知识产权，由该用户承担全部法律责任。</p>

    <h2>版权声明</h2>
    <p>聚友团队（www.yu313.cn）站内所有涉及插件及代码由会员或站主上传而来，聚友团队不拥有会员上传的插件及代码的版权</p>
    <p>聚友团队作为网络服务提供者，对非法转载，盗版行为的发生不具备充分的监控能力。但是当版权拥有者提出侵权指控并出示充分的版权证明材料时，聚友团队负有移除盗版和非法转载作品以及停止继续传播的义务。聚友团队在满足前款条件下采取移除等相应措施后不为此向原发布人承担违约责任或其他法律责任，包括不承担因侵权指控不成立而给原发布人带来损害的赔偿责任。</p>
    <p>如果版权拥有者发现自己作品被侵权，请及时向聚友团队提出权利通知，并将姓名、电话、身份证明、权属证明、具体链接（URL）及详细侵权情况描述发往版权举报专用通道，聚友团队在收到相关举报文件后，在3个工作日内移除相关涉嫌侵权的内容</p>
    <p>QQ：515184405（周一到周五，9：30-18:00）</p>
</div>
<!--协议模块-->


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
    });

    //建站留言
    $("#website_btn").click(function(){
        layer.open({
            type: 2,
            title: '建站咨询',
            area: ['400px','500px'],
            skin: 'layui-login  layui-xieyi', //没有背景色
            anim: 4,
            content: '/site/website'
        });
    })
    //微信弹框
    $(".wx-icon").click(function(){
        layer.open({
            type: 1,
            anim: 2,
            shade: false,
            title: false, //不显示标题
            content: '<img style="width: 250px;height:250px;" src="/asset/static/image/wx-callme.jpg" alt="">', //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
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
            area: ['500px', '400px'],
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
            area: ['500px','400px'],
            skin: 'layui-login', //没有背景色
            anim: 4,
            content: $('#user_register'),
            end:function(){
                $('#user_register').hide();
            }
        });
    })

    //必须统一才能注册
    $('.iagree_btn').click(function(){
        layer.msg('登录/注册必须同意该协议',{
            icon:"4"
        })
    })

    //用户协议
    $('.register-advice').click(function(){

        layer.open({
            type: 1,
            title: '<h1 style="color:#000;font-size:15px;">注册声明与版权声明</h1>',
            anim: 4,
            scrollbar:false,
            area: ['500px', '80%'],
            skin: 'layui-login layui-xieyi', //没有背景色
            content: $('.xieyi'),
            end:function(){
                $('.xieyi').hide();
            }
        });

    })




</script>