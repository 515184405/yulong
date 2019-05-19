
<?= $this->render('../template/header',compact('data'));?>
<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css">
<link rel="stylesheet" href="/asset/static/css/item.css">

<div class="news-items">
    <div class="news-hidden-scroll js_news_items">
        <h2 class="content-title t-c"><?=$data['data']['title']?></h2>
        <div class="content-info">
            <span>来 源：<?=$data['data']['sourse']?></span>
            <span>发布日期：<?=date('Y-m-d h:m:s',$data['data']['create_time'])?></span>
            <span>浏览次数：<?=$data['data']['look']?></span>
        </div>
        <div class="content-text">
            <!--内容部分-->

            <?=$data['data']['content']?>

            <!--内容部分-->
        </div>
        <div class="clearfix btn-box">
            <a <?=is_null($data['prev']) ? '' : 'href="/news/item/'.$data['prev']['id'].'"' ?> class="btn-prev">上一篇：<?=is_null($data['prev']) ? '没有了...' : $data['prev']['title'] ?></a>
            <a <?=is_null($data['next']) ? '' : 'href="/news/item/'.$data['next']['id'].'"' ?> class="btn-next">下一篇：<?=is_null($data['next']) ? '没有了...' : $data['next']['title'] ?></a>
        </div>
        <div id="share" class="share-box"></div>
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
</script>
<?= $this->render('../template/footer');?>