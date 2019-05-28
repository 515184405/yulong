<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>聚友团队后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/asset/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/asset/style/admin.css" media="all">
    <script src="/asset/layui/layui.js"></script>
    <style>
        body{
            padding:50px 70px 10px 30px;
            background-color: #fff;
            height:295px;
        }
        .layui-card{
            -webkit-box-shadow: none;
            -moz-box-shadow: none;
            box-shadow: none;
        }
    </style>
</head>
<body>
<div class="layui-card">
    <div class="layui-card-body">
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">定制标题</label>
                <div class="layui-input-block">
                    <input style="background-color:#f1f1f1;" disabled type="text" value="<?=isset($data['title']) ? $data['title'] : ''?>" name="title"  autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">定制金额</label>
                <div class="layui-input-block">
                    <input type="text" lay-verify="required" value="<?=isset($data['money']) ? $data['money'] : ''?>" name="money" lay-text="定制金额不能为空" autocomplete="off" placeholder="请输入定制金额" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">定制状态</label>
                <div class="layui-input-block">
                    <select name="status" lay-verify="required">
                        <option  value="0" <?=$data['status'] == 0 ? "selected" : ""?>>未处理</option>
                        <option  value="1" <?=$data['status'] == 1 ? "selected" : ""?>>处理中</option>
                        <option  value="2" <?=$data['status'] == 2 ? "selected" : ""?>>已完成</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-normal layui-btn-fluid" lay-submit="" lay-filter="submit-btn">立即提交</button>
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
    }).use(['index', 'form','upload'], function(){

        var $ = layui.$,
            upload = layui.upload,
            form = layui.form;

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
                    layer.msg('操作成功', {icon: 1,time:1000}, function(){
                        parent.location.reload();
                        console.log(parent);
                        parent.layer.closeAll();
                    })
                },
                error: function(){
                    parent.layer.closeAll();
                    layer.msg('操作失败', {icon: 5}, function(){
                        window.location.reload();
                    })
                }
            });
            return false;
        })
    });
</script>
</body>
</html>