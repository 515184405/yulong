<?php $this->title="个人中心 - 我的组件"; ?>
<?php $status = isset($_GET['status']) ? $_GET['status'] : 1; ?>

<link rel="stylesheet" href="/asset/static/css/personal.css">
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title">我的组件</h2>
        <div class="fy-sub-nav">
            <a class="sub-nav-item <?=$status == 1 ? 'active' : ''?>" href="/user?status=1">已发布</a>
            <a class="sub-nav-item <?=$status == 0 ? 'active' : ''?>" href="/user?status=0">审核中</a>
            <a class="sub-nav-item <?=$status == 2 ? 'active' : ''?>" href="/user?status=2">未通过</a>
            <a class="sub-nav-item right" href="/user/info">上传素材</a>
        </div>

        <!--内容部分-->

        <div class="user-unit-list">
            <?php if(!empty($data['widget'])){ foreach ($data['widget'] as $val) { ?>
            <div class="user-unit-item ">
                <a href="/user/info?id=<?=$val['id']?>" class="user-unit-edit transition">编 辑</a>
                <a <?=$val['status'] == 1 ? 'href="/unit/item/'.$val['id'].'"' : '' ?> >
                    <?php if($status == 0 ){ ?>
                        <div class="user-unit-img t-c shenheing" style="background-image:url(<?=Yii::$app->params['backend_url'].$val['banner_url']?>);">
                            <b style="font-size: 36px">审核中</b>
                        </div>
                    <?php }else if($status == 2){ ?>
                        <div class="user-unit-img t-c shenheing" style="background-image:url(<?=Yii::$app->params['backend_url'].$val['banner_url']?>);">
                            <b style="font-size: 36px ;">未通过</b>
                            <p><?=$val['fail_msg']?></p>
                        </div>
                    <?php }else{ ?>
                        <img style="background-color:rgba(<?=rand(0,255);?>,<?=rand(0,255)?>,<?=rand(0,255)?>,.4)" src="<?=Yii::$app->params['backend_url'].$val['banner_url']?>" alt="" class="user-unit-img transition">

                    <?php } ?>
                </a>
                <a <?=$val['status'] == 1 ? 'href="/unit/item/'.$val['id'].'"' : '' ?> class="user-unit-title transition overflow-text"><?=$val['title']?></a>
                <p class="user-unit-desc transition overflow-text2"><?=$val['desc']?></p>
                <p class="user-unit-info clearfix">
                    <span class="left"><i class="iconfont">&#xe618;</i><?=$val['look']?></span>
                    <span style="margin-left:15px;" class="left"><i class="iconfont">&#xe6ca;</i><?=$val['collect']?></span>
                    <span class="right"><i class="iconfont"></i><?=$val['down_count']?></span>
                </p>
            </div>
            <?php }}else{ ?>
                <div class="t-c" style="line-height: 300px;">
                    没有找到相关数据...
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
