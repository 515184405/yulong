<?php
    use yii\widgets\LinkPager;
?>
<?php $this->title='聚友团队 - 组件列表' ?>

<?= $this->render('../template/header',compact('data'));?>

<link rel="stylesheet" href="/asset/static/css/case.css">
<div class="case-list unit-list clearfix">
    <div class="search-wrapper">
        <div class="search-box">
            <input type="text" id="search_input" autocomplete="off" value="<?=isset($_GET['search']) ? $_GET['search'] : ''?>" class="search-input" placeholder="请输入筛选内容">
            <button id="search_btn" class="search-btn">搜 索</button>
        </div>
    </div>
    <?php if(!isset($_GET['page']) || $_GET['page'] == 1 ){ ?>
    <a href="/unit/dingzhi" animate-type="slideInUp" class="case-item animated ">
        <img style="background-color:rgb(<?=rand(0,255);?>,<?=rand(0,255);?>,<?=rand(0,255);?>)" src="/asset/static/image/dingzhi.png" alt="定制开发" class="case-img transition">
        <h2 class="case-title transition overflow-text">组件定制开发</h2>
        <p class="case-desc transition overflow-text2">任意发布需求，前端组件开发定制，周期短费用低</p>
        <p class="case-info">
            <button class="fy-btn fy-btn-danger" style="width: 100%;padding:8px 0;margin-top:10px;">发布定制</button>
        </p>
    </a>
    <?php } ?>
    <?php if(count($data['unit'])) foreach ($data['unit'] as $val){?>
        <!--        delay---><?//= $i % 5 ?><!--s-->
        <a href="/unit/item/<?=$val['id']?>" animate-type="slideInUp" class="case-item animated ">
            <img style="background-color:rgb(<?=rand(0,255);?>,<?=rand(0,255);?>,<?=rand(0,255);?>)" src="<?=Yii::$app->params['backend_url'].$val['banner_url']?>" alt="" class="case-img transition">
            <h2 class="case-title transition overflow-text"><?=$val['title']?></h2>
            <p class="case-desc transition overflow-text2"><?=strip_tags($val['desc'])?></p>
            <p class="case-type transition overflow-text">
                <i class="iconfont">&#xe62c;</i>
                <?php foreach ($val['type_tag'] as $item){ ?>
                <span> <?=$item  ?> </span>
                <?php } ?>
            </p>
            <p class="case-info clearfix">
                <span class="left"><i class="iconfont">&#xe618;</i><?=$val['look'] ?></span>
                <span style="margin-left:15px;" class="left"><i class="iconfont">&#xe6ca;</i><?=$val['collect'] ?></span>
                <?php if($val['is_down'] == 0 ){ ?>
                    <span class="right"><i class="iconfont">&#xe602;</i><?=$val['down_count'] ?></span>
                <?php } ?>
            </p>
        </a>
    <?php } ?>
</div>
    <div class="t-c">
        <?= LinkPager::widget([
            'pagination' => $data['pagination'],
        ]) ?>
    </div>
<script>
    function addAnimateDelay(){
        var width = $('.case-list')[0].clientWidth - 60;
        var oneAWidth = 335;
        var number = Math.floor(width/oneAWidth);
        //$('.case-list').css('width',number * oneAWidth);

        for(var i = 0,len = $('.animated').length;i < len; i++){
            number = number ? number : 1;
            //删除已存在的delay-{{}}s;
            var reg = /delay-[0-9]s/g;
            var classes = $('.animated')[i].className.match(reg);
            classes && $($('.animated')[i]).removeClass(classes[0]);
            $($('.animated')[i]).addClass('delay-'+i % number+'s')
        }
    }

    addAnimateDelay();

    // 按钮搜索
    $("#search_btn").click(function(){
        var val = $('#search_input').val();
        window.location.href = '/unit?search='+val;
    })

    //回车搜索
    $("#search_input").keydown(function(event){
        event=document.all?window.event:event;
        if((event.keyCode || event.which)==13){
            var val = $('#search_input').val();
            window.location.href = '/unit?search='+val;
        }
    });

</script>
<?= $this->render('../template/footer');?>