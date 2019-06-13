<?php $unit = $data['data']; ?>
<?php $this->title='组件列表 - '.$unit['title']; ?>
<?php $this->keywords=$unit['desc']; ?>
<?php $userUnit = isset($data['data']['user']) ? $data['data']['user'] : []; ?>
<?= $this->render('../template/header',compact('data'));?>
<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css<?=Yii::$app->params['static_number']?>">
<link rel="stylesheet" href="/asset/static/css/item.css<?=Yii::$app->params['static_number']?>">
    <style>
        .js_news_recommend{
            top:235px;
        }
    </style>
<div class="news-items unit-items">
        <h2 class="content-title clearfix"><span class="left js_widget_title"><?=$unit['title']?></span><div id="share" class="share-box right"></div></h2>
        <div class="content-info">
            <span>来 源：<?=$unit['source']?></span>
            <span>发布日期：<?=date('Y-m-d h:m:s',$unit['create_time'])?></span>
            <span>浏览次数：<?=$unit['look']?></span>
            <span>下载量：<?=$unit['down_count']?></span>
        </div>
        <div style="background-color:rgba(<?=rand(0,255)?>,<?=rand(0,255)?>,<?=rand(0,255)?>,1)" class="banner-box">
            <img src="<?=Yii::$app->params['backend_url'].$unit['banner_url']?>" alt="">
        </div>
        <div class="unit-btn-box">
            <a class="fy-btn fy-btn-success" target="_blank" href="/widget/widget/<?=$unit['create_time']?>/<?=$unit['id']?>/index">查看演示</a>
            <?php if($unit['website']){ ?>
            <a class="fy-btn fy-btn-primary" target="_blank" href="<?=$unit['website']?>">官网地址</a>
            <?php } ?>
            <?php if($unit['is_down'] == 0){ ?>
            <a data-id="<?=$unit['id'] ?>" class="fy-btn fy-btn-danger <?=Yii::$app->getUser()->getId() ? 'js_download" data-src="'.$unit["download"].'"' : 'login_btn" href="javascript:;"'?> target="_blank">立即下载</a>
            <?php } ?>
        </div>
        <div class="unit-desc layui-elem-quote">
            <span class="theme">插件描述：</span><?=$unit['desc'];?>
        </div>
        <div class="unit-rule">
            <h2 class="unit-rule-title">组件介绍:</h2>
            <div class="unit-rule-content">
                <?=$unit['rule'];?>
            </div>
        </div>
    <div class="clearfix btn-box unit-page-box">

        <a <?=is_null($data['prev']) ? '' : 'href="/unit/item/'.$data['prev']['id'].'"' ?> class="btn-prev left"><i class="iconfont">&#xe604;</i><?=is_null($data['prev']) ? '没有了...' : $data['prev']['title'] ?></a>
        <a <?=is_null($data['next']) ? '' : 'href="/unit/item/'.$data['next']['id'].'"' ?> class="btn-next right"><?=is_null($data['next']) ? '没有了...' : $data['next']['title'] ?><i class="iconfont">&#xe607;</i></a>

    </div>

</div>
<div class="unit-user news-recommend">
    <div class="clearfix unit-user-info">
        <img class="unit-user-avatar" src="//t.cn/RCzsdCq" alt="">
        <h2 class="unit-user-name overflow-text">疯疯癫癫的小伙</h2>
        <p class="unit-user-dress overflow-text">北京市 - 石景山区</p>
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
    //分享功能
    $('#share').share({sites: ['qzone', 'qq', 'weibo','wechat']});
    // 动态设置右侧高度固定右侧
    //  function setRightHeight(){
    //      var winH = $(window).height();
    //      var top = 75;
    //      $('.js_news_items,.js_news_recommend').css('height',winH - top);
    //  }
    // setRightHeight();
    $(".js_download").click(function(){
        if($(this).attr('href')){
            return;
        }
        var csrfName = $("#form_csrf").attr('name');
        var csrfVal = $("#form_csrf").val();
        var href = $(this).data('src');
        $(this).attr('href',href);
        var data = {
            'widget_id' : $(this).data('id'), //项目id
            'down_title' : $('.js_widget_title').html(), //项目标题
            'down_url' : href,
        };
        data[csrfName] = csrfVal;
        $.post('/unit/down-count',data,function(){});
        // $(this).click();
    });

    //关注
    $("#guanzhu").click(function () {
        var text = $("#guanzhu_text").text();
        var csrfName = $("#form_csrf").attr('name');
        var csrfVal = $("#form_csrf").val();
        var number = parseInt($("#guanzhu_number").text());
        var id = $(this).data('id');
        var data={
            'other_id':id
        };
        data[csrfName] = csrfVal;
        $.post('/unit/guanzhu',data,function(res){
            if(res.code == 100000){
                if(text == '√ 已关注'){
                    $("#guanzhu_text").text('关注作者');
                    $("#guanzhu_number").text(number-1);
                }else{
                    $("#guanzhu_text").text('√ 已关注');
                    $("#guanzhu_number").text(number+1);
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
        var csrfName = $("#form_csrf").attr('name');
        var csrfVal = $("#form_csrf").val();
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
</script>
<?= $this->render('../template/footer');?>