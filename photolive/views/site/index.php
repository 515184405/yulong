<?php
use common\models\Widget;
use common\models\MadeToOrder;
use common\models\Zixun;
?>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
       欢迎登录....
    </div>
</div>
<script>


    layui.config({
        base: '<?=Yii::$app->params["backend_url"]?>/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index'],function(){
        //询问框
        // if(localStorage.getItem('warn_tips')) return false;
        // layer.confirm('<span style="color:#f00;">在使用本站期间，上传的图片与内容请勿侵权他人<span>', {
        //     btn: ['确定'], //按钮
        //     title:'警告',
        //     closeBtn : false,
        // }, function(){
        //     localStorage.setItem('warn_tips', true);
        //     layer.closeAll();
        // });
    });
</script>

