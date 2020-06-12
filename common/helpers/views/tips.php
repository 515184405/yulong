<?php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=Yii::t('common','reminder')?></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="<?=Yii::$app->params['static_url']?>/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="<?=Yii::$app->params['static_url']?>/style/admin.css" media="all">
     <style type="text/css">
        .tip-container{
            width:360px;
            margin: 20px auto;
            padding-top: 20px;
            background: #fff;
            box-shadow: 0px 0px 20px rgba(0,0,0,0.1);
            border: 1px solid #ddd;
            text-align: center;
            box-sizing:border-box;
        }
        .tip-icon{
            font-size: 56px;
        }
        .tip-text{
            /*color: #544d4d;*/
            font-size: 18px;
            font-weight: bold;
        }
        .success-color{
            color:#7fdd40;
        }
        .error-color{
            color:#EAB408;
        }
        .tip-subtext{
            margin-top:20px;
        }
        .tip-btn{
            padding: 20px;
            border-top: 1px solid #eee;
            margin-top:20px;
        }
        .layui-btn-block{
            width: auto;
            display: block;
        }

        @media screen and (max-width:600px){
             .tip-container{
                width:100%;
                border:0;
                margin-top:10px;
             }
        }

    </style>
</head>
<body>

    <div class="tip-container">
        <!-- 成功类名 success-color      失败类名  error-color -->
        <?php
        if($status){
            ?>
            <p><i class="iconfont tip-icon success-color">&#xe65a;</i></p>
            <p><span class="tip-text success-color">操作成功</span></p>
            <?php
        }else{
            ?>
            <p><i class="iconfont tip-icon error-color">&#xe65c;</i></p>
            <p><span class="tip-text error-color">操作失败</span></p>
            <?php
        }
        ?>
        <p class="tip-subtext"><span><?=$message?></span></p>
        <div class="tip-btn">
            <?php
            if($url){
                ?>
                <a href="<?=$url?>" class="layui-btn layui-btn-block">继续</a>
                <?php
            }else{
                ?>
               <!-- <a href="javascript:window.opener=null;window.open('','_self');window.close();" class="layui-btn layui-btn-block">关闭</a>-->
                <?php
            }
            ?>
        </div>
    </div>

</body>
<?php
if($url){
    ?>
    <script>
        <?php
        if($iframe){
            ?>
        setTimeout("window.location.href='<?=$url?>'",<?=$time?>)
        <?php
        }else{

        ?>
        setTimeout("top.location.href='<?=$url?>'",<?=$time?>)
        <?php
        }
        ?>

    </script>
    <?php
}
?>

</html>