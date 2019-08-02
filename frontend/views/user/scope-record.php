<?php $type_id = isset($_GET['type']) ? $_GET['type'] : 0; ?>
<style>
    .sub-nav-item{
        margin-right:15px!important;
    }
    .sub-nav-item:last-child{
        margin-right:0!important;
    }
    .record-item-btn{
        width:auto!important;
        background: transparent!important;
        height: 60px!important;
        line-height: 60px!important;
        margin-top: 0!important;
        color: #333!important;
        font-weight: normal!important;
    }
    @media screen and (max-width:768px){
        .record-item-left{
            width:60%!important;
        }
        .record-item-btn{
            width: 90px!important;
        }
    }
</style>

<?php $this->title="个人中心 - 下载历史"; ?>

<link rel="stylesheet" href="/asset/static/css/personal.css<?=Yii::$app->params['static_number']?>">
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title">下载历史</h2>
        <div class="fy-sub-nav">
            <a class="sub-nav-item <?=$type_id == 0 ? 'active' : ''?>" href="/user/scope-record?type=0">全部</a>
            <a class="sub-nav-item <?=$type_id == 1 ? 'active' : ''?>" href="/user/scope-record?type=1">积分赚取记录</a>
            <a class="sub-nav-item <?=$type_id == 2 ? 'active' : ''?>" href="/user/scope-record?type=2">积分消费记录</a>
            <a class="sub-nav-item right" href="/user/info">上传素材</a>
        </div>

        <!--内容部分-->

        <div class="record-list">
            <?php if(!empty($data['record'])){ foreach ($data['record'] as $val) { ?>
                <div class="record-item">
                    <a href="javascript:;" class="record-item-left">
                        <h2 class="overflow-text">
                        <?php
                            switch ($val['type']) {
                            case 0:
                                echo "新用户注册获得积分";
                                $recordStatus = 1;
                                break;
                            case 1:
                                echo "上传项目获得积分";
                                $recordStatus = 1;
                                break;
                            case 2:
                                echo "签到获得积分";
                                $recordStatus = 1;
                                break;
                            case 3:
                                echo "消费积分";
                                $recordStatus = 0;
                                break;
                            case 4:
                                echo "其他用户下载获得积分";
                                $recordStatus = 1;
                                break;
                        } ?></h2>
                        <p>积分变更情况: <b style="font-size:18px;color:<?=$recordStatus == 0 ? 'red' : 'green'?>"><?=$val['scope'];?></b></p>
                    </a>
                    <span class="record-item-btn overflow-text"><?=$val['created_time']?></span>
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
