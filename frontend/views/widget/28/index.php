<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>3d微信抽奖</title>
    <link rel="stylesheet" href="<?=$url;?>index.css" media="screen" type="text/css">
</head>
<body>
<div class="container none"></div>
<div class="mask"></div>
<div id="stop" class="btn_circle none">停止</div>
<div class="lucky_title">2018年美迪康年会抽奖活动</div>
<div class="loader_file">
    用户数据导入中 <span class="current_number"></span><span class="all_number"></span>
</div>
<div class="lucky_list clearfix">
    <div class="left lucky_prize">
        <div class="lucky_prize_box">
            <button class="lucky_prize_left lucky_prize_direction"><</button>
            <div data-default="1" class="lucky_prize_picture">
                <img class="lucky_prize_show none"
                     src="<?=$url;?>img/bXshiKc7Z2mQusImhSzC33czcBci3K.png"
                     alt="一等奖笔记本"/>
                <img class="none lucky_prize_show"
                     src="<?=$url;?>img/szSy9dU21WZnSdGwP9tE533ntEd1WE.png"
                     alt="二等奖平衡车"/>
                <img class="none lucky_prize_show"
                     src="<?=$url;?>img/gLz4H2xZ8XxkXlDDGdd8Fd2xF35kjX.png"
                     alt="三等奖现金红包"/>
            </div>
            <button class="lucky_prize_right active lucky_prize_direction">></button>
        </div>
        <div class="lucky_prize_title">一等奖笔记本</div>
        <div class="lucky_setting">
            <span>
                <b class="lucky_number">998</b>
                人参与
            </span>

            <div class="select_box">
                一次抽
                <select name="select_lucky_number" class='select_lucky_number'>
                    <option selected = "selected" value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
                人
            </div>
        </div>
        <div id="open" class="btn_circle btn_start">开始</div>
    </div>
    <div class="right lucky_people_list">
        <div class="lucky_people_title">中奖名单</div>
        <div class="lpl_list clearfix none">
            <!--<div class="lpl_userInfo">-->
            <!--<img class="lpl_userImage" src="http://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTK9YW8jiaJuo8xHZohXgpMpzVCWleDx4ko9zLn5B8iavAR2yQpeLMR5BQjf2jicwcGURXq5xf4yguwIQ/132"-->
            <!--alt=""/>-->
            <!--<p class="lpl_userName">小木姐姐</p>-->
            <!--</div>-->
        </div>
        <div class="lpl_list clearfix none">

        </div>
        <div class="lpl_list clearfix none">

        </div>
    </div>
</div>
</body>
<script type="text/javascript" src='<?=$url;?>js/jquery.min.js'></script>
<script type="text/javascript" src='<?=$url;?>js/transform.js'></script>
<script type="text/javascript" src='<?=$url;?>js/tick.js'></script>
<!--data为静态数据 如用ajax获取请取消输入引入-->
<!--抽奖动画-->
<script type="text/javascript" src='<?=$url;?>js/3d.js'></script>
<!--实际抽奖逻辑代码-->
<script type="text/javascript" src='<?=$url;?>js/lucky.js'></script>
<!-- ajax抽奖逻辑 -->
<!-- <script type="text/javascript" src='js/ajaxLucky.js'></script> -->
<script type="text/javascript" src = "<?=$url;?>js/data.js"></script>

</html>