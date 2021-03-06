<?php $unit = $data['data']; ?>
<?php $this->title='313组件库 - '.$unit['title']; ?>
<?php $this->keywords=$unit['desc'].',313组件库'; ?>
<?php
    $description = $unit['desc'].',313组件库';
    if(!$description){
        $description = '313组件库，专业从事网站建设.高品质建站服务.丰富的网站建设经验,响应式网站设计、网站制作开发';
    }
    $this->description = $description;
?>
<?php $userUnit = isset($data['data']['user']) ? $data['data']['user'] : []; ?>
<?= $this->render('../template/header',compact('data'));?>

<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css<?=Yii::$app->params['static_number']?>">
<link rel="stylesheet" href="/asset/static/css/item.css<?=Yii::$app->params['static_number']?>">
<link rel="stylesheet" href="/asset/static/css/pinglun.css<?=Yii::$app->params['static_number']?>">
    <style>
        .js_news_recommend{
            top:235px;
        }
        .unit-items .unit-page-box{
            padding-bottom:10px;
        }
        iframe{
            width:100%;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .ie-img {
            max-width: 770px;
            display: block;
            margin: 30px auto;
            width: 90%;
            border-radius: 5px;
            margin-bottom: 25px;
            border: 1px solid #ddd;
        }
    </style>
    <input type="hidden" id="scrope-value" value="<?=isset($data['scope']) ? $data['scope'] : 0?>">
<div class="news-items unit-items">
        <h2 class="content-title clearfix"><span class="left js_widget_title"><?=$unit['title']?></span><div id="share" class="share-box right"></div></h2>
        <div class="content-info">
            <?php if(!($unit['source'] == '无' || $unit['source'] == null)){?>
            <span>来 源：<?=$unit['source']?></span>
            <?php } ?>
            <span>发布日期：<?=date('Y-m-d h:m:s',$unit['create_time'])?></span>
            <span>浏览次数：<?=$unit['look']?></span>
            <span>下载量：<?=$unit['down_count']?></span>
        </div>
        <div class="banner-box">
            <?php if($unit['is_show_img'] == 0){ ?>
            <img  style="background-color:rgba(<?=rand(0,255)?>,<?=rand(0,255)?>,<?=rand(0,255)?>,0.4);" src="<?=Yii::$app->params['backend_url'].$unit['banner_url']?>" alt="">
            <?php }else{ ?>
                <iframe style="background-color:rgba(<?=rand(0,255)?>,<?=rand(0,255)?>,<?=rand(0,255)?>,0.4);" id="iframe" width="100%" src="<?=Yii::$app->params['static_url']?>/<?=$unit['id']?>/<?=$unit['enter_file']?>" frameborder="0"></iframe>
            <?php } ?>

        </div>
        <?= $unit['ie'] == 0 ? '':'<img class="ie-img" src="/asset/static/image/ie'.$unit["ie"].'.jpg" alt="浏览器兼容性">'?>
        <div class="unit-btn-box">
            <?php $upload_file = isset($_GET['upload_file']) ? $_GET['upload_file'] : ''; if($upload_file){ ?>
                <a class="fy-btn fy-btn-success" target="_blank" href="<?=Yii::$app->params['upload_url']?>/<?=$unit['id']?>/<?=$unit['upload_enter_file']?>">查看演示(upload)</a>
            <?php }else{ ?>
                <a class="fy-btn fy-btn-success js_look_widget" data-uid="<?=$unit['u_id']?>" target="_blank" href="/unit/demo/yanshi<?=$unit['id']?>">查看演示</a>
            <?php } ?>
            <a target="_blank" class="js_look_btn"></a>
            <?php if($unit['website']){ ?>
            <a class="fy-btn fy-btn-primary" target="_blank" href="<?=$unit['website']?>">官网地址</a>
            <?php } ?>
            <?php if($unit['is_down'] == 0){ ?>
            <a data-id="<?=$unit['id'] ?>" class="fy-btn fy-btn-danger <?=Yii::$app->getUser()->getId() ? 'js_download"' : 'login_btn" href="javascript:;"'?> target="_blank">立即下载</a>
            <?php } ?>
        </div>
        <div class="new-user-tips"><i class="iconfont">&#xe6dc;</i><b>新用户注册立送5积分哦...</b></div>
        <div class="unit-desc layui-elem-quote">
            <span class="theme">插件描述：</span><?=$unit['desc'];?>
        </div>
        <?php if($unit['upload_txt']){ ?>
        <div class="unit-rule">
            <h2 class="unit-rule-title">最新更新:</h2>
            <div class="unit-rule-content">
                <?=$unit['upload_txt'];?>
            </div>
        </div>
        <?php } ?>
        <div class="unit-rule">
            <h2 class="unit-rule-title">组件介绍:</h2>
            <div class="unit-rule-content">
                <?=$unit['rule'];?>
            </div>
        </div>
        <div class="unit-rule">
            <div class="unit-rule-content" style="font-size: 10px;color:#aaa">
                如有侵权，请联系站主删除
            </div>
        </div>
    <div class="clearfix btn-box unit-page-box">
        <a <?=is_null($data['prev']) ? '' : 'href="/unit/item/'.$data['prev']['id'].'"' ?> class="btn-prev left"><i class="iconfont">&#xe604;</i><?=is_null($data['prev']) ? '没有了...' : $data['prev']['title'] ?></a>
        <a <?=is_null($data['next']) ? '' : 'href="/unit/item/'.$data['next']['id'].'"' ?> class="btn-next right"><?=is_null($data['next']) ? '没有了...' : $data['next']['title'] ?><i class="iconfont">&#xe607;</i></a>
    </div>
    <div class="unit-rule">
        <h2 class="unit-rule-title t-c pinglun-title">项目讨论（<?=$data['pinglunCount']?>）</h2>
    </div>
    <!--评论主体-->
    <?php foreach ($data['pinglun'] as $text) { ?>
        <div class="commentAll pinglun-first" data-pinglun="<?=$text['id']?>">
            <!--回复区域 begin-->
            <div class="comment-show">
                <div class="comment-show-con clearfix">
                    <div class="comment-show-con-img pull-left"><img src="<?=$text['avatar'];?>" alt="头像"></div>
                    <div class="comment-show-con-list pull-left clearfix">
                        <div class="pl-text clearfix">
                            <a href="#" class="comment-size-name"><b><?=$text['username'];?></b></a>
                        </div>
                        <div class="date-dz">
                            <span class="date-dz-left pull-left comment-time"><?=$text['create_time'];?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment-content">
                <?=$text['content']?>
                <?php if(isset($text['child'])){
                    foreach ($text['child'] as $item) { ?>
                        <div class="commentAll sub-content">
                    <!--回复区域 begin-->
                    <div class="comment-show">
                        <div class="comment-show-con clearfix">
                            <div class="comment-show-con-img pull-left"><img src="<?=$item['avatar']; ?>" alt="头像"></div>
                            <div class="comment-show-con-list pull-left clearfix">
                                <div class="pl-text clearfix">
                                    <a href="#" class="comment-size-name"><b><?=$item['username']; ?></b></a>
                                </div>
                                <div class="date-dz">
                                    <span class="date-dz-left pull-left comment-time"><?=$item['create_time']; ?></span>
                                    <div class="date-dz-right pull-right comment-pl-block">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-content">
                        <?=$item['content']?>
                    </div>
                </div>
                <?php  }} ?>
                <div class="date-dz-right comment-pl-block">
                    <a href="javascript:;" class="date-dz-pl js_add_pinglun pl-hf">回复</a>
                </div>
            </div>
        </div>
    <?php } ?>
    <!--回复区域 end-->
    <!--评论区域 begin-->
    <div class="reviewArea flex-text-wrap clearfix">
        <textarea class="content comment-input" rows="3" placeholder="Please enter a comment&hellip;"></textarea>
        <a  data-widgetid="<?=$unit['id'] ?>" data-uid="<?=$unit['u_id']?>" href="javascript:;" class="plBtn <?=Yii::$app->getUser()->getId() ? 'js_pinglun"' : 'login_btn" href="javascript:;"'?>">评论</a>
    </div>
    <!--评论区域 end-->
    <!--评论主体-->
</div>

<div class="unit-user news-recommend">
    <div class="clearfix unit-user-info">
        <img class="unit-user-avatar" src="<?=$unit['userInfo']['avatar']?>" alt="">
        <h2 class="unit-user-name overflow-text"><?=$unit['userInfo']['username']?></h2>
        <p class="unit-user-dress overflow-text"><?=$unit['userInfo']['province']?> - <?=$unit['userInfo']['city']?></p>
    </div>
    <?php if(Yii::$app->getUser()->getId()){ ?>
         <?php if(!empty($userUnit) && $userUnit['guanzhu']){ ?>
            <p class="unit-user-btn">
                <button data-id="<?=$unit['u_id']?>" id="guanzhu" class="fy-btn fy-btn-primary"><span id="guanzhu_text">√ 已关注</span>（<span id="guanzhu_number"><?=$userUnit['guanzhuCount']?></span>）</button>
            </p>
        <?php }else{ ?>
            <p class="unit-user-btn">
                <button data-id="<?=$unit['u_id']?>" id="guanzhu" class="fy-btn fy-btn-primary"><span id="guanzhu_text">关注作者</span>（<span id="guanzhu_number"><?=$userUnit['guanzhuCount']?></span>）</button>
            </p>
        <?php } ?>
        <?php if(!empty($userUnit) && $userUnit['collect']){ ?>
            <p class="unit-user-btn">
                <button data-id="<?=$unit['id']?>" id="shoucang" class="fy-btn fy-btn-success"><span id="shoucang_text">√ 已收藏</span>（<span id="shoucang_number"><?=$userUnit['collectCount']?></span>）</button>
            </p>
        <?php }else{ ?>
            <p class="unit-user-btn">
                <button data-id="<?=$unit['id']?>" id="shoucang" class="fy-btn fy-btn-success"><span id="shoucang_text">收藏插件</span>（<span id="shoucang_number"><?=$userUnit['collectCount']?></span>）</button>
            </p>
        <?php } ?>
    <?php }else{ ?>
        <p class="unit-user-btn">
            <button class="fy-btn fy-btn-primary login_btn"><span id="guanzhu_text">关注作者</span>（<span id="guanzhu_number"><?=$userUnit['guanzhuCount']?></span>）</button>
        </p>
        <p class="unit-user-btn">
            <button class="fy-btn fy-btn-success login_btn"><span id="shoucang_text">收藏插件</span>（<span id="shoucang_number"><?=$userUnit['collectCount']?></span>）</button>
        </p>
    <?php } ?>
</div>
<?= $this->render('../template/right_aslide',compact('data'));?>

<script src="/asset/static/wigdet/share/jquery.share.min.js"></script>
<script>

    //设置iframe高度
    setTimeout(function(){
        setIframeHeight();
    },200)
    function setIframeHeight(){
        if($("#iframe").length == 0) return false;
        var width = $("#iframe")[0].clientWidth;  //未知宽度
        var scale = 0.75;
        $("#iframe").css('height',width*scale);
    }
    window.onresize = function () {
        setIframeHeight();
    }

    //分享功能
    $('#share').share({sites: ['qzone', 'qq', 'weibo','wechat']});
    // 动态设置右侧高度固定右侧
    //  function setRightHeight(){
    //      var winH = $(window).height();
    //      var top = 75;
    //      $('.js_news_items,.js_news_recommend').css('height',winH - top);
    //  }
    // setRightHeight();

    var csrfName = $("#form_csrf").attr('name');
    var csrfVal = $("#form_csrf").val();

    //下载
    $(".js_download").click(function(){
        if($(this).attr('href')){
            return;
        }
        var href = $(this).data('src');
        $(this).attr('href',href);
        var data = {
            'widget_id' : $(this).data('id'), //项目id
            'down_title' : $('.js_widget_title').html(), //项目标题
        };
        data[csrfName] = csrfVal;

        <!--下载主体-->
        var downBox =  '<div id="down-box" class="down-box">\
                            <div class="down-scrope-box"><p>下载所需积分</p><span class="down-scrope"><?=isset($unit["down_money"]) ? $unit["down_money"] : 0?></span></div>\
                            <div class="clearfix down-info">\
                                <div class="left"><span class="user-scrope">'+$('#scrope-value').val()+'</span><p>积分余额</p></div>\
                                <div class="left"><span class="down-count"><?=$unit["down_count"]?></span><p>下载次数</p></div>\
                            </div>\
                            <div class="down-danger-title"><b>注意：</b></div>\
                            <div class="down-tips">1、下载过一次后，往后再次下载此组件免积分</div>\
                            <div class="down-tips">2、新用户注册立送5积分哦...</div>\
                            <div class="down-tips">3、点击当前弹框中的立即下载后积分就已经扣除，出现下载框取消后不返还积分</div>\
                    </div>';

        //弹出确认框
        layer.open({
            type: 1,
            title: "<?=$unit['title']?>",
            area: ['450px'],
            offset: 'auto',
            skin: 'layui-login', //没有背景色
            content: downBox,
            btn: ['立即下载', '取消下载'],
            yes: function(index, layero){
                layer.close(index);
                layer.load(1);
                $.post('/unit/down-count',data,function(res){
                    if(res.code == 100000){
                            location.href = res['down-data'].download;
                    }else{
                        layer.msg(res.message,{icon:5});
                    }
                    layer.closeAll('loading');
                },'json');
            }
        });

    });

    //查看
    // $(".js_look_widget").click(function(){
    //     var that = this;
    //     var uid = $(this).data('uid');
    //     var link = $(this).data('href');
    //     var data={
    //         uid:uid,
    //         type:1, //设置访问量
    //     };
    //     data[csrfName] = csrfVal;
    //     var win = window.open();
    //     $.post('/unit/user-info',data,function(res){
    //         function openWin(){
    //             win.location.href = link;
    //         }
    //         setTimeout(openWin(),800);
    //     },'json')
    // })

    //关注
    $("#guanzhu").click(function () {
        var text = $("#guanzhu_text").text();
        var number = parseInt($("#guanzhu_number").text());
        var id = $(this).data('id');
        var data={
            'other_id':id
        };
        data[csrfName] = csrfVal;
        $.post('/unit/guanzhu',data,function(res){
            data['uid'] = id;
            data['type'] = 2;
            if(res.code == 100000){
                if(text == '√ 已关注'){
                    $("#guanzhu_text").text('关注作者');
                    $("#guanzhu_number").text(number-1);
                    data['status'] = 0;
                    $.post('/unit/user-info',data,function(res){})
                }else{
                    $("#guanzhu_text").text('√ 已关注');
                    $("#guanzhu_number").text(number+1);
                    data['status'] = 1;
                    $.post('/unit/user-info',data,function(res){})
                }
            }else{
                layer.msg(res.message,{icon:5,time:1000});
            }
        },'json');

    })

    // 收藏
    $("#shoucang").click(function () {
        var text = $("#shoucang_text").text();
        var number = parseInt($("#shoucang_number").text());
        var id = $(this).data('id');
        var data={
            'widget_id':id,
            'other_id':'<?=$unit["u_id"]?>'
        };
        data[csrfName] = csrfVal;
        $.post('/unit/collect',data,function(res){
            if(res.code == 100000){
                if(text == '√ 已收藏'){
                    $("#shoucang_text").text('收藏组件');
                    $("#shoucang_number").text(number-1);
                }else{
                    $("#shoucang_text").text('√ 已收藏');
                    $("#shoucang_number").text(number+1);
                };
            }else{
                layer.msg(res.message,{icon:5,time:1000});
            }
        },'json');
    })

    //评论
    $(".js_add_pinglun").click(function(){
        var currentElem = $(this).closest('.comment-content');
        if(currentElem.find('.reviewArea').length > 0){
            return;
        }
        currentElem.append($('.reviewArea').clone());
    })

    //评论
    $(document).delegate('.js_pinglun','click',function(){
        var text = $(this).prev('.content').val();
        var uid = $(this).data('uid');
        var widgetid = $(this).data('widgetid');
        var pinglun_id = $(this).closest('.commentAll').data('pinglun');
        pinglun_id = !!pinglun_id ? pinglun_id : 0;
        var data = {
            content : text,
            widget_uid : uid,
            widget_id : widgetid,
            parent_id : pinglun_id,
        };
        data[csrfName] = csrfVal;
        $.post('/unit/pinglun',data,function(res){
            if(res.code == 100000){
                layer.msg(res.message,{icon:1,time:1500},function(){
                    location.reload();
                });
            }else{
                layer.msg(res.message,{icon:5,time:1500},function(){
                    location.reload();
                });
            }
        },'json')
    })
</script>
<script src="<?=Yii::$app->params['backend_url']?>/asset/layui/layui.js"></script>
<script>
    layui.use(['code'],function(){
        var $ = layui.$,
            code = layui.code;

        $.each($('pre'),function(index,elem){
            var className = $(elem).attr('class');
            var title = className.match(/^\w+:\w+/)[0].split(':')[1];
            title = title == 'js' ? 'javascript': title;
            $(elem).attr('lay-title',title);
        })

        code({
            elem : 'blockquote,pre'
        })
    })
</script>
<?= $this->render('../template/footer');?>