<?php
$this->title = '个人信息';
?>

<link rel="stylesheet" href="<?=Yii::$app->params['backend_url']?>/asset/layui/css/layui.css<?=Yii::$app->params['static_number']?>" media="all">
<link rel="stylesheet" href="/asset/static/css/personal.css<?=Yii::$app->params['static_number']?>">
<style>
    .layui-form-item{
        clear: none;
    }
    .layui-form-item:after{
        clear: none;
    }
    .layui-form{
        margin-top:30px;
    }
    .avatar-box{
        padding:13px;
        font-size:0;
        background-color: #f1f1f1;
    }
    .avatar-item img{
        width:60px;
        height:60px;
        margin:5px 5px 0 0;
        border:1px solid transparent;
    }
    .avatar-item img:hover{
        border:1px solid #4781ff;
    }
    .set-avatar{
        width:80px;height:80px;cursor: pointer;border:1px solid transparent;
    }
    .set-avatar:hover{
        opacity: 0.7;
    }
</style>
<div class="personal fy-container clearfix">
    <?=$this->render('../template/personal');?>
    <div class="personal-right">
        <h2 class="user-title"><?=isset($_GET['id']) ? "组件修改" : '上传组件'?></h2>
        <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-block">
                        <input type="text" value="<?=$data['username']?>" name="username" lay-verify="required" lay-text="用户名不能为空" autocomplete="off" placeholder="请输入用户名" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label style="line-height: 60px;" class="layui-form-label">用户头像</label>
                    <div class="layui-input-block">
                        <img id="user_avatar" class="layui-nav-img set-avatar" src="<?=$data['avatar']?>" alt="用户头像">
                        <input type="hidden" name="avatar" autocomplete="off" placeholder="用户头像" class="js_user_avatar">
                        <p style="display: inline-block;" class="red">点击当前图片切换头像</p>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label style="line-height: 60px;" class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <button class="layui-btn layui-btn-normal" lay-submit="" lay-filter="submit-btn" style="width:150px;">立即提交</button>
                    </div>
                </div>
        </form>
    </div>
</div>

<div class="avatar-box none" id="avatar_select">
    <?php for($i = 1;$i < 84;$i++){ ?>
        <a class="avatar-item" href="javascript:;"><img src="/asset/static/image/avatar/<?=$i?>.jpg" alt="头像"></a>
    <?php } ?>
</div>

<script src="<?=Yii::$app->params['backend_url']?>/asset/layui/layui.js"></script>
<script>
    layui.use([ 'form'], function(){
        var $ = layui.$,
            form = layui.form;

        $('#user_avatar').click(function(){
            layer.open({
                title:'选择头像',
                type: 1,
                area: ['500px','400px'], //宽高
                content:$('#avatar_select'),
            })
        })

        $(document).delegate('.avatar-item','click',function(){
            var avatarSrc = $(this).find('img').attr('src');
            $('#user_avatar').attr('src',avatarSrc);
            $('.js_user_avatar').val(avatarSrc);
            layer.closeAll();
        })


        /* 监听提交 */
        form.on('submit(submit-btn)', function(data) {

            layer.load(1, {shade: .1});
            var _this = this;_this.disabled=true;//防止多次提交
            var params = data.field;
            var csrfName = $("#form_csrf").attr('name');
            var csrfVal = $("#form_csrf").val();
            params[csrfName] = csrfVal;
            $.ajax({
                type: "post",
                url: "",
                data: params,
                dataType: "json",
                success: function(res) {
                    layer.closeAll();
                    _this.disabled=false;
                    if(res.code == 100000) {
                       layer.msg(res.message,{icon:1,time:1500},function(){
                           location.reload();
                       })
                    }else{
                        layer.msg(res.message,{icon:2,time:1500},function(){
                            location.reload();
                        })
                    }
                },
                error: function(){
                    layer.closeAll();
                    // _this.disabled=false;
                    // layer.msg('操作失败', {icon: 1}, function(){
                    //     window.location.reload();
                    // })
                }
            });
            return false;
        })

    })
</script>