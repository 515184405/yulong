<?php
use yii\widgets\LinkPager;
?>
<?php $this->title="聚友团队 - 案例列表" ?>
<?= $this->render('../template/header',compact('data'));?>

<link rel="stylesheet" href="/asset/static/css/case.css<?=Yii::$app->params['static_number']?>">
<div class="case-list clearfix">
    <?php if(count($data['case'])) foreach ($data['case'] as $val){?>
<!--        delay---><?//= $i % 5 ?><!--s-->
    <a href="/case/item/<?=$val['id']?>" animate-type="slideInUp" class="case-item animated ">
        <div class="case-active-bg transition">
            <i class="iconfont transition">&#xe728;</i>
        </div>
        <div class="case-active-bg2 transition">
        </div>
        <img src="<?=Yii::$app->params['backend_url'].$val['banner_url']?>" alt="" class="case-img">
        <h2 class="case-title transition overflow-text"><?=$val['title']?></h2>
        <p class="case-desc transition overflow-text"><?=strip_tags($val['desc'])?></p>
    </a>
    <?php }else{ ?>
        无数据
    <?php } ?>
</div>

<div class="t-c">
    <?= LinkPager::widget([
        'pagination' => $data['pagination'],
    ]) ?>
</div>
<script>
    function addAnimateDelay(){
        for(var i = 0,len = $('.animated').length;i < len; i++){
            var width = $('.case-list')[0].clientWidth - 60;
            var oneAWidth = 295;
            //删除已存在的delay-{{}}s;
            var reg = /delay-[0-9]s/g;
            var classes = $('.animated')[i].className.match(reg);
            classes && $($('.animated')[i]).removeClass(classes[0]);
            $($('.animated')[i]).addClass('delay-'+i % Math.floor(width/oneAWidth)+'s')
        }
    }

    addAnimateDelay();

</script>
<?= $this->render('../template/footer');?>