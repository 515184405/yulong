 $.fn.barrage=function(e){var t=$(this),i=$.extend({},{data:[],row:5,time:2e3,gap:20,position:"fixed",direction:"bottom right",ismoseoverclose:!0,height:30},e),r={},o={};o.data=i.data,r.vertical=i.direction.split(/\s+/)[0],r.horizontal=i.direction.split(/\s+/)[1],r.bgColors=["#edbccc","#edbce7","#c092e4","#9b92e4","#92bae4","#92d9e4","#92e4bc","#a9e492","#d9e492","#e4c892"],o.arrEle=[],r.barrageBox=$('<div id="barrage" style="z-index:999;max-width:100%;position:'+i.position+";"+r.vertical+":0;"+r.horizontal+':0;"></div>'),r.timer=null;function a(){var e=Math.floor(Math.random()*r.bgColors.length),t=$('<a class="overflow-text" target="_blank" style="height:0;opacity:0;text-align:'+i.direction.split(/\s+/)[1]+";float:"+i.direction.split(/\s+/)[1]+";background-color:"+r.bgColors[e]+'"; href="'+(o.data[0].href?o.data[0].href:"javascript:;")+'">'+o.data[0].text+"</a>"),a=o.data.shift();"top"==r.vertical?(t.animate({opacity:1,"margin-top":i.gap,height:i.height,"line-height":i.height+"px"},1e3),r.barrageBox.prepend(t)):(t.animate({opacity:1,"margin-bottom":i.gap,height:i.height,"line-height":i.height+"px"},1e3),r.barrageBox.append(t)),o.data.push(a),r.barrageBox.children().length>i.row&&r.barrageBox.children().eq(0).animate({opacity:0},300,function(){$(this).css({margin:0}).remove()})}return r.mouseClose=function(){i.ismoseoverclose&&r.barrageBox.mouseover(function(){clearInterval(r.timer),r.timer=null}).mouseout(function(){r.timer=setInterval(function(){a()},i.time)})},o.close=function(){r.barrageBox.remove(),clearInterval(r.timer),r.timer=null},o.start=function(){r.timer||(t.append(r.barrageBox),a(),r.timer=setInterval(function(){a()},i.time),r.mouseClose())},o};