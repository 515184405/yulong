<?php $this->title="聚友团队 - 关于我们"; ?>
<link rel="stylesheet" href="/asset/static/css/other.css<?=Yii::$app->params['static_number']?>">
<div class="site-wrapper">
    <div class="site-banner"></div>
    <div class="site-content fy-container">
        <div class="site-title">聚友简介</div>
        <div class="site-text">
            <p>聚友团队（www.yu313.cn），成立于2019年6月，汇集大部分各界网络公司精英人才</p>
            <p>聚友团队（www.yu313.cn），秉承着公司以最少的价格获取最优的网络服务。团队人员来自各个网络公司的精英人才，产品经理统一分配任务，技术管理人员统一核验代码。各个精英人才以git代码托管方式共同进行模块开发，人员多，效率高，比传统的外包公司固定人员多，开发快。</p>
        </div>
    </div>
    <div class="site-content fy-container">
        <div class="site-title">我们的优势</div>
        <div class="site-text">
            <p>提供全流程网站服务，包括但不限于门户网站、电子商务类网站、网店建设（如淘宝店、天猫店、京东店等）、网店装修、视频/多媒体类网站、论坛/社区类网站和博客及个人主页等从建设、域名及服务器空间办理、SEO优化与推广和运营、统计分析的全部操作过程；</p>
            <p>提供不同浏览终端的网站/软件服务，包括但不限于电脑版、手机版和app（手机和平板电脑），满足您或贵公司不同发展阶段的系统建设需求；</p>
            <p>提供全方位品牌策划，包括但不限于品牌分析、品牌设计、品牌传播、品牌管理、设计顾问与咨询。</p>
            <p>当今的日常竞争，已经演变成产品质量、价格、售后服务和品牌形象、企业信誉以及消费者深层次沟通等问题解决的全面战场。作为企业的助手、战略合作伙伴，我们从调查、策划、创意、制作、优化、投放、推广到信息反馈与分析，都必经运筹帷幄、出奇制胜。想客户之所想、急客户之所急，分担客户企业生存与发展的压力，并为此付出不懈的努力！</p>
        </div>
    </div>
    <div class="site-content fy-container">
        <div class="site-title">我们的团队</div>
        <div class="site-text clearfix">
            <?php foreach ($data as $key=>$val){ ?>
            <a class="site-team" href="javascript:;">
                <img style="background:rgba(<?=rand(0,200)?>,<?=rand(0,200)?>,<?=rand(0,200)?>,.2)" src="<?=Yii::$app->params['backend_url'].$val['avatar']?>" alt="<?=Yii::$app->params['backend_url'].$val['avatar']?>">
                <p>姓名：<b><?=$val['name']?></b></p>
                <p>职业：<b><?=$val['profession']?></b></p>
                <p>经验：<b><?=$val['exp']?>年</b></p>
            </a>
            <?php } ?>
        </div>
    </div>
</div>
