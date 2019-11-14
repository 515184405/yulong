<?php $this->title="个人中心 - 上传项目"; ?>
<?php
    use kucha\ueditor\UEditor;


    $widget_id = isset($_GET['id']) ? $_GET['id'] : '';
?>
<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/layui/css/layui.css<?=Yii::$app->params['static_number']?>" media="all">
<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/lib/select2/css/select2.min.css<?=Yii::$app->params['static_number']?>">
<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/style/jquery.tagsinput.css<?=Yii::$app->params['static_number']?>">
<link rel="stylesheet" href="/asset/static/css/personal.css<?=Yii::$app->params['static_number']?>">
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
    .layui-form-select dl{z-index:99999};
</style>
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title"><?=isset($_GET['id']) ? "组件修改" : '上传组件'?></h2>
        <form class="layui-form" action="">
           <?php  if(!$widget_id){ ?>
            <div class="layui-form-item">
                <label class="layui-form-label">作品名称</label>
                <div class="layui-input-block">
                    <input type="text" value="<?=isset($data['widget']['title']) ? $data['widget']['title'] : ''?>" name="title" lay-verify="required" lay-text="作品名称不能为空" autocomplete="off" placeholder="请输入作品名称" class="layui-input">
                    <p class="red">查询主要筛选项，会根据当前字段内容进行查询</p>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作品关键字</label>
                <div class="layui-input-block">
                    <textarea lay-verify="required" lay-text="作品关键字不能为空" autocomplete="off" name="desc" class="layui-textarea"   placeholder="请输入作品关键字以逗号隔开" id="" cols="30" rows="10"><?=isset($data['widget']['desc']) ? $data['widget']['desc'] : ''?></textarea>
                    <p class="red">作品关键字以逗号隔开，例如：弹框组件，信息框组件，提示组件，主要作用是提示提醒用户为主</p>
                </div>
            </div>
           <div class="layui-form-item">
               <label class="layui-form-label">作品来源</label>
               <div class="layui-input-block">
                   <input type="text" value="<?=isset($data['widget']['source']) ? $data['widget']['source'] : ''?>" name="source" autocomplete="off" placeholder="请输入作品来源" class="layui-input">
               </div>
           </div>
           <div class="layui-form-item">
               <label class="layui-form-label">IE兼容</label>
               <div class="layui-input-block">
                   <?php $arr =array(0=>'请选择',8=>'IE8',9=>'IE9',10=>'IE10',11=>'IE11',12=>'不兼容IE'); ?>
                   <select name="ie">
                       <?php foreach ($arr as $k=>$v){?>
                           <option value="<?=$k?>"><?=$v?></option>
                       <?php } ?>
                   </select>
               </div>
           </div>
            <?php } ?>
            <div id="wx_link" class="layui-form-item ">
                <label class="layui-form-label">作品压缩包</label>
                <div class="layui-input-block">
                    <button type="button" class="layui-btn layui-btn-primary js_upload_image" id="upload-zip">上传文件</button><span class="theme-red ml10">格式为：zip|rar</span>
                    <input type="hidden" value="<?=isset($data['widget']['download']) ? $data['widget']['download'] : ''?>" class="js_website" name="upload_download">
                    <a href="<?=isset($data['widget']['download']) ? Yii::$app->params['frontend_url'].$data['widget']['download'] : ''?>" id="zip-upload-demoText"><?=isset($data['widget']['download']) ? Yii::$app->params['frontend_url'].$data['widget']['download'] : ''?></a>
                </div>
            </div>
            <?php if(!$widget_id){ ?>
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
                    <p class="red">温馨提示：代码段使用《<b style="color:#000">insert code</b>》或《<img src="/asset/static/image/yinhao.png" alt="">》来排版,前台已定义了样式...</p>
                </div>
            </div>
            <?php } ?>
            <?php if($widget_id){ ?>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">更新说明</label>
                <div class="layui-input-block">
                <?php echo UEditor::widget([
                    'id'=>'upload_txt',
                    'name'=>'upload_txt',
                    'value'=>'',
                    'clientOptions'=>[
                        'initialFrameHeight'=>'200',
                        'scaleEnabled'=>true,
                        //'initialFrameWidth'=>'40%',
                        'toolbars'=>Yii::$app->params['toolbars']
                    ]
                ]);?>
                </div>
            </div>
            <?php } ?>
            <?php  if(!$widget_id){ ?>
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
            <?php } ?>
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

    layui.use([ 'form','upload'], function(){

        var $ = layui.$,
            upload = layui.upload,
            form = layui.form,
            csrfName = $("#form_csrf").attr('name'),
            csrfVal = $("#form_csrf").val();



        //设置百度编辑器代码块样式
        var style = $('<style id="setIfameStyle">.view blockquote { padding: 10px; background-color: #f2f2f2; color: #595757; }</style>');
        var timer = setInterval(function(){
            var head = $(document.getElementById('ueditor_0').contentWindow.document.head);
            if(head.length > 0){
                clearInterval(timer);
                head.append(style);
            }
        },500);


        //压缩包上传
        //选完文件后不自动上传
        var uploadInstData = {};
        uploadInstData[csrfName] = csrfVal;
        upload.render({
            elem: '#upload-zip'
            ,url: '/user/upload-file'
            ,accept: 'file' //普通文件
            ,exts: 'zip|rar' //只允许上传压缩文件
            ,auto: false
            ,data : uploadInstData
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
            params[csrfName] = csrfVal;
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
                    // _this.disabled=false;
                    // layer.msg('操作失败', {icon: 1}, function(){
                    //     window.location.reload();
                    // })
                }
            });
            return false;
        })
    });
</script>