<div class="right js_news_recommend news-recommend">
    <div class="news-recommend-hidden">
        <img class="nr-img" src="/asset/static/image/call-me.jpg" alt="">
        <h2 class="nr-title">
            案例推荐
        </h2>
        <div>
        <?php foreach ($data['recommend_case'] as $v){?>
            <a href="/case/item/<?=$v['id']?>" class="nr-item clearfix">
                <img class="nr-item-img" src="<?=Yii::$app->params['backend_url'].$v['banner_url']?>" alt="<?=Yii::$app->params['backend_url'].$v['banner_url']?>">
                <div class="nr-item-content">
                    <h3 class="nric-title overflow-text"><?=$v['title']?></h3>
                    <p class="overflow-text2 nric-desc">
                        <?=mb_substr(strip_tags($v['desc']),0,30)?>
                    </p>
                </div>
            </a>
        <?php } ?>
        </div>

        <h2 class="nr-title">
            文章推荐
        </h2>
        <div>
            <?php foreach ($data['recommend_news'] as $v2){?>
            <a href="/news/item/<?=$v2['id'];?>" class="nr-item clearfix">
                <img class="nr-item-img" src="<?=Yii::$app->params['backend_url'].$v2['banner_url']?>" alt="<?=Yii::$app->params['backend_url'].$v2['banner_url']?>">
                <div class="nr-item-content">
                    <h3 class="nric-title overflow-text2" title="<?=$v2['title']?>"><?=$v2['title']?></h3>
                    <p class="nric-info">
                        <span><?=date('m-d',$v2['create_time'])?></span>
                        <i class="iconfont">&#xe605;</i><?=$v2['look']?>
                    </p>
                </div>
            </a>
        <?php } ?>
        </div>
    </div>
</div>
