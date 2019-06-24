<div class="layui-card">
    <div class="layui-card-header header-title">组件列表</div>
    <div class="layui-card-body layui-form">
        <div class="layui-inline">
        <input type="text" class="layui-input js_search_title" placeholder="输入新闻标题搜索">
        </div>
        <div class="layui-inline">
            <select id="select-status-search">
                <option  value="">请选择状态</option>
                <option  value="0">审核中</option>
                <option  value="2">未通过</option>
                <option  value="1">已完成</option>
            </select>
        </div>
        <div class="layui-inline">
            <select id="select-sort-search">
                <option  value="">请选择排序</option>
                <option  value="1">倒序</option>
                <option  value="2">正序</option>
            </select>
        </div>
        <button type="button" id="search_btn" class="layui-btn layui-btn-normal">搜索</button>
    </div>
    <div class="layui-card-body">
        <table class="layui-hide" id="test-table-toolbar" lay-filter="test-table-toolbar"></table>

       <!-- <script type="text/html" id="test-table-toolbar-toolbarDemo">
            <div class="layui-btn-container">
                <a href="/widget/info" class="layui-btn layui-btn-sm">添加组件</a>
            </div>
        </script>-->

        <script type="text/html" id="switchTpl">
            <input type="checkbox" name="recommend" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="filter-recommend" {{ d.recommend == 1 ? 'checked' : '' }}>
        </script>

        <script type="text/html" id="switchTp2">
            <input type="checkbox" name="is_down" value="{{d.id}}" lay-skin="switch" lay-text="是|否" lay-filter="filter-is_down" {{ d.is_down == 1 ? 'checked' : '' }}>
        </script>

        <script type="text/html" id="test-table-toolbar-barDemo">
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-xs layui-btn-normal" lay-event="params">静态配置</a>
                {{# if(d.upload_download){}}
                <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="upload">更新</a>
                {{# } }}
                <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
                <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            </div>
        </script>

    </div>
</div>
<script type="text/html" id="select-status-form">
    <div class="layui-form" style="padding:30px;">
        <select id="select-status" lay-filter="select-status" name="status" lay-verify="required">
            <option  value="0">审核中</option>
            <option  value="2">未通过</option>
            <option  value="1">已完成</option>
        </select>
        <input type="text" placeholder="请输入未通过理由" style="margin-top:20px;" class="js_error_text layui-hide layui-input error-text none">
    </div>
</script>
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
            ,id : 'reloaded'
            ,cols: [[
                {field:'id', width:80, title: 'ID', sort: true}
                ,{field:'title',title: '标题',templet: function (d) {
                       if(d.upload_download){
                           var str = 'upload_file=1';
                       }else{
                           var str = '';
                       }
                       return '<a target="_blank" class="theme" href="'+frontend_url+'/unit/item/'+d.id+'?auth=0777&"'+str+'> '+d.title+' </a>';
                    }}
                ,{field:'create_time',  title: '创建时间',templet: function (d) {
                        return getLocalTime(d.create_time);
                    }}
                ,{field:'banner_url', title: '列表图',templet: function (d) {
                        return '<a class="theme js_banner_url" target="_blank" href='+site_url+d.banner_url+' >'+d.banner_url+'</a>';
                    }}
                ,{field:'recommend',width:100, title: '是否推荐',templet: '#switchTpl'}
                ,{field:'is_down',width:120, title: '不允许下载',templet: '#switchTp2'}
                ,{field:'status',title: '状态',templet:function(d){
                        if(d.status == 0){
                            return '<span style="cursor:pointer" lay-event="change-status" class="theme">审核中</span>'
                        }
                        if(d.status == 2){
                            return '<span style="cursor:pointer" lay-event="change-status" class="theme-red">未通过</span>'
                        }
                        if(d.status == 1){
                            return '<span lay-event="change-status" style="color:#00dd00;cursor:pointer">已完成</span>'
                        }
                    }}
                ,{field:'desc', title: '描述'}
                ,{ title:'操作', toolbar: '#test-table-toolbar-barDemo', width:200}
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
            } else if(obj.event === 'change-status'){
                layer.open({
                    type: 1,
                    title: '修改审核状态',
                    area: ['400px', '300px'],
                    btn: ['确定'],
                    content: $('#select-status-form').html(),
                    success: function(layero, index){
                        $(".layui-layer-page .layui-layer-content").css('overflow','visible');
                        $('#select-status option[value="'+data.status+'"]').attr('selected','selected');
                        if(data.status == 2){
                            $(".js_error_text").val(data.fail_msg).removeClass('layui-hide');
                        }
                        form.render();
                    },
                    yes: function(index, layero){
                        $.post('/widget/info?id='+data.id,{fail_msg:$('.js_error_text').val(),status: $('#select-status option:selected').val()},function(data){
                            layer.close(index);
                            table.reload('reloaded', {
                                page: {
                                    curr: $('.layui-laypage-curr em:last-child').text(), //重新从第 1 页开始
                                }
                            });
                            layer.msg(data.message,{icon:1,duration:1500});
                        },'json')
                    }
                });

            }else if(obj.event == 'params'){
                if(data.upload_download){
                    var dir = 'upload_file'
                }else{
                    var dir = 'widget_file'
                }
                window.location.href = '/widget/params/?id='+data.id+'&dir=../../frontend/web/'+dir+'/'+data.id;
            }else if(obj.event == 'upload'){
                layer.confirm('您确定要更新吗', function(index){
                    layer.close(index);
                    $.post('/widget/upload-widget',{id:data.id},function(res){
                        if(res.code == 100000){
                            layer.msg(res.message);
                            table.reload('reloaded', {
                                page: {
                                    curr: $('.layui-laypage-curr em:last-child').text(), //重新从第 1 页开始
                                }
                            });
                        }
                    },'json')
                });
            }
        });

        form.on('select(select-status)',function(data){
            if(data.value == 2){
                $(".js_error_text").removeClass('layui-hide');
            }else{
                $(".js_error_text").addClass('layui-hide');
            }
        })

        //搜索
        $('#search_btn').bind('click',function(){
            var title = $('.js_search_title').val();
            var status = $('#select-status-search').val();
            var sort = $("#select-sort-search").val();
                //执行重载
                table.reload('reloaded', {
                    page: {
                        curr: 1 //重新从第 1 页开始
                    }
                    , where: {
                        title: title,
                        status:status,
                        sort : sort
                    }
                });
        });

        if('<?=isset($_GET["status"])?>'){
            $('#select-status-search').val('<?=isset($_GET["status"]) ? $_GET["status"] : ''?>');
            form.render();
            $('#search_btn').trigger('click');
        }

        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
        }

    });
</script>