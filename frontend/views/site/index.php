<?php

/* @var $this yii\web\View */

$this->title = '宇龙科技 - 北京网站建设,网站制作,网站设计,专业网站建设';
?>
<link rel="stylesheet" href="/asset/static/wigdet/swiper/swiper.min.css">
<link rel="stylesheet" href="/asset/static/css/index.css">
<!--首页背景-->
<canvas id="canvas" class="canvas-cls"></canvas>
<!--首页背景-->
<!--轮播图-->
<!-- Swiper -->
<div id="IE_false" class="swiper-container swiper-container-initialized swiper-container-horizontal none">
    <div class="swiper-wrapper">
        <?php foreach ($data['banner'] as $key=>$v1){ ?>
        <a target="_blank" href="<?=$v1['url']?>" class="swiper-slide <?=$key==0 ? 'swiper-slide-active' : ($key==1 ? 'swiper-slide-next' : '');  ?> ">
            <div class="title">
                <!--<h3>Adidas NMD</h3>-->
            </div>
            <div class="img-box"><img src="<?=Yii::$app->params['backend_url'].$v1['banner_url'];?>"/></div>
        </a>
        <?php } ?>
    </div>
    <div class="button-prev button disabled">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 350 160 90">
            <g id="arrow-svg-home">
                <g id="circ" class="cls-1">
                    <circle cx="42" cy="42" r="40" class="cls-4"></circle>
                </g>
                <g id="arrow">
                    <path id="arrow-trg" d="M.983,6.929,4.447,3.464.983,0,0,.983,2.482,3.464,0,5.946Z"></path>
                </g>
                <path id="line" d="M120,0H0" class="cls-3"></path>
            </g>
        </svg>
    </div>
    <div class="button-next button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 350 160 90">
            <g id="arrow-svg-home">
                <g id="circ" class="cls-1">
                    <circle cx="42" cy="42" r="40" class="cls-4"></circle>
                </g>
                <g id="arrow">
                    <path id="arrow-trg" d="M.983,6.929,4.447,3.464.983,0,0,.983,2.482,3.464,0,5.946Z"
                          class="cls-2"></path>
                </g>
                <path id="line" d="M120,0H0" class="cls-3"></path>
            </g>
        </svg>
    </div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
</div>
<!--ie10-11-->
<div id="ie-swiper" class="swiper-container ie-swiper none">
    <div class="swiper-wrapper">
        <?php foreach ($data['banner'] as $key=>$v2){ ?>
        <a target="_blank" href="<?=$v2['url']?>" class="swiper-slide" style="background-image:url('<?=Yii::$app->params['backend_url'].$v2['banner_url'];?>')"></a>
        <?php } ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<!-- Swiper -->
<!--轮播图-->
<!--服务类目-->
<section class="section-service">
    <div class="fy-container  service-list">
        <h2 animate-type="slideInUp" class="animated section-title theme animated">用心服务 追求客户满意</h2>
        <p animate-type="slideInUp" class="animated section-desc animated">准备好了“互联网+”之旅？首先您需要一个适合您的网站！</p>
        <ul animate-type="slideInUp" class="section-ul animated clearfix">
            <li animate-type="slideInUp" class="animated">
                <a href="javascript:;">
                    <i class="iconfont transition theme">&#xe616;</i>
                    <p class="li_title">【品牌网站设计】</p>
                    <p class="li_desc">注重美工形象的客户，以创意元素设计企业品牌宣传型的网站,让访客产生眼前一亮的感觉</p>
                </a>
            </li>
            <li animate-type="slideInUp" class="animated delay-1s">
                <a href="javascript:;">
                    <i class="iconfont transition theme">&#xe658;</i>
                    <p class="li_title">【手机/电脑响应式网站】</p>
                    <p class="li_desc">响应式设计在PC、电脑、手机通网址相同体验,用户体验度友好</p>
                </a>
            </li>
            <li animate-type="slideInUp" class="animated delay-2s">
                <a href="javascript:;">
                    <i class="iconfont transition theme">&#xe60f;</i>
                    <p class="li_title">【高端网站定制】</p>
                    <p class="li_desc">网站内容完全按照企业的产品，企业的形象、宣传推广来制作设计，更利于企业的发展</p>
                </a>
            </li>
            <li animate-type="slideInUp" class="animated delay-3s">
                <a href="javascript:;">
                    <i class="iconfont transition theme">&#xe65a;</i>
                    <p class="li_title">【小程序/公众号开发】</p>
                    <p class="li_desc">增粉、微店、推广、用户活跃度高等全方便优势</p>
                </a>
            </li>
        </ul>
        <div class="service-project clearfix">
            <div animate-type="slideInUp" class="left service-item1 animated">
                <div class="service-insert">
                    <a href="javascript:;">
                        <img src="/asset/static/image/MacBook.png" alt="电脑端">
                        <h2 class="si_title">PC网站建设</h2>
                        <p class="si_desc">符合pc电脑大屏的视觉设计效果，展现企业形象，宣传产品和服务</p>
                    </a>
                </div>
            </div>
            <div animate-type="slideInUp" class="left service-item2 animated delay-1s">
                <div class="service-insert">
                    <a href="javascript:;" class="clearfix">
                        <img src="/asset/static/image/wap-demo.png" class="left" alt="手机端">
                        <h2 class="si_title left">手机网站建设</h2>
                        <p class="si_desc left">符合智能手机用户的UI，功能设计，自适应不同屏幕尺寸，访问速度快</p>
                    </a>
                </div>
            </div>
            <div animate-type="slideInUp" class="left service-item3 animated delay-2s">
                <div class="service-insert">
                    <a href="javascript:;" class="clearfix">
                        <img src="/asset/static/image/wx-demo.png" class="left" alt="微信网站">
                        <h2 class="si_title left">小程序/微商城制作</h2>
                        <p class="si_desc left">微信公众号，小程序开发，微商城，让您轻松开启移动营销</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--服务类目-->
