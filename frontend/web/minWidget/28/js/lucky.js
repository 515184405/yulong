$(function(){var a={};function t(i){setTimeout(function(){var e=$('<img class="lucky_icon" />'),t=$('<p class="lucky_userName"></p>'),l=$('<div class="lucky_userInfo"></div>');l.append(e,t),$(".mask").append(l),$(".mask").fadeIn(200),e.attr("src",personArray[a.luckyResult[i]].image),t.text(personArray[a.luckyResult[i]].name),l.animate({left:"50%",top:"50%",height:"200px",width:"200px","margin-left":"-100px","margin-top":"-100px"},1e3,function(){setTimeout(function(){l.animate({height:"100px",width:"100px","margin-left":"100px","margin-top":"-50px"},400,function(){$(".mask").fadeOut(0),e.attr("class","lpl_userImage").attr("style",""),t.attr("class","lpl_userName").attr("style",""),l.attr("class","lpl_userInfo").attr("style",""),$(".lpl_list.active").append(l)})},1e3)})},2500*i),setTimeout(function(){$(".lucky_list").show()},2500)}function i(e,t){t<=e&&$(".lucky_prize_right").removeClass("active"),e<=1&&$(".lucky_prize_left").removeClass("active"),a.luckyPrize=e,$(".lucky_prize_show").hide().eq(e-1).show(),$(".lucky_prize_title").html($(".lucky_prize_show").eq(e-1).attr("alt")),$(".lpl_list").removeClass("active").hide().eq(e-1).show().addClass("active")}a.luckyResult=[],a.luckyPrize="",a.luckyNum=$(".select_lucky_number").val(),$(".select_lucky_number").bind("change",function(){a.luckyNum=$(this).val()}),a.M=$(".container").lucky({row:7,col:5,depth:5,iconW:30,iconH:30,iconRadius:8,data:personArray}),function(e,t){var l=1,i=e.length;$(".all_number").html("/"+i);for(var a=0;a<i;a++){var c=new Image;c.onload=function(){c.onload=null,++l,$(".current_number").html(l),l==i&&t(c)},c.src=e[a].image}}(personArray,function(){$(".loader_file").hide()}),$("#stop").click(function(){a.M.stop(),$(".container").hide(),$(this).hide();for(var e=0;e<a.luckyResult.length;e++)t(e)}),$("#open").click(function(){$(".lucky_list").hide(),$(".container").show(),a.M.open(),function(){a.luckyResult=[];for(var e=0;e<a.luckyNum;e++){var t=Math.floor(Math.random()*personArray.length);-1==a.luckyResult.indexOf(t)?a.luckyResult.push(t):e--}}(),setTimeout(function(){$("#stop").show(500)},1e3)}),function(){var e=$(".lucky_prize_picture").attr("data-default"),t=e||1;i(t);var l=$(".lucky_prize_show").length;$(".lucky_prize_left").click(function(){$(".lucky_prize_right").addClass("active"),t<=1||--t,i(t,l)}),$(".lucky_prize_right").click(function(){$(".lucky_prize_left").addClass("active"),l<=t||++t,i(t,l)})}()});