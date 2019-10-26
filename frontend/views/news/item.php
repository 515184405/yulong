<?php $this->title='文章动态 - '.$data['data']['title']; ?>
<?php $this->keywords=$data['data']['desc']; ?>
<?php $this->description = $data['data']['desc']; ?>


<?= $this->render('../template/header',compact('data'));?>
    <style>
        .layui-code-h3 a{
            display: none;
        }
    </style>
<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css<?=Yii::$app->params['static_number']?>">
<link rel="stylesheet" href="/asset/static/css/item.css<?=Yii::$app->params['static_number']?>">
<link rel="stylesheet" href="/asset/static/css/setDefaultStyle.css<?=Yii::$app->params['static_number']?>"><!---->

<div class="news-items">
    <div class="news-hidden-scroll js_news_items">
        <h2 class="content-title clearfix"><span class="left"><?=$data['data']['title']?></span><div id="share" class="share-box right"></div></h2>
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
    <script src="<?=Yii::$app->params['backend_url']?>/asset/layui/layui.js"></script>
    <script>
        layui.use(['code'],function(){
            var $ = layui.$,
                code = layui.code;

            code({
                elem : 'blockquote,pre'
            })
        })
    </script>
<?= $this->render('../template/footer');?>