<!--建站流程-->
<section class="section-liucheng">
    <div class="fy-container">
        <h2 animate-type="slideInUp" class="section-title animated theme">建站流程</h2>
        <p animate-type="slideInUp" class="section-desc animated">每一步都为您面面俱到，不忽略每个细节！</p>
        <div animate-type="slideInUp" class="flow-wrap animated">
            <div class="start">开 始</div>
            <ul class="flow-menu">
                <li class="li1">
                    <div class="flow-i">
                        <i class="i1"></i><span>1</span>商务洽谈
                    </div>
                    <div class="flow-text">
                        <p><span>1、</span>需求规划</p>
                        <p><span>2、</span>方案报价</p>
                        <p><span>3、</span>签订合同</p>
                    </div>
                </li>
                <li class="li2">
                    <div class="flow-i">
                        <i class="i2"></i><span>2</span>策划设计
                    </div>
                    <div class="flow-text">
                        <p><span>1、</span>原型图设计</p>
                        <p><span>2、</span>UI界面设计</p>
                        <p><span>3、</span>修改确认</p>
                    </div>
                </li>
                <li class="li3">
                    <div class="flow-i">
                        <i class="i3"></i><span>3</span>封闭开发
                    </div>
                    <div class="flow-text">
                        <p><span>1、</span>前端页面编写</p>
                        <p><span>2、</span>后台+功能模块开发</p>
                        <p><span>3、</span>域名+服务器准备</p>
                    </div>
                </li>
                <li class="li4">
                    <div class="flow-i">
                        <i class="i4"></i><span>4</span>上线测试
                    </div>
                    <div class="flow-text">
                        <p><span>1、</span>测试修复BUG</p>
                        <p><span>2、</span>域名解析+服务器部署</p>
                        <p><span>3、</span>上线并上传测试内容</p>
                    </div>
                </li>
                <li class="li5">
                    <div class="flow-i">
                        <i class="i5"></i><span>5</span>技术支持
                    </div>
                    <div class="flow-text">
                        <p><span>1、</span>项目交付</p>
                        <p><span>2、</span>免费提供培训</p>
                        <p><span>3、</span>提供技术支持1年</p>
                    </div>
                </li>
            </ul>
            <img src="/asset/static/image/kf.png" alt="" class="end">
        </div>
    </div>
