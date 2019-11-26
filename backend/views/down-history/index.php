<div class="layui-card">
    <div class="layui-card-header header-title">用户下载历史列表</div>
    <div class="layui-card-body">
        <div class="layui-inline">
            <input type="text" class="layui-input js_search_title" placeholder="输入ID">
        </div>
        <button type="button" id="search_btn" class="layui-btn layui-btn-normal">搜索</button>
    </div>
    <div class="layui-card-body">
        <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>
    </div>
</div>
<script>
    var site_url2 = '<?=Yii::$app->params["frontend_url"];?>';
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
            ,url: '/down-history/index'
            ,cols: [[
                {field:'u_id', width:80, title: '用户ID', sort: true}
                ,{field:'member',title: '用户名',templet:function(d){
                            return d.member.username;
                        }}
                ,{field:'member',title: '头像',templet:function(d){
                        return '<img class="layui-nav-img" src="'+(d.member.avatar.indexOf('http') == -1 ? site_url2+d.member.avatar : d.member.avatar)+'"/>'
                    }}
                ,{field:'down_title',title: '组件名称',templet:function(d){
                        return '<a style="color:blue" target="_blank" href="'+site_url2+'/unit/item/'+d.widget_id+'">'+d.down_title+'</a>';
                    }}
                ,{field:'create_time',  title: '创建时间'}

            ]]
            ,done(res){
                console.log(res);
            }
            ,page: true
            ,limit: 50
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
                        username: title
                    }
                });
            }
        })

        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
        }

    });
</script>