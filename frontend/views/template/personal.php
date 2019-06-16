<?php
$sign = $this->params['sign'];
/*用户信息*/
$userInfo = $this->params['userInfo'];
//今天是否签到
$time = getdate(time());
$lastTime = getdate(strtotime($sign['last_change_time']));
//今天是否签到
function isDiffDays($last_date, $this_date)
{

    if (($last_date['year'] === $this_date['year']) && ($this_date['yday'] === $last_date['yday'])) {
        return true;
    } else {
        return false;
    }
}
//是否连续签到
function isStreakDays($last_date,$this_date){
//        var_dump($last_date);die;
    if(($last_date['year']===$this_date['year'])&&($this_date['yday']-$last_date['yday']===1)){
        return true;
    }elseif(($this_date['year']-$last_date['year']===1)&&($last_date['mon']-$this_date['mon']=11)&&($last_date['mday']-$this_date['mday']===30)){
        return true;
    }else{
        return false;
    }
}

$isStreakSign = isStreakDays($lastTime, $time); //是否连续签到
$isTodaySign = isDiffDays($lastTime, $time); //今天是否签到
?>
<i class="js_menu_btn none css-menu-btn"></i>
<a class="sub-nav-item upload-btn-widget none" href="/user/info">上传素材</a>
<div class="none qiandao_box" id="qiandao_box">
    <h2 class="qiandao-title">你已连续签到 <span class="js_qiandao_day"><?= ($isStreakSign || $isTodaySign) ? $sign['sign_count'] : 0 ?></span>天！</h2>
    <p class="qiandao-desc">签到说明：连续签到3天以上,每天签到都会获得1金币</p>
    <ul class="qiandao-progress js_qiandao_progress clearfix">
        <!--类名为active-->
        <li class="<?= ($isStreakSign || $isTodaySign) ? ($sign['sign_count'] >= 1 ? 'active' : '') : '' ?>"></li>
        <li class="<?= ($isStreakSign || $isTodaySign) ? ($sign['sign_count'] >= 2 ? 'active' : '') : '' ?>"></li>
        <li class="<?= ($isStreakSign || $isTodaySign) ? ($sign['sign_count'] >= 3 ? 'active' : '') : '' ?>"></li>
    </ul>
    <div class="slide_qiandao">
        <?php if ($isTodaySign) { ?>
            <p>今天已签到，明天再来吧...</p>
        <?php } else { ?>
            <div id="slide_box">
                <div id="slide_xbox">
                    <div id="btn">
                    </div>
                </div>
                <p>请按住滑块，拖动到最右边签到</p>
            </div>
        <?php } ?>
    </div>
</div>
<div class="left personal-left transition js_personal_nav">
    <div class="fy-userInfo">
        <?php if($isTodaySign){ ?>
            <button class="js_qiandao active css_qiandao">已连续签到<?=$sign['sign_count'] ?>天</button>
        <?php }else{ ?>
            <button class="js_qiandao css_qiandao">签 到</button>
        <?php } ?>
        <div class="userInfo-avatar-box"><img src="<?=$userInfo['avatar']?>" class="userInfo-avatar"></div>
        <p class="userInfo-name"><?=$userInfo['username']?><i class="iconfont userInfo-vip">&#xe68e;</i></p>
    </div>
    <ul class="userInfo-info clearfix">
        <li class="userInfo-item"><span>9999</span>
            <p>金币</p></li>
        <li class="userInfo-item"><span>888</span>
            <p>粉丝</p></li>
        <li class="userInfo-item"><span>100001</span>
            <p>访问量</p></li>
    </ul>
    <ul class="fy-nav-default">
        <li class="fy-nav-item"><a href="/user">我的组件</a></li>
        <li class="fy-nav-item"><a href="/user/dingzhi">我的定制</a></li>
        <li class="fy-nav-item"><a href="/user/collect">我的收藏</a></li>
        <li class="fy-nav-item"><a href="/user/down-history">下载历史</a></li>
        <li class="fy-nav-item"><a href="/user/guan-zhu">我的关注</a></li>
    </ul>
</div>
<script src="/asset/static/wigdet/script.js"></script>
<script>
    var href = window.location.href;
    $.each($('.fy-nav-item a'), function (index, elem) {
        if (href.indexOf($(elem).attr('href')) != -1) {
            $('.fy-nav-item a').removeClass('active');
            $(this).addClass('active');
        }
    })

    var isTodaySign = '<?=$isTodaySign?>';

    //签到事件
    $('.js_qiandao').bind('click', function () {
        var that = this;
        //执行滑动方法
        layer.open({
            type: 1,
            title: '<h1 style="color:#000;font-size:15px;">签到</h1>',
            anim: 2,
            scrollbar: false,
            offset: ["20%"],
            area: ['500px', '300px'],
            skin: 'layui-login layui-xieyi',
            content: $('#qiandao_box'),
            success: function () {
                if (isTodaySign) {
                    return false;
                }
                slide(function () {
                    var csrfName = $("#form_csrf").attr('name');
                    var csrfVal = $("#form_csrf").val();
                    var data = {};
                    data[csrfName] = csrfVal;
                    $.post('/user/sign', data, function (res) {
                        if (res.code == 100000) {
                            var day = parseInt($(".js_qiandao_day").text());
                            day += 1;
                            $(".js_qiandao_day").text(day);
                            $(".js_qiandao_progress li").not('.active').eq(0).addClass('active');
                            layer.msg(res.message, {icon: 1, time: 1000}, function () {
                                layer.closeAll();
                                isTodaySign = true;
                                $(that).addClass('active').html("已连续签到" + day + "天");
                                $('.slide_qiandao').html('<p>今天已签到，明天再来吧...</p>');
                            })
                        } else if (res.code == 100001) {
                            layer.msg(res.message, {icon: 4, time: 1000}, function () {
                                layer.closeAll();
                            });
                        } else {
                            layer.msg('签到失败', {icon: 5, time: 1000}, function () {
                                layer.closeAll();
                            });
                        }
                        ;
                    }, 'json');

                });
            },
            end: function () {
                $("#qiandao_box").hide();
            }
        });
    })

    //移动端导航
    $(".js_menu_btn").bind('click', function () {
        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.js_personal_nav,.user-title').removeClass('active');
        } else {
            $(this).addClass('active');
            $('.js_personal_nav,.user-title').addClass('active');
        }
    })
</script>