</section>
<!--建站流程-->
<!--项目案例-->
<section class="section-project">
    <div class="fy-container">
        <h2 animate-type="slideInUp" class="section-title animated theme">案例展示</h2>
        <p animate-type="slideInUp" class="section-desc animated">认真服务好每一位客户,让客户满意是我们的宗旨！</p>
        <p animate-type="slideInUp"  class="section-btn-box animated overflow-text">
        <a target="_blank" href="/case">全 部</a>
            <?php foreach ($data['case_type'] as $v3) { ?>
                <a target="_blank" href="/case?id=<?=$v3['type_id']?>"><?=$v3['title']?></a>
            <?php }?>
        </p>
        <div class="sp-list clearfix">
            <?php foreach ($data['case'] as $k4=>$v4) {  ?>
            <a animate-type="slideInUp" class="sp-item animated delay-<?=$k4%3?>s" target="_blank" href="/case/item/<?=$v4['id'];?>">
                <div class="sp-item-top transition" style="background-image:url('<?=Yii::$app->params['backend_url'].$v4['banner_url']; ?>')">
                    <div class="spi-top-active transition">
                        <p class="_line transition"></p>
                        <span class="hover-title transition">查看项目</span>
                        <p class="_line transition"></p>
                    </div>
                    <!--<img class="sp-item-img" src="" alt="">-->
                </div>
                <div class="sp-item-bottom transition">
                    <p class="sib-title overflow-text"><?=$v4['title'];?></p>
                    <p class="sib-desc">
                        <?= str_replace(",",' / ',$v4['tag_id']); ?>
                    </p>
                    <p class='clearfix sib-btn'>
                        <span class="left">详情</span>
                        <i class="iconfont right transition">&#xe600;</i>
                    </p>
                </div>
            </a>

            <?php } ?>
        </div>
    </div>
</section>
<!--项目案例-->
<!--组件案例-->
<section class="section-project unit-project">
    <div class="fy-container">
        <h2 animate-type="slideInUp" class="section-title animated theme">组件展示</h2>
        <p animate-type="slideInUp" class="section-desc animated">积攒更多更好的组件，开发效率才是最高的</p>
        <p animate-type="slideInUp"  class="section-btn-box animated overflow-text">
            <a target="_blank" href="/unit">全 部</a>
            <?php foreach ($data['widget_type'] as $v5) { ?>
                <a target="_blank" href="/unit?id=<?=$v5['type_id']?>"><?=$v5['title']?></a>
            <?php }?>
        </p>
        <div class="sp-list clearfix">
            <div class="sp-list clearfix">
                <?php foreach ($data['widget'] as $k6=>$v6) {  ?>
                    <a animate-type="slideInUp" class="sp-item animated delay-<?=$k6%3?>s" target="_blank" href="/unit/item/<?=$v6['id'];?>">
                        <div class="sp-item-top transition" style="background-color:rgba(<?=rand(0,255);?>,<?=rand(0,255);?>,<?=rand(0,255);?>,1);background-image:url('<?=Yii::$app->params['backend_url'].$v6['banner_url']; ?>')">
                            <div class="spi-top-active transition">
                                <p class="_line transition"></p>
                                <span class="hover-title transition">查看组件</span>
                                <p class="_line transition"></p>
                            </div>
                            <!--<img class="sp-item-img" src="" alt="">-->
                        </div>
                        <div class="sp-item-bottom transition">
                            <p class="sib-title overflow-text"><?=$v6['title'];?></p>
                            <p class="sib-desc unit-desc">
                                <i class="iconfont">&#xe618;</i><?=$v6['look'];?>
                                <i style="margin-left:30px;" class="iconfont">&#xe602;</i><?=$v6['down_count'];?>
                            </p>
                            <p class='clearfix sib-btn'>
                                <span class="left">详情</span>
                                <i class="iconfont right transition">&#xe600;</i>
                            </p>
                        </div>
                    </a>

                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!--组件案例-->
<!--新闻列表-->
<section class="section-news">
    <div class="fy-container">
        <h2 animate-type="slideInUp" class="section-title animated theme">新闻动态</h2>
        <p animate-type="slideInUp" class="section-desc animated">我们一直在学习与进步 对精品网站的追求与研究从未停止</p>
        <div class="news-list clearfix">
            <?php foreach ($data['news'] as $index=>$news) {  ?>
                <div animate-type="slideInUp" class="news-item left animated delay-<?=$index%3?>s">
                <div class="news-item-insert">
                    <?php if($index == 0){ ?>
                        <div class="news-first-image"></div>
                    <?php } ?>
                    <a target="_blank" href="/news/item/<?=$news['id']?>" class="news-content transition">
                        <div class="clearfix">
                            <div class="left news-date">
                                <b><?=date('d',$news['create_time']); ?></b>
                                <p><?=date('Y-m',$news['create_time']); ?></p>
                            </div>
                            <div class="news-title overflow-text2">
                                <h2><?=$news['title']; ?></h2>
                            </div>
                        </div>
                        <div class="news-text overflow-text2">
                            <h2><?=$news['desc']; ?></h2>
                        </div>
                    </a>
                </div>
            </div>
           <?php } ?>
        </div>
    </div>
</section>
<!--新闻列表-->
<script src="/asset/static/wigdet/swiper/swiper.min.js"></script>
<script src="/asset/static/js/index.js"></script>