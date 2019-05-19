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
<div class="none" id="wx-icon-box">
    <img style="max-width: 100%;" src="/asset/static/image/wx-callme.jpg" alt="">
</div>

<!--wap底部导航-->
<div data-animate="slideInUp" id="js_other_link" class="other-link">
    <a class="animated" href="">服务</a>
    <a class="animated delay-01s" href="">关于</a>
    <a class="animated delay-02s" href="">合作</a>
    <a class="animated delay-03s" href="">联系</a>
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
        $('body,html').animate({
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
            content: $('#wx-icon-box'), //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
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
    })
</script>