<link rel="stylesheet" href="/asset/style/jquery.tagsinput.css">
<div class="layui-card">
    <div class="layui-card-header header-title">创建案例</div>
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">案例标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" lay-verify="required" autocomplete="off" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">案例描述</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea layui-hide" name="desc" lay-verify="content" id="LAY_demo_editor"></textarea>
                </div>
            </div>
            <div class="layui-form-item" pane="">
                <label class="layui-form-label">案例地址</label>
                <div class="layui-input-block">
                    <input type="checkbox" lay-filter="filter-link" value="pc" lay-skin="primary" title="PC端地址">
                    <input type="checkbox" lay-filter="filter-link" value="wap" lay-skin="primary" title="移动端地址">
                    <input type="checkbox" lay-filter="filter-link" value="wx" lay-skin="primary" title="微信二维码">
                </div>
            </div>
            <div id="pc_link" class="layui-form-item layui-hide">
                <label class="layui-form-label">PC端地址</label>
                <div class="layui-input-block">
                    <input type="text" name="pc_link" placeholder="请输入PC端地址" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div id="wap_link" class="layui-form-item layui-hide">
                <label class="layui-form-label">移动端地址</label>
                <div class="layui-input-block">
                    <input type="text" name="wap_link" placeholder="请输入移动端地址" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div id="wx_link" class="layui-form-item layui-hide">
                <label class="layui-form-label">微信二维码</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal1">上传图片</button>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="test-upload-normal-img1">
                        <p id="test-upload-demoText1"></p>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">列表小图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal2">上传图片</button><span class="theme-red ml10">建议上传280 * 180</span>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="test-upload-normal-img2">
                        <p id="test-upload-demoText2"></p>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">头图banner</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal3">上传图片</button><span class="theme-red ml10">建议上传1920 * 500</span>
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="test-upload-normal-img3">
                        <p id="test-upload-demoText3"></p>
                    </div>

                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">内容大图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary" id="test-upload-more">多图片上传</button>
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                        预览图：
                        <div class="layui-upload-list" id="test-upload-more-list"></div>
                    </blockquote>

                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">案例类型</label>
                <div class="layui-input-block">
                    <select name="type">
                        <option value="">请选择</option>
                        <option value="0">写作</option>
                        <option value="1">阅读</option>
                        <option value="2">游戏</option>
                        <option value="3">音乐</option>
                        <option value="4">旅行</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">案例类型</label>
                <div class="layui-input-block">
                    <input id="tags_1" type="text" name="tag" placeholder="添加标签" class="tags" value="foo,bar,baz,roffle" />
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
    }).use(['index', 'form','layedit','upload','tagsInput'], function(){

        var $ = layui.$,
            layedit = layui.layedit,
            upload = layui.upload,
            form = layui.form;

        //超文本编辑器
        layedit.set({
            uploadImage: {
                url: '{:url("index/index/lay_img_upload")}', //接口url
                type: 'post' //默认post
            }
        });
        var layedit_index = layedit.build('LAY_demo_editor');

        //链接地址
        form.on('checkbox(filter-link)',function(data){
            if(data.elem.checked){
                $('#'+data.value+'_link').removeClass('layui-hide');
            }else{
                $('#'+data.value+'_link').addClass('layui-hide');
            }
        })

        // 文件上传
        //普通图片上传
        $.each($('.js_upload_image'),function(key,elem){
            var uploadInst = upload.render({
                elem: '#test-upload-normal'+(key+1)
                , url: ''
                , before: function (obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function (index, file, result) {
                        $('#test-upload-normal-img'+(key+1)).attr('src', result); //图片链接（base64）
                    });
                }
                , done: function (res) {
                    //如果上传失败
                    if (res.code > 0) {
                        return layer.msg('上传失败');
                    }
                    //上传成功
                }
                , error: function () {
                    //演示失败状态，并实现重传
                    var demoText = $('#test-upload-demoText'+(key+1));
                    demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
                    demoText.find('.demo-reload').on('click', function () {
                        uploadInst.upload();
                    });
                }
            })
        });

        //多图片上传
        upload.render({
            elem: '#test-upload-more'
            ,url: '/upload/'
            ,multiple: true
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#test-upload-more-list').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">')
                });
            }
            ,done: function(res){
                //上传完毕
            }
        });

        //标签
        $('#tags_1').tagsInput({width:'auto'});

        /* 监听提交 */
        form.on('submit(submit-btn)', function(data) {
            // layer.load(1, {shade: .1});
            data.field['desc'] =  layedit.getContent(layedit_index);
            console.log(data.field);
            return false;
        })
    });
</script>