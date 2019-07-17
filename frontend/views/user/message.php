<?php $this->title="个人中心 - 我的评论"; ?>
<?php $type_id = isset($_GET['type']) ? $_GET['type'] : 0; ?>
<?php
function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}
?>
<style>
    .sub-nav-item{
        margin-right:15px!important;
    }
    .sub-nav-item:last-child{
        margin-right:0!important;
    }
    .message-content pre{
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<?php $this->title="个人中心 - 我的评论"; ?>

<link rel="stylesheet" href="/asset/static/css/personal.css<?=Yii::$app->params['static_number']?>">
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title">评论列表</h2>
        <div class="fy-sub-nav">
<!--            <a class="sub-nav-item" href="javascript:;">最新</a>-->
            <a class="sub-nav-item right" href="/user/info">上传素材</a>
        </div>

        <!--内容部分-->

        <div class="record-list">
            <?php if(!empty($data['message'])){ foreach ($data['message'] as $val) { ?>
                <div class="record-item">
                    <a href="/unit/item/<?=$val['widget_id']?>" class="record-item-left">
                        <p style="margin-top:0;"><?=format_date(strtotime($val['create_time']))?></p>
                        <h2 class="overflow-text message-content"><?=$val['content']?></h2>
                    </a>
                    <a class="record-item-btn" href="/unit/item/<?=$val['widget_id']?>">查 看</a>
                </div>
            <?php }}else{ ?>
                <div class="t-c" style="line-height: 300px;">
                    还没有任何评论消息哦...
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
