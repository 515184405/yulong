<?php $type_id = isset($_GET['type']) ? $_GET['type'] : 0; ?>
<style>
    .sub-nav-item{
        margin-right:15px!important;
    }
    .sub-nav-item:last-child{
        margin-right:0!important;
    }
</style>

<?php $this->title="个人中心 - 我的收藏"; ?>

<link rel="stylesheet" href="/asset/static/css/personal.css">
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title">我的收藏</h2>
        <div class="fy-sub-nav">
            <?php foreach ($data['typeArr'] as $key => $type) { ?>
                <a class="sub-nav-item <?=$type_id == $key ? 'active' : ''?>" href="/user/collect?type=<?=$key?>"><?=$type['title']?>(<?=$type['number']?>)</a>
            <?php } ?>
            <a class="sub-nav-item right" href="/user/info">上传素材</a>
        </div>

        <!--内容部分-->

        <div class="user-unit-list">
            <?php if(!empty($data['widget'])){ foreach ($data['widget'] as $val) { ?>
                <a href="/unit/item/<?=$val['id']?>" class="user-unit-item ">
                    <img style="background-color:rgba(<?=rand(0,255);?>,<?=rand(0,255)?>,<?=rand(0,255)?>,.4)" src="<?=Yii::$app->params['backend_url'].$val['banner_url']?>" alt="" class="user-unit-img transition">
                    <h2 class="user-unit-title transition overflow-text">选座系统（移动 - PC）</h2>
                    <p class="user-unit-desc transition overflow-text2"><?=$val['desc']?></p>
                    <p class="user-unit-info clearfix">
                        <span class="left"><i class="iconfont">&#xe618;</i><?=$val['look']?></span>
                        <span style="margin-left:15px;" class="left"><i class="iconfont">&#xe6ca;</i><?=$val['collect']?></span>
                        <span class="right"><i class="iconfont"></i><?=$val['down_count']?></span>
                    </p>
                </a>
            <?php }}else{ ?>
                <div class="t-c" style="line-height: 300px;">
                    还没有？去<a style="padding:3px 8px" class="fy-btn fy-btn-primary" href="/user/info">上传</a>一个吧...
                </div>
            <?php } ?>
        </div>

        <div class="t-c">
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $data['pagination'],
            ]) ?>
        </div>
        <!--内容部分-->

    </div>
</div>
