<?php $unit = $data['data']; ?>
<?php $this->title='组件列表 - '.$unit['title']; ?>

<?= $this->render('../template/header',compact('data'));?>
<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css">
<link rel="stylesheet" href="/asset/static/css/item.css">
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
    })

</script>
<?= $this->render('../template/footer');?>