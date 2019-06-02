<i class="js_menu_btn none css-menu-btn"></i>
<a class="sub-nav-item upload-btn-widget none" href="/user/info">上传素材</a>
<div class="none qiandao_box" id="qiandao_box">
    <h2 class="qiandao-title">你已连续签到 <span class="js_qiandao_day">0</span>天！</h2>
    <p class="qiandao-desc">签到说明：连续签到3天以上,每天签到都会获得1金币</p>
    <ul class="qiandao-progress js_qiandao_progress clearfix">
        <!--类名为active-->
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <div class="slide_qiandao">
        <div id="slide_box">
            <div id="slide_xbox">
                <div id="btn">
                </div>
            </div>
            <p>请按住滑块，拖动到最右边</p>
        </div>
    </div>
</div>
<div class="left personal-left transition js_personal_nav">
    <div class="fy-userInfo">
        <button class="js_qiandao css_qiandao">签 到</button>
        <div class="userInfo-avatar-box"><img src="//t.cn/RCzsdCq" class="userInfo-avatar"></div>
        <p class="userInfo-name">依鸣 <i class="iconfont userInfo-vip">&#xe68e;</i></p>
    </div>
    <ul class="userInfo-info clearfix">
        <li class="userInfo-item"><span>9999</span><p>金币</p></li>
        <li class="userInfo-item"><span>888</span><p>粉丝</p></li>
        <li class="userInfo-item"><span>100001</span><p>访问量</p></li>
    </ul>
    <ul class="fy-nav-default">
        <li class="fy-nav-item"><a href="/user">我的组件</a></li>
        <li class="fy-nav-item"><a href="/user/dingzhi">我的定制</a></li>
        <li class="fy-nav-item"><a href="/user/collect">我的收藏</a></li>
        <li class="fy-nav-item"><a href="/user/down-history">下载历史</a></li>
        <li class="fy-nav-item"><a href="/user/message">信息通知</a></li>
    </ul>
</div>
<script src="/asset/static/wigdet/script.js"></script>
<script>
    var href = window.location.href;
    $.each($('.fy-nav-item a'),function(index,elem){
        if(href.indexOf($(elem).attr('href')) != -1){
            $('.fy-nav-item a').removeClass('active');
            $(this).addClass('active');
        }
    })

    //签到事件
    $('.js_qiandao').bind('click',function(){
        if(!$(this).hasClass('active')){
            var that = this;
            //执行滑动方法
            layer.open({
                type: 1,
                title: '<h1 style="color:#000;font-size:15px;">签到</h1>',
                anim: 2,
                scrollbar:false,
                offset:["20%"],
                area: ['500px', '300px'],
                skin: 'layui-login layui-xieyi',
                content: $('#qiandao_box'),
                success:function(){
                    slide(function(){
                        var day = parseInt($(".js_qiandao_day").text());
                        day+=1;
                        $(".js_qiandao_day").text(day);
                        $(".js_qiandao_progress li").not('.active').eq(0).addClass('active');
                        layer.msg('签到成功',{icon:1,time:1000},function(){
                            layer.closeAll();
                            $(that).addClass('active').html("已签到"+day+"天");
                        })
                    });
                },
                end:function(){
                    $("#qiandao_box").hide();
                }
            });
        }
    })

    //移动端导航
    $(".js_menu_btn").bind('click',function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $('.js_personal_nav,.user-title').removeClass('active');
        }else{
            $(this).addClass('active');
            $('.js_personal_nav,.user-title').addClass('active');
        }
    })
</script>