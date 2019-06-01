<i class="js_menu_btn none css-menu-btn"></i>
<a class="sub-nav-item upload-btn-widget none" href="/user/info">上传素材</a>
<div class="left personal-left transition js_personal_nav">
    <div class="fy-userInfo">
        <div class="userInfo-avatar-box"><img src="//t.cn/RCzsdCq" class="userInfo-avatar"></div>
        <p class="userInfo-name">依鸣 <i class="iconfont userInfo-vip">&#xe68e;</i></p>
        <ul class="userInfo-info">
            <li class="userInfo-item">我的金币：<span>9999</span></li>
            <li class="userInfo-item">我的粉丝：<span>888</span></li>
            <li class="userInfo-item">总访问量：<span>100001</span></li>
        </ul>
    </div>
    <ul class="fy-nav-default">
        <li class="fy-nav-item"><a class="active" href="/user">我的组件</a></li>
        <li class="fy-nav-item"><a href="/user/dingzhi">我的定制</a></li>
        <li class="fy-nav-item"><a href="/user/collect">我的收藏</a></li>
        <li class="fy-nav-item"><a href="/user/down-history">下载历史</a></li>
        <li class="fy-nav-item"><a href="/user/message">信息通知</a></li>
    </ul>
</div>
<script>
    var href = window.location.href;
    $.each($('.fy-nav-item a'),function(index,elem){
        if(href.indexOf($(elem).attr('href')) != -1){
            $('.fy-nav-item a').removeClass('active');
            $(this).addClass('active');
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