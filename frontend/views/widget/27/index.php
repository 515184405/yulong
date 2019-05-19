<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta id="scale" content="initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
	<link rel="stylesheet" href="<?=$url;?>css/common.css">
	<link rel="stylesheet" href="<?=$url;?>js/SyntaxHighlighter/shCoreDefault.css">
	<link rel="stylesheet" href="<?=$url;?>css/alert.css">
	<link rel="stylesheet" href="<?=$url;?>css/style.css">
	<script src="http://www.jq22.com/jquery/jquery-1.10.2.js"></script>
	<script src='<?=$url;?>js/SyntaxHighlighter/shCore.js'></script>
	<script src='<?=$url;?>js/SyntaxHighlighter/makeSy.js'></script>
	<script src='<?=$url;?>js/alert.js'></script>
	<script src='<?=$url;?>js/alert-api.js'></script>
</head>
<body>
	<p class="t_c f24 alert-api-txt m30 w1004">alert.js说明文档</p>
	<div class="w1004 alert-box">
		<div class="alert-api-list">
			<p class="f18 alert-api-title">演示demo</p>
			<ul class="alert_list">
				<li><a class="alert-api-hover" href="#tishi1">默认提示</a></li>
				<li><a href="#tishi2">正确提示</a></li>
				<li><a href="#tishi3">错误提示</a></li>
				<li><a href="#tishi4">警告提示</a></li>
				<li><a href="#anniu1">按钮1</a></li>
				<li><a href="#anniu2">按钮2</a></li>
				<li><a href="#noAnimate">不使用动画</a></li>
				<li><a href="#animate2">动画2</a></li>
				<li><a href="#buhuo">捕获页</a></li>
				<li><a href="#iframe1">iframe层</a></li>
				<li><a href="#iframe2">iframe窗</a></li>
				<li><a href="#pcAlert">pc弹层</a></li>
			</ul>
			<p class="f18 alert-api-title">基础参数</p>
			<ul class="alert_list">
				<li><a href="#style">style</a></li>
				<li><a href="#title">title   </a></li>
				<li><a href="#icon">icon   </a></li>
				<li><a href="#content">content	</a></li>
				<li><a href="#contentTextAlign">contentTextAlign</a></li>
				<li><a href="#width">width</a></li>	
				<li><a href="#height">height</a></li>	
				<li><a href="#minWidth">minWidth</a></li>	
				<li><a href="#className">className</a></li>	
				<li><a href="#position">position</a></li>	
				<li><a href="#animateType">animateType</a></li>	
				<li><a href="#modal">modal</a></li>	
				<li><a href="#isModalClose">isModalClose</a></li>	
				<li><a href="#bodyScroll">bodyScroll</a></li>	
				<li><a href="#closeTime">closeTime</a></li>	
				<li><a href="#buttons">buttons	</li>
			</ul>
			<p class="f18 alert-api-title">返回对象</p>
			<ul class="alert_list">
				<li><a href="#dialog">dialog</a></li>
			</ul>
			<p class="f18 alert-api-title">内置方法</p>
			<ul class="alert_list">
				<li><a href="#dialog_close">dialog.close</a></li>
				<li><a href="#dialog_show">dialog.show</a></li>
				<li><a href="#dialog_destroy">dialog.destroy </a></li>
			</ul>
		</div>
		<div class="alert-api-box">	
			<div class="alert-api-intro">
			<p class="alert-api-intro-msg">
				<span class="f18">alert.js弹层说明</span> 
				<span class="f14 red" style="margin-left:20px">此为 PC 和 手机 都兼容的弹层组件</span>
			</p>
			<p class="m20 f16 brush-title">引入说明</p>
				<pre class="brush:javascript;toolbar:false">
					&lt;link rel=&quot;stylesheet&quot; href=&quot;css/alert.css&quot;&gt;
					&lt;script src=&quot;http://www.jq22.com/jquery/jquery-1.10.2.js&quot;&gt;&lt;/script&gt;
					&lt;script src=&#x27;js/alert.js&#x27;&gt;&lt;/script&gt;</pre>
			<fieldset class="m20 fieldset">
					<legend>信息提示演示</legend>
					<button class="alert-api-button alert-btn1">默认提示</button>
					<button class="alert-api-button alert-btn11">正确提示</button>
					<button class="alert-api-button alert-btn12">错误提示</button>
					<button class="alert-api-button alert-btn13">警告提示</button>
				</fieldset>
				<fieldset class="m20 fieldset">
					<legend>实例演示</legend>
					<button class="alert-api-button alert-btn2">按钮1</button>
					<button class="alert-api-button alert-btn3">按钮2</button>
					<button class="alert-api-button alert-btn4">不使用动画</button>
					<button class="alert-api-button alert-btn5">动画2</button>
					<button class="alert-api-button alert-btn6">捕获页</button>
					<button class="alert-api-button alert-btn7">iframe层</button>
					<button class="alert-api-button alert-btn8">iframe窗</button>
					<button class="alert-api-button alert-btn9">pc弹层</button>
				</fieldset>
				<fieldset class="m20 fieldset">
					<legend>实例演示</legend>
					<button class="alert-api-button alert-btn10">actionsheet</button>
				</fieldset>
				<div class="m20 blockquote">
				alert.js是基于jQuery开发的一款 <span class="red"> PC  移动端 </span> 都兼容的轻量级弹层组件
			</div>
	
			<p class="f18 m20">评分</p>
			<div class="m20 blockquote">
			   	<p>如果觉得好用，就在github上 <a style='line-height: 25px;height:25px' class="alert-api-button" target="_blank" href='https://github.com/515184405/alert'>star</a><a target="_blank" style='line-height: 25px;height:25px;margin-left:5px;' class="alert-api-button" href="https://github.com/515184405/alert"> Fock</a> 或本站 <a class="alert-api-button" style='line-height: 25px;height:25px;' href="http://fy.035k.com/project/alert">留言</a> 哦</p>
			</div>

			<p class="f18 m20">浏览器兼容</p>
			<div class="m20 blockquote" id="alert-blockquote">
			     <p class="f16">浏览器兼容，下面是我们的主要兼容目标</p>
		         <p class="f14">1、IE8 或者 IE8以上 (Windows), <span class="red">IE8以下浏览器不兼容</p>
		         <p class="f14">2、Safari (Mac)</p>
		         <p class="f14">3、Chrome (Windows, Mac, Linux)</p>
		         <p class="f14"> 4、Firefox (Windows, Mac,  Linux)</p>
		         <p class="f14">5、谷歌内核(webkit)浏览器，如360浏览器，搜狗浏览器，QQ浏览器等</p>
			</div>
			<p class="f18 m20 blue">核心方法（配置）: jqueryAlert(opts)</p>
			<div class="m20 blockquote">
				opts是一个对象，它包含了以下key: '默认值'
			</div>
			<p class="m20 blue brush-title">javascript 代码:</p>
			<pre class="brush:javascript;toolbar:false">
						'style'        : 'wap', //wap | pc | actionsheet
 						'title'        : '',    //标题
						'icon'         : '',  //示例 ：'img/right.png' url地址 只对没有按钮且没有title时起作用
						'content'      : '',	//内容
						'contentTextAlign' : 'center', //内容对齐方式
						'width'        : 'auto', //宽度
						'height'       : 'auto', //高度
						'minWidth'     : '0', //最小宽度
						"className"    : '', //添加类名
						'position'     : 'fixed', //定位方式
						'animateType'  : 'scale',
						'modal'        : false, //是否存在蒙层
						'isModalClose' : false, //点击蒙层是否关闭
						'bodyScroll'   : false, //是否关闭body的滚动条
						'closeTime'    : 3000, //当没有按钮时关闭时间
						'actionsheetCloseText' : '', //当前样式为actionsheet时有效，关闭的文字按钮
						"buttons"      : {}, //按钮对象</pre>
				
				<p id="tishi1" class="m20 blue brush-title"><button class="alert-api-button alert-btn1">默认提示</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog1){
					return M.dialog1.show();
				}
				M.dialog1 = jqueryAlert({
					'content' : 'hello 程序员...',
					'closeTime' : 2000,
				})</pre>
				
				<p id="tishi2" class="m20 blue brush-title"><button class="alert-api-button alert-btn11">正确提示</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog11){
					return M.dialog11.show();
				}
				M.dialog11 = jqueryAlert({
					'icon'    : 'img/right.png',
					'content' : 'hello 程序员...',
					'closeTime' : 2000,
				})</pre>

				<p id="tishi3" class="m20 blue brush-title"><button class="alert-api-button alert-btn12">错误提示</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog12){
					return M.dialog12.show();
				}
				M.dialog12 = jqueryAlert({
					'icon'    : 'img/error.png',
					'content' : 'hello 程序员...',
					'closeTime' : 2000,
				})</pre>

				<p id="tishi4" class="m20 blue brush-title"><button class="alert-api-button alert-btn13">警告提示</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog13){
					return M.dialog13.show();
				}
				M.dialog13 = jqueryAlert({
					'icon'    : 'img/warning.png',
					'content' : 'hello 程序员...',
					'closeTime' : 2000,
				})</pre>

				<p id="anniu1" class="m20 blue brush-title"><button class="alert-api-button alert-btn2">按钮1</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog2){
					return M.dialog2.show();
				}
				M.dialog2 = jqueryAlert({
					'content' : 'hello 程 序 员 ...',
					'modal'   : true,
					'buttons' :{
						'确定' : function(){
							M.dialog2.close();
						}
					}
				})</pre>

				<p id="anniu2" class="m20 blue brush-title"><button class="alert-api-button alert-btn3">按钮2</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog3){
					return M.dialog3.show();
				}
				M.dialog3 = jqueryAlert({
					'title'   : 'alertjs提示',
					'content' : '欢迎使用alertjs弹层 ...',
					'modal'   : true,
					'buttons' :{
						'确定' : function(){
							M.dialog3.close();
						},
						'我不是' : function(){
							if(M.dialog31){
								return M.dialog31.show();
							}
							M.dialog31 = jqueryAlert({
								'content' : '我不是程序员...'
							})
						}
					}
				})</pre>

				<p id="noAnimate" class="m20 blue brush-title"><button class="alert-api-button alert-btn4">不使用动画</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
					// 判断是否已存在，如果已存在则直接显示
					if(M.dialog4){
						return M.dialog4.show();
					}
					M.dialog4 = jqueryAlert({
						'title'   : 'alertjs提示',
						'content' : '欢迎使用alertjs弹层 ...',
						'modal'   : true,
						'animateType' : '',
						'buttons' :{
							'确定' : function(){
								M.dialog4.close();
							},
							'不使用' : function(){
								if(M.dialog41){
									return M.dialog41.show();
								}
								M.dialog41 = jqueryAlert({
									'content' : '祝您找到更好用的...'
								})
							}
						}
					})</pre>

				<p id="animate2" class="m20 blue brush-title"><button class="alert-api-button alert-btn5">动画2</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog5){
					return M.dialog5.show();
				}
				M.dialog5 = jqueryAlert({
					'content' : alertContent ,
					'modal'   : true,
					'contentTextAlign' : 'left',
					'width'   : '400px',
					'animateType' : 'linear',
					'buttons' :{
						'不同意' : function(){
							M.dialog5.close();
						},
						'同意' : function(){
							if(M.dialog51){
								return M.dialog51.show();
							}
							M.dialog51 = jqueryAlert({
								'content' : '同意也不能注册哦...'
							})
						}
					}
				})</pre>

				<p id="buhuo" class="m20 blue brush-title"><button class="alert-api-button alert-btn6">捕获页</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog6){
					return M.dialog6.show();
				}
				M.dialog6 = jqueryAlert({
					'style'   : 'pc',
					'title'   : '捕获页',
					'content' :  $("#alert-blockquote"),
					'modal'   : true,
					'contentTextAlign' : 'left',
					'width'   : 'auto',
					'animateType' : 'linear',
					'buttons' :{
						'关闭' : function(){
							M.dialog6.close();
						},
					}
				})</pre>

				<p id="iframe1" class="m20 blue brush-title"><button class="alert-api-button alert-btn7">iframe层</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog7){
					return M.dialog7.show();
				}
				M.dialog7 = jqueryAlert({
					'style'   : 'pc',
					'title'   : 'iframe层',
					'content' :  alertContent,
					'modal'   : true,
					'contentTextAlign' : 'left',
					'width'   : '300',
					'height'  : '200',
					'animateType' : 'linear',
					'buttons' :{
						'关闭' : function(){
							M.dialog7.close();
						},
					}
				})</pre>

				<p id="iframe2" class="m20 blue brush-title"><button class="alert-api-button alert-btn8">iframe窗</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog8){
					return M.dialog8.show();
				}
				M.dialog8 = jqueryAlert({
					'style'   : 'pc',
					'title'   : 'iframe窗',
					'content' :  $(".alert-box"),
					'modal'   : true,
					'contentTextAlign' : 'left',
					'width'   : '90%',
					'height'  : '90%',
					'animateType': 'scale',
				})</pre>

				<p id="pcAlert" class="m20 blue brush-title"><button class="alert-api-button alert-btn9">PC弹层</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog9){
					return M.dialog9.show();
				}
				M.dialog9 = jqueryAlert({
					'style'   : 'pc',
					'title'   : 'pc弹层',
					'content' :  'PC端普通弹层呦呦呦...',
					'modal'   : true,
					'contentTextAlign' : 'left',
					'animateType': 'scale',
					'bodyScroll' : 'true',
					'buttons' : {
						'关闭' : function(){
							M.dialog9.close();
						},
						'去首页' : function(){
							location.href="http://fy.035k.com";
						}
					}
				})</pre>

				<p class="m20 blue brush-title"><button class="alert-api-button alert-btn10">IOS actionsheet</button> 参数配置</p>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.actionsheet){
					return M.actionsheet.show();
				}

				//注意:因actionsheet是后添加方法，所以只有以下参数设置有效
				//上面那些多余的参数对此无效
				M.actionsheet = jqueryAlert({
					'style' : 'actionsheet',
					'title'   : '我是一个标题',
					"className"    : '', //添加类名
					'modal'   : true,
					'actionsheetCloseText' : '取消',
					'buttons' :{
						'分享' : function(){
							if(M.actionsheet11){
								return M.actionsheet11.show();
							}
							M.actionsheet11 = jqueryAlert({
								'content' : '您点击了分享操作'
							})
						},
						'菜单' : function(){
							if(M.actionsheet12){
								return M.actionsheet12.show();
							}
							M.actionsheet12 = jqueryAlert({
								'content' : '您点击了菜单操作...'
							})
						},
						'示例一' : function(){
							if(M.actionsheet13){
								return M.actionsheet13.show();
							}
							M.actionsheet13 = jqueryAlert({
								'content' : '您点击了示例一操作...'
							})
						},
						'示例二' : function(){
							if(M.actionsheet14){
								return M.actionsheet14.show();
							}
							M.actionsheet14 = jqueryAlert({
								'content' : '您点击了示例二操作...'
							})
						},
					}
				})</pre>



				<p class="f24 m30">基本参数</p>

				<p id="style" class="alert-api-api "><span class="blue f18">style </span>- String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：'wap'</p>
					<p><span class="blue">选项</span>：<span class="str_bg">wap</span><span class="str_bg">pc</span><span class="str_bg">actionsheet</span></p>
					<p><span class="blue">释义</span>：设置显示样式</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'style' :  'wap',
				})</pre>


				<p id="title" class="alert-api-api "><span class="blue f18">title </span>- String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：''</p>
					<p><span class="blue">释义</span>：设置标题</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'title' :  '温馨提示',
				})</pre>

				<p id="icon" class="alert-api-api "><span class="blue f18">icon </span>- String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：''</p>
					<p><span class="blue">释义</span>：在title与buttons都不存在的时候设置icon才生效</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'icon'    : 'img/right.png',
					'content' :  '温馨提示',
				})</pre>

				<p id="content" class="alert-api-api "><span class="blue f18">content </span>- String/jQuery对象</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：''</p>
					<p><span class="blue">释义</span>：设置内容</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'content' :  '普通弹层呦呦呦...',
				})</pre>

				<p id="contentTextAlign" class="alert-api-api "><span class="blue f18">contentTextAlign </span>- String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：center</p>
					<p><span class="blue">选项</span>：<span class="str_bg">center</span><span class="str_bg">left</span><span class="str_bg">right</span></p>
					<p><span class="blue">释义</span>：设置内容对齐方式</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'contentTextAlign' : "left",
				})</pre>
				
				<p id="width" class="alert-api-api "><span class="blue f18">width </span>- Number/String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：auto</p>
					<p><span class="blue">释义</span>：设置宽度</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'width' : "500",
				})</pre>

				<p id="height" class="alert-api-api "><span class="blue f18">height </span>- Number/String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：auto</p>
					<p><span class="blue">释义</span>：设置高度</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'height' : "500",
				})</pre>

				<p id="minWidth" class="alert-api-api "><span class="blue f18">minWidth </span>- Number/String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：0</p>
					<p><span class="blue">释义</span>：设置最小宽度</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'minWidth' : "160",
				})</pre>

				<p id="className" class="alert-api-api "><span class="blue f18">className </span>- String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：""</p>
					<p><span class="blue">释义</span>：给弹层添加一个特殊的类名，方便调整自己的样式</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'className' : "myDialog1",
				})</pre>

				<p id="position" class="alert-api-api "><span class="blue f18">position </span>- String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：fixed</p>
					<p><span class="blue">选项</span>：<span class="str_bg">fixed</span><span class="str_bg">absolute</span></p>
					<p><span class="blue">释义</span>：使用定位情况</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'position' : "fixed",
				})</pre>

				<p id="animateType" class="alert-api-api "><span class="blue f18">animateType </span>- String</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：scale</p>
					<p><span class="blue">选项</span>：<span class="str_bg">scale</span><span class="str_bg">linear</span><span class="str_bg">为空或其他则为fadeIn动画</span></p>
					<p><span class="blue">释义</span>：使用动画</p>
					<p><span class="blue">Bug</span>：在IE8下动画效果失效</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'animateType' : "scale",
				})</pre>

				<p id="modal" class="alert-api-api "><span class="blue f18">modal </span>- Boolean</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：false</p>
					<p><span class="blue">释义</span>：是否添加蒙层</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'modal' : true,
				})</pre>
	
				<p id="isModalClose" class="alert-api-api "><span class="blue f18">isModalClose </span>- Boolean</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：false</p>
					<p><span class="blue">释义</span>：点击蒙层时是否关闭</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'isModalClose' : true,
				})</pre>

				<p id="bodyScroll" class="alert-api-api "><span class="blue f18">bodyScroll </span>- Boolean</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：false</p>
					<p><span class="blue">释义</span>：弹出蒙层是否禁止滚动</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'bodyScroll' : true,
				})</pre>
				
				<p id="closeTime" class="alert-api-api "><span class="blue f18">closeTime </span>- number</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：3000</p>
					<p><span class="blue">释义</span>：如果所有按钮不存在并且style参数 != 'pc'则此参数生效</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'closeTime' : 3000,
				})</pre>

				<p id="closeTime" class="alert-api-api "><span class="blue f18">actionsheetCloseText </span>- string</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：""</p>
					<p><span class="blue">释义</span>：当前style = 'actionsheet'时有效，值为关闭按钮的文字,值为空时，则无关闭按钮</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'actionsheetCloseText' : '取消',
				})</pre>

				<p id="buttons" class="alert-api-api "><span class="blue f18">buttons </span>- Object</p>
				<div class="m20 blockquote">
					<p><span class="blue">默认</span>：{}</p>
					<p><span class="blue">释义</span>：只能传入key:callback形式,可为多个</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
					'buttons' : {
						'确定' : function(){
				            dialog.close();
				        },
				        '我不是' : function(){
				            alert(11)
				        }
					}
				})</pre>
				<p class="f24 m30">返回对象</p>
				<p id="dialog" class="alert-api-api "><span class="blue f18">dialog </span>- Object</p>
				<div class="m20 blockquote">
					<p><span class="blue">释义</span>：组件内部返回dialog对象，需要变量做接收</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				var dialog = jqueryAlert({
				})</pre>
			
				<p class="f24 m30">内置方法</p>
				<p id="dialog_close" class="alert-api-api "><span class="blue f18">close() </span>- 关闭当前窗口</p>
				<div class="m20 blockquote">
					<p><span class="blue">释义</span>：关闭当前窗口方法</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				M.dialog = jqueryAlert({
					'buttons' : {
						'关闭' : function(){
							M.dialog.close() //关闭
						}
					}
				})</pre>
				

				<p id="dialog_show" class="alert-api-api "><span class="blue f18">show() </span>- 当DOM元素已经存在时，调用</p>
				<div class="m20 blockquote">
					<p>如果不想每次都重新生成一遍模板，那么必须加上这段代码</p>
					<p><span class="blue">释义</span>：如果M.dialog存在，则直接调用 show方法</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				// 判断是否已存在，如果已存在则直接显示
				if(M.dialog){
					return M.dialog.show();
				}
				M.dialog = jqueryAlert({
				})</pre>


				<p id="dialog_destroy" class="alert-api-api "><span class="blue f18">destroy() </span>- 销毁组件的HTML代码</p>
				<div class="m20 blockquote">
					<p>如果想每次都重新生成一遍模板，那么把上次的代码销毁掉是必要的</p>
					<p><span class="blue">释义</span>：当关闭时销毁掉组件的html代码</p>
				</div>
				<pre class="brush:javascript;toolbar:false">
				M.dialog = jqueryAlert({
					'buttons' : {
						'关闭' : function(){
							M.dialog.destroy() //销毁掉
						}
					}
				})</pre>
		</div>
	</div>
</body>
</html>