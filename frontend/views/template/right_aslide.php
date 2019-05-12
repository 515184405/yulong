<div class="right js_news_recommend news-recommend">
    <div class="news-recommend-hidden">
        <img class="nr-img" src="/asset/static/image/call-me.jpg" alt="">
        <h2 class="nr-title">
            案例推荐
        </h2>
        <div>
        <?php for($i = 0; $i < 3; $i++){?>
            <a href="/case/item/<?=$i;?>" class="nr-item clearfix">
                <img class="nr-item-img" src="http://www.1000zhu.com/upload/image/201607/09/0217075001.jpg" alt="">
                <div class="nr-item-content">
                    <h3 class="nric-title overflow-text">为企业网站购买云服务器</h3>
                    <p class="overflow-text2 nric-desc">
                        快乐和公司来管理你是个但经过看见帅哥吧福利局i
                    </p>
                </div>
            </a>
        <?php } ?>
        </div>

        <h2 class="nr-title">
            文章推荐
        </h2>
        <div>
        <?php for($j = 0; $j < 3; $j++){?>
            <a href="/news/item/<?=$j;?>" class="nr-item clearfix">
                <img class="nr-item-img" src="http://www.1000zhu.com/upload/image/201607/09/0217075001.jpg" alt="">
                <div class="nr-item-content">
                    <h3 class="nric-title overflow-text2" title="为企业网站购买云服务器，你真的懂吗？">为企业网站购买云服务器，你真的懂吗？</h3>
                    <p class="nric-info">
                        <span>03-05</span>
                        <i class="iconfont">&#xe605;</i>55576
                    </p>
                </div>
            </a>
        <?php } ?>
        </div>
    </div>
</div>
