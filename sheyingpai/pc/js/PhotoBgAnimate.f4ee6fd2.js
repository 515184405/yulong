(window.webpackJsonp=window.webpackJsonp||[]).push([["PhotoBgAnimate"],{"0374":function(t,e,i){"use strict";var s=i("0d0e");i.n(s).a},"0d0e":function(t,e,i){},"1a79":function(t,e,i){t.exports=i.p+"img/2.aa4b28d4.png"},"21dc":function(t,e,i){t.exports=i.p+"img/3.4517847f.png"},4850:function(t,e,i){"use strict";var s=i("dea6");i.n(s).a},"5a06":function(t,e,i){t.exports=i.p+"img/1.7b5484a4.png"},"5ad9":function(t,e,i){"use strict";i.r(e);i("fe59"),i("e35a"),i("5e9f"),i("0d7a"),i("08ba");var s=i("418f"),a=i("e455"),o=i("06f8"),n=i("157c"),r={data:function(){return{}},props:{customList:{type:Object,default:function(){}}},watch:{customList:{handler:function(t,e){if(console.log(t),0==t.bg_id)this.otherFun(t.images);else switch(parseInt(t.bg_id)){case 1:this.qipaoFun();break;case 2:this.yeFun();break;case 3:this.personFun();break;case 4:this.aixinFun()}},deep:!0}},methods:{qipaoFun:function(){n.tsParticles.load("tsparticles",{fpsLimit:60,emitters:{direction:"top",size:{width:10,height:0},position:{x:0,y:100},rate:{delay:.3,quantity:20}},particles:{number:{Value:0},color:{value:"#ffffff"},shape:{type:"image",image:[{src:i("c8b7"),width:400,height:400},{src:i("f21f"),width:400,height:375},{src:i("21dc"),width:202,height:200}]},opacity:{value:1},size:{value:20,anim:{enable:!0,speed:2,size_min:2,sync:!0,startValue:"min",destroy:"max"}},move:{enable:!0,speed:3,direction:"right",random:!1,straight:!1,out_mode:"destroy",attract:{enable:!1,rotateX:600,rotateY:1200}}},detectRetina:!0})},aixinFun:function(){n.tsParticles.load("tsparticles",{fpsLimit:60,emitters:{direction:"bottom",size:{width:200,height:0},position:{x:100,y:0},rate:{delay:.3,quantity:20}},particles:{number:{Value:0},color:{value:"#ffffff"},shape:{type:"image",image:[{src:i("5e14"),width:240,height:240},{src:i("1a79"),width:240,height:240},{src:i("9e3e"),width:240,height:240}]},opacity:{value:1},size:{value:10,anim:{enable:!0,speed:1,size_min:1,sync:!0,startValue:"min",destroy:"max"}},move:{enable:!0,speed:3,direction:"bottom",random:!1,straight:!1,out_mode:"destroy",attract:{enable:!1,rotateX:600,rotateY:1200}}},detectRetina:!0})},personFun:function(){n.tsParticles.load("tsparticles",{fpsLimit:60,emitters:{direction:"bottom",size:{width:200,height:0},position:{x:100,y:0},rate:{delay:.3,quantity:20}},particles:{number:{Value:0},color:{value:"#ffffff"},shape:{type:"image",image:[{src:i("5a06"),width:240,height:240},{src:i("b17e"),width:240,height:240},{src:i("7658"),width:240,height:240}]},opacity:{value:1},size:{value:10,anim:{enable:!0,speed:1,size_min:1,sync:!0,startValue:"min",destroy:"max"}},move:{enable:!0,speed:3,direction:"bottom",random:!1,straight:!1,out_mode:"destroy",attract:{enable:!1,rotateX:600,rotateY:1200}}},detectRetina:!0})},yeFun:function(){n.tsParticles.load("tsparticles",{fpsLimit:60,emitters:{direction:"bottom",size:{width:200,height:0},position:{x:100,y:0},rate:{delay:.3,quantity:20}},particles:{number:{Value:0},color:{value:"#ffffff"},shape:{type:"image",image:[{src:i("91ff"),width:240,height:240},{src:i("f58e"),width:240,height:240},{src:i("6821"),width:240,height:240}]},opacity:{value:1},size:{value:10,anim:{enable:!0,speed:1,size_min:1,sync:!0,startValue:"min",destroy:"max"}},move:{enable:!0,speed:3,direction:"bottom",random:!1,straight:!1,out_mode:"destroy",attract:{enable:!1,rotateX:600,rotateY:1200}}},detectRetina:!0})},otherFun:function(t){var e=this,i=[];t.split(",").forEach((function(t){i.push({width:240,height:240,src:e.$oss+t})})),n.tsParticles.load("tsparticles",{fpsLimit:60,emitters:{direction:"bottom",size:{width:200,height:0},position:{x:100,y:0},rate:{delay:.3,quantity:20}},particles:{number:{Value:0},color:{value:"#ffffff"},shape:{type:"image",image:i},opacity:{value:1},size:{value:10,anim:{enable:!0,speed:1,size_min:1,sync:!0,startValue:"min",destroy:"max"}},move:{enable:!0,speed:3,direction:"bottom",random:!1,straight:!1,out_mode:"destroy",attract:{enable:!1,rotateX:600,rotateY:1200}}},detectRetina:!0})}},mounted:function(){}},c=(i("0374"),i("e90a")),l=Object(c.a)(r,(function(){var t=this.$createElement;return(this._self._c||t)("div",{attrs:{id:"tsparticles"}})}),[],!1,null,null,null).exports,d={name:"photoStartPage",data:function(){return{type:"1",systemList:[],customList:{bg_id:"",images:""}}},components:{photoPhoneBg:s.a,coverImageSettings:a.a,skin:o.a,bgAnimate:l},watch:{},methods:{submitStartPageEvent:function(){var t=this;if(1==this.type)this.customList.images="";else{if(0!=this.type)return this.$req.photoliveBgAmimateDelete(this.customList).then((function(e){1e5==e.code?t.$Modal.success({title:"消息提示",content:"已取消设置"}):t.$Message.error(e.message)})).catch((function(e){console.log(e),t.$Message.error("系统异常")})),!1;if(this.customList.bg_id=0,!this.customList.images.length)return this.$Modal.warning({title:"消息提示",content:"漂浮图片不能为空"});this.customList.images.substr(0,this.customList.images.length-1)}this.customList.project_id=this.$route.params.project_id,this.$req.photoliveBgAnimateCreateUpdate(this.customList).then((function(e){1e5==e.code?(t.$Modal.success({title:"消息提示",content:"相册背景动画已设置成功"}),t.customList.id||(t.$emit("getPhotoOne"),t.customList=e.data)):t.$Message.error(e.message)})).catch((function(e){console.log(e),t.$Message.error("系统异常")}))},getPhotoliveBgAnimateList:function(){var t=this;this.$req.photoliveBgAmimateList({project_id:this.$route.params.project_id}).then((function(e){1e5==e.code?e.data.forEach((function(e){1==e.type?t.systemList.push(e):(t.customList=e,0!=e.bg_id?t.type="1":t.type="0")})):t.$Message.error(e.message)})).catch((function(e){console.log(e),t.$Message.error("系统异常")}))},handleSuccess:function(t,e){1e5==t.code?this.customList.images+=t.data.fileSrc+",":this.$Message.error(t.message)},handleFormatError:function(t){this.$Notice.warning({title:"图片格式不正确",desc:"图片格式不正确，请上传'jpg','jpeg','png','gif'格式"})},handleMaxSize:function(t){this.$Notice.warning({title:"图片尺寸过大",desc:"上传的封面图最大不能超过256kb"})},handleBeforeUpload:function(t){var e=this.customList.images.split(",").length<6;return e||this.$Notice.warning({title:"背景图数量过多",desc:"背景图数量过多最多不能超过4张"}),e},handleRemove:function(t){this.$set(this.customList,"images",this.customList.images.replace(t+",",""))}},created:function(){this.getPhotoliveBgAnimateList()}},p=(i("4850"),Object(c.a)(d,(function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",{staticClass:"photoStartPage"},[i("Card",{attrs:{"dis-hover":"",bordered:!1}},[i("p",{staticStyle:{"line-height":"33px",height:"30px"},attrs:{slot:"title"},slot:"title"},[i("Icon",{staticStyle:{"font-size":"20px"},attrs:{type:"md-bookmarks"}}),t._v(" 设置相册背景漂浮动画 "),i("span",{staticStyle:{color:"#f00","margin-left":"15px"}},[t._v("※※ 选择背景漂浮动画时最好把模块与背景颜色设置为半透明颜色 ※※")])],1)]),i("div",{staticClass:"flex"},[i("photo-phone-bg",[i("skin",{attrs:{skinItem:t.photoSkin}}),i("bg-animate",{attrs:{customList:t.customList}})],1),i("div",{staticClass:"flex-item",staticStyle:{"margin-left":"50px"}},[i("Form",{attrs:{model:t.bgAmimate,"label-width":140}},[i("FormItem",{attrs:{label:"漂浮动画类型："}},[i("RadioGroup",{model:{value:t.type,callback:function(e){t.type=e},expression:"type"}},[i("Radio",{attrs:{label:"1"}},[i("span",[t._v("系统类")])]),i("Radio",{attrs:{label:"0"}},[i("span",[t._v("自定义")])]),i("Radio",{attrs:{label:"-1"}},[i("span",[t._v("不设置")])])],1)],1),1==t.type?i("FormItem",{attrs:{label:"漂浮动画选择："}},[i("RadioGroup",{model:{value:t.customList.bg_id,callback:function(e){t.$set(t.customList,"bg_id",e)},expression:"customList.bg_id"}},t._l(t.systemList,(function(e,s){return i("Radio",{key:s,attrs:{label:e.id}},[i("span",[t._v(t._s(e.name))])])})),1)],1):t._e(),0==t.type?i("FormItem",{attrs:{label:"漂浮图片上传："}},[t._l(t.customList.images.split(","),(function(e,s){return t.customList.images?[e?i("div",{staticClass:"demo-upload-list"},[i("img",{attrs:{src:t.$oss+e}}),i("div",{staticClass:"demo-upload-list-cover"}),i("Icon",{attrs:{type:"md-trash"},nativeOn:{click:function(i){return i.stopPropagation(),t.handleRemove(e)}}})],1):t._e()]:t._e()})),i("Upload",{ref:"upload",staticStyle:{display:"inline-block",width:"58px"},attrs:{name:"file","show-upload-list":!1,"on-success":t.handleSuccess,accept:".png,.jpg,.jpeg,.gif",format:["jpg","jpeg","png","gif"],"max-size":256,"on-format-error":t.handleFormatError,"on-exceeded-size":t.handleMaxSize,"before-upload":t.handleBeforeUpload,type:"drag",data:{dir:t.$userinfo.id+"/"+t.$route.params.project_id+"/bg_animate"},action:t.$req.uploadImage()}},[i("div",{staticStyle:{width:"58px",height:"58px","line-height":"58px"}},[i("Icon",{attrs:{type:"ios-camera",size:"20"}})],1)]),i("div",{staticClass:"error",staticStyle:{"line-height":"1.5"}},[i("p",[t._v("1.背景图片需要上传240*240像素")]),i("p",[t._v("2.建议上传透明的以.png格式为结尾的图片")])])],2):t._e(),i("FormItem",{attrs:{"label-width":140}},[i("Button",{staticStyle:{width:"100px"},attrs:{size:"large",type:"primary"},on:{click:t.submitStartPageEvent}},[t._v("提 交")])],1)],1)],1)],1)],1)}),[],!1,null,"2ddcc821",null));e.default=p.exports},"5e14":function(t,e,i){t.exports=i.p+"img/1.ba7e92f7.png"},6821:function(t,e,i){t.exports=i.p+"img/3.5014d771.png"},7658:function(t,e,i){t.exports=i.p+"img/3.a33b5bfe.png"},"91ff":function(t,e,i){t.exports=i.p+"img/1.dd289939.png"},"9e3e":function(t,e,i){t.exports=i.p+"img/3.d73183f4.png"},b17e:function(t,e,i){t.exports=i.p+"img/2.5ee3c848.png"},c8b7:function(t,e,i){t.exports=i.p+"img/1.fdc16219.png"},dea6:function(t,e,i){},f21f:function(t,e,i){t.exports=i.p+"img/2.3b422e4e.png"},f58e:function(t,e,i){t.exports=i.p+"img/2.1ca7a3a2.png"}}]);