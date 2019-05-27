<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/layui/css/layui.css">
<style>
    body{
        padding-top:60px;
    }
    .form-container{
        padding:50px 0;
        background-color: #f1f1f1;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .layui-form-item{
        margin-top:30px;
    }
    .dingzhi{
        padding:50px 150px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        background-color: #fff;
    }
    .dingzhi-title{
        font-size: 24px;
        font-weight: bold;
    }
    .dingzhi-banner{
        width: 100%;
        height:300px;
        background:url("/asset/static/image/dingzhi-banner.jpg") no-repeat center center;
        -webkit-background-size: auto 100%;
        background-size: auto 100%;
    }
    @media screen and (max-width: 768px) {
        body{
            padding-top:0px;
        }
        .form-container{
            padding:0px;
        }
        .dingzhi{
            padding:0;
            padding-right:15px;
            padding-top:15px;
        }
        .dingzhi-banner{
            height:120px;
        }
    }
</style>
<div class="dingzhi-banner"></div>
<div class="form-container">
    <form class="layui-form dingzhi fy-container" action="">
        <h2 class="t-c dingzhi-title">发布定制需求</h2>
        <div class="layui-form-item">
            <label class="layui-form-label">定制标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="title" autocomplete="off" placeholder="定制标题" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">素材文件</label>
            <div class="layui-input-block">
                <button type="button" class="layui-btn layui-btn-primary" id="file_upload"><i class="layui-icon"></i>上传文件</button>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">定制内容</label>
            <div class="layui-input-block">
                <textarea placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item ">
            <div class="layui-input-block">
                <button style="height:50px;line-height: 50px;" class="layui-btn layui-btn-normal layui-btn-fluid">立即定制</button>
            </div>
        </div>
    </form>
</div>
<script src="<?=Yii::$app->params['backend_url']?>/asset/layui/layui.js"></script>
<script>
    layui.config({
        base: '<?=Yii::$app->params["backend_url"]?>/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index','form','upload'], function() {
        var $ = layui.$,
            form = layui.form,
            upload = layui.upload;


        //指定允许上传的文件类型
        upload.render({
            elem: '#file_upload'
            , url: '/upload/'
            , accept: 'file' //普通文件
            , done: function (res) {
                console.log(res)
            }
        });
    })
</script>