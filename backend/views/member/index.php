<div class="layui-card">
    <div class="layui-card-header header-title">用户列表</div>
    <div class="layui-card-body">
        <div class="layui-inline">
            <input type="text" class="layui-input js_search_title" placeholder="输入用户名">
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
            ,url: '/member/index'
            ,cols: [[
                {field:'id', width:80, title: 'ID', sort: true}
                ,{field:'username',title: '用户名'}
                ,{field:'avatar',title: '用户头像',templet:function(d){
                        return '<img class="layui-nav-img" src="'+(d.avatar.indexOf('http') == -1 ? site_url2+d.avatar : d.avatar)+'"/>'
                    }}
                ,{field:'created_time',  title: '创建时间',templet: function (d) {
                        return getLocalTime(d.created_time);
                    }}
                ,{field:'province',title: '地址',templet:function(d){
                    return d.province + '/' + d.city;
                    }}
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