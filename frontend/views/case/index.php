
<?= $this->render('../template/header',compact('data'));?>

<link rel="stylesheet" href="/asset/static/css/case.css">
<div class="case-list clearfix">
    <?php for($i = 0; $i < 100; $i++){?>
<!--        delay---><?//= $i % 5 ?><!--s-->
    <a href="/case/item/<?=$i?>" animate-type="slideInUp" class="case-item animated ">
        <div class="case-active-bg transition">
            <i class="iconfont transition">&#xe728;</i>
        </div>
        <div class="case-active-bg2 transition">
        </div>
        <img src="http://www.1000zhu.com/upload/image/201511/10/1153507477.jpg" alt="" class="case-img">
        <h2 class="case-title transition overflow-text">京城地铁官网</h2>
        <p class="case-desc transition overflow-text">国有企业 , 企业官网国有企业企业官网国有企业 , 企业官网国有企业 , 企业官网国有企业 , 企业官网</p>
    </a>
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