<div class="layui-card">
    <div class="layui-card-header header-title">新闻列表</div>
    <div class="layui-card-body">
        <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

        <script type="text/html" id="test-table-toolbar-toolbarDemo">
            <div class="layui-btn-container">
                <a href="/news/info" class="layui-btn layui-btn-sm">新增文章</a>
                <a href="/news/type" class="layui-btn layui-btn-sm">新增类型</a>
            </div>
        </script>

        <script type="text/html" id="test-table-toolbar-barDemo">
            <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        </script>

    </div>
</div>
<script>
    layui.config({
        base: '/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table'], function(){
            table = layui.table;

        table.render({
            elem: '#test-table-toolbar'
            ,url:  '/asset/json/table/user.js'
            ,toolbar: '#test-table-toolbar-toolbarDemo'
            ,url: layui.setter.base + 'json/table/user.js'
            ,cols: [[
                {field:'id', width:80, title: 'ID', sort: true}
                ,{field:'username', width:80, title: '用户名'}
                ,{field:'sex', width:80, title: '性别', sort: true}
                ,{field:'city', width:80, title: '城市'}
                ,{field:'sign', title: '签名', minWidth: 150}
                ,{field:'experience', width:80, title: '积分', sort: true}
                ,{field:'score', width:80, title: '评分', sort: true}
                ,{field:'classify', width:80, title: '职业'}
                ,{field:'wealth', width:135, title: '财富', sort: true}
                ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
            ]]
            ,page: true
        });

        //头工具栏事件
        table.on('toolbar(test-table-toolbar)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            switch(obj.event){
                case 'getCheckData':
                    var data = checkStatus.data;
                    layer.alert(JSON.stringify(data));
                    break;
                case 'getCheckLength':
                    var data = checkStatus.data;
                    layer.msg('选中了：'+ data.length + ' 个');
                    break;
                case 'isAll':
                    layer.msg(checkStatus.isAll ? '全选': '未全选');
                    break;
            };
        });

        //监听行工具事件
        table.on('tool(test-table-toolbar)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('真的删除行么', function(index){
                    obj.del();
                    layer.close(index);
                });
            } else if(obj.event === 'edit'){
                layer.prompt({
                    formType: 2
                    ,value: data.email
                }, function(value, index){
                    obj.update({
                        email: value
                    });
                    layer.close(index);
                });
            }
        });

    });
</script>