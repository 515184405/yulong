
<?= $this->render('../template/header',compact('data'));?>
<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css">
<link rel="stylesheet" href="/asset/static/css/item.css">

<div class="news-items case-items">
    <div class="news-hidden-scroll js_news_items">
        <img class="case-banner" src="<?=Yii::$app->params['backend_url'].$data['data']['header_url']?>" alt="">
        <h2 class="case-title">项目简介</h2>
        <div class="case-desc">
            <?=$data['data']['desc']?>
        </div>
        <h2 class="case-title">项目标签</h2>
        <div class="case-dress">
            <i class="iconfont theme" style="font-size: 22px;position:relative;top:2px;">&#xe634;</i>
            <?php foreach ($data['data']['tag_join'] as $item){ ?>
            <a href="/case/?tag_id=<?=$item['tag_id']['tag_id']?>" class="theme case-tag"><?=$item['tag_id']['title']?></a>
            <?php } ?>
        </div>
        <h2 class="case-title">项目地址</h2>
        <div class="case-dress">
            <?php if($data['data']['pc_link']){ ?>
            <p>电脑端：<a href="<?=$data['data']['pc_link']?>"><?=$data['data']['pc_link']?></a></p>
            <?php } ?>
            <?php if($data['data']['wap_link']){ ?>
                <p>移动端：<a href="<?=$data['data']['wap_link']?>"><?=$data['data']['wap_link']?></a></p>
            <?php } ?>
            <?php if(!is_null($data['data']['wap_link'])){ ?>
            <div class="case-dress-wxbox">
                <img class="case-dress-wx" style="width:120px;height:120px;" src="<?=Yii::$app->params['backend_url'].$data['data']['wx_link']?>" alt="">
                <p>扫一扫微信二维码</p>
            </div>
            <?php } ?>
        </div>
        <h2 class="case-title">分享精品</h2>
        <div id="share" class="case-share"></div>
        <h2 class="case-title">设计欣赏</h2>
        <?php $contentArr = explode(',',substr($data['data']['content_url'],1));?>
        <img class="case-show-img js_case_list" src="<?=Yii::$app->params['backend_url'].$contentArr[0]?>" alt="">
        <div class="js_list_box case-swipper" data-show="0">
            <?php foreach ($contentArr as $val){ ?>
            <img class="case-show-img" data-src="<?=Yii::$app->params['backend_url'].$val?>" alt="">
            <?php } ?>
        </div>
    </div>
</div>
<?= $this->render('../template/right_aslide');?>
<script src="/asset/static/wigdet/share/jquery.share.min.js"></script>
<script src="/asset/static/js/case-item.js"></script>
<script>
    //分享功能
    $('#share').share({sites: ['qzone', 'qq', 'weibo','wechat']});
    // 动态设置右侧高度固定右侧
    // function setRightHeight(){
    //     var winH = $(window).height();
    //     var top = 75;
    //     $('.js_news_items,.js_news_recommend').css('height',winH - top);
    // }
    // setRightHeight();
</script>
<?= $this->render('../template/footer');?>
<p class="swipper-number none"><span class="sn-current">1</span> / <span class="sn-count">3</span></p>
