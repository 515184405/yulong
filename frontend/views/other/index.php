<?php $this->title="个人中心 - 我的组件"; ?>
<?php
    $type = isset($_GET['type']) ? $_GET['type'] : 1;
    $personalInfo = $data['personalInfo'];
?>

<link rel="stylesheet" href="/asset/static/css/personal.css<?=Yii::$app->params['static_number']?>">
<style>
    .userInfo-info{
        min-height: 320px;
    }
    .userInfo-info li{
        width:100%;
        border:0;
        border-bottom:1px solid #eee;
        padding:10px;
    }
    .userInfo-info li span{
        font-size: 18px;
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
           <li class="userInfo-item"><span><?=isset($data['scope']) ? $data['scope']['scope'] : 0?></span>
                <p>积分</p></li>
            <li class="userInfo-item"><span><?=isset($personalInfo['collect']) ? $personalInfo['collect'] : 0?></span>
                <p>粉丝</p></li>
            <li class="userInfo-item"><span><?=isset($personalInfo['count']) ? $personalInfo['count'] : 0?></span>
                <p>访问量</p></li>
        </ul>
    </div>
    <div class="personal-right">
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
