<?php
    use kucha\ueditor\UEditor;
?>
<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/layui/css/layui.css" media="all">
<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/lib/select2/css/select2.min.css">
<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/style/jquery.tagsinput.css">
<link rel="stylesheet" href="/asset/static/css/personal.css">
<style>
    .select2-container--default.select2-container--focus .select2-selection--multiple{
        padding-right:50px;
    }
    .relative{
        position: relative;
    }
    .add_type{
        position: absolute;
        right: 8px;
        top:8px;
        z-index: 9;
    }
    .layui-form-item{
        clear: none;
    }
    .layui-form-item:after{
         clear: none;
     }
    .layui-form{
        margin-top:30px;
    }
</style>
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title"><?=isset($_GET['id']) ? "组件修改" : '上传组件'?></h2>
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">作品名称</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['widget']['title']) ? $data['widget']['title'] : ''?>" name="title" lay-verify="required" lay-text="作品名称不能为空" autocomplete="off" placeholder="请输入作品名称" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作品简介</label>
                <div class="layui-input-block">
                    <textarea lay-verify="required" lay-text="作品简介" autocomplete="off" name="desc" class="layui-textarea"   placeholder="请输入作品简介" id="" cols="30" rows="10"><?=isset($data['widget']['desc']) ? $data['widget']['desc'] : ''?></textarea>
                </div>
            </div>
            <div id="wx_link" class="layui-form-item ">
                <label class="layui-form-label">作品压缩包</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="upload-zip">上传文件</button><span class="theme-red ml10">格式为：zip|rar</span>
                    <input type="hidden" value="<?=isset($data['widget']['download']) ? $data['widget']['download'] : ''?>" class="js_website" name="website">
                    <a href="<?=isset($data['widget']['download']) ? Yii::$app->params['frontend_url'].$data['widget']['download'] : ''?>" id="zip-upload-demoText"><?=isset($data['widget']['download']) ? Yii::$app->params['frontend_url'].$data['widget']['download'] : ''?></a>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">作品来源</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['widget']['source']) ? $data['widget']['source'] : ''?>" name="source" lay-verify="required" lay-text="作品来源不能为空" autocomplete="off" placeholder="请输入作品来源" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">使用方法</label>
                <div class="layui-input-block">
                    <?php echo UEditor::widget([
                        'id'=>'rule',
                        'name'=>'rule',
                        'value'=>isset($data['widget']['rule']) ? $data['widget']['rule'] : '',
                        'clientOptions'=>[
                            'initialFrameHeight'=>'200',
                            'scaleEnabled'=>true,
                            //'initialFrameWidth'=>'40%',
                            'toolbars'=>Yii::$app->params['toolbars']
                        ]
                    ]);?>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">下载金币数</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['widget']['down_money']) ? $data['widget']['down_money'] : ''?>" name="down_money" autocomplete="off" placeholder="请输入下载所需金币" class="layui-input">
                    <div style="color:#f00;line-height: 25px;">用户下载您将获得对应金币</div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">官网地址</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['widget']['website']) ? $data['widget']['website'] : ''?>" name="website" autocomplete="off" placeholder="请输入官网地址（选填）" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="button" class="layui-hide" id="upload-file-submit">提交过后上传zip包</button>
                    <button class="layui-btn" lay-submit="" lay-filter="submit-btn">立即提交</button>
                    <a href="javascript:history.go(-1);" class="layui-btn layui-btn-primary">返回</a>
                </div>
            </div>
        </form>
    </div>
</div>


<script src="<?=Yii::$app->params['backend_url']?>/asset/layui/layui.js"></script>
<script>

    var frontend_url = "Yii::$app->params['frontend_url']";

    layui.config({
        base: '<?=Yii::$app->params["backend_url"]?>/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index', //主入口模块
        select2:'../lib/select2/js/select2.min'
    }).use(['index', 'form','upload','select2'], function(){

        var $ = layui.$,
            upload = layui.upload,
            form = layui.form;

        // 文件上传
        //普通图片上传
            var uploadInst = upload.render({
                elem: '#test-upload-normal'
                , url: '/site/upload-image'
                ,data:{
                    fileName : 'banner_url',
                    caseDir : 'widget/banner_url/'
                }
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

        //压缩包上传
        //选完文件后不自动上传
        upload.render({
            elem: '#upload-zip'
            ,url: '/user/upload-file'
            ,accept: 'file' //普通文件
            ,exts: 'zip|rar' //只允许上传压缩文件
            ,auto: false
            ,bindAction: '#upload-file-submit'
            ,done: function(res){

                layer.closeAll();
                if(res.code == 100000){
                    $("#zip-upload-demoText").attr('href',frontend_url+res.download).html(res.name);
                    $('.js_website').val(res.download);

                    layer.msg(res.message,{icon:1,time:1500},function(){
                        window.location.href='/user';
                    })
                }

            }
        });

        /* 监听提交 */
        form.on('submit(submit-btn)', function(data) {
            var zipFile = $("#upload-zip").next('input[name="file"]').val();
            if(!zipFile && !$('.js_website').val()){
                layer.msg('请上传文件压缩包',{icon:5});
                return false;
            }

            layer.load(1, {shade: .1});
            var _this = this;_this.disabled=true;//防止多次提交
            var params = data.field;
            $.ajax({
                type: "post",
                url: "",
                data: params,
                dataType: "json",
                success: function(res) {
                    layer.closeAll();
                    _this.disabled=false;
                    if(zipFile) {
                        $('#upload-file-submit').click();
                        layer.msg('正在上传文件...', {
                            icon: 16,
                            time: 0,
                            shade: [0.1, '#000']
                        })
                    }else{
                        layer.msg(res.message,{icon:1,time:1500},function(){
                            window.history.go(-1);
                        })


                    }
                },
                error: function(){
                    layer.closeAll();
                    _this.disabled=false;
                    layer.msg('操作失败', {icon: 1}, function(){
                        window.location.reload();
                    })
                }
            });
            return false;
        })
    });
</script>