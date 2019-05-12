<?php if(isset($data['prev_id'])){?>
    <div class="list-header transition clearfix">
        <i class="iconfont aslide-switch left"></i>
        <div class="list-header-nav list-header-nav2">
            <?php if($data['link'] === 'news'){ ?>
                <a href="/news" class="lhn-item">文章列表</a>
            <?php }; ?>
            <?php if($data['link'] === 'case'){ ?>
                <a href="/case" class="lhn-item">案例列表</a>
            <?php }; ?>

            <a href="/news/item/<?=$data['prev_id']?>" class="lhn-item"><i class="iconfont icon-prev">&#xe604;</i>PREV</a>
            <a href="/news/item/<?=$data['next_id']?>" class="lhn-item">NEXT<i class="iconfont icon-next">&#xe607;</i></a>
        </div>
    </div>
<?php }else{ ?>
    <div class="list-header transition clearfix">
        <i class="iconfont aslide-switch left"></i>
        <div class="list-header-nav">
            <a href="/<?=$data['link']?>?id=0" class="lhn-item <?=(!isset($_GET['id']) || (isset($_GET['id'])&&$_GET['id']==0)) ? 'active' : '' ?>">全部</a>
            <?php foreach ($data['type'] as $key=>$val){ ?>
            <a href="/<?=$data['link']?>?id=<?=$val['type_id']?>" class="lhn-item <?=((isset($_GET['id'])&&$_GET['id']!=0) && $_GET['id']== $val['type_id']) ? 'active' : '' ?>"><?=$val['title']?></a>
            <?php } ?>
        </div>
    </div>
<?php } ?>
