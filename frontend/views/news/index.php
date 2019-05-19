<?php $this->title='宇龙科技 - 文章动态' ?>
<?= $this->render('../template/header',compact('data'));?>

<link rel="stylesheet" href="/asset/static/css/news.css">
<div class="news-list clearfix">
    <?php if(!empty($data['news'])){ foreach ($data['news'] as $key => $val) { ?>
        <!--        delay---><?//= $i % 5 ?><!--s-->
        <div animate-type="slideInUpLeft" class="news-item animated duration0_5">
            <a class="news-item-imgbox" href="/news/item/<?=$val['id'] ?>">
                <div class="page-shadow1 transition">点击查看</div>
                <img class="news-img" src="<?=Yii::$app->params['backend_url'].$val['banner_url']?>" alt="">
            </a>
            <div class="news-content">
                <h2 class="overflow-text nc-title"><a href="/news/item/<?=$val['id']?>"><?=$val['title']?></a></h2>
                <p class="nc-info">
                    <i class="iconfont icon-date">&#xe75e;</i><?=date('Y-m-d',$val['create_time'])?>
                    <i class="iconfont">&#xe605;</i><?=is_null($val['look']) ? 0 : $val['look'] ?>
                    <i class="iconfont icon-type">&#xe6cc;</i><a href="/news/?id=<?=$val['newsType']['title'] ?>"><?=$val['newsType']['title'] ?></a>
                </p>
                <p class="overflow-text2 nc-desc"><?=$val['desc']?></p>
                <p class="news-tag">
                    <i class="iconfont icon-tag">&#xe634;</i>
                    <?php foreach ($val['news_tag_join'] as $tag){ ?>
                    <a href="/news?tag_id=<?=$tag['newsTag']['tag_id']?>" class="tag-link theme"><?=$tag['newsTag']['title']?></a>
                    <?php } ?>
                </p>
            </div>
        </div>
    <?php }}else{ ?>
        无数据
    <?php } ?>
</div>
<?= $this->render('../template/footer');?>