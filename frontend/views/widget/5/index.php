<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>智能选座系统</title>
    <link rel="stylesheet" type="text/css" href="<?=$url;?>css/reset.css">
    <link rel="stylesheet" type="text/css" href="<?=$url;?>js/layer/theme/default/layer.css">
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
<script type="text/javascript">
         
    // 0 - 过道 1 - 无人 2 - 已有人 3 - 自己已选
    // 作座位数据
    var seatData = [
        [[1,1,1],0,[1,1,1,1],0,[1,1,1,1,1],0,[1,1,1,1,1,1],0,[1,1,1,1,1,1,1],0,[1,1,1,1,1,1,1,1],0,[1,1,1,1,1,1,1,1],0,[1,1,1,1,1,1,1,1,1],0,[1,1,1,1,1,1,1,1,1,1]],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,2,2,2,2,2,2,2,2,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,2,2,2,2,2,2,2,2,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,2,2,2,2,2,2,2,2,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,2,2,2,2,2,2,2,2,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,2,2,2,2,2,2,2,2,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
        [1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,0,1,1,1,1,1,1,1,1,1,1,1,1],
       
    ];


    $.fn.seatCreate = function(opt){
        var setting = {
                data:[],
                offset : 30, //x轴偏移量 单位px
                tableWidth : 188, //设置桌子占的位置宽  单位px
                tableHeight : 188, //设置桌子占的位置宽  单位px
                isCheckout  : true, //是否开启多选
                checkoutNumber : 99999999999, //开启多选后最多可选数量
                isThumbnail : true, //是否开启缩略图
                thumbnailRank : 0.3, //缩放等级 建议0.3-0.5之间 opts.isThumbnail 为false此参数无效
                thumbnailLongShow : true,//是否持续显示|间断显示开关 opts.isThumbnail 为false此参数无效
                thumbnailWidth : 3,//缩略图可视区域的框宽度 opts.isThumbnail 为false此参数无效
                eventSeatSuccess:function(that){

                }

        };

        //参数覆盖
        var opts = $.extend(setting,opt);

        var boxWidth = 0; //可视区域宽
        var boxWidth = 0; //可视区域高
        var myScroll; //缩放对象
        var timer = 0; // 避免多次重复执行
        var thumbnailCount = 0;//显示缩略图的次数

        var M = {
            rowsElem : '', //行数的dom集合
            seatElem : '', //座位的dom集合
            seatBoxElem : $("#seatList"),
            initScale : 1,
        };

        // 初始化所有座位
        function seatInit(){
            $.each(opts.data,function(index,obj){
                //设置行数
                M.rowsElem += seatRows(index + 1,obj);
                M.rows = obj.length;
                M.seatElem += '<div class="rows-box clearfix">';
                var keys = 0;
                $.each(obj,function(key,val){
                    if(val != 0){
                       keys += 1;
                    }
                    //设置单个座位
                    if(Array.isArray(val)){
                        M.seatElem += seatTable(index,keys,val);
                    }else{
                        M.seatElem += seatItem(index,keys,val);
                    }
                });
                M.seatElem += '</div>';

            })
            //添加行数dom
            $('.js_row_box').append(M.rowsElem);
            M.cols = opts.data.length;
            //添加座位dom
            $(".js_seats_wrapper").append(M.seatElem);
            //绑定点击事件
            $(".js_seats_wrapper").delegate('.js_select_click','tap',function(){

                //如果点击的是缩量图则无效
                if($(this).parents('.js_thumbnail_box').length > 0) return;
                var reg = /seat-\d*-\d*?[-\d]*/g; //匹配类名
                var className = this.className.match(reg)[0];
                //判断是否是已经选过的
                if($(this).hasClass('noSel')){
                    return layer.msg('此座位已有人，请选择其他座位');
                }
                if($(this).hasClass('yesSel')){
                    $('.'+className).removeClass('yesSel').addClass('sel');
                    typeof(opts.eventSeatSuccess) == 'function' && opts.eventSeatSuccess($(this),false);
                    return;
                }
                //单选限制
                $('.'+className).addClass('yesSel').removeClass('sel');
                if(!opts.isCheckout && $(this).parents('.js_seats_wrapper').find('.js_select_click.yesSel').length > 1){
                    $('.'+className).removeClass('yesSel').addClass('sel');
                    return layer.msg('每人只能选一个座位'); 
                } 
                //多选限制
                if(opts.isCheckout && $(this).parents('.js_seats_wrapper').find('.js_select_click.yesSel').length > opts.checkoutNumber){
                    $('.'+className).removeClass('yesSel').addClass('sel');
                    return layer.msg('每人最多可选'+opts.checkoutNumber+'个座位'); 
                } 

                typeof(opts.eventSeatSuccess) == 'function' && opts.eventSeatSuccess($(this),true);

            })
            //定义盒子的宽高
            M.seatBoxWidth = $(".js_seats_wrapper")[0].clientWidth;
            M.seatBoxHeight = $(".js_seats_wrapper")[0].clientHeight;

            //设置盒子的宽高
            M.seatBoxElem.css({
                'width' : M.seatBoxWidth + opts.offset,
                'height': M.seatBoxHeight + opts.offset
            })
            
            //默认进来缩放100%宽
            boxWidth = parseInt($('#seatBox').css('width'));
            boxHeight = parseInt($('#seatBox').css('height'));
            M.scaleWidth = boxWidth / (M.seatBoxWidth + opts.offset).toFixed(1);
            M.scaleHeight = boxHeight / (M.seatBoxHeight + opts.offset).toFixed(1);
            //初始化为宽度100%;
            M.scale = M.scaleWidth;
            //显示全部座位信息;
            //M.scale = scaleWidth > scaleHeight ? scaleHeight : scaleWidth;
            M.minScale = M.scaleWidth > M.scaleHeight ? M.scaleHeight : M.scaleWidth;

            myScroll = new IScroll('#seatBox', {
                zoom: true,
                scrollX: true,
                scrollY: true,
                mouseWheel: true,
                wheelAction: 'zoom',
                zoomMin : M.scale,
                // click:true,
                tap:true
            });

            //初始化为最小
            myScroll.zoom(M.scale,0,0,300);
            myScroll.scrollTo(0, 0,100)

            //创建缩略图
            createThumbnail();
        }
        //排数
        function seatRows(rows,data){
            //判断data下面是否还有子数组
            var className = '';
            $.each(data,function(index,val){
                if(Array.isArray(val)){
                    className = 'table-row';
                }
            })
            var rows = '<div class="seat-row '+className+'">'+rows+'</div>';
            return rows;
        }
        //单个座位
        function seatItem(rows,cols,val){
            var className = '';
            switch(val){
                case 1:
                    className = 'sel js_select_click';
                    break;
                case 2:
                    className = 'noSel js_select_click';
                    break;
                case 3:
                    className = 'yesSel js_select_click';
                    break;
            }
            var item = '<div data-seat="'+(val != 0 ? (rows + 1)+'-'+cols : "")+'" class="seats-item seat-'+(val != 0 ? (rows + 1)+'-'+cols : "")+' '+className+'">\
                            <p class="seatName">'+(val != 0 ? (rows + 1)+'-'+cols : "")+'\
                            </p>\
                        </div>';
            return item;
        };

        //圆桌式座位
        function seatTable(rows,cols,data){
            if(data.length > 10) return alert('座位数不能大于10');
            var item = '<div class="circle-table circle-table'+data.length+'" style="width:'+opts.tableWidth+'px;height:'+opts.tableHeight+'px;line-height:'+opts.tableHeight+'px">'+(rows + 1)+'-'+cols+'号桌';
            $.each(data,function(key,val){
                var className = '';
                switch(val){
                    case 1:
                        className = 'sel js_select_click';
                        break;
                    case 2:
                        className = 'noSel js_select_click';
                        break;
                    case 3:
                        className = 'yesSel js_select_click';
                        break;
                }

                item += '<span data-seat="'+((rows + 1)+'-'+cols+'-'+(key + 1))+'" class="'+className+' circle-seat seat-'+((rows + 1)+'-'+cols+'-'+(key + 1))+'"></span>';
                                
            })

            item += '</div>';
            
            return item;
        }

        //生成缩略图方法
        function createThumbnail(){

            var thumbnailBox = $("<div class='create-thumbnail js_thumbnail_box'>")
            var thumbnail = thumbnailBox.append($(".js_thumbnail").clone());
            thumbnail.css('transform',"scale("+(opts.thumbnailRank)+")")
            $(".js_thumbnail").append(thumbnail);

            //增加缩略图视口
            var $visibleArea = $("<div class='visible-area'>").css({
                'width' : boxWidth,
                'height': boxHeight,
            });

            thumbnailBox.find('.seat-box').append($visibleArea);
            //初始化最初滚动信息
            M.maxScrollY = myScroll.maxScrollY;
            M.maxScrollX = myScroll.maxScrollX;
            M.scrollerHeight = myScroll.scrollerHeight;
            M.scrollerWidth = myScroll.scrollerWidth;
            //设置缩略图显示视图
            myScroll.on('scrollEnd',function(){
                var scaleX = myScroll.x / myScroll.maxScrollX;
                scaleX = !scaleX ? 0 : scaleX;
                var scaleY = myScroll.y / myScroll.maxScrollY;
            
                $('.js_thumbnail_box').find('.seats-list').css('top',M.maxScrollY*scaleY);

                //修改面积区域的位置
                $visibleArea.show(0).css({
                    'left': Math.abs(M.scaleWidth/myScroll.scale*myScroll.x),
                    'top' :Math.abs(M.scaleWidth/myScroll.scale*myScroll.y-M.maxScrollY*scaleY),
                    'border-width' : opts.thumbnailWidth * myScroll.scale * opts.thumbnailWidth
                })

                //是否持续显示缩略图
                if(opts.thumbnailLongShow) return;
                thumbnailCount++;
                if(thumbnailCount == 1) return $('.js_thumbnail_box').hide(); //第一次进入不显示缩略图
                if (timer) {
                  clearTimeout(timer);
                  timer = 0;
                }
                $('.js_thumbnail_box').show();

                timer = setTimeout(function () {
                    $('.js_thumbnail_box').hide();
                },3000)
            })

            //修改缩放后内容区域面积
            myScroll.on('zoomEnd',function(){ 
                if(M.scaleWidth > myScroll.scale) return $visibleArea.hide();
                $visibleArea.show(0).css({
                    'transform':'scale('+(M.scaleWidth/myScroll.scale)+')',
                })
                myScroll._events.scrollEnd[0]();
            })

        }

        //移动端缩放
        var app = document.getElementById("seatBox");
        var hammer = new Hammer(app);

        //启用pinch事件
         hammer.get('pinch').set({
            enable: true
        });

        hammer.on('pinchmove pinchstart pinchin pinchout', function(e) { console.log(e)
            //缩放
            if(e.type == "pinchstart"){
                M.initScale = M.scale || 1;
            }
            M.scale = M.initScale * e.scale;
            //M.seatBoxElem.css({'transform':'scale('+ M.initScale * e.scale+')'});
            myScroll.zoom(M.initScale * e.scale,myScroll.x,myScroll.y,0);
            //myScroll.scrollTo(myScroll.x,myScroll.y, 0);
            myScroll._events.zoomEnd[0]();
            myScroll._events.scrollEnd[0]();

        });

        //实例化
        seatInit();
    }

    $.fn.seatCreate({
            data : seatData,
            offset : 30, //x轴偏移量 单位px
            tableWidth : 150, //设置桌子占的位置宽  单位px
            tableHeight : 150, //设置桌子占的位置宽  单位px
            isCheckout  : true, //是否开启多选 
            checkoutNumber : 10, //开启多选后最多可选数量 isCheckout为false此参数无效
            isThumbnail : true, //是否开启缩略图
            thumbnailRank : 0.3, //缩放等级 建议0.3-0.5之间 opts.isThumbnail 为false此参数无效
            thumbnailLongShow : false,//是否持续显示|间断显示开关 opts.isThumbnail 为false此参数无效
            thumbnailWidth : 3,//缩略图可视区域的框宽度 opts.isThumbnail 为false此参数无效
            eventSeatSuccess:function(that,data){ console.log(that);
                if(data){
                    $('.js_selected_seat').append('<span class="js_selected_item js_selected_'+that.data("seat")+' css-selected-item">'+that.data("seat")+'</span>')
                }else{
                    $('.js_selected_'+that.data("seat")).remove();
                
                }
            }
        });


        //删除已选项
        $('.js_selected_seat').delegate('.js_selected_item','click',function(){
           
            $('.seat-'+$(this).text()).click();
        })
      
</script>
</html>