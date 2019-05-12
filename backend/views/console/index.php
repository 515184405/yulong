<div class="layui-card">
    <div class="layui-card-body">控制台</div>
</div>
<script>
    layui.config({
        base: './asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use('index');
</script>