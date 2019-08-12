<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?=$widget['title']?></title>
    <link href="/asset/static/demo-look/css/index.css" rel="stylesheet" media="screen" />
    <script type="text/javascript" src="/asset/static/wigdet/jquery.min.js"></script>
    <script type="text/javascript" src="/asset/static/demo-look/js/jquery.qrcode.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            function fixHeight() {
                var headerHeight = $("#switcher").height();
                $("#iframe").attr("height", $(window).height()-49+ "px");
            }
            $(window).resize(function () {
                fixHeight();
            }).resize();

            $('.yu-monitor').addClass('active');

            /*点击通用方法*/
            function commonClickFun(domClassName,addClassName){
                $(domClassName).click(function () {

                    $('#iframe-wrap').removeClass().addClass(addClassName);
                    $('#Device li div[class^="yu"]').removeClass('active');
                    $(this).addClass('active');
                    return false;
                });
            }

            //绑定点击事件
            commonClickFun(".yu-mobile-3",'mobile-width-3');
            commonClickFun(".yu-mobile-2",'mobile-width-2');
            commonClickFun(".yu-mobile-1",'mobile-width');
            commonClickFun(".yu-tablet",'tablet-width');
            commonClickFun(".yu-monitor",'full-width');


            function fyAlertTips(){
                // alert('无效操作');
                // return false;
            }

            document.onkeydown=function(){
                var e = window.event||arguments[0];
                if(e.keyCode==123){
                    return fyAlertTips();
                }else if((e.ctrlKey)&&(e.shiftKey)&&(e.keyCode==73)){
                    return fyAlertTips();
                }else if((e.ctrlKey)&&(e.keyCode==85)){
                    return fyAlertTips();
                }else if((e.ctrlKey)&&(e.keyCode==83)){
                    return fyAlertTips();
                }
            }
            document.oncontextmenu=function(){
                return fyAlertTips();
            }
            //生成二维码
            jQuery('#qrcode').qrcode({width:150,height: 150,text: window.location.href});
        });

    </script>
</head>
<body>

<div id="switcher">
    <div class="center">
        <ul>
            <div id="Device">
                <li class="device-monitor"><a href="javascript:"><div class="yu-monitor"></div></a></li>
                <li class="device-mobile"><a href="javascript:"><div title="iPad 768*1024" class="yu-tablet"></div></a></li>
                <li class="device-mobile"><a href="javascript:"><div title="iPad横屏 768*1024" class="yu-mobile-1"></div></a></li>
                <li class="device-mobile-2"><a href="javascript:"><div title="iPhone6/7/8 375*667" class="yu-mobile-2"></div></a></li>
                <li class="device-mobile-3"><a href="javascript:"><div title="iPhone6/7/8横屏 667*375" class="yu-mobile-3"></div></a></li>
            </div>
            <li class="top2">
                <a href="#">手机二维码预览</a>
                <div class="vm">
                    <div class="qrcode" id="qrcode"></div>
                    <p style="color:#808080;margin:10px 0 0 0;">扫一扫，直接在手机上打开</p>
                </div>
            </li>
            <li class="title">
                <a href="<?=Yii::$app->params['static_url']?>/<?=$widget['id']?>/<?=$widget['enter_file']?>"><?=$widget['title']?></a>
            </li>
            <li class="remove_frame"><a href="<?=Yii::$app->params['static_url']?>/<?=$widget['id']?>/<?=$widget['enter_file']?>" title="移除框架"></a></li>
        </ul>
    </div>
</div>

<div id="iframe-wrap">
    <iframe id="iframe" src="<?=Yii::$app->params['static_url']?>/<?=$widget['id']?>/<?=$widget['enter_file']?>" frameborder="0"  width="100%"></iframe>
</div>

</body>
</html>
