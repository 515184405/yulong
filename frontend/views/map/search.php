<?php $this->title="按标签搜索"; ?>
<style>
    a:link{text-decoration: none;}a:visited{text-decoration:none;}a:active{text-decoration:none;}
    body{font-family: Arial, "微软雅黑";font-size: 13px;}
    ul, li{margin:0px; padding:0px; list-style:none;}ul{width:90%;margin-left: auto;margin-right: auto;}.title{width:100%;font-size: 18px;}
    .lks a {font-size:13px;border:1px solid #e4e4e4;width:150px;height:30px;line-height:30px;float:left;padding-left:5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
    .lks span {font-size:10px;width:40px;background-color:#e4e4e469;margin-bottom:3px;text-align:center;border-left:1px solid #e4e4e4;float:left;border-top:1px solid #e4e4e4;border-bottom:1px solid #e4e4e4;}
    .lks {line-height:30px;font-size:16px;height:32px;width:200px;text-align:left;float:left;margin-bottom:3px;}
</style>


<div style="display: table;width: 100%;">
    <ul>
        <li class="title"><h1><a href="/">313组件库</a></h1></li>
        <li class="title"><h2><a href="/unit">组件</a></h2></li>
        <?php foreach ($data as $key=>$val) { ?>
            <li class="lks"><span><?=$key?></span><a href="/unit/item/<?=$val['type_id']?>" title="<?=$val['title']?>" target="_blank"><?=$val['title']?></a></li>
        <?php } ?>
    </ul>
</div>