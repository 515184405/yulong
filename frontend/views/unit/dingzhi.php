<?php $this->title="聚友团队 - 组件定制"; ?>
<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/layui/css/layui.css<?=Yii::$app->params['static_number']?>">
<style>
    body{
        padding-top:60px;
        background-color: #f5f5f5;
    }
    .form-container{
        padding:50px 0;
        background-color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .layui-form-item{
        margin-top:30px;
    }
    .dingzhi{
        padding:50px 250px;
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
    .news-recommend{
        background-color: transparent;
    }
    .layui-upload-img {
        width: 92px;
        height: 92px;
        margin: 0 10px 10px 0;
    }
    @media screen and (max-width: 768px) {
        body{
            padding-top:0px;
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
    <form class="layui-form dingzhi fy-container">
        <h2 class="t-c dingzhi-title">发布定制需求</h2>
        <div class="layui-form-item">
            <label class="layui-form-label">联系人姓名</label>
            <div class="layui-input-block">
                <input type="text" name="username" lay-verify="required" lay-text="联系人姓名不能为空" autocomplete="off" placeholder="联系人姓名" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">联系人电话</label>
            <div class="layui-input-block">
                <input type="text" name="tel" lay-verify="tel" autocomplete="off" placeholder="联系人电话" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">定制标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" lay-verify="required" lay-text="定制标题不能为空" autocomplete="off" placeholder="定制标题" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">素材图片</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <button type="button" class="layui-btn" id="upload_image">上传图片</button>
                    <input type="hidden" name="file_url" class="js_file_url"  lay-verify="required"  lay-text="素材文件不能为空">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="test-upload-normal-img">
                        <p id="demoText"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">定制内容</label>
            <div class="layui-input-block">
                <textarea name="desc" lay-verify="required" placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button lay-submit="" lay-filter="submit-btn" class="layui-btn layui-btn-normal layui-btn-fluid">立即定制</button>
            </div>
        </div>
    </form>
</div>
<script src="<?=Yii::$app->params['backend_url']?>/asset/layui/layui.js"></script>
<script>
    layui.use(['form','upload'], function() {
        var $ = layui.$,
            form = layui.form,
            upload = layui.upload;

        var csrfName = $("#form_csrf").attr('name');
        var csrfVal = $("#form_csrf").val();
        var uploadImageData = {
            fileName : 'file_url',
            caseDir : 'dingzhi/',
        };
        uploadImageData[csrfName] = csrfVal;
        //普通图片上传
        var uploadInst = upload.render({
            elem: '#upload_image'
            , url: '/site/upload-image'
            ,data:uploadImageData
            , before: function (obj) {
                layer.msg('上传中...', {
                    icon: 16,
                    time: 0,
                    shade: [0.1, '#000']
                });
                //预读本地文件示例，不支持ie8
                obj.preview(function (index, file, result) {
                    $('#test-upload-normal-img').attr('src', result); //图片链接（base64）
                });
            }
            , done: function (res) {
                layer.closeAll();
                //上传成功
                if(res.code == 100000){
                    $('.js_'+res.data.fileName).val(res.data.fileSrc);
                }
                //如果上传失败
                if (res.code == 100001) {
                    return layer.msg('上传失败');
                }
            }
            , error: function () {
                //演示失败状态，并实现重传
                var demoText = $('#test-upload-demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function () {
                    uploadInst.upload();
                });
            }
        })

        //自定义验证规则
        form.verify({
            tel: function(value){
                if(!(/^[1][0-9]{10}$/.test(value))){
                    return '请填写正确的手机号码';
                }
            }
        });

        /* 监听提交 */
        form.on('submit(submit-btn)', function(data) {
            layer.load(1, {shade: .1});
            var _this = this;_this.disabled=true;//防止多次提交
            var params = data.field;
            params[csrfName] = csrfVal;
            $.ajax({
                type: "post",
                url: "",
                data: params,
                dataType: "json",
                success: function(res) {
                    layer.closeAll();
                    _this.disabled=false;
                    layer.msg(res.message, {icon: 1,time:1000}, function(){
                        history.go(-1);
                    })
                },
                error: function(){
                    layer.closeAll();
                    _this.disabled=false;
                    layer.msg('操作失败', {icon: 5}, function(){
                        window.location.reload();
                    })
                }
            });
            return false;
        })
    })
</script>