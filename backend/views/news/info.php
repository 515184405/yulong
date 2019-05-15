<?php
use kucha\ueditor\UEditor;
?>
<link rel="stylesheet" href="/asset/style/jquery.tagsinput.css">
<?php //var_dump($data['news']['tag_join']); ?>
<?php //var_dump(\yii\helpers\Json::encode($data));die;?>
<div class="layui-card">
    <div class="layui-card-header header-title"><?=isset($_GET['id']) ? '修改新闻' : '添加新闻'?></div>
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">新闻标题</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['news']['title']) ? $data['news']['title'] : ''?>" name="title" lay-verify="required" lay-text="标题不能为空" autocomplete="off" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">新闻来源</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['news']['sourse']) ? $data['news']['sourse'] : ''?>" name="sourse" lay-verify="required" lay-text="来源不能为空" autocomplete="off" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">新闻类型</label>
                <div class="layui-input-block">
                    <select name="type_id" lay-verify="required" lay-text="新闻类型必填">
                        <option value="">请选择</option>
                        <?php if(isset($data['type'])){
                            foreach ($data['type'] as $key=>$val) {
                          ?>
                        <option <?=isset($data['news']['type_id']) && $val['type_id'] == $data['news']['type_id'] ? 'selected' : ''?> value="<?=$val['type_id']?>"><?=$val['title'] ?></option>
                        <?php }} ?>
                    </select>
                </div>
            </div>
            <div id="wx_link" class="layui-form-item ">
                <label class="layui-form-label">列表图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal">上传图片</button><span class="theme-red ml10">建议上传200*200，图片大小不要超过2M</span>
                    <input type="hidden" lay-verify="required" lay-text="列表图片必填" value="<?=isset($data['news']['banner_url']) ? $data['news']['banner_url'] : ''?>" class="js_banner_url" name="banner_url">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" <?=isset($data['news']['banner_url']) ? 'src="'.$data['news']['banner_url'].'"' : ''?>" id="test-upload-normal-img">
                        <p id="test-upload-demoText"></p>
                    </div>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">新闻内容</label>
                <div class="layui-input-block">
                    <?php echo UEditor::widget([
                        'id'=>'content',
                        'name'=>'content',
                        'value'=>isset($data['news']['content']) ? $data['news']['content'] : '',
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
                <label class="layui-form-label">新闻状态</label>
                <div class="layui-input-block">
                    <select name="issue" lay-verify="required" lay-text="新闻状态必选">
                        <option value="">请选择</option>
                        <option value="1" <?= isset($data['news']['issue']) ? ($data['news']['issue'] == 1 ? 'selected' : '') : '' ?>>存稿</option>
                        <option value="2" <?= isset($data['news']['issue']) ? ($data['news']['issue'] == 2 ? 'selected' : '') : '' ?>>发布</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">新闻标签</label>
                <div class="layui-input-block">
                    <?php if(isset($data['news']['news_tag_join'])) {
                        $tag_title = '';$tag_id = '';
                        foreach ($data['news']['news_tag_join'] as $key => $val) {
                            $tag_title .= ','.$val['newsTag']['title'];
                            $tag_id .= ','.$val['newsTag']['tag_id'];
                        }}
                    ?>
                    <input id="tags_1" type="text" lay-verify="required" lay-text="新闻标签必填" name="tag_id" placeholder="添加标签" class="tags" value="<?= isset($tag_title) ? substr($tag_title,1): '' ?>" />
                </div>
            </div>


            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="submit-btn">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    layui.config({
        base: '/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index', //主入口模块
        tagsInput:'../lib/jquery.tagsinput.min'
    }).use(['index', 'form','upload','tagsInput'], function(){

        var $ = layui.$,
            upload = layui.upload,
            form = layui.form;

        // 文件上传
        //普通图片上传
            var uploadInst = upload.render({
                elem: '#test-upload-normal'
                , url: '/news/upload-image'
                ,data:{
                    fileName : 'banner_url',
                    caseDir : 'news/banner_url/'
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

        //标签
        $('#tags_1').tagsInput({width:'auto'});

        /* 监听提交 */
        form.on('submit(submit-btn)', function(data) {
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
                    layer.confirm(res.message+'是否返回列表？', {
                        btn: ['确定','取消'] //按钮
                    }, function(){
                        location.href='/news';
                    }, function(){
                        layer.closeAll();
                        window.location.reload();
                    });
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