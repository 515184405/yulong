
<div class="layui-card">
    <div class="layui-card-header header-title">定制组件</div>
    <div class="layui-card-body layui-form">

        <div class="layui-inline">
            <select id="select-status-search">
                <option  value="">请选择状态</option>
                <option  value="0">未处理</option>
                <option  value="1">处理中</option>
                <option  value="2">已完成</option>
            </select>
        </div>
        <button type="button" id="search_btn" class="layui-btn layui-btn-normal">搜索</button>
    </div>
    <div class="layui-card-body">
        <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

        <script type="text/html" id="test-table-toolbar-barDemo">
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </div>
        </script>

    </div>
</div>
<script>
    var site_url = '<?=Yii::$app->params["backend_url"];?>';
    var frontend_url = '<?=Yii::$app->params["frontend_url"];?>';
    layui.config({
        base: '/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table','form'], function(){
        var $ = layui.$,
            form = layui.form,
            table = layui.table;

        table.render({
            elem: '#test-table-toolbar'
            ,toolbar: '#test-table-toolbar-toolbarDemo'
            ,url: '/dingzhi/index'
            ,id:'reloaded'
            ,cols: [[
                {field:'id', width:80, title: 'ID', sort: true}
                ,{field:'username',title: '定制人姓名'}
                ,{field:'tel',title: '定制人手机号'}
                ,{field:'title',title: '定制标题'}
                ,{field:'desc',title: '描述'}
                ,{field:'money',title: '金额'}
                ,{field:'status',title: '状态',templet:function(d){
                        if(d.status == 0){
                            return '<span class="theme-red">未处理</span>'
                        }
                        if(d.status == 1){
                            return '<span class="theme">处理中</span>'
                        }
                        if(d.status == 2){
                            return '<span style="color:#00dd00">已完成</span>'
                        }
                    }}
                ,{field:'file_url', title: '定制素材',templet: function (d) {
                        return '<a class="theme js_banner_url" target="_blank" href='+frontend_url+d.file_url+' >'+d.file_url+'</a>';
                  }}
                ,{ title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
            ]]
            ,done(res){
            }
            // ,page: true
            // ,limit: 10
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

        //监听行工具事件
        table.on('tool(test-table-toolbar)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('您确定要删除吗', function(index){
                    obj.del();
                    layer.close(index);
                    $.post('/dingzhi/delete',{id:data.id},function(res){
                        if(res.code == 100000){
                            layer.msg(res.message);
                        }
                    },'json')
                });
            } else if(obj.event === 'edit'){
                layer.open({
                    type: 2,
                    title: '编辑定制信息',
                    shadeClose: true,
                    shade: false,
                    maxmin: true, //开启最大化最小化按钮
                    area: ['80%', '80%'],
                    content: '/dingzhi/info?id='+data.id
                });
            }
        });

        //搜索
        $('#search_btn').bind('click',function(){
            var status = $('#select-status-search').val();
            //执行重载
            table.reload('reloaded', {
                page: {
                    curr: 1 //重新从第 1 页开始
                }
                , where: {
                    status:status,
                }
            });
        });
        if('<?=isset($_GET["status"])?>'){
            $('#select-status-search').val('<?=isset($_GET["status"]) ? $_GET["status"] : ''?>');
            form.render();
            $('#search_btn').trigger('click');
        }
    });
</script>