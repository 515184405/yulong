
<?= $this->render('../template/header',compact('data'));?>
<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css">
<link rel="stylesheet" href="/asset/static/css/item.css">

<div class="news-items">
    <div class="news-hidden-scroll js_news_items">
        <h2 class="content-title">拉法基娄山关路是个联合国</h2>
        <div class="content-info">
            <span>来 源：艺麟盛世</span>
            <span>发布日期：2014-08-11 17:15:03</span>
            <span>浏览次数：3131</span>
        </div>
        <div class="content-text">
            <!--内容部分-->

                <p class="MsoNormal">
                    &emsp;&emsp;网站权重一直都是大家所关心的问题，网站权重越高，在搜索引擎的排名就会越好。提高网站权重，不但利于网站，网站内页在搜索引擎的排名更靠前，还能提高整站的流量，提高网站信任度。网站权重既然有这么多好处，那么什么是网站权重呢？该如何来提高网站权重呢？今天小编就带大家来了解一下。<br>
                    <br>
                    &emsp;&emsp;网站权重就是搜索引擎对网站的结构、内容原创性、外链质量、站点年龄等综合的评级，赋予一定的权威值。所以一个网站评级越高，排名自然就越好。提高网站的权重除了可以让排名更靠前，还能提高整站的流量与信任度。另外针对网站指数关键词在前五页的排名预估给网站带来流量，划分0-9的等级，对于流量的预估各自算法不一样，所以会有偏差。我们知道了什么是网站权重后，那么我们该如何提高网站权重呢？
                </p>
                <div style="text-align:center;">
                    <img src="https://www.yilinicms.com//public/yilincms/image/20190314/20190314100639_41383.png" alt="网站权重是什么？该如何提高网站权重" width="469" height="317" title="网站权重是什么？该如何提高网站权重" align="">
                </div>
                &emsp;&emsp;要提高网站权重要做到以下三点：<br>
                <br>
                <strong>&emsp;&emsp;第一 提升关键词排名</strong><br>
                <br>
                &emsp;&emsp;网站关键词的竞争比较大，指数高的词语就是我们优化的重点，做好这样的词对网站权重的提升效果是非常明显的。小编推荐一个查询关键词的工具，爱站就是一个比较不错的查询关键词工具。<br>
                <br>
                <strong>&emsp;&emsp;第二 友情链接</strong><br>
                <br>
                &emsp;&emsp;友情链接对网站权重也是非常重要的，友情链接要适量的添加，一篇文章一次添加2-3个就可以。不要一次性添加大量的友情链接，这样网站权重反而会下降。所以我们在添加友情链接时一定要注意。<br>
                <br>
                <strong>&emsp;&emsp;第三 网站内容和内链</strong><br>
                <div style="text-align:center;">
                    <img src="https://www.yilinicms.com//public/yilincms/image/20190314/20190314101002_57444.png" alt="内链" width="469" height="278" title="内链" align=""><br>
                </div>
                &emsp;&emsp;网站内容好的话，也能提高搜索引擎的抓取率。网站的内容最好是原创或者是伪原创，如果经常发布原创或伪原创的文章，蜘蛛会经常光顾，网站权重也会一步步得到提升。<br>
                <br>
                &emsp;&emsp;在做好原创或伪原创的文章的同时，也要做好网站的内链，良好的网站内链，利于搜索引擎蜘蛛深度抓取、提升关键词排名，还有利于提升用户体验，引导用户深度浏览网站。<br>
                <br>
                &emsp;&emsp;要想做好网站权重首先要先做到以上几点，这样才有可能提高网站权重。当然，说起来容易，做起来难，这需要我们有耐心和细心，慢慢从头做起，网站权重才会随之慢慢提升。<br>
                <p>
                    <br>
                </p>


            <!--内容部分-->
        </div>
        <div class="clearfix btn-box">
            <a href="#" class="btn-prev">上一篇：吉林省刚刚回来时光流逝</a>
            <a href="#" class="btn-next">下一篇：姐IP感觉数量减少浪费精力四号公路拿到了</a>
        </div>
        <div id="share" class="share-box"></div>
    </div>
</div>
<?= $this->render('../template/right_aslide');?>

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