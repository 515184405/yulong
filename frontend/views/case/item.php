
<?= $this->render('../template/header',compact('data'));?>
<link rel="stylesheet" href="/asset/static/wigdet/share/share.min.css">
<link rel="stylesheet" href="/asset/static/css/item.css">

<div class="news-items case-items">
    <div class="news-hidden-scroll js_news_items">
        <img class="case-banner" src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1557571160202&di=ffe2cc9109a1032e98386fcb346cb987&imgtype=0&src=http%3A%2F%2Fimages.hisupplier.com%2Fvar%2FuserImages%2F201609%2F23%2F160034532709_s.jpg" alt="">
        <h2 class="case-title">项目简介</h2>
        <div class="case-desc">
            <p style="text-indent: 2rem;">ATA是一家纳斯达克上市公司，以考试与测评服务为主营业务的公司，总部位于北京，运营中心在上海。ATA以世界领先的考试技术，丰富的考试运营和管理经验，以及遍布全国的3,000余家考站为政府机构，教育机构，企事业单位和数千万考生提供专业化的考试和测评服务。</p>
            <p style="text-indent: 2rem;">ATA的网站建设项目采用了当前比较前沿的技术，HTML5响应式网站布局，整体设计风格采用了简约欧美风，布局均采用一屏布局，其中的交互动画充满了科技感，酷炫的动画使整个网站充满活力，更多精彩可以关注ATA官网。</p>
        </div>
        <h2 class="case-title">项目标签</h2>
        <div class="case-dress">
            <i class="iconfont theme" style="font-size: 22px;position:relative;top:2px;">&#xe634;</i>
            <a href="#" class="theme case-tag">设计案例</a><a href="#" class="theme case-tag">宇龙精选</a>
        </div>
        <h2 class="case-title">项目地址</h2>
        <div class="case-dress">
            <p>电脑端：<a href="http://www.baidu.com">http://www.baidu.com</a></p>
            <p>移动端：<a href="http://www.baidu.com">http://www.baidu.com</a></p>
            <div class="case-dress-wxbox">
                <img class="case-dress-wx" style="width:120px;height:120px;" src="http://www.1000zhu.com/images/wechat_code.jpg" alt="">
                <p>扫一扫微信二维码</p>
            </div>
        </div>
        <h2 class="case-title">分享精品</h2>
        <div id="share" class="case-share"></div>
        <h2 class="case-title">设计欣赏</h2>
        <img class="case-show-img js_case_list" src="http://www.1000zhu.com/upload/image/201610/24/0117212543.gif" alt="">
        <div class="js_list_box case-swipper" data-show="0">
            <img class="case-show-img" data-src="https://www.yilinicms.com/public/uploads/20181101/10621621b41b90eb6511686975e0fc98.jpg" alt="">
            <img class="case-show-img" data-src="https://www.yilinicms.com/public/uploads/20181101/df459cee12342cf507c13e6903a47a12.jpg" alt="">
            <img class="case-show-img" data-src="https://www.yilinicms.com/public/uploads/20181101/3224dd69bce7c52cce0a1c9a87442bba.jpg" alt="">
        </div>
    </div>
</div>
<?= $this->render('../template/right_aslide');?>
<script src="/asset/static/wigdet/share/jquery.share.min.js"></script>
<script src="/asset/static/js/case-item.js"></script>
<script>
    //分享功能
    $('#share').share({sites: ['qzone', 'qq', 'weibo','wechat']});
    // 动态设置右侧高度固定右侧
    // function setRightHeight(){
    //     var winH = $(window).height();
    //     var top = 75;
    //     $('.js_news_items,.js_news_recommend').css('height',winH - top);
    // }
    // setRightHeight();
</script>
<?= $this->render('../template/footer');?>
<p class="swipper-number none"><span class="sn-current">1</span> / <span class="sn-count">3</span></p>
