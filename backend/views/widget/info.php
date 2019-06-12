<?php
use kucha\ueditor\UEditor;
?>
<?php //var_dump($data['widget']['type']); ?>
<?php //var_dump(\yii\helpers\Json::encode($data));die;?>
<link rel="stylesheet" href="/asset/lib/select2/css/select2.min.css">
<link rel="stylesheet" href="/asset/style/jquery.tagsinput.css">
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
</style>
<?php $this->title="个人中心 - ".(isset($_GET['id']) ? '修改作品' : '添加作品'); ?>

<div class="layui-card">
    <div class="layui-card-header header-title"><?=isset($_GET['id']) ? '修改作品' : '添加作品'?></div>
    <div class="layui-card-body">
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
            <div class="layui-form-item">
                <label class="layui-form-label">作品类型</label>
                <div class="layui-input-block relative">
                    <select2 id="select2"  name="type">
                    </select2>
                    <button type="button" class="layui-btn layui-btn-normal layui-btn-xs add_type js_add_type layui-icon layui-icon-add-1"></button>
                </div>
            </div>
            <div id="wx_link" class="layui-form-item ">
                <label class="layui-form-label">作品缩略图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal">上传图片</button><span class="theme-red ml10">建议上传4:3，图片大小不要超过2M</span>
                    <input type="hidden" lay-verify="required" lay-text="作品缩略图必传" value="<?=isset($data['widget']['banner_url']) ? $data['widget']['banner_url'] : ''?>" class="js_banner_url" name="banner_url">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" <?=isset($data['widget']['banner_url']) ? 'src="'.$data['widget']['banner_url'].'"' : ''?>" id="test-upload-normal-img">
                        <p id="test-upload-demoText"></p>
                    </div>
                </div>
            </div>


            <div id="wx_link" class="layui-form-item ">
                <label class="layui-form-label">作品压缩包</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="upload-zip">上传文件</button><span class="theme-red ml10">格式为：zip|rar</span>
                    <input type="hidden" value="<?=isset($data['widget']['download']) ? $data['widget']['download'] : ''?>" class="js_website" name="website">
                    <a href="<?=isset($data['widget']['download']) ? Yii::$app->params['frontend_url'].$data['widget']['download'] : ''?>" id="zip-upload-demoText"><?=isset($data['widget']['download']) ? Yii::$app->params['frontend_url'].$data['widget']['download'] : ''?></a>
                </div>
            </div>t

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



<script>

    var frontend_url = "Yii::$app->params['frontend_url']";

    layui.config({
        base: '/asset/' //静态资源所在路径
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
                , url: '/widget/upload-image'
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
            ,url: '/widget/upload-file'
            ,accept: 'file' //普通文件
            ,exts: 'zip|rar' //只允许上传压缩文件
            ,auto: false
            ,bindAction: '#upload-file-submit'
            ,done: function(res){

                layer.closeAll();
                if(res.code == 100000){
                    $("#zip-upload-demoText").attr('href',frontend_url+res.download).html(res.name);
                    $('.js_website').val(res.download);

                    layer.confirm(res.message+'是否返回列表？', {
                        btn: ['确定','取消'] //按钮
                    }, function(){
                        window.history.go(-1);
                    }, function(){
                        layer.closeAll();
                        window.location.reload();
                    });
                }

            }
        });


        // select2初始化

        setSelect("<?=isset($data['widget']['type']) ? $data['widget']['type'] : ''?>".split(','));
        //传入选中数组
        function setSelect(selectedArr){
            $.getJSON('/widget/add-type',function(res){
                var data = res.data.map(item => {
                    return {id : item.type_id,text:item.title};
                });
                $("#select2").select2("destroy");
                $('#select2').select2({
                    placeholder : '请选择类型',
                    width : '100%',
                    multiple : true,
                    language : 'zh-CH',
                    data : data,
                });
                $("#select2").select2("val", selectedArr);
            })
        };


        //新增type类型
        $('.js_add_type').bind('click',function(){
            layer.prompt(function(val, index){
                $.post('/widget/add-type',{'title':val},function(res){
                    if(res.code == 100000){
                        var selected = $("#select2").select2("val").map((item => {
                            return Number(item);
                        }));
                        selected.push(res.type.type_id);
                        setSelect(selected);
                    }else{
                        layer.msg(res.message, {icon: 5});
                    }
                },'json')
                layer.close(index);
            });
        });

        /* 监听提交 */
        form.on('submit(submit-btn)', function(data) {
            var type = $("#select2").select2("val").join(',');
            var zipFile = $("#upload-zip").next('input[name="file"]').val();
            if(!type){
                layer.msg('作品类型必填',{icon:5});
                return false;
            }
            if(!zipFile && !$('.js_website').val()){
                layer.msg('请上传文件压缩包',{icon:5});
                return false;
            }

            data.field['type'] = type; //多选
            // console.log(data.field);return false;
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
                        layer.msg('正在上传图片...', {
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