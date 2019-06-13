<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>智能选座系统</title>
    <link rel="stylesheet" type="text/css" href="<?=$url;?>css/reset.css<?=Yii::$app->params['static_number']?>">
    <link rel="stylesheet" type="text/css" href="<?=$url;?>js/layer/theme/default/layer.css<?=Yii::$app->params['static_number']?>">
    <link rel="stylesheet" type="text/css" href="<?=$url;?>css/seat.css?v=2" media="screen">

</head>
<body>
    <div id="container">
        <div class="buy" >
        <!-- title模块 -->
        <div class="buy-head">
            <p class="movie-showName">北京古城电影院</p>
            <p class="movie-time">今天 09-06 16：45 （国语2D）</p>
        </div>
        <!-- title模块 -->
        <div class="js_thumbnail thumbnail">
             <!-- 影厅与标注模块 -->
         <p class="hallName">4号厅</p>
         <p class="seat-title">
            <span class="sel">可选</span>
            <span class="noSel">已售</span>
            <span class="yesSel">已选</span>
         </p>
        <!-- 影厅与标注模块 -->
        <!-- 选座模块 -->
         <div class="seat-box" id="seatBox">
            <div class="seats-list" id="seatList">
                <!-- 排数模块 -->
                <div class="seat-row-box js_row_box">
                    
                </div>
                <!-- 排数模块 -->
                <!-- 座位模块 -->
                <div class="seats-wrapper js_seats_wrapper">
                    
                </div>
                <!-- 座位模块 -->
            </div>
         </div>
    </div>
       <!-- 底部提示选座模块 -->
      <div v-show='selMoney' class="buyShopping">
          <div class="hidden-scrollbar">
              <div class="js_selected_seat buy-info" id="selectedSeat">
                  
              </div>
          </div>
          <button class="confirm-btn">确认选座</button>
      </div>
    </div>
</body>
<script type="text/javascript" src="<?=$url;?>js/jquery.min.js"></script>
<script type="text/javascript" src="<?=$url;?>js/iscroll-zoom.js"></script>
<script type="text/javascript" src="<?=$url;?>js/hammer.min.js"></script>
<script type="text/javascript" src="<?=$url;?>js/layer/layer.js"></script>
<script type="text/javascript" src="<?=$url;?>js/seat.min.js"></script>
<script>
    layer.alert('滚动滚轮操作缩放，拖动页面上下滚动，手机访问可直接手势操作缩放', {
        skin: 'layui-layer-molv' //样式类名
    }, function(){
        layer.closeAll();
    });
</script>
</html>