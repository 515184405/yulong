
<?php $this->title="个人中心 - ".(isset($_GET['id']) ? '修改手机号信息' : '添加手机号'); ?>
<?php
    $id = isset($_GET['id']) ? true : false;
?>
<div class="layui-card">
    <div class="layui-card-header header-title"><?=$id ? '修改手机号信息' : '添加手机号'?></div>
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <?php if(!$id){ ?>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">是否导入</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_excel" <?=$id ? '' : 'checked'?> lay-skin="switch" lay-text="是|否" lay-filter="switch-excel">
                </div>
            </div>
            <div class="layui-hide" id="upload_excel">
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">excel模板</label>
                    <div class="layui-input-block">
                        <a href="/uploads/phone.xlsx" class="layui-btn">导入excel文件模板下载</a>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">导入手机号</label>
                    <div class="layui-input-block">
                        <button type="button" class="layui-btn layui-btn-normal" id="upload_btn">导入excel文件</button>
                        <span class="theme-red ml10">注意上传的excel表格必须符合模板要求</span>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="layui-hide" id="upload_one">
                <div class="layui-form-item">
                    <label class="layui-form-label">手机号</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?=isset($data['number_list']['tel']) ? $data['number_list']['tel'] : ''?>" name="tel" lay-verify="required" lay-text="手机号不能为空" autocomplete="off" placeholder="请输入手机号" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">单价</label>
                    <div class="layui-input-block">
                        <input type="price" value="<?=isset($data['number_list']['price']) ? $data['number_list']['price'] : ''?>" name="price" lay-verify="required" lay-text="单价不能为空" autocomplete="off" placeholder="请输入单价" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">网络类型</label>
                <div class="layui-input-block">
                    <select  name="online" lay-verify="required">
                        <option <?=(isset($data['number_list']['online']) && $data['number_list']['online'] == 1) ? 'selected' : ''?> value="1">中国移动</option>
                        <option <?=(isset($data['number_list']['online']) && $data['number_list']['online'] == 2) ? 'selected' : ''?>  value="2">中国联通</option>
                        <option <?=(isset($data['number_list']['online']) && $data['number_list']['online'] == 3) ? 'selected' : ''?>  value="3">中国电信</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">归属地</label>
                <div class="layui-inline">
                    <select lay-filter="province" name="province" id="province" lay-verify="required">

                    </select>
                </div>
                <div class="layui-inline" id="city_select">

                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">套餐介绍</label>
                <div class="layui-input-block">
                    <textarea lay-verify="required" lay-text="套餐介绍" autocomplete="off" name="content" class="layui-textarea"   placeholder="请输入套餐介绍" id="" cols="30" rows="10"><?=isset($data['number_list']['content']) ? $data['number_list']['content'] : ''?></textarea>
                </div>
            </div>

            <div class="layui-form-item">
                <label class="layui-form-label">联系人</label>
                <div class="layui-input-block">
                    <select  name="user_tel" lay-verify="required">
                        <?php foreach ($data['contact'] as $key=>$val){ ?>
                            <option <?=(isset($data['number_list']['user_tel']) && $val['id'] == $data['number_list']['user_tel']) ? 'selected' : ''?> value="<?=$val['id']?>"><?=$val['name']?>-<?=$val['tel']?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">是否推荐</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_recommend" <?=(isset($data['number_list']['is_recommend']) && $data['number_list']['is_recommend']) == 1 ? 'checked' : ''?> lay-skin="switch" lay-text="是|否" lay-filter="filter-recommend">
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">是否秒杀</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_miaosha" <?=(isset($data['number_list']['is_miaosha']) && $data['number_list']['is_miaosha']) == 1 ? 'checked' : ''?> lay-skin="switch" lay-text="是|否" lay-filter="filter-recommend">
                </div>
            </div>

            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">是否特价</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="is_tejia" <?=(isset($data['number_list']['is_tejia']) && $data['number_list']['is_tejia']) == 1 ? 'checked' : ''?> lay-skin="switch" lay-text="是|否" lay-filter="filter-recommend">
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


<script src="/china.js"></script>
<script>

    layui.config({
        base: '/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index', //主入口模块
    }).use(['index', 'form','upload'], function(){

        var $ = layui.$,
            upload = layui.upload,
            form = layui.form;

        /* excel导入 */
        //选完文件后不自动上传
        upload.render({
            elem: '#upload_btn'
            ,url: '' //改成您自己的上传接口
            ,auto: false
            //,multiple: true
            ,accept:'file'
            ,exts : 'xls|xlsx'
            ,done: function(res){
                layer.msg('上传成功');
                console.log(res)
            }
        });

        /* 切换 */
        form.on('switch(switch-excel)',function(data){
            enterExcelData(data.elem.checked);
        })

        /* 是否为导入excel */
        function enterExcelData(value){
            // 导入excel
            if(value){
                $("#upload_excel").removeClass('layui-hide');
                $("#upload_one").addClass('layui-hide')
                $("#upload_one").find('input').removeAttr('lay-verify');
            }else{
                // 单个手机号
                $("#upload_excel").addClass('layui-hide');
                $("#upload_one").removeClass('layui-hide').find('input').attr('lay-verify','required');
            }
        }

        // 初始化
        enterExcelData('<?=$id ? false : true;?>');


        var address = '<?=isset($data['number_list']['address']) ? $data['number_list']['address'] : "[]"?>'.split('-');
        var province = address[0];
        var city = address[1];

        /* 设置归属地数据 */
        function setAddressFun(){
            var options = '<option value="">请选择</option>';
            for(var key in china){
                options += '<option '+(province == key ? 'selected' : '')+' value="'+key+'">'+key+'</option>'
            }
            $("#province").html(options);
            form.render('select');
        }
        setAddressFun();

        form.on('select(province)',function(data){
            setCitysFun(data.value);
        })

        /* 设置城市数据 */
        function setCitysFun(value){
            if(value && china[value]){
                var options = ' <select lay-filter="city" name="city" id="city" lay-verify="required"><option value="">请选择</option>';
                for(var i=0,len = china[value].length;i < len;i++){
                    let item = china[value][i];
                    options += '<option '+(city == item ? 'selected' : '' )+' value="'+item+'">'+item+'</option>'
                }
                options += '</select>';
                $("#city_select").html(options);
                form.render('select');
            }
        }

        /* 自动添加 */
        if(city){
            setCitysFun(province);
        }

        /* 监听提交 */
        form.on('submit(submit-btn)', function(data) {
            var _this = this;_this.disabled=true;//防止多次提交
            var params = data.field;
            params['is_recommend'] =  params['is_recommend'] == 'on' ? 1 : 0;
            params['is_miaosha'] =  params['is_miaosha'] == 'on' ? 1 : 0;
            params['is_tejia'] =  params['is_tejia'] == 'on' ? 1 : 0;
            if(params['is_excel'] == 'on' && params['file'] == ''){
                return layer.msg('未导入excel文件',{icon:2});
            }
            layer.load(1, {shade: .1});
            params['address'] =  params['province'] + '-' + params['city'];
            params['file'] = params['file'] ? $("#upload_btn").siblings('input')[0].files[0] : '';
            var formData = new FormData();
            for(var key in params){
                formData.append(key,params[key]);
            }
            $.ajax({
                type: "post",
                url: "",
                data: formData,
                dataType: "json",
                contentType: false, // jQuery不要去设置Content-Type请求头
                processData: false, // jQuery不要去处理发送的数据
                success: function(res) {
                    layer.closeAll();
                    _this.disabled=false;
                    layer.msg(res.message,{icon:1,time:1500},function(){
                        window.history.go(-1);
                    })
                },
                error: function(){
                    layer.closeAll();
                    _this.disabled=false;
                    layer.msg('操作失败', {icon: 1}, function(){

                    })
                }
            });
            return false;
        })
    });
</script>