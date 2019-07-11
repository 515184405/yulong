<?php $this->title="网站地图"; ?>
<h1><a href="/">313组件库</a></h1>
<h2><a href="/unit">组件</a></h2>
<?php foreach ($data as $val) { ?>
    <h5><a href="/unit/item/<?=$val['id']?>"><?=$val['title']?></a></h5>
<?php } ?>
