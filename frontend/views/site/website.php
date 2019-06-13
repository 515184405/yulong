<?php $this->title = "聚友团队 - 网站定制"; ?>
<link rel="stylesheet" href="<?= Yii::$app->params['backend_url'] ?>/asset/layui/css/layui.css<?=Yii::$app->params['static_number']?>">
<style>
    .form-container {
        padding: 35px;
        padding-top:15px;
    }

    .website-callme {
        padding: 10px;
        background-color: #f3f3f3;
    }

    .website-title {
        font-size: 15px;
        color: #000;
    }

    .website-tel {
        color:#999;
        font-size: 14px;
    }
</style>
<input type="hidden" id="form_csrf" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
<div class="form-container">
    <form class="layui-form dingzhi fy-container">
        <div class="layui-form-item">
            <div class="website-callme">
                <h2 class="website-title">聚友团队</h2>
                <p class="website-tel">咨询电话：15321353313</p>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <textarea name="content" lay-verify="required" placeholder="请在此输入留言内容，我们会尽快与您联系。（必填）"
                      class="layui-textarea"></textarea>
        </div>

        <div class="layui-form-item">
            <input type="text" name="name" autocomplete="off" placeholder="姓名" class="layui-input">
        </div>

        <div class="layui-form-item">
            <input type="text" name="tel" lay-verify="tel" lay-text="手机号码格式不正确" autocomplete="off" placeholder="手机号"
                   class="layui-input">
        </div>

        <div class="layui-form-item">
            <input type="text" name="email" lay-verify="email" lay-text="邮箱格式不正确" autocomplete="off" placeholder="邮箱"
                   class="layui-input">
        </div>
        <div class="layui-form-item">
            <button lay-submit="" lay-filter="submit-btn" class="layui-btn layui-btn-fluid layui-btn-normal">发 送
            </button>
        </div>
    </form>
</div>
<script src="<?= Yii::$app->params['backend_url'] ?>/asset/layui/layui.js"></script>
<script>

    layui.use(['form'], function () {
        var $ = layui.$,
            form = layui.form;

        //自定义验证规则
        form.verify({
            tel: function (value) {
                if (!(/^[1][0-9]{10}$/.test(value))) {
                    return '请填写正确的手机号码';
                }
            }
        });

        /* 监听提交 */
        form.on('submit(submit-btn)', function (data) {
            layer.load(1, {shade: .1});
            var _this = this;
            _this.disabled = true;//防止多次提交
            var params = data.field;
            var csrfName = $("#form_csrf").attr('name');
            var csrfVal = $("#form_csrf").val();
            params[csrfName] = csrfVal;
            $.ajax({
                type: "post",
                url: "",
                data: params,
                dataType: "json",
                success: function (res) {
                    layer.closeAll();
                     _this.disabled = false;
                    layer.msg(res.message, {icon: 1, time: 1000}, function () {
                        parent.layer.closeAll();
                    })
                },
                error: function () {
                    layer.closeAll();
                    _this.disabled = false;
                    layer.msg('操作失败', {icon: 5}, function () {
                        window.location.reload();
                    })
                }
            });
            return false;
        })
    })
</script>