
<div class="layui-card">
    <div class="layui-card-header header-title">商品列表</div>
    <div class="layui-card-body layui-form">
        <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

        <script type="text/html" id="test-table-toolbar-toolbarDemo">
            <div class="layui-btn-container">
                <a href="/goods/info" class="layui-btn layui-btn-sm">添加商品</a>
            </div>
        </script>

        <script type="text/html" id="switchTpl">
            <input type="checkbox" name="recommend" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="filter-recommend" {{ d.recommend == 1 ? 'checked' : '' }}>
        </script>

        <script type="text/html" id="switchTp2">
            <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="filter-status" {{ d.status == 1 ? 'checked' : '' }}>
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
    var frontend_url = '<?=Yii::$app->params["frontend_url"];?>';
    layui.config({
        base: '<?=Yii::$app->params["backend_url"]?>/asset/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table','form'], function(){
        var $ = layui.$,
            form = layui.form,
            table = layui.table;

        table.render({
            elem: '#test-table-toolbar'
            ,toolbar: '#test-table-toolbar-toolbarDemo'
            ,url: '/goods/index'
            ,cols: [[
                {field:'id', width:80, title: 'ID', sort: true}
                ,{field:'name',title: '商品名称'}
                ,{field:'price',title: '商品价格',templet:function(d){
                    return '<span style="color:#f00;font-weight:bold">'+d.price+'</span>';
        }}
                ,{field:'status',title: '商品状态',templet:'#switchTp2'}
                ,{field:'recommend',title: '商品推荐',templet:'#switchTpl'}
                ,{field:'imgsrc', title: '商品图片',templet: function (d) {
                        return '<a class="theme js_banner_url" target="_blank" href='+site_url+d.imgsrc+' >'+d.imgsrc+'</a>';
                  }}
                ,{ title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
            ]]
            ,done:function(res){
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

        // 推荐单选开关事件
        form.on('switch(filter-recommend)',function(res){
            $.post('/goods/recommend',{checked:res.elem.checked,id:res.value},function(data){
                layer.tips(data.message, $(res.elem).next(), {
                    tips: [1, '#0FA6D8'] //还可配置颜色
                });
            },'json')
        })

        // 是否发布单选开关事件
        form.on('switch(filter-status)',function(res){
            $.post('/goods/issue',{checked:res.elem.checked,id:res.value},function(data){
                layer.tips(data.message, $(res.elem).next(), {
                    tips: [1, '#0FA6D8'] //还可配置颜色
                });
            },'json')
        })


        //监听行工具事件
        table.on('tool(test-table-toolbar)', function(obj){
            var data = obj.data;
            if(obj.event === 'del'){
                layer.confirm('您确定要删除吗', function(index){
                    obj.del();
                    layer.close(index);
                    $.post('/banner/delete',{id:data.id},function(res){
                        if(res.code == 100000){
                            layer.msg(res.message);
                        }
                    },'json')
                });
            } else if(obj.event === 'edit'){
                window.location.href = '/goods/info/?id='+data.id;
            }
        });
    });
</script>