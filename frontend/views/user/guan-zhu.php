<?php $this->title="个人中心 - 我的关注"; ?>
<?php $status = isset($_GET['status']) ? $_GET['status'] : 1; ?>

<link rel="stylesheet" href="/asset/static/css/personal.css<?=Yii::$app->params['static_number']?>">
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title">我关注的人</h2>
        <div class="fy-sub-nav">
            <a class="sub-nav-item" href="javascript:;">快去看看你关注的人的主页吧...</a>
            <a class="sub-nav-item right" href="/user/info">上传素材</a>
        </div>

        <!--内容部分-->

        <div class="user-guanzhu-list">
            <?php if(!empty($data['guanZhu'])){ foreach ($data['guanZhu'] as $val) { ?>
            <a href="/other/index/<?=$val['other_id']?>/1" class="user-guanzhu-item ">
                <img class="left user-guanzhu-avatar" src="<?=$val['member']['avatar']?>" alt="">
                <div class="user-guanzhu-info">
                    <h2 class="overflow-text"><?=$val['member']['username']?>&nbsp;</h2>
                    <p class="overflow-text"><?=$val['member']['province']?><?=$val['member']['city']?>&nbsp;</p>
                </div>
            </a>
            <?php }}else{ ?>
                <div class="t-c" style="line-height: 300px;font-size:14px;">
                    您还没有关注任何人
                </div>
            <?php } ?>
        </div>

        <!--内容部分-->

    </div>
</div>
