<?php $this->title="个人中心 - 我的组件"; ?>
<?php $status = isset($_GET['status']) ? $_GET['status'] : 2; ?>

<link rel="stylesheet" href="/asset/static/css/personal.css">
<style>
    .down-btn{
        padding:5px 0;
        background-color: #5181f1;
        color:#fff;
        border:0;
        display: block;
        width:100%;
        text-align: center;
    }
    .user-unit-img{
        -webkit-background-size: cover!important;
        background-size: cover!important;
    }
    .down-btn:hover{
        color:#fff;
        opacity: 0.8;
    }
</style>
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title">我的定制</h2>
        <div class="fy-sub-nav">
            <a class="sub-nav-item <?=$status == 2 ? 'active' : ''?>" href="/user/dingzhi?status=2">已完成</a>
            <a class="sub-nav-item <?=$status == 1 ? 'active' : ''?>" href="/user/dingzhi?status=1">定制中</a>
            <a class="sub-nav-item <?=$status == 0 ? 'active' : ''?>" href="/user/dingzhi?status=0">处理中</a>
            <a class="sub-nav-item " href="/unit/dingzhi">去定制</a>
            <a class="sub-nav-item right" href="/user/info">上传素材</a>
        </div>

        <!--内容部分-->

        <div class="user-unit-list">
            <?php if(!empty($data['widget'])){ foreach ($data['widget'] as $val) { ?>
            <div class="user-unit-item" <?= $status != 2 ? 'style="opacity:0.7;"' :''; ?>>
                    <?php if($status == 2){ ?>
                        <a href="/unit/item/<?=$val['project_join']['id'];?>"><img style="background-color:rgba(<?=rand(0,255);?>,<?=rand(0,255)?>,<?=rand(0,255)?>,.4)" src="<?=Yii::$app->params['backend_url'].$val['project_join']['banner_url']?>" alt="" class="user-unit-img transition"></a>
                        <a href="/unit/item/<?=$val['project_join']['id'];?>" class="user-unit-title transition overflow-text"><?=$val['project_join']['title']?></a>
                        <p class="user-unit-desc transition overflow-text2"><?=$val['project_join']['desc']?></p>
                        <p style="padding:3px 15px;" class="user-unit-info clearfix">
                            <a href="<?=$val['project_join']['download']?>" class="down-btn left">点击下载</a>
                        </p>
                    <?php }else{ ?>
                        <div style="background:url(<?=Yii::$app->params['frontend_url'].$val['file_url']?>) no-repeat center center;" class="user-unit-img t-c shenheing"></div>
                        <h2 class="user-unit-title transition overflow-text"><?=$val['title']?></h2>
                        <p class="user-unit-desc transition overflow-text2"><?=$val['desc']?></p>
                        <p class="user-unit-info t-c clearfix">
                            <?php if($status == 0 ){ ?>
                                <b style="color:#f00;line-height: 30px;">处理中</b>
                            <?php }else if($status == 1){ ?>
                                <b class="theme" style="line-height: 30px;">定制中</b>
                            <?php } ?>
                        </p>
                    <?php } ?>
            </div>
            <?php }}else{ ?>
                <div class="t-c" style="line-height: 300px;">
                    还没有？去<a style="padding:3px 8px" class="fy-btn fy-btn-primary" href="/unit/dingzhi">定制</a>一个吧...
                </div>
            <?php } ?>
        </div>

        <!--内容部分-->

    </div>
</div>
