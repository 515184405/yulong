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
</script>