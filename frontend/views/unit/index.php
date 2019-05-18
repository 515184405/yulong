
<?= $this->render('../template/header',compact('data'));?>

<link rel="stylesheet" href="/asset/static/css/case.css">
<div class="case-list unit-list clearfix">
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
                <span class="right"><i class="iconfont">&#xe602;</i><?=$val['down_count'] ?></span>
            </p>
        </a>
    <?php }else{ ?>
        无数据
    <?php } ?>
</div>
<script>
    function addAnimateDelay(){
        for(var i = 0,len = $('.animated').length;i < len; i++){
            var width = $('.case-list')[0].clientWidth - 60;
            var oneAWidth = 295;
            //删除已存在的delay-{{}}s;
            var reg = /delay-[0-9]s/g;
            console.log(i % Math.floor(width/oneAWidth))
            var classes = $('.animated')[i].className.match(reg);
            classes && $($('.animated')[i]).removeClass(classes[0]);
            $($('.animated')[i]).addClass('delay-'+i % Math.floor(width/oneAWidth)+'s')
        }
    }

    addAnimateDelay();

</script>
<?= $this->render('../template/footer');?>