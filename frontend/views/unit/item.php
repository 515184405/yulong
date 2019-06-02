<?php $unit = $data['data']; ?>
<?php $this->title='组件列表 - '.$unit['title']; ?>

<?= $this->render('../template/header',compact('data'));?>
<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css">
<link rel="stylesheet" href="/asset/static/css/item.css">
    <style>
        .js_news_recommend{
            top:235px;
        }
    </style>
<div class="news-items unit-items">
        <h2 class="content-title clearfix"><span class="left"><?=$unit['title']?></span><div id="share" class="share-box right"></div></h2>
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
            <a data-id="<?=$unit['id'] ?>" class="fy-btn fy-btn-danger js_download" data-src="<?=$unit['download']?>" target="_blank">立即下载</a>
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
    <p class="unit-user-btn">
        <button id="guanzhu" class="fy-btn fy-btn-primary"><span id="guanzhu_text">关注作者</span>（<span id="guanzhu_number">35</span>）</button>
    </p>
    <p class="unit-user-btn">
        <button id="shoucang" class="fy-btn fy-btn-success"><span id="shoucang_text">收藏插件</span>（<span id="shoucang_number">75</span>）</button>
    </p>
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
        var href = $(this).data('src');
        $(this).attr('href',href);
        $.post('/unit/down-count',{id:$(this).data('id')},function(){});
        // $(this).click();
    });

    //关注
    $("#guanzhu").click(function () {
        var text = $("#guanzhu_text").text();
        var number = parseInt($("#guanzhu_number").text());
        if(text == '√ 已关注'){
            $("#guanzhu_text").text('关注作者');
            $("#guanzhu_number").text(number-1);
        }else{
            $("#guanzhu_text").text('√ 已关注');
            $("#guanzhu_number").text(number+1);
        }
    })

    // 收藏
    $("#shoucang").click(function () {
        var text = $("#shoucang_text").text();
        var number = parseInt($("#shoucang_number").text());
        if(text == '√ 已收藏'){
            $("#shoucang_text").text('收藏组件');
            $("#shoucang_number").text(number-1);
        }else{
            $("#shoucang_text").text('√ 已收藏');
            $("#shoucang_number").text(number+1);
        }
    })
</script>
<?= $this->render('../template/footer');?>