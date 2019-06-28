<?php if(isset($data['data'])){?>
    <div class="list-header transition clearfix">
        <i class="iconfont aslide-switch left"></i>
        <div class="list-header-nav list-header-nav2">
            <?php if($data['link'] === 'unit'){ ?>
                <a href="/unit" class="lhn-item">组件列表</a>
            <?php }; ?>
            <?php if($data['link'] === 'case'){ ?>
                <a href="/case" class="lhn-item">案例列表</a>
            <?php }; ?>
            <?php if($data['link'] === 'news'){ ?>
                <a href="/news" class="lhn-item">文章列表</a>
            <?php }; ?>

            <a <?=is_null($data['prev']['id']) ? '' : 'href="/'.$data['link'].'/item/'.$data['prev']['id'].'"' ?> class="lhn-item <?=is_null($data['prev']['id']) ? 'a-disabled' : ''?>"><i class="iconfont icon-prev">&#xe604;</i>PREV</a>
            <a <?=is_null($data['next']['id']) ? '' : 'href="/'.$data['link'].'/item/'.$data['next']['id'].'"' ?> class="lhn-item <?=is_null($data['next']['id']) ? 'a-disabled' : ''?>">NEXT<i class="iconfont icon-next">&#xe607;</i></a>
        </div>
    </div>
<?php }else{ ?>
    <div class="list-header transition clearfix">
        <i class="iconfont aslide-switch left"></i>
        <div class="list-header-hidden">
            <div class="list-header-nav">
                <a href="/<?=$data['link']?>" class="lhn-item overflow-text <?=(!isset($_GET['id']) || (isset($_GET['id'])&&$_GET['id']==0)) ? 'active' : '' ?>">全部</a>
                <?php foreach ($data['type'] as $key=>$val){ ?>
                    <a href="/<?=$data['link']?>?id=<?=$val['type_id']?>" class="lhn-item overflow-text <?=((isset($_GET['id'])&&$_GET['id']!=0) && $_GET['id']== $val['type_id']) ? 'active' : '' ?>"><?=$val['title']?></a>
                <?php } ?>
            </div>
        </div>
    </div>
    <i class="iconfont css-filter js_filter none"></i>
<?php } ?>
