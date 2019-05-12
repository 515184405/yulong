
<?= $this->render('../template/header',compact('data'));?>

<link rel="stylesheet" href="/asset/static/css/news.css">
<div class="news-list clearfix">
    <?php for($i = 0; $i < 100; $i++){?>
        <!--        delay---><?//= $i % 5 ?><!--s-->
        <div animate-type="slideInUpLeft" class="news-item animated duration0_5">
            <a class="news-item-imgbox" href="/news/item/<?= $i ?>">
                <div class="page-shadow1 transition"><i class="iconfont">&#xe618;</i></div>
                <img class="news-img" src="http://www.1000zhu.com/upload/image/201708/15/1213248935.jpg" alt="">
            </a>
            <div class="news-content">
                <h2 class="overflow-text nc-title"><a href="/news/item/<?= $i ?>">给你看八个网页特效，让你的网站建设更加引人入胜</a></h2>
                <p class="nc-info">
                    <i class="iconfont icon-date">&#xe75e;</i>2019-05-02
                    <i class="iconfont">&#xe605;</i>1356
                    <i class="iconfont icon-type">&#xe6cc;</i><a href="#">经验之谈</a>
                </p>
                <p class="overflow-text2 nc-desc">网站设计是一个永无止境的创意工作，优秀的网站通常伴有多个具有一定难度的网页特效。当然，一款设计精良、用户体验度高的网站对您的业务推广是至关重要的。　　在这个互联网数字 . . .
                    网页特效</p>
                <p class="news-tag">
                    <i class="iconfont icon-tag">&#xe634;</i>
                    <a href="#" class="tag-link theme">404错误页面</a>
                    <a href="#" class="tag-link theme">推荐设计</a>
                    <a href="#" class="tag-link theme">网站优化</a>
                </p>
            </div>
        </div>
    <?php } ?>
</div>
<?= $this->render('../template/footer');?>