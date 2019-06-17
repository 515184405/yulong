<?php
use kucha\ueditor\UEditor;
?>
<link rel="stylesheet" href="/asset/style/jquery.tagsinput.css">
<?php //var_dump($data['case']['tag_join']); ?>
<?php //var_dump(\yii\helpers\Json::encode($data));die;?>
<div class="layui-card">
    <div class="layui-card-header header-title"><?=isset($_GET['id']) ? '修改案例' : '添加案例'?></div>
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">案例标题</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['case']['title']) ? $data['case']['title'] : ''?>" name="title" lay-verify="required" lay-text="标题不能为空" autocomplete="off" placeholder="请输入标题" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">案例描述</label>
                <div class="layui-input-block">
                    <?php echo UEditor::widget([
                        'id'=>'desc',
                        'name'=>'desc',
                        'value'=>isset($data['case']['desc']) ? $data['case']['desc'] : '',
                        'clientOptions'=>[
                            'initialFrameHeight'=>'200',
                            'scaleEnabled'=>true,
                            //'initialFrameWidth'=>'40%',
                            'toolbars'=>Yii::$app->params['toolbars']
                        ]
                    ]);?>
                </div>
            </div>
            <div class="layui-form-item" pane="">
                <label class="layui-form-label">案例地址</label>
                <div class="layui-input-block">
                    <input type="checkbox" <?=(isset($data['case']['pc_link']) && !empty($data['case']['pc_link'])) ? 'checked' : ''?> lay-filter="filter-link" value="pc" lay-skin="primary" title="PC端地址">
                    <input type="checkbox" <?=(isset($data['case']['wap_link']) && !empty($data['case']['wap_link'])) ? 'checked' : ''?> lay-filter="filter-link" value="wap" lay-skin="primary" title="移动端地址">
                    <input type="checkbox" <?=(isset($data['case']['wx_link']) && !empty($data['case']['wx_link'])) ? 'checked' : ''?> lay-filter="filter-link" value="wx" lay-skin="primary" title="微信二维码">
                </div>
            </div>
            <div id="pc_link" class="layui-form-item  <?=(isset($data['case']['pc_link']) && !empty($data['case']['pc_link'])) ? '' : 'layui-hide'?>">
                <label class="layui-form-label">PC端地址</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['case']['pc_link']) ? $data['case']['pc_link'] : ''?>" name="pc_link" placeholder="请输入PC端地址" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div id="wap_link" class="layui-form-item <?=(isset($data['case']['wap_link']) && !empty($data['case']['wap_link'])) ? '' : 'layui-hide'?>">
                <label class="layui-form-label">移动端地址</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['case']['pc_link']) ? $data['case']['wap_link'] : ''?>" name="wap_link" placeholder="请输入移动端地址" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div id="wx_link" class="layui-form-item <?=(isset($data['case']['wx_link']) && !empty($data['case']['wx_link'])) ? '' : 'layui-hide'?>">
                <label class="layui-form-label">微信二维码</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal1">上传图片</button><span class="theme-red ml10">建议上传200*200，图片大小不要超过2M</span>
                    <input type="hidden" value="<?=isset($data['case']['wx_link']) ? $data['case']['wx_link'] : ''?>" class="js_wx_link" name="wx_link">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" <?=isset($data['case']['wx_link']) ? 'src="'.$data['case']['wx_link'].'"' : ''?> id="test-upload-normal-img1">
                        <p id="test-upload-demoText1"></p>
                    </div>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">列表小图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal2">上传图片</button><span class="theme-red ml10">建议上传280 * 180，图片大小不要超过2M</span>
                    <input type="hidden" value="<?=isset($data['case']['banner_url']) ? $data['case']['banner_url'] : ''?>" lay-verify="required" lay-text="请上传列表小图" class="js_banner_url" name="banner_url">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" <?=isset($data['case']['banner_url']) ? 'src="'.$data['case']['banner_url'].'"' : ''?> id="test-upload-normal-img2">
                        <p id="test-upload-demoText2"></p>
                    </div>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">详情头图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="test-upload-normal3">上传图片</button><span class="theme-red ml10">建议上传1920 * 500，图片大小不要超过2M</span>
                    <input type="hidden" value="<?=isset($data['case']['header_url']) ? $data['case']['header_url'] : null?>" lay-verify="required" lay-text="请上传详情头图" class="js_header_url" name="header_url">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" <?=isset($data['case']['header_url']) ? 'src="'.$data['case']['header_url'].'"' : null?> id="test-upload-normal-img3">
                        <p id="test-upload-demoText3"></p>
                    </div>

                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">内容大图</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary" id="test-upload-more">多图片上传</button><span class="theme-red ml10">图片大小不要超过2M</span>
                    <input type="hidden" value="<?=isset($data['case']['content_url']) ? $data['case']['content_url'] : ''?>" lay-verify="required" lay-text="请上传内容大图" class="js_content_url" name="content_url">
                    <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
                        预览图：
                        <div class="layui-upload-list" id="test-upload-more-list">
                            <?php if(isset($data['case']['content_url'])){
                                $conent_url_arr = explode(',',substr($data['case']['content_url'],1));
                                foreach ($conent_url_arr as $key => $val){
                            ?>
                                <p class="upload-image-box"><img src="<?=$val?>" class="layui-upload-img"><i class="iconfont upload-image-close js_close_icon">&#xe61b;</i></p>
                            <?php }} ?>
                        </div>
                    </blockquote>

                </div>
            </div>


            <div class="layui-form-item">
                <label class="layui-form-label">案例类型</label>
                <div class="layui-input-block">
                    <select name="type_id" lay-verify="required" lay-text="案例类型必填">
                        <option value="">请选择</option>
                        <?php foreach($data['case_type'] as $key => $val){ ?>
                            <option <?=(isset($data['case']['type_id']) && $data['case']['type_id'] == $val['type_id']) ? 'selected' : ''?> value="<?=$val['type_id']?>"><?=$val['title']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">案例标签</label>
                <div class="layui-input-block">
                    <?php if(isset($data['case']['tag_join'])) {
                        $tag_title = '';$tag_id = '';
                        foreach ($data['case']['tag_join'] as $key => $val) {
                            $tag_title .= ','.$val['tag_id']['title'];
                            $tag_id .= ','.$val['tag_id']['tag_id'];
                        }}
                    ?>
                    <input id="tags_1" type="text" lay-verify="required" name="tag_id" placeholder="添加标签" class="tags" value="<?= isset($tag_title) ? substr($tag_title,1): '' ?>" />
                    <input type="hidden" name="tag_ids" value="<?=isset($tag_id) ? substr($tag_id,1) : ''?>">
                </div>
            </div>


            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit="" lay-filter="submit-btn">立即提交</button>
                    <a href="javascript:history.go(-1);" class="layui-btn layui-btn-primary">返回</a>
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
                , url: '/cases/upload-image'
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
            ,url: '/cases/upload-image'
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
                $.post('/cases/remove-image',{filesrc:imgSrc},function(){});
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
                    _this.disabled=false;
                    layer.confirm(res.message+'是否返回列表？', {
                        btn: ['确定','取消'] //按钮
                    }, function(){
                        location.href='/cases';
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