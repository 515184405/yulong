<div class="layui-card">
    <div class="layui-card-header header-title">案例列表</div>
    <div class="layui-card-body">
        <div class="layui-inline">
        <input type="text" class="layui-input js_search_title" placeholder="输入作品名搜索">
        </div>
        <button type="button" id="search_btn" class="layui-btn layui-btn-normal">搜索</button>
    </div>
    <div class="layui-card-body">
        <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

        <script type="text/html" id="test-table-toolbar-toolbarDemo">
            <div class="layui-btn-container">
                <a href="/cases/info" class="layui-btn layui-btn-sm">添加作品</a>
                <a href="/cases/type" class="layui-btn layui-btn-sm">添加类型</a>
            </div>
        </script>

        <script type="text/html" id="test-table-toolbar-barDemo">
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </div>
        </script>

    </div>
</div>
<script>
    var site_url = '<?=Yii::$app->params["backend_url"];?>';
    layui.config({
        base: '/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table'], function(){
        var $ = layui.$,
            table = layui.table;

        table.render({
            elem: '#test-table-toolbar'
            ,toolbar: '#test-table-toolbar-toolbarDemo'
            ,url: '/cases/index'
            ,cols: [[
                {field:'id', width:80, title: 'ID', sort: true}
                ,{field:'title',title: '标题',templet: function (d) {
                        if(d.pc_link){
                            return '<a target="_blank" class="theme" href="'+d.pc_link+'"> '+d.title+' </a>';
                        }else if(d.wap_link){
                            return '<a target="_blank" class="theme" href="'+d.wap_link+'"> '+d.title+' </a>'
                        }else{
                            return d.title;
                        }
                    }}
                ,{field:'create_time',  title: '创建时间',templet: function (d) {
                        return getLocalTime(d.create_time);
                    }}
                ,{field:'banner_url', title: '列表图',templet: function (d) {
                        return '<a class="theme js_banner_url" target="_blank" href='+site_url+d.banner_url+' >'+d.banner_url+'</a>';
                    }}
                ,{field:'caseType',width:80, title: '类型',templet: function (d) {
                        return d.caseType.title
                    }}
                ,{field:'tag_id', title: '标签'}
                ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
            ]]
            ,done(res){
                console.log(res);
            }
            ,page: true
            ,limit: 10
        });

        //小图tip
        $(document).delegate('.js_banner_url','mouseenter',function(){
            var img = new Image();
            var that = this;
            img.onload = function(){
                layer.tips('<img style="width:180px;" src="'+$(that).attr('href')+'" />', that, {
                    tips: [3,'#5181a1'],
                    time:9999999
                });
            }
            img.src = $(this).attr('href');
        });
        $(document).delegate('.js_banner_url','mouseleave',function(){
            layer.closeAll('tips');
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
                layer.confirm('您确定要删除吗', function(index){
                    obj.del();
                    layer.close(index);
                    $.post('/cases/delete',{id:data.id},function(res){ console.log(res);
                        if(res.code == 100000){
                            layer.msg(res.message);
                        }
                    },'json')
                });
            } else if(obj.event === 'edit'){
                window.location.href = '/cases/info/?id='+data.id;
            }
        });

        //搜索
        $('#search_btn').bind('click',function(){
            var title = $('.js_search_title').val();
            if(title){
                //执行重载
                table.reload('test-table-toolbar', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , where: {
                        title: title
                    }
                });
            }
        })

        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
        }

    });
</script>