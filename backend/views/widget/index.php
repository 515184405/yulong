<div class="layui-card">
    <div class="layui-card-header header-title">组件列表</div>
    <div class="layui-card-body">
        <div class="layui-inline">
        <input type="text" class="layui-input js_search_title" placeholder="输入新闻标题搜索">
        </div>
        <button type="button" id="search_btn" class="layui-btn layui-btn-normal">搜索</button>
    </div>
    <div class="layui-card-body">
        <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

        <script type="text/html" id="test-table-toolbar-toolbarDemo">
            <div class="layui-btn-container">
                <a href="/widget/info" class="layui-btn layui-btn-sm">添加组件</a>
            </div>
        </script>

        <script type="text/html" id="switchTpl">
            <input type="checkbox" name="recommend" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="filter-recommend" {{ d.recommend == 1 ? 'checked' : '' }}>
        </script>

        <script type="text/html" id="switchTp2">
            <input type="checkbox" name="issue" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="filter-issue" {{ d.issue == 2 ? 'checked' : '' }}>
        </script>

        <script type="text/html" id="switchTp3">
            <input type="checkbox" name="issue" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="filter-is_down" {{ d.is_down == 1 ? 'checked' : '' }}>
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
            ,url: '/widget/index'
            ,cols: [[
                {field:'id', width:80, title: 'ID', sort: true}
                ,{field:'title',title: '标题',templet: function (d) {
                       return '<a target="_blank" class="theme" href="'+frontend_url+'/unit/item/'+d.id+'?auth=0777"> '+d.title+' </a>';
                    }}
                ,{field:'create_time',  title: '创建时间',templet: function (d) {
                        return getLocalTime(d.create_time);
                    }}
                ,{field:'banner_url', title: '列表图',templet: function (d) {
                        return '<a class="theme js_banner_url" target="_blank" href='+site_url+d.banner_url+' >'+d.banner_url+'</a>';
                    }}
                ,{field:'recommend',width:100, title: '是否推荐',templet: '#switchTpl'}
                ,{field:'issue',width:100, title: '是否发布',templet: '#switchTp2'}
                ,{field:'is_down',width:120, title: '不允许下载',templet: '#switchTp3'}
                ,{field:'desc', title: '描述'}
                ,{fixed: 'right', title:'操作', toolbar: '#test-table-toolbar-barDemo', width:150}
            ]]
            ,done(res){
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

        // 推荐单选开关事件
        form.on('switch(filter-recommend)',function(res){
            $.post('/widget/recommend',{checked:res.elem.checked,id:res.value},function(data){
                layer.tips(data.message, $(res.elem).next(), {
                    tips: [1, '#0FA6D8'] //还可配置颜色
                });
            },'json')
        })

        // 发布单选开关事件
        form.on('switch(filter-issue)',function(res){
            $.post('/widget/issue',{checked:res.elem.checked,id:res.value},function(data){
                layer.tips(data.message, $(res.elem).next(), {
                    tips: [1, '#0FA6D8'] //还可配置颜色
                });
            },'json')
        })

        // 是否允许下载单选开关事件
        form.on('switch(filter-is_down)',function(res){
            $.post('/widget/is-down',{checked:res.elem.checked,id:res.value},function(data){
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
                    $.post('/widget/delete',{id:data.id},function(res){
                        if(res.code == 100000){
                            layer.msg(res.message);
                        }
                    },'json')
                });
            } else if(obj.event === 'edit'){
                window.location.href = '/widget/info/?id='+data.id;
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