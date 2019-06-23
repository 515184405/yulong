<?php $this->title="个人中心 - 我的组件"; ?>
<?php $type = isset($_GET['type']) ? $_GET['type'] : 1; ?>

<link rel="stylesheet" href="/asset/static/css/personal.css<?=Yii::$app->params['static_number']?>">
<style>
    .userInfo-info{
        min-height: 320px;
    }
</style>
<div class="personal fy-container clearfix">
    <?php
    /*用户信息*/
    $userInfo = $this->params['userInfo'];
    ?>
    <div class="left personal-left transition js_personal_nav">
        <div class="fy-userInfo">
            <div class="userInfo-avatar-box"><img src="<?=$data['guanzhu']['avatar']?>" class="userInfo-avatar"></div>
            <p class="userInfo-name"><?=$data['guanzhu']['username']?><i class="iconfont userInfo-vip">&#xe68e;</i></p>
        </div>
        <ul class="userInfo-info clearfix">
            <li class="userInfo-item"><span>9999</span>
                <p>金币</p></li>
            <li class="userInfo-item"><span>888</span>
                <p>粉丝</p></li>
            <li class="userInfo-item"><span>100001</span>
                <p>访问量</p></li>
        </ul>
    </div>
    <div class="personal-right">
        <h2 class="user-title">TA的组件</h2>
        <div class="fy-sub-nav t-c">
            <a class="sub-nav-item <?=$type == 1 ? 'active' : ''?>" href="/other/index/<?=$_GET['u_id']?>/1">TA发布的插件</a>
            <a class="sub-nav-item <?=$type == 2 ? 'active' : ''?>" href="/other/index/<?=$_GET['u_id']?>/2">TA收藏的插件</a>
            <a href=""></a>
        </div>

        <!--内容部分-->

        <div class="user-unit-list">
            <?php
                if(!empty($data['widget'])){ foreach ($data['widget'] as $val) {
                    if($type == 2){
                        $val = $val['collect_widget'];
                    }
            ?>
            <div class="user-unit-item ">
                <a <?=$val['status'] == 1 ? 'href="/unit/item/'.$val['id'].'"' : '' ?> >
                        <img style="background-color:rgba(<?=rand(0,255);?>,<?=rand(0,255)?>,<?=rand(0,255)?>,.4)" src="<?=Yii::$app->params['backend_url'].$val['banner_url']?>" alt="" class="user-unit-img transition">
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
