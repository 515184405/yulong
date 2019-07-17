<?php $type_id = isset($_GET['type']) ? $_GET['type'] : 0; ?>
<style>
    .sub-nav-item{
        margin-right:15px!important;
    }
    .sub-nav-item:last-child{
        margin-right:0!important;
    }
</style>

<?php $this->title="个人中心 - 下载历史"; ?>

<link rel="stylesheet" href="/asset/static/css/personal.css<?=Yii::$app->params['static_number']?>">
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title">下载历史</h2>
        <div class="fy-sub-nav">
            <a class="sub-nav-item" href="javascript:;">最近下载历史记录</a>
            <a class="sub-nav-item right" href="/user/info">上传素材</a>
        </div>

        <!--内容部分-->

        <div class="record-list">
            <?php if(!empty($data['record'])){ foreach ($data['record'] as $val) { ?>
                <div class="record-item">
                    <a href="/unit/item/<?=$val['widget_id']?>" class="record-item-left">
                        <h2 class="overflow-text"><?=$val['down_title']?></h2>
                        <p><?=$val['create_time']?></p>
                    </a>
                    <a class="record-item-btn" href="<?=$val['down_url']?>">下 载</a>
                </div>
            <?php }}else{ ?>
                <div class="t-c" style="line-height: 300px;">
                    还没有？去<a style="padding:3px 8px" class="fy-btn fy-btn-primary" href="/unit">下载</a>一个吧...
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
