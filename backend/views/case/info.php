<link rel="stylesheet" href="/asset/style/jquery.tagsinput.css">
<div class="layui-card">
    <div class="layui-card-header header-title">创建案例</div>
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">案例标题</label>
                <div class="layui-input-block">
                    <input type="text" name="title" lay-verify="required" lay-text="标题不能为空" autocomplete="off" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">案例描述</label>
                <div class="layui-input-block">
                    <textarea class="layui-textarea layui-hide" name="desc" id="LAY_demo_editor"></textarea>
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
                    <input type="hidden" class="js_wx_link" name="wx_link">
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
                    <input type="hidden" lay-verify="required" lay-text="请上传列表小图" class="js_banner_url" name="banner_url">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="test-upload-normal-img2">
                        <p id="test-upload-demoText2"></p>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">详情头图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal3">上传图片</button><span class="theme-red ml10">建议上传1920 * 500</span>
                    <input type="hidden" lay-verify="required" lay-text="请上传详情头图" class="js_header_url" name="header_url">
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
                    <input type="hidden" lay-verify="required" lay-text="请上传内容大图" class="js_content_url" name="content_url">
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                        预览图：
                        <div class="layui-upload-list" id="test-upload-more-list"></div>
                    </blockquote>

                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">案例类型</label>
                <div class="layui-input-block">
                    <select name="type_id" lay-verify="required" lay-text="案例类型必填">
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
                <label class="layui-form-label">案例标签</label>
                <div class="layui-input-block">
                    <input id="tags_1" type="text" lay-verify="required" name="tag_id" placeholder="添加标签" class="tags" value="foo,bar,baz,roffle" />
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
                url: '/case/layedit', //接口url
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
            var fileName = $(elem).parent().find('input[type="hidden"]').attr('name');
            var uploadInst = upload.render({
                elem: '#test-upload-normal'+(key+1)
                , url: '/case/upload-image'
                ,data:{
                    fileName : fileName,
                    caseDir : 'case/'+fileName+'/'
                }
                , before: function (obj) {
                    //预读本地文件示例，不支持ie8
                    obj.preview(function (index, file, result) {
                        $('#test-upload-normal-img'+(key+1)).attr('src', result); //图片链接（base64）
                    });
                }
                , done: function (res) {
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
            ,url: '/case/upload-image'
            ,data:{
                fileName : 'content_url',
                caseDir : 'case/content_url/'
            }
            ,multiple: true
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                });
            }
            ,done: function(res){
                //上传成功
                if(res.code == 100000){
                    var val = $('.js_'+res.data.fileName).val();
                    $('.js_'+res.data.fileName).val(val+','+res.data.fileSrc);
                    $('#test-upload-more-list').append('<p class="upload-image-box"><img src="'+ res.data.fileSrc +'" class="layui-upload-img"><i class="iconfont upload-image-close js_close_icon">&#xe61b;</i></p>')
                }
                //如果上传失败
                if (res.code == 100001) {
                    return layer.msg('上传失败');
                }
            }
        });

        //多图片上传删除功能
        $(document).delegate('.js_close_icon','click',function(){

            var that = this;
            layer.confirm('是否删除当前图片？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var currentImg = $(that).parent().find('.layui-upload-img');
                var imgSrc = currentImg.attr('src');
                var inputVal = $(that).parents('.layui-input-block').find('input[type="hidden"]').val();
                $(that).parents('.layui-input-block').find('input[type="hidden"]').val(inputVal.replace(','+imgSrc,''));
                currentImg.parent().remove();
                layer.closeAll();
                //删除线上图片
                $.post('/case/remove-image',{filesrc:imgSrc},function(){});
            }, function(){

            });
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


                },
                error: function(){
                    layer.closeAll();
                    _this.disabled=false;
                    // layer.msg('操作失败', {icon: 1}, function(){
                    //     window.location.reload();
                    // })
                }
            });
            return false;
        })
    });
</script>